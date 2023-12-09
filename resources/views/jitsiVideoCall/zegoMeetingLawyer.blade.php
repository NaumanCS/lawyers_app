@extends('jitsiVideoCall.layout.lawyer-video-call-layout')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <style>
        #root {
            width: 100%;
            max-height: 100vh !important;
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
                turnOnCameraWhenJoining: false,
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

            // Set a timeout for 20 minutes (20 minutes * 60 seconds * 1000 milliseconds)
            const timeoutDuration = 20 * 60 * 1000;
            const videoContainer = document.getElementById("root"); // Remove the "#" symbol


            setTimeout(() => {

                // alert('Meeting has ended due to inactivity.');

                // Leave the room
                // zp.leaveRoom(roomID);

                // // Log out of the room
                // zp.logoutRoom(roomID);

                // Hide the video container
                videoContainer.style.display = "none";

                // Show SweetAlert
                SweetAlert.fire({
                    title: "Meeting Ended",
                    text: "The meeting has ended due to inactivity.",
                    icon: "warning",
                    confirmButtonText: "OK",
                }).then(() => {
                    
                    window.location.href = "lawyer_meeting_list";
                });
            }, timeoutDuration);

        };
    </script>

@endsection
