@php
    use App\General\ChatClass;
@endphp

@foreach ($rooms as $room)
    @if ($room->sender->id !== auth()->user()->id)
        <li class="p-2 border-bottom single-room-chat" data-room-id="{{ $room->id }}">
            <a href="#!" class="d-flex justify-content-between">
                <div class="d-flex flex-row">
                    <div>
                        <img src="{{ $room->sender->image }}" alt="avatar" class="d-flex align-self-center me-3"
                            width="60" style="border-radius: 30px;" />
                        <span class="badge bg-success badge-dot"></span>
                    </div>
                    <div class="pt-1">
                        <p class="fw-bold mb-0">
                            {{ $room->sender->name }}
                        </p>
                        <p class="small text-muted">
                            {{ ChatClass::getLatestMessage($room->id) }}
                        </p>
                    </div>
                </div>
                <div class="pt-1">
                    <p class="small text-muted text-end mb-1">
                        {{ ChatClass::getLatestMessageTime($room->id) }}
                    </p>
                    @if (ChatClass::getUnreadCount($room->id))
                        <span class="badge bg-danger rounded-pill float-end">
                            {{ ChatClass::getUnreadCount($room->id) }}
                        </span>
                    @endif
                </div>
            </a>
        </li>
    @endif
    @if ($room->receiver->id !== auth()->user()->id)
        <li class="p-2 border-bottom single-room-chat" data-room-id="{{ $room->id }}">
            <a href="#!" class="d-flex justify-content-between">
                <div class="d-flex flex-row">
                    <div>
                        <img src="{{ $room->receiver->image }}" alt="avatar" class="d-flex align-self-center me-3"
                            width="60" style="border-radius: 30px;" />
                        <span class="badge bg-warning badge-dot"></span>
                    </div>
                    <div class="pt-1">
                        <p class="fw-bold mb-0">
                            {{ $room->receiver->name }}
                        </p>
                        <p class="small text-muted">
                            {{ ChatClass::getLatestMessage($room->id) }}
                        </p>
                    </div>
                </div>
                <div class="pt-1">
                    <p class="small text-muted mb-1">
                        {{ ChatClass::getLatestMessageTime($room->id) }}
                    </p>
                    @if (ChatClass::getUnreadCount($room->id))
                        <span class="badge bg-danger rounded-pill float-end">
                            {{ ChatClass::getUnreadCount($room->id) }}
                        </span>
                    @endif
                </div>
            </a>
        </li>
    @endif
@endforeach
