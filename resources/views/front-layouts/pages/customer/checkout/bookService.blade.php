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
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
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

                           

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Book Appointment
                            </button>


                        </div>
                    </div>
                    <div class="scrollable-div mt-3">
                        <div class="card me-4 w-100" style="display: inline-block; background:black !important;">
                            <div class="card-body row">
                                <input type="date" name="date" id="" required>
                                <input type="hidden" name="lawyer_id" value="{{ $lawyerDetail->id }}" id="">
                                <input type="hidden" name="amount" value="{{ $lawyerDetail->service->amount ?? '' }}"
                                    id="">
                                   
                                @foreach ($lawyerDetail->time_spans as $span)
                                    <?php
                            // Extract start time from the time span
                            list($startTime, $endTime) = explode(' - ', $span->time_spans);
                    
                            // Create DateTime objects for comparison
                            $currentTime = new DateTime();
                            $twoHoursLater = new DateTime('+2 hours');
                            $spanStartTime = new DateTime($startTime);
                          
                            // Check if the start time is after 2 hours from the current time
                            if ($spanStartTime > $twoHoursLater) {
                        ?>
                          {{-- {{ dd(1) }} --}}
                                    @if ($span->booked == 1)
                                        <div
                                            class="col-2 m-3 px-3 py-2 d-flex align-items-center justify-content-center bg-danger text-white">
                                            <input type="hidden" name="lawyer_id" value="{{ $lawyerDetail->id }}"
                                                id="">
                                            <input type="hidden" name="amount"
                                                value="{{ $lawyerDetail->service->amount ?? '' }}" id="">
                                            <input type="radio" value="{{ $span->id }}" name="select_time_span"
                                                id="select_time_span{{ $span->id }}" required disabled>
                                            <label class="mb-0"
                                                for="select_time_span{{ $span->id }}">{{ $span->time_spans }}</label>
                                        </div>
                                    @else
                                        <div
                                            class="col-2 m-3 px-3 py-2 d-flex align-items-center justify-content-center bg-light">
                                            <input type="hidden" name="lawyer_id" value="{{ $lawyerDetail->id }}"
                                                id="">
                                            <input type="hidden" name="amount"
                                                value="{{ $lawyerDetail->service->amount ?? '' }}" id="">
                                            <input type="radio" value="{{ $span->id }}" name="select_time_span"
                                                id="select_time_span{{ $span->id }}" required>
                                            <label class="mb-0"
                                                for="select_time_span{{ $span->id }}">{{ $span->time_spans }}</label>
                                        </div>
                                    @endif

                                    <?php
                            }
                        ?>
                                @endforeach
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Describe your issue shortly</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      
                                            <textarea class="w-100" name="detail" id="detail" rows="4" placeholder="Describe your issue shortly" maxlength="200" required></textarea>
                                      
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                            <button type="submit"
                                            class="py-2 btn btn-primary d-flex justify-content-evenly align-items-center">
                                            </i>Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
