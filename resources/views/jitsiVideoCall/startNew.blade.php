@extends('front-layouts.video-call-layout')
@section('content')
    <script src='https://8x8.vc/vpaas-magic-cookie-486c47a14c1d4f048c13fd841aafd042/external_api.js' async></script>
    <style>
        #jaas-container {
            height: 80%;
        }
    </style>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



    <div class="col-xl-9 col-md-8" style="height: 100vh">
        <div class="row">
        </div>
        <div id="jaas-container"></div>
    </div>


    <script type="text/javascript">
        let api; // Declare api in the global scope
        let timer;

        function initializeJitsi(roomName) {
            api = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: roomName,
                parentNode: document.querySelector('#jaas-container'),
                // Make sure to include a JWT if required for your setup.
                // jwt: "Your-JWT-Token"
            });

           // Start the timer to close the meeting after 1 minute
           timer = setTimeout(function() {
                closeMeeting();
            }, 900000); // 15 minutes in milliseconds
        }

        function closeMeeting() {
            if (api) {
                api.executeCommand('hangup');
                api.dispose();
                api = null;
                alert("Meeting has been closed because 15 minute has elapsed.");
            }
            // Clear the timer
            clearTimeout(timer);

          
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

        // Get the room name from your Laravel variable and initialize the meeting
        const roomNameFromLaravel = "{{ $meetingLink }}"; // Replace with your actual Laravel variable

        // Initialize the meeting with the room name from Laravel when the page loads
        window.onload = function() {
            if (roomNameFromLaravel) {
                initializeJitsi(roomNameFromLaravel);
            }
        };
    </script>
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
