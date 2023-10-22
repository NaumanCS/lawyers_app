@extends('front-layouts.master-layout')
@section('content')
    @php
        use App\General\ChatClass;
    @endphp
    <style>
        .chatUnavailableContainer {
            text-align: center;
            width: 100%;
            height: 100vh;
            position: relative;
            background-image: url('{{ asset('front') }}/assets/img/chatsUnavailable.png');
            background-size: cover;
            background-position: center;
        }

        .chat-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .message {
            color: white;
            font-size: 24px;
        }

        .servicesLink {
            color: white;
            font-size: 16px;
        }

        .servicesLink a {
            color: wheat;
        }

        .chat-list-box {
            background: #eee !important;
        }

        .chat-list-box.active {
            background: #000 !important;
        }

        .chat-list-box.active p {
            color: white !important;
        }

        #parent-container {
            position: relative;
        }

        #chat-container {
            height: 70vh;
            overflow-y: auto;
            padding-top: 1rem;
            margin-bottom: 2rem;
        }

        #chat-rooms-list {
            height: 60vh;
            overflow-y: auto
        }

        #chat-input-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            z-index: 11111;
        }

        #chat3 .form-control {
            border-color: transparent;
        }

        #chat3 .form-control:focus {
            border-color: transparent;
            box-shadow: inset 0px 0px 0px 1px transparent;
        }

        .badge-dot {
            border-radius: 50%;
            height: 10px;
            width: 10px;
            margin-left: 2.9rem;
            margin-top: -0.75rem;
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <section style="background-color: #36353e">
        @if ($rooms->isEmpty())
            <div class="chatUnavailableContainer">
                <div class="chat-overlay">
                    <p class="message mb-0">Sorry, no chats are available at the moment.</p><br>
                    <p class="servicesLink mb-0">Find lawyers to discuss your matters <a
                            href="{{ route('categories', ['filter' => 'all']) }}">Click Here.</a> </p>
                </div>
            </div>
        @else
            <div class="container py-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body p-0 pt-3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4 mb-md-0"
                                        style="border-right: 1px solid #36353e;">
                                        <div class="py-3">
                                            <div class="input-group rounded mb-3 d-none">
                                                <input type="search" class="form-control rounded" placeholder="Search"
                                                    aria-label="Search" aria-describedby="search-addon" />
                                                <span class="input-group-text border-0" id="search-addon">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>

                                            <div data-mdb-perfect-scrollbar="true"
                                                style="
                                                    position: relative;
                                                    height: 400px;
                                                    overflow-y: auto !important;
                                                ">
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($rooms as $room)
                                                        @if ($room->sender->id !== auth()->user()->id)
                                                            <li class="p-2 border-bottom single-room-chat"
                                                                data-room-id="{{ $room->id }}">
                                                                <a href="#!" class="d-flex justify-content-between">
                                                                    <div class="d-flex flex-row">
                                                                        <div>
                                                                            <img src="{{ $room->sender->image }}"
                                                                                alt="avatar"
                                                                                class="d-flex align-self-center me-3"
                                                                                width="60"
                                                                                style="border-radius: 30px;" />
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
                                                                            <span
                                                                                class="badge bg-danger rounded-pill float-end">
                                                                                {{ ChatClass::getUnreadCount($room->id) }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if ($room->receiver->id !== auth()->user()->id)
                                                            <li class="p-2 border-bottom single-room-chat"
                                                                data-room-id="{{ $room->id }}">
                                                                <a href="#!" class="d-flex justify-content-between">
                                                                    <div class="d-flex flex-row">
                                                                        <div>
                                                                            <img src="{{ $room->receiver->image }}"
                                                                                alt="avatar"
                                                                                class="d-flex align-self-center me-3"
                                                                                width="60"
                                                                                style="border-radius: 30px;" />
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
                                                                            <span
                                                                                class="badge bg-danger rounded-pill float-end">
                                                                                {{ ChatClass::getUnreadCount($room->id) }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                        <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                                            style="
                                                position: relative;
                                                height: 400px;
                                                overflow-y: auto !important;
                                            ">
                                        </div>

                                        <form action="" id="newMessageForm">
                                            <div
                                                class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                    alt="avatar 3" style="width: 40px; height: 100%;" />

                                                <div class="d-flex align-items-center w-100">
                                                    <input type="text" class="form-control form-control-lg message-box"
                                                        id="exampleFormControlInput2" placeholder="Type message" />
                                                    {{-- <a class="ms-1 text-muted" href="#!"><i
                                                    class="fas fa-paperclip"></i></a>
                                            <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a> --}}
                                                    <a class="" type="submit"><i class="fas fa-paper-plane"></i></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        let roomId = null;
        let authUserId = {{ auth()->user()->id }};
        let chatHistory = [];
        $('.parent-container').hide();

        $(document).on('click', '.single-room-chat', function(e) {
            e.preventDefault();
            if ($(this).find('li').hasClass('active')) {
                return; // Don't proceed with the Ajax request
            }
            roomId = $(this).data('room-id');
            $('#chat-container').empty();
            $('.chat-list-box').removeClass('active');
            var clickedLi = $(this).find('li');
            clickedLi.addClass('active');
            $.ajax({
                url: '/display-single-chat/' + roomId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('.parent-container').show();
                    var chatRecords = response.chatRecords;
                    response.chat.forEach(function(message) {
                        chatHistory.push(message);
                        var messageHtml = '';
                        $('#user-name').text(message.user.name);

                        if (message.sender_id == authUserId) {
                            messageHtml +=
                                '<li class="d-flex justify-content-between mb-4">';
                            messageHtml += '<img src="' + message.user.image +
                                '" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">';
                            messageHtml += '<div class="card px-3 py-2">';
                            messageHtml +=
                                '<div class="d-flex justify-content-end">';
                            messageHtml +=
                                '<p class="text-muted small mb-0"><i class="far fa-clock"></i> ' +
                                message.created_at + '</p>';
                            messageHtml += '</div>';
                            messageHtml += '<p class="mb-0">' + message.body +
                                '</p>';
                            messageHtml += '</div>';
                            messageHtml += '</li>';
                        } else {
                            messageHtml +=
                                '<li class="d-flex justify-content-between mb-4">';
                            messageHtml +=
                                '<div class="card w-100 card px-3 py-2">';
                            messageHtml +=
                                '<div class="d-flex justify-content-end">';
                            messageHtml +=
                                '<p class="text-muted small mb-0"><i class="far fa-clock"></i> ' +
                                message.created_at + '</p>';
                            messageHtml += '</div>';
                            messageHtml += '<p class="mb-0">' + message.body +
                                '</p>';
                            messageHtml += '</div>';
                            messageHtml += '<img src="' + message.user.image +
                                '" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">';
                            messageHtml += '</li>';
                        }
                        $('#chat-container').append(messageHtml);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#newMessageForm').on('submit', function(e) {
            e.preventDefault();
            let message = $('.message-box').val();
            let userId = {{ auth()->user()->id }};

            if (message !== "" && message !== null) {
                $.ajax({
                    url: '/send/new/message',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'user_id': userId,
                        'room_id': roomId,
                        'message': message
                    },
                    success: function(response) {
                        $('#textAreaExample2').val('');
                        console.log(JSON.stringify(response) +
                            "========== send message response");
                        chatHistory.push(response);
                        renderChatHistory();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });


        function renderChatHistory() {
            $('#chat-container').empty();

            chatHistory.forEach(function(message) {
                var messageHtml = '';
                if (message.sender_id == authUserId) {
                    messageHtml +=
                        '<li class="d-flex justify-content-between mb-4">';
                    messageHtml += '<img src="' + (message.user ? message.user.image : '') +
                        // Check if message.user is defined
                        '" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">';
                    messageHtml += '<div class="card px-3 py-2">';
                    messageHtml +=
                        '<div class="d-flex justify-content-end">';
                    messageHtml +=
                        '<p class="text-muted small mb-0"><i class="far fa-clock"></i> ' +
                        message.created_at + '</p>';
                    messageHtml += '</div>';
                    messageHtml += '<p class="mb-0">' + message.body +
                        '</p>';
                    messageHtml += '</div>';
                    messageHtml += '</li>';
                } else {
                    messageHtml +=
                        '<li class="d-flex justify-content-between mb-4">';
                    messageHtml +=
                        '<div class="card w-100 card px-3 py-2">';
                    messageHtml +=
                        '<div class="d-flex justify-content-end">';
                    messageHtml +=
                        '<p class="text-muted small mb-0"><i class="far fa-clock"></i> ' +
                        message.created_at + '</p>';
                    messageHtml += '</div>';
                    messageHtml += '<p class="mb-0">' + message.body +
                        '</p>';
                    messageHtml += '</div>';
                    messageHtml += '<img src="' + (message.user ? message.user.image : '') +
                        // Check if message.user is defined
                        '" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">';
                    messageHtml += '</li>';
                }
                // Append the message HTML to the chat container
                $('#chat-container').append(messageHtml);
            });
        }

        function fetchAllChatData() {
            $.ajax({
                url: '/fetch-new-messages',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Handle the response containing all chat rooms and messages
                    var chatData = response.chats;

                    // Process and display the chat rooms and messages as needed
                    chatData.forEach(function(chatRoom) {
                        // Access chat room details (e.g., chatRoom.id, chatRoom.name, etc.)

                        // Access messages for this chat room
                        var messages = chatRoom.messages;

                        // Iterate through messages and display them
                        messages.forEach(function(message) {
                            // Access message details (e.g., message.id, message.body, etc.)
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Call fetchAllChatData when needed to fetch all chat data for the authenticated user
        fetchAllChatData();


        // setInterval(() => {
        renderChatHistory();
        // }, 3000);
    });
</script>
