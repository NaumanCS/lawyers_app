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
                    $update_id = 0;
                }
                ?>
                <form action="{{ route('lawyer.service.store', $update_id) }}" method="POST">
                    @csrf
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">Service Information</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" value="{{ $update_id }}" name="id">
                                <div class="form-group">
                                    <label class="black_label">Service Title <span class="text-danger">*</span></label>
                                    <input class="form-control black_input" type="text" name="title"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="black_label">Service Location <span class="text-danger">*</span></label>
                                    <input class="form-control black_input" type="text" name="location" required
                                        value="{{ old('location') }}">
                                    @error('location')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="me-sm-2 black_label">Select a Category for this service</label>
                                    <select class="form-control form-select black_input" name="categories_id"
                                        id="categories" required>
                                        <option selected disabled>Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                        value="{{ old('amount') }}" required>
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="black_label">Starting Day of the week<span
                                            class="text-danger ">*</span></label>
                                    <select class="form-control form-select black_input" name="start_day" id="starting_day">
                                        <option selected disabled>Select A Day</option>
                                        <option value="monday" {{ old('start_day') == 'monday' ? 'selected' : '' }}>Monday
                                        </option>
                                        <option value="tuesday" {{ old('start_day') == 'tuesday' ? 'selected' : '' }}>
                                            Tuesday</option>
                                        <option value="wednessday" {{ old('start_day') == 'wednesday' ? 'selected' : '' }}>
                                            Wednessday</option>
                                        <option value="thursday" {{ old('start_day') == 'thursday' ? 'selected' : '' }}>
                                            Thursday</option>
                                        <option value="friday" {{ old('start_day') == 'friday' ? 'selected' : '' }}>Friday
                                        </option>
                                        <option value="saturday" {{ old('start_day') == 'saturday' ? 'selected' : '' }}>
                                            Saturday</option>
                                        <option value="sunday" {{ old('start_day') == 'sunday' ? 'selected' : '' }}>Sunday
                                        </option>
                                    </select>
                                    @error('starting_day')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="black_label">Ending Day of the week<span
                                            class="text-danger ">*</span></label>
                                    <select class="form-control form-select black_input" name="end_day" id="end_day">
                                        <option selected disabled>Select A Day</option>
                                        <option value="monday" {{ old('end_day') == 'monday' ? 'selected' : '' }}>Monday
                                        </option>
                                        <option value="tuesday" {{ old('end_day') == 'tuesday' ? 'selected' : '' }}>
                                            Tuesday</option>
                                        <option value="wednessday" {{ old('end_day') == 'wednesday' ? 'selected' : '' }}>
                                            Wednessday</option>
                                        <option value="thursday" {{ old('end_day') == 'thursday' ? 'selected' : '' }}>
                                            Thursday</option>
                                        <option value="friday" {{ old('end_day') == 'friday' ? 'selected' : '' }}>Friday
                                        </option>
                                        <option value="saturday" {{ old('end_day') == 'saturday' ? 'selected' : '' }}>
                                            Saturday</option>
                                        <option value="sunday" {{ old('end_day') == 'sunday' ? 'selected' : '' }}>Sunday
                                        </option>
                                    </select>
                                    @error('ending_day')
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
                                        value="{{ old('start_time') }}" required>
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
                                        value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-0">
                                    <label class="black_label">Do you want to add an extra day?<span
                                            class="text-danger ">*</span></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input black_input" type="radio" name="add_extra_day"
                                        id="Yes" value="1">
                                    <label class="form-check-label black_label" for="Yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input black_input" type="radio" name="add_extra_day"
                                        id="No" value="0">
                                    <label class="form-check-label black_label" for="No">No</label>
                                </div>
                            </div>
                            <div class="col-lg-6" id="extra_day_div">
                                <div class="form-group">
                                    <label class="black_label">Select Day<span class="text-danger ">*</span></label>
                                    <select class="form-control form-select black_input" name="extra_day">
                                        <option value="monday" {{ old('extra_day') == 'monday' ? 'selected' : '' }}>Monday
                                        </option>
                                        <option value="tuesday" {{ old('extra_day') == 'tuesday' ? 'selected' : '' }}>
                                            Tuesday</option>
                                        <option value="wednessday"
                                            {{ old('extra_day') == 'wednesday' ? 'selected' : '' }}>Wednessday</option>
                                        <option value="thursday" {{ old('extra_day') == 'thursday' ? 'selected' : '' }}>
                                            Thursday</option>
                                        <option value="friday" {{ old('extra_day') == 'friday' ? 'selected' : '' }}>Friday
                                        </option>
                                        <option value="saturday" {{ old('extra_day') == 'saturday' ? 'selected' : '' }}>
                                            Saturday</option>
                                        <option value="sunday" {{ old('extra_day') == 'sunday' ? 'selected' : '' }}>Sunday
                                        </option>
                                    </select>
                                    @error('extra_day')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6" id="extra_day_start_time_div">
                                <div class="form-group">
                                    <label class="black_label">Start Time<span class="text-danger ">*</span></label>
                                    <input class="form-control black_input" type="time" name="extra_day_start_time"
                                        id="extra_day_start_time" value="{{ old('extra_day_start_time') }}">
                                    @error('extra_day_start_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6" id="extra_day_end_time_div">
                                <div class="form-group">
                                    <label class="black_label">End Time<span class="text-danger ">*</span></label>
                                    <input class="form-control black_input" type="time" name="extra_day_end_time"
                                        id="extra_day_end_time" value="{{ old('extra_day_end_time') }}">
                                    @error('extra_day_end_time')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-fields mb-3">
                        <h3 class="heading-2">Cover Image</h3>
                        <div class="col-8 mb-4">
                            <label for="image" class="black_label"><b>Upload Your Service Cover</b></label>
                            <input type="file" name="image" class="dropify" value="{{ old('image') }}"
                                data-default-file="{{ asset('front') }}/assets/img/category/Category1.jpg">
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
