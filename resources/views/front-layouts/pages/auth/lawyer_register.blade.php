@extends('front-layouts.master-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2 style="font-weight: 600!important">Registration</h2>
                    </div>
                </div>
                <div class="col-auto float-end ms-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Register</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <img src="{{ asset('front') }}/assets/img/LawyerSignup.jpg" alt="Sign Up to the App" class="img-fluid">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <form method="POST" action="{{ route('lawyer.register') }}" enctype="multipart/form-data" id="formId">
                        @csrf
                        <div id="step1">

                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name"
                                        placeholder="Your Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Mobile Number</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required placeholder="Phone">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" autocomplete="email"
                                        placeholder="abc@exapmle.com" email>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">City</label>
                                    <select class="form-control @error('city') is-invalid @enderror" name="city" required>
                                        <option value="" disabled selected>Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->city }}">{{ $city->city }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                {{-- <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        name="country" value="{{ old('country') }}" required autocomplete="country"
                                        placeholder="Country">
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Create Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password" placeholder="********">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group form-focus">
                                    <label class="focus-label">Confirm password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="********">
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="black_label">Category<span class="text-danger ">*(Select any two
                                                categories)</span></label>
                                        <select id="multiSelect" class="form-control form-select" name="categories[]"
                                            multiple="multiple" required>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id ?? '' }}">{{ $category->title ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a class="nav-link header-login" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#login_modal">Already have an account?</a>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-block btn-lg login-btn"
                                    onclick="showStep(2)">Next</button>
                            </div>

                        </div>

                        <!-- Step 2: Address and Categories -->
                        <div id="step2" style="display: none;">

                            <div class="row">
                                <h6 class="bg-black text-white rounded p-2">Lawyer Experience</h6>
                                {{-- <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="black_label">Degree / Advocacy Level<span
                                                class="text-danger ">*</span></label>
                                        <select class="form-control form-select" name="degree" id="degree">
                                            <option selected disabled>Select Degree</option>
                                            <option value="Advocate" {{ old('degree') == 'Advocate' ? 'selected' : '' }}>
                                                Advocate
                                            </option>
                                            <option value="Barister" {{ old('degree') == 'Barister' ? 'selected' : '' }}>
                                                Barister
                                            </option>
                                        </select>
                                        @error('degree')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-lg-3" id="advocate">
                                    <div class="form-group">
                                        <input type="checkbox" class="license-checkbox" name="advocate" value="1"
                                            {{ is_array(old('advocate')) && in_array('1', old('advocate')) ? 'checked' : '' }} checked>
                                        <label class="mx-2">Advocate</label>
                                    </div>
                                </div>

                                <div class="col-lg-4" id="baristerHighCourt">
                                    <div class="form-group">
                                        <input type="checkbox" class="license-checkbox" name="high_court" value="1"
                                            {{ is_array(old('high_court')) && in_array('1', old('high_court')) ? 'checked' : '' }}>
                                        <label class="" for="monday">Advocate High Court</label>
                                    </div>
                                </div>

                                <div class="col-lg-5" id="baristerSupremeCourt">
                                    <div class="form-group">
                                        <input type="checkbox" class="license-checkbox" name="supreme_court"
                                            value="1"
                                            {{ is_array(old('supreme_court')) && in_array('1', old('supreme_court')) ? 'checked' : '' }}>
                                        <label class="" for="monday">Advocate Supreme Court</label>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div id="advocateLicenseDiv">
                                        <div class="form-group">
                                            <label class="black_label">Upload Advocate Licence<span
                                                    class="text-danger">*</span></label>

                                                    <input type="file" name="advocate_licence" class="dropify" data-default-file="" required>
                                            @error('advocate_licence')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="highCourtLicenseDiv" style="display: none;">
                                        <div class="form-group">
                                            <label class="black_label">Upload High Court Licence<span
                                                    class="text-danger">*</span></label>

                                            <input type="file" name="high_court_licence" class="dropify"
                                                value="{{ old('high_court_licence') }}" data-default-file="">
                                            @error('high_court_licence')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="supremeCourtLicenseDiv" style="display: none;">
                                        <div class="form-group">
                                            <label class="black_label">Upload Supreme Court Licence<span
                                                    class="text-danger">*</span></label>

                                            <input type="file" name="supreme_court_licence" class="dropify"
                                                value="{{ old('supreme_court_licence') }}" data-default-file="">
                                            @error('supreme_court_licence')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="black_label">Experience In Years<span
                                                class="text-danger ">*</span></label>
                                        <select class="form-control form-select" name="experience_in_years"
                                            id="experience_in_years" required>
                                          
                                            <option value="">Select Years</option>
                                            <option value="1"
                                                {{ old('experience_in_years') == '1' ? 'selected' : '' }}>
                                                1
                                            </option>
                                            <option value="2"
                                                {{ old('experience_in_years') == '2' ? 'selected' : '' }}>
                                                2
                                            </option>
                                            <option value="3"
                                                {{ old('experience_in_years') == '3' ? 'selected' : '' }}>
                                                3
                                            </option>
                                            <option value="4"
                                                {{ old('experience_in_years') == '4' ? 'selected' : '' }}>
                                                4
                                            </option>
                                            <option value="5"
                                                {{ old('experience_in_years') == '5' ? 'selected' : '' }}>
                                                5
                                            </option>
                                            <option value="6"
                                                {{ old('experience_in_years') == '6' ? 'selected' : '' }}>
                                                6
                                            </option>
                                            <option value="7"
                                                {{ old('experience_in_years') == '7' ? 'selected' : '' }}>
                                                7
                                            </option>
                                            <option value="8"
                                                {{ old('experience_in_years') == '8' ? 'selected' : '' }}>
                                                8
                                            </option>
                                            <option value="9"
                                                {{ old('experience_in_years') == '9' ? 'selected' : '' }}>
                                                9
                                            </option>
                                            <option value="10"
                                                {{ old('experience_in_years') == '10' ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="11"
                                                {{ old('experience_in_years') == '11' ? 'selected' : '' }}>
                                                11
                                            </option>
                                            <option value="12"
                                                {{ old('experience_in_years') == '12' ? 'selected' : '' }}>
                                                12
                                            </option>
                                            <option value="13"
                                                {{ old('experience_in_years') == '13' ? 'selected' : '' }}>
                                                13
                                            </option>
                                            <option value="14"
                                                {{ old('experience_in_years') == '14' ? 'selected' : '' }}>
                                                14
                                            </option>
                                            <option value="15"
                                                {{ old('experience_in_years') == '15' ? 'selected' : '' }}>
                                                15
                                            </option>
                                            <option value="16"
                                                {{ old('experience_in_years') == '16' ? 'selected' : '' }}>
                                                16
                                            </option>
                                            <option value="17"
                                                {{ old('experience_in_years') == '17' ? 'selected' : '' }}>
                                                17
                                            </option>

                                            <option value="18"
                                                {{ old('experience_in_years') == '18' ? 'selected' : '' }}>
                                                18
                                            </option>
                                            <option value="19"
                                                {{ old('experience_in_years') == '19' ? 'selected' : '' }}>
                                                19
                                            </option>
                                            <option value="20"
                                                {{ old('experience_in_years') == '20' ? 'selected' : '' }}>
                                                20
                                            </option>
                                            <option value="21"
                                                {{ old('experience_in_years') == '21' ? 'selected' : '' }}>
                                                21
                                            </option>
                                            <option value="22"
                                                {{ old('experience_in_years') == '22' ? 'selected' : '' }}>
                                                22
                                            </option>
                                            <option value="23"
                                                {{ old('experience_in_years') == '23' ? 'selected' : '' }}>
                                                23
                                            </option>
                                            <option value="24"
                                                {{ old('experience_in_years') == '24' ? 'selected' : '' }}>
                                                24
                                            </option>
                                            <option value="25"
                                                {{ old('experience_in_years') == '25' ? 'selected' : '' }}>
                                                25
                                            </option>
                                            <option value="26"
                                                {{ old('experience_in_years') == '26' ? 'selected' : '' }}>
                                                26
                                            </option>
                                            <option value="27"
                                                {{ old('experience_in_years') == '27' ? 'selected' : '' }}>
                                                27
                                            </option>

                                            <option value="28"
                                                {{ old('experience_in_years') == '28' ? 'selected' : '' }}>
                                                28
                                            </option>
                                            <option value="29"
                                                {{ old('experience_in_years') == '29' ? 'selected' : '' }}>
                                                29
                                            </option>
                                            <option value="30"
                                                {{ old('experience_in_years') == '30' ? 'selected' : '' }}>
                                                30
                                            </option>
                                            <option value="31"
                                                {{ old('experience_in_years') == '31' ? 'selected' : '' }}>
                                                31
                                            </option>
                                            <option value="32"
                                                {{ old('experience_in_years') == '32' ? 'selected' : '' }}>
                                                32
                                            </option>
                                            <option value="33"
                                                {{ old('experience_in_years') == '33' ? 'selected' : '' }}>
                                                33
                                            </option>
                                            <option value="34"
                                                {{ old('experience_in_years') == '34' ? 'selected' : '' }}>
                                                34
                                            </option>
                                            <option value="35"
                                                {{ old('experience_in_years') == '35' ? 'selected' : '' }}>
                                                35
                                            </option>
                                            <option value="36"
                                                {{ old('experience_in_years') == '36' ? 'selected' : '' }}>
                                                36
                                            </option>
                                            <option value="37"
                                                {{ old('experience_in_years') == '37' ? 'selected' : '' }}>
                                                37
                                            </option>

                                            <option value="38"
                                                {{ old('experience_in_years') == '38' ? 'selected' : '' }}>
                                                38
                                            </option>
                                            <option value="39"
                                                {{ old('experience_in_years') == '39' ? 'selected' : '' }}>
                                                39
                                            </option>
                                            <option value="40"
                                                {{ old('experience_in_years') == '40' ? 'selected' : '' }}>
                                                40
                                            </option>
                                        </select>
                                        @error('experience_in_years')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="black_label">Qualification<span
                                                class="text-danger ">*</span></label>
                                        <select class="form-control form-select" name="qualification" id="qualification" required>
                                            <option value="">Select Qualification</option>
                                            <option value="LLB" {{ old('qualification') == 'LLB' ? 'selected' : '' }}>
                                                LLB
                                            </option>
                                            <option value="LLM" {{ old('qualification') == 'LLM' ? 'selected' : '' }}>
                                                LLM
                                            </option>
                                            <option value="Baristrate"
                                                {{ old('qualification') == 'Baristrate' ? 'selected' : '' }}>
                                                Baristrate
                                            </option>
                                        </select>
                                        @error('qualification')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div id="qualificationCertificate" style="display: none;">
                                        <div class="form-group">
                                            <label class="black_label">Upload Qualification Certificate/Degree<span
                                                    class="text-danger">*</span></label>

                                            <input type="file" name="qualification_certificate" class="dropify"
                                                value="{{ old('qualification_certificate') }}" data-default-file="">
                                            @error('qualification_certificate')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- SET DAY AND TIME --}}
                                <div class="col-lg-12">
                                    <h6 class="bg-black text-white rounded p-2">Set Days in week-Time per day</h6>
                                    <div class="form-group">
                                        <label class="black_label">Days of the week<span
                                                class="text-danger">*</span></label>
                                        <div class="checkboxes">
                                            <input class="day-checkbox" type="checkbox" name="days[]" value="monday"
                                                {{ is_array(old('days')) && in_array('monday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="monday">Mon</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="tuesday"
                                                {{ is_array(old('days')) && in_array('tuesday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="tuesday">Tues</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="wednesday"
                                                {{ is_array(old('days')) && in_array('wednesday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="wednesday">Wed</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="thursday"
                                                {{ is_array(old('days')) && in_array('thursday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="thursday">Thurs</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="friday"
                                                {{ is_array(old('days')) && in_array('friday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="friday">Fri</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="saturday"
                                                {{ is_array(old('days')) && in_array('saturday', old('days')) ? 'checked' : '' }}>
                                            <label class="mx-2" for="saturday">Sat</label>

                                            <input class="day-checkbox" type="checkbox" name="days[]" value="sunday"
                                                {{ is_array(old('days')) && in_array('sunday', old('days')) ? 'checked' : '' }}>
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
                                        <label class="black_label">Start Time<span class="text-danger">*</span></label>
                                        <select class="form-control black_input" name="start_time" required>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" {{ old('start_time') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                </option>
                                            @endfor
                                        </select>
                                        @error('start_time')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="black_label">End Time<span class="text-danger">*</span></label>
                                        <select class="form-control black_input" name="end_time" required>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00" {{ old('end_time') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                                                </option>
                                            @endfor
                                        </select>
                                        @error('end_time')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="black_label">Amount<span class="text-danger ">* (amount for 30min
                                                consultancy.)</span></label>
                                        <input class="form-control " type="text" name="amount" required
                                            value="{{ old('amount') }}">
                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ADD Account Info --}}
                                <h6 class="bg-black text-white rounded p-2">Account information</h6>
                                <div class="col-lg-6" id="bankAccount">
                                    <div class="form-group">
                                        <input type="checkbox" class="account-checkbox" name="bank_account"
                                            value="1"
                                            {{ is_array(old('bank_account')) && in_array('1', old('bank_account')) ? 'checked' : '' }}>
                                        <label class="mx-2" for="monday">Bank Account</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 " id="jazzCashAccount">
                                    <div class="form-group">
                                        <input type="checkbox" class="account-checkbox" name="jazzcash_account"
                                            value="1"
                                            {{ is_array(old('jazzcash_account')) && in_array('1', old('jazzcash_account')) ? 'checked' : '' }}>
                                        <label class="mx-2" for="monday">jazzcash_account</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div id="bankAccountDiv" style="display: none;">
                                        <div class="form-group">
                                            <label class="black_label">Bank Account Title<span
                                                    class="text-danger">*</span></label>

                                            <input class="form-control " type="text" name="bank_account_title"
                                                value="{{ old('bank_account_title') }}">
                                            @error('bank_account_title')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <label class="black_label">Bank Name<span class="text-danger">*</span></label>

                                            <input class="form-control " type="text" name="bank_name"
                                                value="{{ old('bank_name') }}">
                                            @error('bank_name')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <label class="black_label">Bank Account Number<span
                                                    class="text-danger">*(IBAN)</span></label>

                                            <input class="form-control " type="text" name="bank_account_number"
                                                value="{{ old('bank_account_number') }}">
                                            @error('bank_account_number')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div id="jazzCashDiv" style="display: none;">
                                        <div class="form-group">
                                            <label class="black_label">Jazz Cash Title<span
                                                    class="text-danger">*</span></label>

                                            <input class="form-control " type="text" name="jazzcash_account_title"
                                                value="{{ old('jazzcash_account_title') }}">
                                            @error('jazzcash_account_title')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <label class="black_label">Jazz Cash Number<span
                                                    class="text-danger">*</span></label>

                                            <input class="form-control " type="text" name="jazzcash_number"
                                                value="{{ old('jazzcash_number') }}">
                                            @error('jazzcash_number')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" onclick="showStep(1)">Previous</button>
                                <button type="submit"  class="btn btn-primary" onclick="return validateForm()">Signup</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('#multiSelect').select2({
                maximumSelectionLength: 2 // Limit the maximum selection to 2
            });
        });

        function showStep(step) {
            if (step === 1) {
                document.getElementById('step1').style.display = 'block';
                document.getElementById('step2').style.display = 'none';
            } else if (step === 2) {
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
            }
        }



        // $(document).ready(function() {
        //     // Initially check the selected value and show/hide the Barister Certificate field
        //     toggleBaristerCertificateField();

        //     // Add an event listener to the degree dropdown
        //     $('#degree').on('change', function() {
        //         toggleBaristerCertificateField();
        //     });

        //     function toggleBaristerCertificateField() {
        //         var selectedDegree = $('#degree').val();
        //         if (selectedDegree === 'Barister') {
        //             $('#baristerHighCourt').show();
        //             $('#baristerSupremeCourt').show();

        //         } else {
        //             $('#baristerHighCourt').hide();
        //             $('#baristerSupremeCourt').hide();

        //         }
        //     }
        // });

        $(document).ready(function() {
            $('.license-checkbox').on('change', function() {
                if ($('input[name="high_court"]').is(':checked')) {
                    $('#highCourtLicenseDiv').show();
                } else {
                    $('#highCourtLicenseDiv').hide();
                }

                if ($('input[name="supreme_court"]').is(':checked')) {
                    $('#supremeCourtLicenseDiv').show();
                } else {
                    $('#supremeCourtLicenseDiv').hide();
                }

                if ($('input[name="advocate"]').is(':checked')) {
                    $('#advocateLicenseDiv').show();
                } else {
                    $('#advocateLicenseDiv').hide();
                }
            });
        });

        // qualification degree
        $(document).ready(function() {
            $('#qualification').on('change', function() {
                var selectedQualification = $(this).val();

                if (selectedQualification === 'LLB' || selectedQualification === 'LLM' ||
                    selectedQualification === 'Baristrate') {
                    $('#qualificationCertificate').show();
                } else {
                    $('#qualificationCertificate').hide();
                }
            });
        });

        $(document).ready(function() {
            $('.account-checkbox').on('change', function() {
                if ($('input[name="jazzcash_account"]').is(':checked')) {
                    $('#jazzCashDiv').show();
                } else {
                    $('#jazzCashDiv').hide();
                }

                if ($('input[name="bank_account"]').is(':checked')) {
                    $('#bankAccountDiv').show();
                } else {
                    $('#bankAccountDiv').hide();
                }
            });
        });
    </script>

<script>
    function validateCheckboxes() {
        const checkboxes = document.querySelectorAll('.license-checkbox');
        let isChecked = false;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            alert("Please select Lawyer Experience.");
            return false; // Prevent form submission
        }

        // If at least one checkbox is checked, allow the form to be submitted
        return true;
    }
</script>
<script>
    function showStep(step) {
        var isValid = validateStep(step - 1); // Validate the previous step before proceeding

        if (isValid) {
            // Hide all steps
            $('[id^=step]').hide();

            // Show the specified step
            $('#step' + step).show();
        }
    }

    function validateStep(step) {
        var isValid = true;

        $('#step' + step + ' [required]').each(function() {
            if ($(this).is('select[multiple]')) {
                
                var selectedItems = $(this).val();
                var $select2Container = $(this).next('.select2').find('.select2-selection');
                if (!selectedItems || selectedItems.length < 1) {
                    isValid = false;
                    $select2Container.css('border-color', 'red').css('border-width', '1px').css('border-style', 'solid').css('border-color', 'red', 'important');
                } else {
                    $select2Container.css('border', '');
                }
            } else {
                // Check if the field is empty
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid'); // Add a red border to indicate error
                } else {
                    $(this).removeClass('is-invalid'); // Remove red border if field is filled
                }
            }
        });

        return isValid;
    }


    function validateCheckboxes() {
        // Validation logic for checkboxes in step 2
    }
</script>
<script>
    // Function to validate the form
    function validateForm() {
        var daysCheckboxes = document.querySelectorAll('.day-checkbox');
        var accountCheckboxes = document.querySelectorAll('.account-checkbox');
        var dayChecked = false;
        var accountChecked = false;

        // Check if at least one day checkbox is checked
        daysCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                dayChecked = true;
            }
        });

        // Check if at least one account checkbox is checked
        accountCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                accountChecked = true;
            }
        });

        // If either day or account checkbox is not checked, show alert and prevent form submission
        if (!dayChecked) {
            alert('Please select at least one day of the week.');
            return false;
        }

        if (!accountChecked) {
            alert('Please select at least one account type (Bank Account or JazzCash Account).');
            return false;
        }

        // If both day and account checkboxes are checked, submit the form
        return true
    }
</script>


@endsection
@section('injected-script')
    {{-- <script>
        $(document).ready(function() {
            $('#exampleSelect').multiselect();
        });
    </script> --}}
@endsection
