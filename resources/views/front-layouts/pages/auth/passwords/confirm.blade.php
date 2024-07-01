@extends('front-layouts.master-layout')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>Confirm Password</h2>
                    </div>
                </div>
                <div class="col-auto float-end ms-auto breadcrumb-menu">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Confirm Password</li>
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
                    <form action="{{ route('reset.password') }}" method="POST">
                      @csrf
                   
                      <input type="hidden" name="email" value="{{ $userEmail->email }}">
                        <div class="form-group form-focus">
                            <label class="focus-label">Password</label>
                            <input type="phone" class="form-control @error('password') is-invalid @enderror" name="password"
                                value="{{ old('password') }}" autocomplete="password" required placeholder="********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-focus">
                            <label class="focus-label">Confirm Password</label>
                            <input type="phone" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"
                                value="{{ old('password') }}" autocomplete="new-password" required  placeholder="********">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Send</button>
                          
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
