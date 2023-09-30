<!-- Provider Register Modal -->
<div class="modal account-modal fade multi-step" id="provider-register" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-header">
                    <h3>Join as a Lawyer</h3>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('lawyer.register') }}">
                    @csrf

                    <div class="form-group form-focus">
                        <label class="focus-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" placeholder="Your Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="abc@exapmle.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Mobile Number</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}" required placeholder="986 452 1236">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Create Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="********">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Conform password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Conform password">
                    </div>
                    <div class="text-end">
                        <a class="nav-link header-login" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#login_modal">Already have an account?</a>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                    </div>
                </form>
                <!-- /Register Form -->
            </div>
        </div>
    </div>
</div>
<!-- /Provider Register Modal -->

<!-- User Register Modal -->
<div class="modal account-modal fade multi-step" id="user-register" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-header">
                    <h3>Join as a Customer</h3>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('customer.register') }}">
                    @csrf
                    <div class="form-group form-focus">
                        <label class="focus-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" placeholder="Your Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Email (Optional)</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}"  autocomplete="email" placeholder="abc@exapmle.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Mobile Number</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" required placeholder="986 452 1236">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                            name="city" value="{{ old('city') }}" required placeholder="city">
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Create Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="********">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-focus">
                        <label class="focus-label">Conform password</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Conform password">
                    </div>
                    <div class="text-end">
                        <a class="nav-link header-login" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#login_modal">Already have an account?</a>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                    </div>
                </form>
                <!-- /Register Form -->
            </div>
        </div>
    </div>
</div>
<!-- /User Register Modal -->

<!-- Login Modal -->
<div class="modal account-modal fade" id="login_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 border-0">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-header">
                    <h3>Login <span>Lawyers App</span></h3>
                </div>
                <form method="POST" action="{{ route('users.login') }}">
                    @csrf
                    <div class="form-group form-focus">
                        <label class="focus-label">Phone</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" autocomplete="phone" required
                            placeholder="phone">
                        @error('phone')
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
                    <div class="d-flex justify-content-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="text-center dont-have">Don’t have an account? <a href="javascript:void(0);"
                            data-bs-toggle="modal" data-bs-target="#provider-register">Register As Lawyer</a> OR <a
                            href="javascript:void(0);" type="button" data-bs-toggle="modal"
                            data-bs-target="#user-register">Register as a
                            Customer</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Login Modal -->
