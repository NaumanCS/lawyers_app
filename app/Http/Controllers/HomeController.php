<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

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
        if (!$chatRoom && !auth()->user()->role='admin') {
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

        // Display the chat rooms (or further processing)
        // dd($rooms);
        return view('front-layouts.pages.chat.chat', get_defined_vars());
    }

    public function get_rooms()
    {
        $rooms = Chat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->with('sender', 'receiver')->get();
        return view('front-layouts.pages.chat.ajax.rooms_container', compact('rooms'))->render();
    }

    public function single_chat($roomId)
    {
        $chat = ChMessage::where('chat_id', $roomId)->with('user')->orderBy('created_at', 'asc')->get();
        foreach ($chat as $message) {
            $message->seen = 1;
            $message->save();
        }
        // dd($chat);
        return view('front-layouts.pages.chat.ajax.messages_container', compact('chat'))->render();
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

        if ($request->file()) {
            $images = $request->file('attachment');
            $uploadedImages = [];

            foreach ($images as $image) {
                $imageName = uniqid() . '_' . time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/chat'), $imageName);
                $uploadedImages[] = 'uploads/chat/' . $imageName;
            }

            // Store file paths as an array
            $chMessage->attachment = $uploadedImages;
        }

        $chMessage->save();

        $chat = ChMessage::where('chat_id', $room_id)->with('user')->orderBy('created_at', 'asc')->get();
        return view('front-layouts.pages.chat.ajax.messages_container', compact('chat'))->render();
    }

    public function fetch_new_messages()
    {
        $rooms = Chat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->with('sender', 'receiver')->get();
        return view('front-layouts.pages.chat.chat', get_defined_vars());
    }
}
