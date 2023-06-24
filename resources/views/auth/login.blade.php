<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Lawyer App | Admin Login</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('admin') }}/assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/admin.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="login-page">
            <div class="login-body container">
                <div class="loginbox">
                    <div class="login-right-wrap">
                        <div class="account-header">
                            <div class="account-logo text-center mb-4">
                                <a href="index.html">
                                    <img src="{{asset('admin')}}/assets/img/logo-icon.png" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="login-header">
                            <h3>Login <span>Truelysell</span></h3>
                            <p class="text-muted">Access to our dashboard</p>
                        </div>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Email Address</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="control-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('admin') }}/assets/js/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('admin') }}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('admin') }}/assets/js/admin.js"></script>

</body>

</html>
