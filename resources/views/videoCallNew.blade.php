@extends('layouts.app')

@section('content')
<style>
    body{
    background:#0F2027;
    background:-webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027) ;
    background: linear-gradient(to right, #2C5364, #203A43, #0F2027);
}

#join-btn{
    position: fixed;
    top:50%;
    left:50%;
    margin-top:-50px;
    margin-left:-100px;
    font-size:18px;
    padding:20px 40px;
}

#video-streams{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    height: 90vh;
    width: 1400px;
    margin:0 auto;
}

.video-container{
    max-height: 100%;
    border: 2px solid black;
    background-color: #203A49;
}

.video-player{
    height: 100%;
    width: 100%;
}

button{
    border:none;
    background-color: cadetblue;
    color:#fff;
    padding:10px 20px;
    font-size:16px;
    margin:2px;
    cursor: pointer;
}

#stream-controls{
    display: none;
    justify-content: center;
    margin-top:0.5em;
}

@media screen and (max-width:1400px){
    #video-streams{
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        width: 95%;
    }
}
.video-container{ 
    border: 1px solid black;
    border-radius: 30px;
    overflow: hidden;
}
</style>
<button class="btn btn-primary" id="join-btn">Join Meeting</button>

@if ($meettingLink == '1122')
<div id="stream-wrapper">
    <div id="video-streams"></div>

    <div id="stream-controls">
        <button class="btn btn-primary" id="leave-btn">Leave Meeting</button>
        <button class="btn btn-primary" id="mic-btn">Mic On</button>
        <button class="btn btn-primary" id="camera-btn">Camera on</button>
    </div>
</div>
@else
<button class="btn btn-primary" id="join-btn">Ask to Allow</button>
@endif


<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
<script src="{{ asset('videoCall/AgoraRTC_N-4.7.3.js') }}"></script>
<script src='{{ asset('videoCall/main.js') }}'></script>

@endsection