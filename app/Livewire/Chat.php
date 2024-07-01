<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LivewireMessage;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $messages;
    public $messageText;

    protected $listeners = ['messageAdded' => '$refresh'];

    public function mount()
    {
        $this->messages = LivewireMessage::latest()->take(20)->get()->reverse();
    }

    public function sendMessage()
    {
        $message = LivewireMessage::create([
            'user_id' => Auth::id(),
            'message' => $this->messageText,
        ]);

        // Append the new message to the messages array
        $this->messages->push($message);

        // Clear the message input field
        $this->messageText = '';

        // Emit event to refresh the component and scroll to bottom
      
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
