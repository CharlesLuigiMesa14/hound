@extends('layouts.front')

@section('content')
<!-- Include Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<div style="background-image: url('{{ asset('assets/images/login.png') }}'); background-size: cover; background-position: center; min-height: 100vh; align-items: center; justify-content: center; padding: 20px; font-family: 'Roboto', sans-serif;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4"> <!-- Width of the form card -->
                <div class="card shadow-sm" style="margin-top: 20px; padding: 30px;">

                    <div class="text-center" style="margin-bottom: 15px;">
                        <img src="{{ asset('assets/images/navhound.png') }}" alt="Logo" style="max-width: 100px; margin-bottom: 20px;">
                        <h5 style="font-weight: bold; color: #333;">{{ __('Reset Password') }}</h5>
                    </div>

                    <div style="border-top: 1px solid #ccc;"></div> <!-- Toolbar style divider -->

                    <div class="text-center" style="font-size: 0.8rem; margin: 10px 0; color: #333;">
                        {{ __('Enter your email address to receive a password reset link.') }}
                    </div>

                    <div class="card-body" style="padding: 10px;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label" style="color: #333;">
                                    {{ __('Email Address') }}
                                    <span data-bs-toggle="tooltip" title="Please enter your registered email address." style="cursor: pointer;">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-0 text-end">
                                <button type="submit" class="login-button" style="background: linear-gradient(135deg, #9B1B1B, #6A0D0D); color: white; border: none; border-radius: 5px; padding: 8px 16px; font-weight: bold; transition: background 0.3s, color 0.3s; font-size: 14px;">
                                    <i class="fas fa-paper-plane"></i> {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="text-center" style="margin-top: 20px;">
                        <a href="{{ route('login') }}" style="font-size: 0.9rem; color: #333;">{{ __('Remember your password? Log in') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Bootstrap CSS for Tooltips -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Optional: Add custom styles for hover effect -->
<style>
    .login-button:hover {
        background: linear-gradient(135deg, #6A0D0D, #9B1B1B);
        color: #fff;
        cursor: pointer;
    }
</style>

<!-- Bootstrap JS for Tooltips -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection