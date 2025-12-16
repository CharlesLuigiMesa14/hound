@extends('layouts.front')

@section('content')

<div style="background-image: url('{{ asset('assets/images/login.png') }}'); background-size: cover; background-position: center; min-height: 100vh; align-items: center; justify-content: center; padding: 20px; font-family: 'Roboto', sans-serif;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Reduced width of form -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4" style="background-color: #fdfdfd;"> <!-- Dirty white background -->
                            <img src="{{ asset('assets/images/navhound.png') }}" alt="Logo" style="max-width: 100px; margin-top: 10px;">
                        </div>

                        <hr> <!-- Horizontal rule -->
                        <h5 class="card-title">
                            <i class="fas fa-envelope"></i> {{ __('Verify Your Email Address') }}
                        </h5>
                        
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p class="mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                        <!-- Display user email with styling -->
                        <p style="font-weight: bold; font-size: 1.25rem; color: darkred;">
                            {{ Auth::user()->email }}
                        </p>

                        <!-- Message about email verification, now inline -->
                        <p style="display: inline;">
                            {{ __('If you did not receive the email') }},
                        </p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0" style="color: darkred;">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection