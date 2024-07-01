<div>
    <div class="messages">
        @foreach($messages as $message)
            <div class="message {{ $message->user_id === Auth::id() ? 'right' : 'left' }}">
                <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
            </div>
        @endforeach
    </div>
</div>
