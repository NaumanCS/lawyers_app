@extends('front-layouts.master-layout')

<head>
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>Registration</h2>
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
                    <form method="POST" action="{{ route('lawyer.register') }}">
                        @csrf
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
                                    name="phone" value="{{ old('phone') }}" required placeholder="986 452 1236">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-12 form-group form-focus">
                                <label class="focus-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="abc@exapmle.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
                            <div class="col-lg-6">
                                <select class="select2" multiple name="example">
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>

                            </div>
                        </div>
                        <div class="text-end">
                            <a class="nav-link header-login" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#login_modal">Already have an account?</a>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('injected-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
