@extends('front-layouts.master-lawyer-layout')
@section('injected-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-xxxxx" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('front') }}/assets/css/custom.css">
@endsection
@section('content')
    @if (session('message'))
        <div id="flash-message" class="mb-3">
            @include('flash::message')
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="section-header text-center">
                    <h2>Add Service</h2>
                </div>
                <?php
                $update_id = 0;
                if ($id !== 0) {
                    $update_id = $id;
                }
                ?>
                <form action="{{ route('lawyer.service.store', $update_id) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $update_id }}" name="id">
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">Service Information</h3>
                        <div class="row">


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="me-sm-2 black_label">Select a Category for this service</label>
                                    <select class="form-control form-select black_input" name="categories_id"
                                        id="categories" required>
                                        <option selected disabled>Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id ?? '' }}"
                                                {{ isset($service) && $service->categories_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories_id')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="black_label">Service Amount <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"
                                        style="background-color: #393a3c; color:white; border: 1px solid #393a3c;">PKR</span>
                                    <input type="number" class="form-control black_input" name="amount" aria-label="PKR"
                                        value="{{ $service->amount ?? '' }}" required>
                                    @error('amount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">Service Timming</h3>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="black_label">Days of the week<span class="text-danger">*</span></label>
                                    <div class="checkboxes">
                                        <input type="checkbox" name="days[]" value="monday"
                                        @if($service && $service->days && in_array('monday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="monday">Mon</label>

                                        <input type="checkbox" name="days[]" value="tuesday"
                                             @if($service && $service->days && in_array('tuesday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="tuesday">Tues</label>

                                        <input type="checkbox" name="days[]" value="wednesday"
                                             @if($service && $service->days && in_array('wednesday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="wednesday">Wed</label>

                                        <input type="checkbox" name="days[]" value="thursday"
                                             @if($service && $service->days && in_array('thursday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="thursday">Thurs</label>

                                        <input type="checkbox" name="days[]" value="friday"
                                             @if($service && $service->days && in_array('friday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="friday">Fri</label>

                                        <input type="checkbox" name="days[]" value="saturday"
                                             @if($service && $service->days && in_array('saturday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="saturday">Sat</label>

                                        <input type="checkbox" name="days[]" value="sunday"
                                             @if($service && $service->days && in_array('saturday', json_decode($service->days))) checked @endif>
                                        <label class="mx-2" for="sunday">Sun</label>

                                        <!-- Repeat the above for each day of the week -->
                                    </div>
                                    @error('days')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="black_label">Start Time<span class="text-danger ">*</span></label>
                                    <input class="form-control black_input" type="time" name="start_time"
                                        value="{{ $service->start_time ?? '' }}" required>
                                    @error('start_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="black_label">End Time<span class="text-danger ">*</span></label>
                                    <input class="form-control black_input" type="time" name="end_time" required
                                        value="{{ $service->end_time ?? '' }}">
                                    @error('end_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                   
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('injected-scripts')
    <script src="{{ asset('front') }}/assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            // Store the original options of the "ending-day" dropdown
            var originalOptions = $('#ending_day').html();

            $('#starting_day').change(function() {
                var selectedDay = $(this).val();

                // Reset the "ending-day" dropdown with the original options
                $('#ending_day').html(originalOptions);

                // Remove the selected day from the "ending-day" dropdown
                $('#ending_day option[value="' + selectedDay + '"]').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#extra_day_div').hide();
            $('#extra_day_start_time_div').hide();
            $('#extra_day_end_time_div').hide();
            $('input[name="add_extra_day"]').change(function() {
                var selectedValue = $(this).val();

                if (selectedValue === '1') {
                    updateExtraDayOptions();
                    $('#extra_day_div').show();
                    $('#extra_day_start_time_div').show();
                    $('#extra_day_end_time_div').show();
                } else {
                    $('#extra_day_div').hide();
                    $('#extra_day_start_time_div').hide();
                    $('#extra_day_end_time_div').hide();
                }
            });

            function updateExtraDayOptions() {
                var startingDay = $('#starting_day').val();
                var endingDay = $('#ending_day').val();
                var extraDaySelect = $('#extra_day');

                // Clear previous options
                extraDaySelect.empty();

                // Populate options
                var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

                var excludedDays = [startingDay, endingDay];

                for (var i = 0; i < days.length; i++) {
                    if (!excludedDays.includes(days[i])) {
                        extraDaySelect.append($('<option></option>').attr('value', days[i]).text(days[i]));
                    }
                }
            }

            // Event listener for starting day change
            $('#starting_day').change(function() {
                updateExtraDayOptions();
            });

            // Event listener for ending day change
            $('#ending_day').change(function() {
                updateExtraDayOptions();
            });
        });
    </script>
@endsection
