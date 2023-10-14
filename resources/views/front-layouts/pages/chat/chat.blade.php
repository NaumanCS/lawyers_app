@extends('front-layouts.master-layout')
@section('content')
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
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <section style="background-color: #eee;">
        @if ($rooms->isEmpty())
            <div class="chatUnavailableContainer">
                <div class="chat-overlay">
                    <p class="message mb-0">Sorry, no chats are available at the moment.</p><br>
                    <p class="servicesLink mb-0">Find lawyers to discuss your matters <a
                            href="{{ route('categories', ['filter' => 'all']) }}">Click Here.</a> </p>
                </div>
            </div>
        @else
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
        @endif
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
            let message = $('#message-box').val();
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
