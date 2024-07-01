<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LivewireMessage;

class AdminChat extends Component
{
    public $messages;

    public function mount()
    {
        $this->messages = LivewireMessage::latest()->take(20)->get()->reverse();
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}

