@extends('front-layouts.master-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>Login</h2>
                    </div>
                </div>
                <div class="col-auto float-end ms-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
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
                    <img src="{{ asset('front') }}/assets/img/LoginImage.jpeg" alt="Sign Up to the App" class="img-fluid">
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('users.login') }}">
                        @csrf
                        <div class="form-group form-focus">
                            <label class="focus-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" required placeholder="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-focus">
                            <label class="focus-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" placeholder="********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-focus">
                            <label class="focus-label">User Type</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_user" value="user" {{ old('user_type') == 'user' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="user_type_user">User</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_lawyer" value="lawyer" {{ old('user_type') == 'lawyer' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="user_type_lawyer">Lawyer</label>
                                </div>
                            </div>
                            @error('user_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        
                        <div class="d-grid">
                            <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
                            {{-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif --}}
                            <a class="btn btn-link" href="{{ route('forgot.password') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                        <div class="text-center dont-have">Don’t have an account? <a
                                href="{{ route('lawyer.register.page') }}">Register As Lawyer</a> OR <a
                                href="{{ route('customer.register.page') }}">Register as a
                                Customer</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('injected-script')
    {{-- <script>
        $(document).ready(function() {
            $('#exampleSelect').multiselect();
        });
    </script> --}}
@endsection
