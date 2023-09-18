@extends('front-layouts.master-layout')
@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- google fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap" rel="stylesheet">
<!-- my css file-->
<style>
    div.transbox {
  margin: 30px;
  background-color: #ffffff;
  border: 1px solid rgba(19, 59, 238, 0.6);
  opacity: 0.6;
  height: 20%;
  text-align: center;

}

.btn:hover {
	background-color: rgba(19, 59, 238, 0.6);
	color:white;
	border: 2px solid rgba(19, 59, 238, 0.6);
}

.btn{
	color: rgba(19, 59, 238, 0.6);
	background-color: white;
	font-size:25px;
	box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}
</style>
<script src='https://meet.jit.si/external_api.js'></script>
    <div class="thebody text-center">


        <div class="container align-items-center " style="margin-top: 15%;">
            <div class="row">
                <div class="col-lg-2">
                    <div class="transbox text-center"><br><br>
                        <button id="start" class="btn btn-light btn-lg" type="button"><b>Start a new meeting</b></button>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div id="jitsi-container" class="container align-items-center">
                        <button>add users</button>
                    </div>
                </div>
            </div>

        </div>





    </div>







    <script>
        var button = document.querySelector('#start');
        var container = document.querySelector('#jitsi-container');
        var api = null;

        button.addEventListener('click', () => {
            var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var stringLength = 30;

            function pickRandom() {
                return possible[Math.floor(Math.random() * possible.length)];
            }

            var randomString = Array.apply(null, Array(stringLength)).map(pickRandom).join('');

            var domain = "meet.jit.si";
            var options = {
                "roomName": randomString,
                "parentNode": container,
                "width": 600,
                "height": 600,
            };
            api = new JitsiMeetExternalAPI(domain, options);
        });
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endsection
