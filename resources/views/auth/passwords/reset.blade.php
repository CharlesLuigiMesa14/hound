@extends('layouts.front')

@section('content')
<!-- Include Google Fonts for Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div style="background-image: url('{{ asset('assets/images/login.png') }}'); background-size: cover; background-position: center; min-height: 100vh; padding: 20px; align-items: center;">
    <div class="container" style="max-width: 400px; margin: auto; font-family: 'Roboto', sans-serif;">
        <div class="card" style="padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

            <div class="text-center" style="margin-bottom: 20px;">
                <img src="{{ asset('assets/images/navhound.png') }}" alt="Logo" style="max-width: 100px; margin-bottom: 15px;">
                <h5 style="font-weight: bold; color: #333;">{{ __('Reset Password') }}</h5>
                <hr style="border: 1px solid #ccc; width: 100%; margin-bottom: -10px;">
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address -->
<div class="mb-3">
    <label for="email" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Email Address') }}</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly style="pointer-events: none;">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #333; color: white;">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Password" style="border: 1px solid #ccc; padding: 10px; font-size: 0.9rem;" onfocus="showPasswordRequirements()" oninput="validatePassword()">
                    </div>
                    <div id="password-requirements" class="form-text" style="opacity: 0.7; font-size: 0.75rem;">
                        <i class="fas fa-check-circle" style="color: green;"></i> Must include at least one uppercase letter, one number, and one special character. No spaces allowed.
                    </div>
                    <div id="password-strength" class="form-text" style="display: none; font-weight: bold;"></div>
                    <div id="password-progress" style="height: 8px; border-radius: 5px; background-color: #ddd; display: none;">
                        <div id="progress-bar" style="height: 100%; width: 0; border-radius: 5px; transition: width 0.4s;"></div>
                    </div>
                    <small class="form-text text-danger" id="password-alert" style="display: none;">Password does not meet requirements!</small>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password-confirm" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Confirm Password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #333; color: white;">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" style="border: 1px solid #ccc; padding: 10px; font-size: 0.9rem;" oninput="validateForm()">
                    </div>
                    <small class="form-text text-danger" id="password-match-alert" style="display: none;">Passwords do not match!</small>
                </div>

                <div class="mb-0">
                    <div class="d-grid gap-2">
                        <button type="submit" id="submit-btn" class="btn" style="background-color: #b22222; color: white; border: none; border-radius: 5px; transition: background-color 0.3s; padding: 10px; font-weight: bold;" disabled>
                            <i class="fas fa-check"></i> {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const password = document.getElementById('password').value.trim();
    const passwordConfirm = document.getElementById('password-confirm').value.trim();
    const passwordMatchAlert = document.getElementById('password-match-alert');
    const submitBtn = document.getElementById('submit-btn');

    // Validate password match
    if (password !== passwordConfirm) {
        passwordMatchAlert.style.display = 'block';
        submitBtn.disabled = true; // Disable submit button
        return false; // Prevent form submission
    } else {
        passwordMatchAlert.style.display = 'none'; // Hide alert if passwords match
    }

    // Enable button only if all fields are valid (basic validation for this example)
    submitBtn.disabled = password.length < 6; // Ensure password is at least 6 characters
    return true;
}

// Show password requirements on focus
function showPasswordRequirements() {
    document.getElementById('password-strength').style.display = 'block';
    document.getElementById('password-progress').style.display = 'block';
}

// Validate password strength
function validatePassword() {
    const password = document.getElementById('password').value.trim();
    const passwordAlert = document.getElementById('password-alert');
    const passwordStrengthIndicator = document.getElementById('password-strength');
    const progressBar = document.getElementById('progress-bar');
    const passwordProgress = document.getElementById('password-progress');

    let strength = 'Invalid';
    let color = '#ff4d4d'; // Red for Weak
    let textColor = '#ff4d4d'; // Red for Weak
    let width = '1%';

    if (password.length < 6) {
        passwordAlert.style.display = 'block';
        passwordAlert.textContent = 'Password must be at least 6 characters!';
        width = '1%';
    } else {
        passwordAlert.style.display = 'none';
        
        if (password.length >= 14 && /[A-Za-z]/.test(password) && /\d/.test(password) && /[!@#$%^&*]/.test(password)) {
            strength = 'Excellent';
            color = '#2196f3'; // Blue
            textColor = '#2196f3'; // Blue for Excellent
            width = '100%';
        } else if (password.length >= 12 && /[A-Za-z]/.test(password) && /\d/.test(password)) {
            strength = 'Very Strong';
            color = '#4caf50'; // Dark green
            textColor = '#4caf50'; // Dark green for Very Strong
            width = '75%';
        } else if (password.length >= 10 && /[A-Za-z]/.test(password)) {
            strength = 'Strong';
            color = '#8bc34a'; // Green
            textColor = '#8bc34a'; // Green for Strong
            width = '50%';
        } else if (password.length >= 8 && /[A-Za-z]/.test(password)) {
            strength = 'Moderate';
            color = '#ffd700'; // Yellow
            textColor = 'orange'; 
            width = '25%';
        } else {
            strength = 'Weak';
            color = '#ff4d4d'; // Red
            textColor = '#ff4d4d'; // Red for Weak
            width = '15%';
        }
    }
    passwordStrengthIndicator.style.color = textColor; // Set dynamic text color
    passwordStrengthIndicator.textContent = strength;
    progressBar.style.width = width;
    progressBar.style.backgroundColor = color; // Set solid color for the progress bar
    passwordProgress.style.display = width !== '0%' ? 'block' : 'none'; // Show progress bar if needed

    validateForm(); // Validate the form after checking password
}

// Real-time validation feedback
document.getElementById('password').addEventListener('input', validatePassword);
document.getElementById('password-confirm').addEventListener('input', validateForm);

</script>
@endsection