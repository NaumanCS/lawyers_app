@extends('front-layouts.master-layout')
@section('content')
    <style>
        .scrollable-div {
            overflow-x: auto;
            white-space: nowrap;
            /* Hide scrollbar */
            scrollbar-width: none;
            -ms-overflow-style: none;
            overflow: -moz-scrollbars-none;
        }

        .scrollable-div::-webkit-scrollbar {
            display: none;
        }

        .lawyers-card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
    <div class="container py-5">
        <div class="card lawyers-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2 col md-2 col-sm-12">
                        <div class="lawyer-img d-flex justify-content-center align-items-center"
                            style="border-radius: 50%; width: 100%; overflow: hidden;">
                            <img src="{{ $lawyerDetail->image }}" alt="Lawyer" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-8 col-sm-12">
                        <h5 class="card-title">{{ $lawyerDetail->name }}</h5>

                        <div class="card"
                            style="display: inline-block; border:none; border-right: 2px solid black; border-radius: 0;">
                            <div class="card-body p-2">
                                <h6 class="card-title">Reviews</h6>
                                <p class="card-text">+163</p>
                            </div>
                        </div>

                        <div class="card" style="display: inline-block; border: none">
                            <div class="card-body p-2">
                                <h6 class="card-title">Experience</h6>
                                <p class="card-text">15 Years</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-2 col-sm-12"
                        style="display: flex; flex-direction: column; justify-content: space-evenly;">
                        <a href="{{ route('login.page') }}" class="py-2 btn btn-primary d-flex justify-content-evenly align-items-center"><i
                                class="fa-solid fa-video"></i>Video Consultation</a>
                        <a href="{{ route('login.page') }}" class="py-2 btn btn-primary d-flex justify-content-evenly align-items-center"><i
                                class="fa-solid fa-calendar-check"></i>Book Appointment</a>
                    </div>
                </div>
                <div class="scrollable-div mt-3">
                    <div class="card me-4 w-100" style="display: inline-block; background:black !important;">
                        <div class="card-body row">
                            @foreach ($lawyerDetail->time_spans as $span)
                                <div class="col-2 m-3 px-3 py-2 d-flex align-items-center justify-content-center bg-light">
                                    <input type="radio" value="{{$span->id}}" name="select_time_span" id="select_time_span{{$span->id}}">
                                    <label class="mb-0" for="select_time_span{{$span->id}}">{{ $span->time_spans }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="card me-4 w-50" style="display: inline-block; background:black !important;">
                        <div class="card-body">
                            <h5 class="card-title text-light">Video Consultation</h5>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Monday - Friday | 12:00 PM - 06:00 PM
                            </p>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Saturday - Sunday | 12:00 PM - 06:00 PM
                            </p>
                            <div class="d-flex justify-content-between">
                                <span style="color: chartreuse;">Available from tomorrow</span>
                                <span style="color: whitesmoke">Fee: Rs1500</span>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="card me-4" style="display: inline-block; width: 40%; background:black !important;">
                        <div class="card-body">
                            <h5 class="card-title text-light">Chamber Address</h5>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Monday - Friday | 12:00 PM - 06:00 PM
                            </p>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Saturday - Sunday | 12:00 PM - 06:00 PM
                            </p>
                            <div class="d-flex justify-content-between">
                                <span style="color: chartreuse;">Available from tomorrow</span>
                                <span style="color: whitesmoke">Fee: Rs1500</span>
                            </div>
                        </div>
                    </div>

                    <div class="card me-4" style="display: inline-block; width: 40%; background:black !important;">
                        <div class="card-body">
                            <h5 class="card-title text-light">Video Consultation</h5>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Monday - Friday | 12:00 PM - 06:00 PM
                            </p>
                            <p class="card-text d-flex align-items-center"><i class="fa-solid fa-clock"
                                    style="font-size: 19px;margin-right: 10px;"></i>Saturday - Sunday | 12:00 PM - 06:00 PM
                            </p>
                            <div class="d-flex justify-content-between">
                                <span style="color: chartreuse;">Available from tomorrow</span>
                                <span style="color: whitesmoke">Fee: Rs1500</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
