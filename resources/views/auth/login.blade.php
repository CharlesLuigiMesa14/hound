@extends('layouts.front')

@section('content')

<div style="background-image: url('{{ asset('assets/images/login.png') }}'); background-size: cover; background-position: center; min-height: 100vh; display: flex; align-items: flex-start; justify-content: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); margin-top: 50px;">
                    <div class="card-header" style="background-color: white; color: #333; font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.5rem; text-align: center; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <img src="{{ asset('assets/images/navhound.png') }}" alt="Logo" style="max-width: 100px; margin-bottom: 10px;">
                    </div>

                    <div class="card-body" style="color: #333; font-family: 'Roboto', sans-serif;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error:</strong> {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #333; color: white;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email Address" style="border: none; background: white; color: #333; padding: 10px; font-size: 0.9rem; @error('email') border: 2px solid red; @enderror">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #333; color: white;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Your Password" style="border: none; background: white; color: #333; padding: 10px; font-size: 0.9rem; @error('password') border: 2px solid red; @enderror">
                                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePasswordVisibility()">
                                        <i id="password-icon" class="fas fa-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="font-size: 0.9rem;">{{ __('Remember Me') }}</label>
                                </div>
                                <div class="forgot-password">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}" style="color: darkblue; text-decoration: underline; font-size: 0.9rem;">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="login-button" style="background: linear-gradient(135deg, #9B1B1B, #6A0D0D); color: white; border: none; border-radius: 5px; padding: 10px; font-weight: bold; transition: background 0.3s, color 0.3s;">
                                        {{ __('LOGIN') }}
                                    </button>

                                    <div class="social-login-text" style="text-align: center; opacity: 0.9; font-size: 0.9rem; margin-top: 5px;">
                                        <p>Or continue using</p>
                                        <a href="{{ route('auth.redirection', 'google') }}" class="btn google-login-btn" style="display: flex; align-items: center; justify-content: center; background-color: white; color: #4285F4; padding: 10px 15px; border: 1px solid #4285F4; border-radius: 5px; text-decoration: none; font-size: 16px; width: 100%; transition: background-color 0.3s ease, color 0.3s ease; font-weight: bold; margin-top: -5px;">
                                            <img src="https://www.transparentpng.com/thumb/google-logo/google-logo-png-icon-free-download-SUF63j.png" alt="Google Logo" class="google-logo" style="width: 24px; height: 24px; margin-right: 10px;"> 
                                            Continue with Google
                                        </a>
                                        <!-- <a href="{{ route('auth.redirection', 'facebook') }}" class="btn btn-facebook" style="background-color: #3b5998; color: white; border: none; border-radius: 5px; padding: 10px; font-weight: bold; text-align: center; transition: background 0.3s; width: 100%; margin-top: 10px;">
                                            <i class="fab fa-facebook-f fa-fw"></i>
                                            Login with Facebook
                                        </a> -->
                                    </div>
                                    <hr style="border: 1px solid #ccc;">

                                    <div class="account-text" style="text-align: center; margin-top: 10px; font-size: 0.9rem;">
                                        <p>Don't have an account? <a href="{{ route('register') }}" style="color: #b22222; font-weight: bold;">Create Account</a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Include Google Fonts for Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@endsection

@section('scripts')
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Show SweetAlert messages if they exist
        @if (session('message'))
            Swal.fire({
                icon: 'info',
                title: 'Notice',
                text: '{{ session('message') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection