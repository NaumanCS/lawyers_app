@extends('front-layouts.video-call-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src='https://8x8.vc/vpaas-magic-cookie-486c47a14c1d4f048c13fd841aafd042/external_api.js' async></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style>
        #root {
            width: 100%;
            max-height: 100vh !important;
        }
    </style>
    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .star-rating-complete {
            color: #c59b08;
        }

        .rating-container .form-control:hover,
        .rating-container .form-control:focus {
            background: #fff;
            border: 1px solid #ced4da;
        }

        .rating-container textarea:focus,
        .rating-container input:focus {
            color: #000;
        }

        .rated {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rated:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ffc700;
        }

        .rated:not(:checked)>label:before {
            content: '★ ';
        }

        .rated>input:checked~label {
            color: #ffc700;
        }

        .rated:not(:checked)>label:hover,
        .rated:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rated>input:checked+label:hover,
        .rated>input:checked+label:hover~label,
        .rated>input:checked~label:hover,
        .rated>input:checked~label:hover~label,
        .rated>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>




    <div class="col-xl-9 col-md-8" style="height: 100vh">
        <div class="row">
            <div id="root"></div>
        </div>

    </div>
    <!-- Add this to your HTML body -->



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="box-shadow: 0 0 10px 0 #ddd;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rate and Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="submitMeetingForm()"></button>
                </div>
                <div class="modal-body">
                    <form class="" action="{{ route('feedback.store') }}" method="POST" autocomplete="off">
                        @csrf
                        @if (!empty($value->star_rating))
                            <div class="container">
                                <div class="row">
                                    <div class="col mt-4">
                                        <p class="font-weight-bold ">Review</p>
                                        <div class="form-group row">
                                            {{-- <input type="hidden" name="booking_id" value="{{ $value->id }}"> --}}
                                            <div class="col">
                                                <div class="rated">
                                                    @for ($i = 1; $i <= $value->star_rating; $i++)
                                                        {{-- <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/> --}}
                                                        <label class="star-rating-complete"
                                                            title="text">{{ $i }}
                                                            stars</label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4">
                                            <div class="col">
                                                <p>{{ $value->comments }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="lawyer_id" value="{{ $lawyerId ?? '' }}">
                            <input type="hidden" name="customer_id" value="{{ $customerId ?? '' }}">
                            <input type="hidden" name="meeting_link" value="{{ $meetingLink ?? '' }}">


                            <div class="form-group row">
                                <input type="hidden" name="booking_id" value="">
                                <div class="col">
                                    <div class="rate">
                                        <input type="radio" id="star5" class="rate" name="rating" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" checked id="star4" class="rate" name="rating"
                                            value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" class="rate" name="rating" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" class="rate" name="rating" value="2">
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" class="rate" name="rating" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <div class="col">
                                    <textarea class="form-control" name="review" rows="6 " placeholder="review" maxlength="200"></textarea>
                                </div>
                            </div>
                        @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="submitMeetingForm()">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    <script>
        window.onload = function() {
            function getUrlParams(url) {
                let urlStr = url.split('?')[1];
                const urlSearchParams = new URLSearchParams(urlStr);
                const result = Object.fromEntries(urlSearchParams.entries());
                return result;
            }


            // Generate a Token by calling a method.
            // @param 1: appID
            // @param 2: serverSecret
            // @param 3: Room ID
            // @param 4: User ID
            // @param 5: Username
            const roomID = "{{ $meetingLink }}";
            const userID = Math.floor(Math.random() * 10000) + "";
            const userName = "userName" + userID;
            const appID = 676303317;
            const serverSecret = "99713f21172222172c5180a7e4b4a2f7";
            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);


            const zp = ZegoUIKitPrebuilt.create(kitToken);
            zp.joinRoom({
                container: document.querySelector("#root"),
                sharedLinks: [{
                    name: 'Personal link',
                    url: window.location.protocol + '//' + window.location.host + window.location
                        .pathname + '?roomID=' + roomID,
                }],
                scenario: {
                    mode: ZegoUIKitPrebuilt.VideoConference,
                },

                turnOnMicrophoneWhenJoining: true,
                turnOnCameraWhenJoining: true,
                showMyCameraToggleButton: true,
                showMyMicrophoneToggleButton: true,
                showAudioVideoSettingsButton: true,
                showScreenSharingButton: true,
                showTextChat: true,
                showUserList: true,
                maxUsers: 2,
                layout: "Auto",
                showLayoutButton: false,

            });

            const timeoutDuration = 20 * 60 * 1000;
            const videoContainer = document.getElementById("root"); // Remove the "#" symbol
            setTimeout(() => {
                alert('Meeting has ended due to inactivity.');
                // Leave the room

                showRatingAndReviewModel();
                // zp.leaveRoom();
                // // Log out of the room
                // zp.logoutRoom(roomID);

                // Hide the video container
                videoContainer.style.display = "none";

                // You can add additional cleanup or redirect logic if needed.
            }, timeoutDuration);


        }

        function showRatingAndReviewModel() {
            $('#staticBackdrop').modal('show');
        }

        function submitRatingAndReview() {
            $('#staticBackdrop').modal('hide');
        }

        function submitMeetingForm() {
            // Get the meeting ID from somewhere (replace 'MEETING_ID' with the actual ID)
            var meetingId = '{{ isset($meetingLink) ? $meetingLink : '' }}';

            // Submit the form asynchronously
            $.ajax({
                type: 'POST',
                url: '/delete-meeting/' + meetingId,
                data: {
                    _token: '{{ csrf_token() }}', // Include the CSRF token for security
                },
                success: function(response) {
                    console.log(response.message);
                    toastr.success(response.message, 'Meeting Done');
                    window.location.href = '{{ route('meeting.schedule.list') }}';
                },
                error: function(error) {
                    console.log('Error deleting meeting record:', error);
                }
            });
        }
    </script>
@endsection
