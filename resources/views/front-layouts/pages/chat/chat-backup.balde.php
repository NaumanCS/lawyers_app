<div class="container py-3">
                <div class="row">
                    <div class="col-md-12 col-lg-5 col-xl-4 mb-4 mb-md-0">
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-unstyled mb-0" id="chat-rooms-list">
                                    @foreach ($rooms as $room)
                                        @if ($room->sender->id !== auth()->user()->id)
                                            <div class="single-room-chat" data-room-id="{{ $room->id }}">
                                                <li class="p-2 border-bottom chat-list-box">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <img src="{{ $room->sender->image }}" alt="avatar"
                                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                                width="60">
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">{{ $room->sender->name }}</p>
                                                                <p class="small text-muted">Hello, Are you there?</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Just now</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </div>
                                        @endif
                                        @if ($room->receiver->id !== auth()->user()->id)
                                            <div class="single-room-chat" data-room-id="{{ $room->id }}">
                                                <li class="p-2 border-bottom chat-list-box">
                                                    <a href="#!" class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row">
                                                            <img src="{{ $room->receiver->image }}" alt="avatar"
                                                                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                                width="60">
                                                            <div class="pt-1">
                                                                <p class="fw-bold mb-0">{{ $room->receiver->name }}</p>
                                                                <p class="small text-muted">Hello, Are you there?</p>
                                                            </div>
                                                        </div>
                                                        <div class="pt-1">
                                                            <p class="small text-muted mb-1">Just now</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7 col-xl-8 parent-container" id="parent-container">
                        <div class="d-flex bg-dark p-2">
                            <h5 class="text-light mb-0" id="user-name">Lawyer's Legal App</h5>
                        </div>
                        <ul class="list-unstyled px-3" id="chat-container"></ul>
                        <div class="bg-white mx-3" id="chat-input-container">
                            <form class="mb-0" id="newMessageForm">
                                <div class="form-outline d-flex">
                                    <textarea class="form-control" id="message-box" rows="2" placeholder="Type your message..."></textarea>
                                    <button type="submit" class="btn btn-info btn-rounded float-end submitButton"
                                        data-user-Id="{{ auth()->user()->id }}">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
