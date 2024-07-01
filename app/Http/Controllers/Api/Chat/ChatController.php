<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function create_chat_room(Request $request)
    {
        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->lawyerId,
        ]);
        return redirect()->route('chat');
    }
    public function index()
    {
        $allUsers = User::get();
        $allOrders = Order::get();

        if ($allUsers) {
            $countAllUsers = $allUsers->count();
        }
        if ($allOrders) {
            $countAllOrders = $allOrders->count();
            $totalPayment = Order::whereNotNull('payment_slip')->sum('amount');
            $adminProfit = $totalPayment * 0.20;
        }

        return view('layouts.pages.dashboard', get_defined_vars());
    }

    public function chat()
    {
        $adminId = 1; // Assuming the admin user has an ID of 1
        $userId = Auth::id();

        // Check if a chat room exists between the authenticated user and the admin
        $chatRoom = Chat::where(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $adminId);
            })->orWhere(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $adminId)
                      ->where('receiver_id', $userId);
            })->with('sender', 'receiver')->first();

        // If no chat room exists, create one
       
        if (!$chatRoom && auth()->user()->role!='admin') {
            $chatRoom = Chat::create([
                'sender_id' => $userId,
                'receiver_id' => $adminId,
            ]);
        }

        // Fetch all chat rooms for the authenticated user
        $rooms = Chat::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with('sender', 'receiver')
            ->get();

      
        if ($rooms) {
            return response()->json(['message' => 'Chat Rooms',"chat_rooms"=>$rooms], 200);
        } else {
            return response()->json(['error' => 'Failed to Load chat rooms'], 500);
        }
    }

    public function get_rooms()
    {
        $rooms = Chat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->with('sender', 'receiver')->get();
        if ($rooms) {
            return response()->json(['message' => 'Chat Rooms',"chat rooms"=>$rooms], 200);
        } else {
            return response()->json(['error' => 'Failed to Load chat rooms'], 500);
        }
    }

    public function single_chat($roomId)
    {
        $chat = ChMessage::where('chat_id', $roomId)->with('user')->orderBy('created_at', 'asc')->get();
        foreach ($chat as $message) {
            $message->seen = 1;
            $message->save();
        }

        if ($chat) {
            $appUrl = config('app.url'); // or env('APP_URL')
            $chat->each(function ($message) use ($appUrl) {
                $message->attachment_urls = collect($message->attachment)->map(function ($attachment) use ($appUrl) {
                    return $appUrl . '/public/uploads/chat/' . $attachment;
                });
            });

            return response()->json(['message' => 'New Messages', "messages" => $chat], 200);
        } else {
            return response()->json(['error' => 'Failed to Load messages'], 500);
        }
    }

    public function send_message(Request $request)
    {
        $user_id = $request->input('user_id');
        $room_id = $request->input('room_id');
        $message = $request->input('message');

        $chMessage = new ChMessage();
        $chMessage->sender_id = $user_id;
        $chMessage->chat_id = $room_id;
        $chMessage->body = $message;
        
         $attachment1 = $request->attachment1 ?? null;
        $attachment2 = $request->attachment2 ?? null;
        $attachment3 = $request->attachment3 ?? null;
        $attachment4 = $request->attachment4 ?? null;

        // Filter out null values
        $attachments = array_filter([$attachment1, $attachment2, $attachment3, $attachment4]);

        if (count($attachments) > 0) {
            $uploadedImages = [];

            foreach ($attachments as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('uploads/chat'), $imageName);
                $uploadedImages[] = $imageName;
            }

            // Store file paths as an array
            $chMessage->attachment = $uploadedImages;
        }

         $chMessage->save();
//  if ($request->file('attachment')) {
//             $advocateLicence = time() . '.' . $request->attachment->extension();
//             $request->attachment->move(public_path('uploads/chat'), $advocateLicence);
//             ChMessage::whereId($chMessage->id)->update([
//                 'attachment' => $advocateLicence
//             ]);
//         }
        $chat = ChMessage::where('chat_id', $room_id)->with('user')->orderBy('created_at', 'asc')->get();
       

        if ($chat) {
            return response()->json(['message' => 'Message Sent','file'=>$request->file('attachment')], 200);
        } else {
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    public function fetch_new_messages()
    {
        $rooms = Chat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->with('sender', 'receiver')->get();
      
        if ($rooms) {
            return response()->json(['message' => 'New Messages',"messages"=>$rooms], 200);
        } else {
            return response()->json(['error' => 'Failed to Load messages'], 500);
        }
    }
}
