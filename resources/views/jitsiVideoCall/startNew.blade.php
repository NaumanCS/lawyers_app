@extends('front-layouts.video-call-layout')
@section('content')
    <script src='https://8x8.vc/vpaas-magic-cookie-486c47a14c1d4f048c13fd841aafd042/external_api.js' async></script>
    <style>
        #jaas-container {
            height: 80%;
        }
    </style>
    <script type="text/javascript">
        // let api; // Declare api in the global scope

        // function initializeJitsi() {
        //     const customRoomName = "lawyers-meet";
        //     api = new JitsiMeetExternalAPI("8x8.vc", {
        //         // roomName: "vpaas-magic-cookie-486c47a14c1d4f048c13fd841aafd042/SampleAppWorthyContemptsHirePermanently",
        //         roomName: customRoomName,
        //         parentNode: document.querySelector('#jaas-container'),
        //         // Make sure to include a JWT if required for your setup.
        //         // jwt: "Your-JWT-Token"
        //     });
        // }
        let api; // Declare api in the global scope

        function initializeJitsi(roomName) {
            api = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: roomName,
                parentNode: document.querySelector('#jaas-container'),
                // Make sure to include a JWT if required for your setup.
                // jwt: "Your-JWT-Token"
            });
        }

        // function joinMeeting() {
        //     if (!api) {
        //         initializeJitsi();
        //     }
        //     const roomName = "vpaas-magic-cookie-486c47a14c1d4f048c13fd841aafd042/SampleAppWorthyContemptsHirePermanently";
        //     api.executeCommand('join', roomName);
        // }

        function showInputField() {
            const inputField = document.createElement("input");
            inputField.setAttribute("type", "text");
            inputField.setAttribute("id", "roomNameInput");
            inputField.setAttribute("class", "mb-2");
            inputField.setAttribute("placeholder", "Enter Room Name");
            inputField.classList.add("form-control");

            const joinButton = document.createElement("button");
            joinButton.innerText = "Join Meeting";
            joinButton.setAttribute("id", "roomNameButtonJoin");
            joinButton.classList.add("btn", "btn-success", "btn-block", "mb-3");
            joinButton.addEventListener("click", joinMeeting);

           

            // Replace the existing button with the input field and new button
            const buttonContainer = document.querySelector("#button-container");
            buttonContainer.innerHTML = "";
            buttonContainer.appendChild(inputField);
            buttonContainer.appendChild(joinButton);
            buttonContainer.appendChild(closeButton);
        }

        function joinMeeting() {
            const inputField = document.querySelector("#roomNameInput");
            const roomName = inputField.value.trim();
            if (roomName === "") {
                alert("Please enter a room name.");
                return;
            }

            if (!api) {
                initializeJitsi(roomName);
            } else {
                // If the API instance already exists, just join the new room
                api.executeCommand('join', roomName);
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <div class="col-xl-9 col-md-8" style="height: 100vh">


        <!-- Left Sidebar (3 columns) -->


        <div class="row">
            <div class="col-lg-2">
                <!-- First Button (send Link) -->
                <button class="btn btn-primary mt-1" id="showInputBtn">Send Link</button>
            </div>
            {{-- <div class="col-lg-3">
                <!-- Second Button (Join Meeting) -->
                <button class="btn btn-success btn-block mb-3" onclick="joinMeeting()">Join Meeting</button>
            </div>   --}}
            <div class="col-lg-3" id="button-container">
                <!-- Second Button (Join Meeting) -->
                <button class="btn btn-success btn-block " onclick="showInputField()">Join Meeting</button>
            </div>
            <div class="col-lg-7">

                <form action="" method="post" id="send-meeting-link" style="display: none;">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <input type="hidden" name="lawyer_id" value="{{ $lawyerId }}">
                            <input type="text" class="form-control" name="meeting_link" placeholder="Enter meeting code">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary mt-1">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Content (8 columns) -->

        <div id="jaas-container"></div>

        </section>
        <script>
            // Get references to the button and input container
            const showInputBtn = document.getElementById("showInputBtn");
            const inputContainer = document.getElementById("send-meeting-link");

            // Add click event listener to the button
            showInputBtn.addEventListener("click", function() {
                // Toggle the visibility of the input container
                if (inputContainer.style.display === "none") {
                    inputContainer.style.display = "block";
                } else {
                    inputContainer.style.display = "none";
                }
            });
        </script>


        <script>
             $(function() {
            $("#send-meeting-link").on('submit', function(e) {
                e.preventDefault();
                // Show the loader
                $.ajax({
                    url: "/store-meeting-link",
                    method: "post",
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,

                    success: function(data) {
                        toastr.success(data.message, 'Success');

                // Clear the input field or perform any other actions as needed
                $('#inputContainer input[name="meeting_link"]').val('');
                    }
                });
            });
        });
        </script>
       
    @endsection
