<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChMessage;
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
    public function index()
    {
        return view('layouts.pages.dashboard');
    }

    public function chat()
    {
        $rooms = Chat::where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id())->with('sender', 'receiver')->get();
        return view('front-layouts.pages.chat.chat', get_defined_vars());
    }

    public function single_chat($roomId)
    {
        $chat = ChMessage::where('chat_id', $roomId)->with('user')->get();
        foreach ($chat as $message) {
            $message->seen = 1;
            $message->save(); // Save the updated message
        }
        return response()->json(['status' => true, 'chat' => $chat]);
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
            $chMessage->attachment = $request->attachment;
        }
        $chMessage->save();

        $chat = ChMessage::where('chat_id', $room_id)->with('user')->get();
        \Log::info($chat);
        return response()->json(['status' => true, 'chat' => $chat]);
    }

    public function fetch_new_messages(){

    }
}
