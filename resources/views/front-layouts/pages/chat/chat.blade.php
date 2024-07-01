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

        #imagePreviewContainer {
            display: flex !important;
            overflow-x: auto;
            white-space: nowrap;
        }

        .single-room-chat.active {
            background: black;
        }

        .single-room-chat.active p {
            color: white;
        }

        .badge-dot {
            border-radius: 50%;
            height: 10px;
            width: 10px;
            margin-left: 2.9rem;
            margin-top: -0.75rem;
        }

        #chat-container {
            position: relative;
            height: 68vh;
            overflow-y: auto !important;
        }

        .chat-rooms-container {
            position: relative;
            height: 400px;
            overflow-y: auto !important;
        }

        @media only screen and (max-width: 780px) {
            .chat-rooms-container {
                height: 496px;
            }

            #chat-container {
                position: relative;
                height: 65vh;
                overflow-y: auto;
            }
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <section style="background-color: #36353e">
        {{-- @if ($rooms->isEmpty())
            <div class="chatUnavailableContainer">
                <div class="chat-overlay">
                    <p class="message mb-0">Sorry, no chats are available at the moment.</p><br>
                    <p class="servicesLink mb-0">Find lawyers to discuss your matters <a
                            href="{{ route('categories', ['filter' => 'all']) }}">Click Here.</a> </p>
                </div>
            </div>
        @else --}}
            <div class="container py-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body p-0 pt-3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4 mb-md-0"
                                        style="border-right: 1px solid #36353e; padding-right: 2px;">
                                        <span class="backChatButton mx-3"
                                            style="cursor: pointer; border: 1px solid black; border-radius: 50%; padding: 6px;">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </span>
                                        <div class="py-3 hide-show-rooms">
                                            <div class="input-group rounded mb-3 d-none">
                                                <input type="search" class="form-control rounded" placeholder="Search"
                                                    aria-label="Search" aria-describedby="search-addon" />
                                                <span class="input-group-text border-0" id="search-addon">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <div data-mdb-perfect-scrollbar="true" class="chat-rooms-container" style="width: 97%;">
                                                <ul class="list-unstyled mb-0" id="chatRoomsColumn">
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
                                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 parent-container">
                                        <div class="pt-3 pe-3" id="chat-container" data-mdb-perfect-scrollbar="true">
                                        </div>
                                        <form action="" id="newMessageForm">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="imagePreviewContainer"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div
                                                        class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"alt="avatar 3"
                                                            style="width: 40px; height: 100%;" />
                                                        <div class="d-flex align-items-center w-100">
                                                            <input type="text"
                                                                class="form-control form-control-lg message-box"
                                                                id="typeChatMessage" name="message"
                                                                placeholder="Type message" />
                                                            <label for="fileInput" class="text-muted"
                                                                style="margin-bottom: 0; margin-right: 10px; cursor: pointer;">
                                                                <i class="fas fa-paperclip"></i>
                                                            </label>
                                                            <input type="file" id="fileInput" name="attachment[]"
                                                                multiple style="display: none">
                                                            <label for="submit-button" class="mb-0"
                                                                style="cursor: pointer;">
                                                                <a> <i class="fas fa-paper-plane"></i></a>
                                                            </label>
                                                            <input type="submit" id="submit-button"
                                                                style="display: none">
                                                        </div>
                                                    </div>
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
        {{-- @endif --}}
    </section>
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var room_id = 0;
        var userScrolledUp = false;
        $('.parent-container').hide();
        $('.backChatButton').hide();

        function scrollChatToBottom() {
            var chatContainer = $('#chat-container');
            chatContainer.scrollTop(chatContainer[0].scrollHeight);
        }

        $(document).on('click', '.backChatButton', function() {
            $('.hide-show-rooms').show();
            $('#chat-container').empty();
            $('#chat-container').hide();
            $('.backChatButton').hide();
        });

        function getSingleRoomChat(roomId) {
            $.ajax({
                url: '/display-single-chat/' + roomId,
                type: 'GET',
                success: function(response) {
                    var isSmallScreen = $(window).width() < 780;

                    if (isSmallScreen) {
                        $('.backChatButton').show();
                        $('.hide-show-rooms').hide();
                    } else {
                        $('.backChatButton').hide();
                    }
                    $('#chat-container').empty();
                    $('#chat-container').append(response);
                    if (!userScrolledUp) {
                        scrollChatToBottom();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function getRoomsLatestData() {
            $.ajax({
                url: '/display-rooms',
                type: 'GET',
                success: function(response) {
                    $('#chatRoomsColumn .single-room-chat').remove();
                    $('#chatRoomsColumn').append(response);

                    if (room_id) {
                        $(`.single-room-chat[data-room-id='${room_id}']`).addClass('active');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        // setInterval(function() {
        //     getSingleRoomChat(room_id);
        //     getRoomsLatestData();
        // }, 5000);

        function fetchNewMessages() {
            $.ajax({
                url: '/fetch-new-messages',
                type: 'GET',
                success: function(response) {
                    if (response.newMessages && response.newMessages.length > 0) {
                        response.newMessages.forEach(function(message) {
                            $('#chat-container').append(`
                                <div class="message">
                                    <p>${message.content}</p>
                                </div>
                            `);
                        });
                        if (!userScrolledUp) {
                            scrollChatToBottom();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        setInterval(function() {
            if (room_id) {
                getSingleRoomChat(room_id);
            }

            fetchNewMessages();
        }, 10000); // 10 seconds

        $(document).on('click', '.single-room-chat', function(e) {
            e.preventDefault();
            if ($(this).hasClass('active')) {
                return;
            }
            $('.parent-container').show();
            roomId = $(this).data('room-id');
            $('#chat-container').empty();
            $('.single-room-chat').removeClass('active');
            $(this).addClass('active');
            room_id = roomId;
            getSingleRoomChat(roomId);
        });

        $('#chat-container').on('scroll', function() {
            // Check if the user has manually scrolled up
            userScrolledUp = this.scrollTop + this.clientHeight < this.scrollHeight;
        });

        var selectedImages = [];

        $('#fileInput').on('change', function() {
            var input = this;
            var files = input.files;

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imgSrc = e.target.result;
                    var img =
                        '<div class="image-container" style="flex: 0 0 40%; max-width: 100px; margin-right: 10px; position: relative;">' +
                        '<img src="' + imgSrc +
                        '" class="img-thumbnail mx-1" style="width: 100%; height: 100px;" data-src="' +
                        imgSrc + '" />' +
                        '<button class="remove-btn" style="position: absolute; top: 0; right: 0; background: none; border: none; cursor: pointer;"><i class="fas fa-times" style="color: red;"></i></button>' +
                        '</div>';

                    $('#imagePreviewContainer').append(img);
                    selectedImages.push(imgSrc);
                };

                reader.readAsDataURL(files[i]);
            }
        });

        $('#imagePreviewContainer').on('click', '.remove-btn', function() {
            var container = $(this).closest('.image-container');
            var imgSrc = container.find('img').data('src');
            container.remove();

            selectedImages = selectedImages.filter(function(item) {
                return item !== imgSrc;
            });
        });

        $('#newMessageForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('user_id', {{ auth()->user()->id }});
            formData.append('room_id', roomId);
            let message = $('.message-box').val();

            if (message !== "" && message !== null) {
                $.ajax({
                    url: '/send/new/message',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response) {
                        $('#imagePreviewContainer').empty();
                        $('#fileInput').val('');

                        $('#typeChatMessage').val('');
                        $('#chat-container').empty();
                        $('#chat-container').append(response);

                        if (!userScrolledUp) {
                            scrollChatToBottom();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

    });
</script>
