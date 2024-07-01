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
    <form action="{{ route('lawyer.profile.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="widget">
            <div class="row">
                <div class="col-xl-6">
                    <h4 class="widget-title">Profile</h4>
                </div>
                <div class="form-group col-xl-6">
                    <div class="media align-items-center mb-3 d-flex">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg" hidden />
                                <label for="imageUpload" class="btn btn-primary" class="pencil-lable"><i
                                        class="fas fa-pencil-alt"></i>
                                </label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $user->image ?? '' }});"></div>
                            </div>
                        </div>
                        <div class="media-body">
                            <p class="mb-0">Advocate</p>
                            <h5 class="mb-0">{!! $user->name !!}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="personal-info-tab" data-toggle="tab" href="#personal-info" role="tab"
                        aria-controls="personal-info" aria-selected="true">Personal Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="documents-tab" data-toggle="tab" href="#documents" role="tab"
                        aria-controls="documents" aria-selected="false">Documents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="account-setting-tab" data-toggle="tab" href="#account-setting" role="tab"
                        aria-controls="account-setting" aria-selected="false">Account Setting</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="personal-info" role="tabpanel"
                    aria-labelledby="personal-info-tab">
                    <div class="row">
                        <div class="col-xl-12">
                            <h5 class="form-title">Personal Information</h5>
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Name</label>
                            <input class="form-control black_input" name="name" type="text"
                                value="{!! $user->name !!}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Email</label>
                            <input class="form-control black_input" name="email" type="email"
                                value="{!! $user->email !!}">
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Mobile Number</label>
                            <input class="form-control black_input no_only" name="phone" type="text"
                                value="{!! $user->phone !!}" required>
                            @error('phone')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Date of birth</label>
                            <input type="date" class="form-control black_input white-date-input provider_datepicker"
                                autocomplete="off" onchange="validateBirthdate(event)" name="date_of_birth"
                                value="{!! $user->date_of_birth !!}">
                            <small id="birthdateError" class="form-text text-danger"></small>
                            @error('date')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label">Gender</label>
                            <select class="form-control form-select black_input" name="gender">
                                <option>Select Gender</option>
                                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-xl-12">
                            <h5 class="form-title">Address Information</h5>
                        </div>
                        <div class="form-group col-xl-12">
                            <label class="me-sm-2 black_label">Address</label>
                            <input type="text" name="address" class="form-control black_input"
                                value="{{ $user->address ?? '' }}">
                            @error('address')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="city">City</label>
                            <input class="form-control black_input" type="text" name="city"
                                value="{!! $user->city !!}">
                            @error('city')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="state">State</label>
                            <input class="form-control black_input" type="text" name="state"
                                value="{!! $user->state !!}">
                            @error('state')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-6">
                            <label class="me-sm-2 black_label" for="postal_code">Postal Code</label>
                            <input type="text" class="form-control black_input" name="postal_code"
                                value="{{ $user->postal_code ?? '' }}">
                            @error('postal_code')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-xl-12">
                            <button class="btn btn-primary ps-5 pe-5 update_button" type="submit">Update</button>
                        </div>
                    </div>
                </div>
    </form>
    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
        <div class="row">
            <div class="col-xl-12">
                <h5 class="form-title">Documents</h5>
            </div>
            <div class="form-group col-xl-6">
                <label class="me-sm-2 black_label">Degree</label>
                <input class="form-control black_input" type="text" value="{!! $user->degree !!}" readonly>

            </div>
            <div class="form-group col-xl-6">
                <label class="me-sm-2 black_label">Qualification</label>
                <input class="form-control black_input" value="{!! $user->qualification !!}" readonly>

            </div>
            <div class="form-group col-xl-12">
                <label class="me-sm-2 black_label">Experience in years</label>
                <input class="form-control black_input no_only" value="{!! $user->experience_in_years !!}" readonly>

            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->high_court_licence }}" alt="Certificate 1" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">High Court Licence</h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->supreme_court_licence }}" alt="Certificate 2" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Supreme Court Licence</h5>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <img src="{{ $user->qualification_certificate }}" alt="Certificate 3" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Qualification Certificate</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="account-setting" role="tabpanel" aria-labelledby="account-setting-tab">
        <form action="{{ route('lawyer.account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lawyer_id" value="{{ $user->id ?? '' }}">
            <div class="row">
                <div class="col-xl-12">
                    <h5 class="form-title">Bank Account</h5>
                </div>
                <div class="form-group col-xl-6">
                    <label class="me-sm-2 black_label">Bank Account Title</label>
                    <input type="text" class="form-control black_input" name="bank_account_title"
                        value="{{ $user->accountDetail->bank_account_title ?? '' }}">

                </div>
                <div class="form-group col-xl-6">
                    <label class="me-sm-2 black_label">Bank Name</label>
                    <input type="text" class="form-control black_input" name="bank_name"
                        value="{{ $user->accountDetail->bank_name ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">Bank Account Number</label>
                    <input type="text" class="form-control black_input" name="bank_account_number"
                        value="{{ $user->accountDetail->bank_account_number ?? '' }}">

                </div>
                <div class="col-xl-12">
                    <h5 class="form-title">JazzCash Account</h5>
                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">JazzCash Title</label>
                    <input type="text" class="form-control black_input" name="jazzcash_title"
                        value="{{ $user->accountDetail->jazzcash_title ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <label class="me-sm-2 black_label">JazzCash Number</label>
                    <input type="text" class="form-control black_input" name="jazzcash_number"
                        value="{{ $user->accountDetail->jazzcash_number ?? '' }}">

                </div>
                <div class="form-group col-xl-12">
                    <button class="btn btn-primary ps-5 pe-5 update_button" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
@endsection
@section('injected-scripts')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.countrypicker').countrypicker();
    </script>
    <script>
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 3000);
    </script>
    <script>
        $(document).ready(function() {
            var currentDate = new Date();
            // Format the date as "YYYY-MM-DD"
            var formattedDate = currentDate.toISOString().split('T')[0];
            // Set the max attribute of the birthdate input field
            document.getElementById('provider_datepicker').max = formattedDate;
        });

        function validateBirthdate(event) {
            let date = event.target.value;
            var birthdateError = document.getElementById('birthdateError');

            var currentDate = new Date();
            var selectedDate = new Date(date);

            // Calculate the minimum allowed birthdate (18 years ago)
            var minBirthdate = new Date();
            minBirthdate.setFullYear(currentDate.getFullYear() - 18);

            if (selectedDate > minBirthdate) {
                birthdateError.textContent = 'You must be at least 18 years old.';
                $('.update_button').prop('disabled', true);
            } else {
                birthdateError.textContent = '';
                $('.update_button').prop('disabled', false);
                // Date is valid, continue with further processing or form submission
            }
        }
    </script>
    <script src="{{ asset('front') }}/assets/js/custom.js"></script>
@endsection
