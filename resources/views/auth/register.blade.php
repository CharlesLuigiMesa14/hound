@extends('layouts.front')
@section('content')

<div style="background-image: url('{{ asset('assets/images/login.png') }}'); background-size: cover; background-position: center; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container m-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);">
                    <div class="card-header" style="background-color: white; text-align: center; padding: 20px;">
                        <img src="{{ asset('assets/images/navhound.png') }}" alt="Logo" style="width: 100%; max-width: 150px; height: auto;">
                    </div>
                    <div class="card-body" style="color: #333; font-family: 'Roboto', sans-serif;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('register') }}" onsubmit="return validateForm()">
                            @csrf
                            
                            <!-- First Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('First Name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #333; color: white;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus placeholder="First Name" style="border: 1px solid #ccc; padding: 10px; font-size: 0.9rem;" oninput="validateName()">
                                </div>
                                <small class="form-text text-danger" id="name-alert" style="display: none;">Invalid first name! Only letters and spaces allowed.</small>
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3">
                                <label for="lname" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Last Name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #333; color: white;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="lname" type="text" class="form-control" name="lname" required autocomplete="lname" placeholder="Last Name" style="border: 1px solid #ccc; padding: 10px; font-size: 0.9rem;" oninput="validateLastName()">
                                </div>
                                <small class="form-text text-danger" id="lname-alert" style="display: none;">Invalid last name! Only letters and spaces allowed.</small>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label" style="font-weight: bold; font-size: 0.9rem;">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #333; color: white;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" placeholder="Email Address" style="border: 1px solid #ccc; padding: 10px; font-size: 0.9rem;" oninput="validateEmail()">
                                </div>
                                <small class="form-text text-danger" id="email-alert" style="display: none;">Invalid email address!</small>
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
                                        {{ __('REGISTER') }}
                                    </button>
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

    // Check other fields' validity
    const nameValid = document.getElementById('name-alert').style.display === 'none';
    const lnameValid = document.getElementById('lname-alert').style.display === 'none';
    const emailValid = document.getElementById('email-alert').style.display === 'none';
    const passwordValid = password.length >= 6; // Ensure password is at least 6 characters

    // Enable button only if all fields are valid
    submitBtn.disabled = !(nameValid && lnameValid && emailValid && passwordValid);
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
    let color = '#333'; // Red for Weak
    let textColor = '#333'; // Red for Weak
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
            color = '#ffd700';
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

// Validate name fields (allows spaces)
function validateName() {
    const name = document.getElementById('name').value;
    const nameAlert = document.getElementById('name-alert');

    // Validate first name (letters and spaces)
    if (/^[A-Za-z\s]+$/.test(name)) {
        nameAlert.style.display = 'none'; // Hide alert if valid
        document.getElementById('name').style.borderColor = '#ccc'; // Reset border color
    } else {
        nameAlert.style.display = 'block'; // Show alert if invalid
        document.getElementById('name').style.borderColor = 'red'; // Set border color to red
        nameAlert.textContent = 'Invalid first name! Only letters and spaces allowed.'; // Specific message
    }

    validateForm(); // Validate form again
}

// Validate last name (allows spaces)
function validateLastName() {
    const lname = document.getElementById('lname').value;
    const lnameAlert = document.getElementById('lname-alert');

    // Validate last name (letters and spaces)
    if (/^[A-Za-z\s]+$/.test(lname)) {
        lnameAlert.style.display = 'none'; // Hide alert if valid
        document.getElementById('lname').style.borderColor = '#ccc'; // Reset border color
    } else {
        lnameAlert.style.display = 'block'; // Show alert if invalid
        document.getElementById('lname').style.borderColor = 'red'; // Set border color to red
        lnameAlert.textContent = 'Invalid last name! Only letters and spaces allowed.'; // Specific message
    }

    validateForm(); // Validate form again
}

// Validate email
function validateEmail() {
    const email = document.getElementById('email').value;
    const emailAlert = document.getElementById('email-alert');
    const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

    if (emailPattern.test(email)) {
        emailAlert.style.display = 'none'; // Hide alert if valid
        document.getElementById('email').style.borderColor = '#ccc'; // Reset border color
    } else {
        emailAlert.style.display = 'block'; // Show alert if invalid
        document.getElementById('email').style.borderColor = 'red'; // Set border color to red
        emailAlert.textContent = 'Invalid email address!'; // Specific message
    }

    validateForm(); // Validate form again
}

// Real-time validation feedback
document.getElementById('password').addEventListener('input', validatePassword);
document.getElementById('password-confirm').addEventListener('input', validateForm);
document.getElementById('name').addEventListener('input', validateName);
document.getElementById('lname').addEventListener('input', validateLastName);
document.getElementById('email').addEventListener('input', validateEmail);

</script>

@endsection