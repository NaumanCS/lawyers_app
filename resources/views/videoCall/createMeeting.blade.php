@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: #0F2027;
            background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027);
        }

        #join-btn {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -100px;
            font-size: 18px;
            padding: 20px 40px;
        }

        #video-streams {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            height: 90vh;
            width: 1400px;
            margin: 0 auto;
        }

        .video-container {
            max-height: 100%;
            border: 2px solid black;
            background-color: #203A49;
        }

        .video-player {
            height: 100%;
            width: 100%;
        }

        button {
            border: none;
            background-color: cadetblue;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            margin: 2px;
            cursor: pointer;
        }

        #stream-controls {
            display: none;
            justify-content: center;
            margin-top: 0.5em;
        }

        @media screen and (max-width:1400px) {
            #video-streams {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                width: 95%;
            }
        }

        .video-container {
            border: 1px solid black;
            border-radius: 30px;
            overflow: hidden;
        }
    </style>
    {{-- <button class="btn btn-primary" id="join-btn">Join Meeting</button> --}}

    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-6 text-center">
                    
                    <button class="btn btn-primary" id="showFormBtn">Create Meeting</button>
                    <button class="btn btn-primary" id="showInputBtn">Join Meeting</button>
                </div>
                <div class="col-12 text-center mt-2" id="inputContainer" style="display: none;">
                    <form action="{{ route('agora.index.new') }}" method="post">
                        @csrf
                    <input type="text" class="form-control" name="meeting_link" placeholder="Enter meeting code">
                    <button type="submit" class="btn btn-primary mt-2">Join</button>
                    </form>
                </div>

                <div class="col-12 text-center" id="formContainer" style="display: none;">
                    <form action="{{ route('store.meeting') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="meeting_with"  value="{{ $meetWith }}">
                            <input type="hidden" name="created_by"  value="{{ $createdBy }}">
                            <label for="meetingName" class="form-label text-white">Meeting Name:</label>
                            <input type="text" class="form-control" name="meeting_name" id="meetingName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Generate Link</button>
                    </form>
                    <div id="meetingLink" class="mt-3" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3" >
        <div class="row">
           
        </div>
    </div>
   

    <script>
        // Get references to the button and input container
        const showInputBtn = document.getElementById("showInputBtn");
        const inputContainer = document.getElementById("inputContainer");

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
    // Get references to the button and form container
    const showFormBtn = document.getElementById("showFormBtn");
    const formContainer = document.getElementById("formContainer");
    const meetingForm = document.getElementById("meetingForm");
    const meetingNameInput = document.getElementById("meetingName");
    const meetingLink = document.getElementById("meetingLink");

    // Add click event listener to the button to show the form
    showFormBtn.addEventListener("click", function() {
        formContainer.style.display = "block";
    });

    // Add submit event listener to the form
    meetingForm.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent the form from submitting and refreshing the page

        // Generate the meeting link based on the input and display it
        const meetingName = meetingNameInput.value.trim();
        const link = generateMeetingLink(meetingName);
        meetingLink.textContent = "Meeting Link: " + link;
        meetingLink.style.display = "block";
    });

    // Function to generate the meeting link (replace this with your own logic)
    function generateMeetingLink(meetingName) {
        // Example: You can generate a link based on the meeting name
        return "https://your-website.com/meetings/" + encodeURIComponent(meetingName);
    }
</script>

    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script src="{{ asset('videoCall/AgoraRTC_N-4.7.3.js') }}"></script>
    <script src='{{ asset('videoCall/main.js') }}'></script>
@endsection
