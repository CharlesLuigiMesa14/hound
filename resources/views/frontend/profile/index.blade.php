@extends('layouts.front')

@section('title', 'My Profile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<div style="max-width: 1280px; margin: auto; padding: 30px; margin-top: 50px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); position: relative;">
    <span style="position: absolute; top: 30px; right: 30px; font-size: 10px; color: rgba(0, 0, 0, 0.5);">User ID: {{ $user->id }}</span>

    @if(session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('status') }}",
                confirmButtonText: 'Okay'
            });
        </script>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
        @csrf
        @method('PUT')

        <div style="display: flex; align-items: flex-start; margin-bottom: 30px;">
        <div style="flex: 1; text-align: center; position: relative;">
    @if($user->profile_image)
        <img id="profileImage" src="{{ asset('assets/uploads/userprofile/' . $user->profile_image) }}" alt="Profile Image" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
    @else
        <div style="width: 200px; height: 200px; margin-left: 100px; border-radius: 8px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; font-family: 'Roboto', sans-serif; font-size: 1.2rem; color: #dc3545; border: 2px dashed #dc3545;">
            No Image
        </div>
    @endif
</div>
    <div style="flex: 2; padding-left: 20px;">
        <h3 style="margin: 0; color: #333; font-size: 1.8rem;">{{ $user->name }} {{ $user->lname }}</h3>
        <div style="margin: 5px 0; display: flex; align-items: center;">
            <i class="fas fa-phone" style="margin-right: 10px; color: #dc3545;"></i>
            <span style="color: #555;">{{ $user->phone }}</span>
        </div>
        <div style="margin: 5px 0; display: flex; align-items: center;">
            <i class="fas fa-envelope" style="margin-right: 10px; color: #dc3545;"></i>
            <span style="color: #555;">{{ $user->email }}</span>
        </div>
        <div style="margin-top: 10px;">
            <label for="profile_image" style="display: block; color: #333;">Change Profile Picture</label>
            <div style="display: flex; align-items: center;">
                <i class="fas fa-camera" style="margin-right: 10px; color: #dc3545;"></i>
                <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; background-color: #f8f9fa;" onchange="previewImage(event)">
            </div>
        </div>
    </div>
</div>

        <hr style="margin: 20px 0; border-color: #dc3545;">

        <h2 style="font-size: 1.5rem; margin-bottom: 15px; color: #333;">User Information</h2>
       
<div style="display: flex; justify-content: space-between; gap: 20px;">
    <div style="flex: 1; background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="mb-3">
            <label for="name" style="display: block; color: #333;">First Name</label>
            <div style="display: flex; align-items: center;">
                <i class="fas fa-id-card" style="margin-right: 10px; color: #dc3545;"></i>
                <input type="text" class="form-control" name="name" id="name" 
                       value="{{ old('name', $user->name) }}" placeholder="Enter your first name" required 
                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa; transition: border-color 0.3s ease;" 
                       oninput="validateName(this)" 
                       onmouseover="if (this.classList.contains('invalid')) this.style.borderColor='red';" 
                       onmouseout="if (this.classList.contains('invalid')) this.style.borderColor='red';">
            </div>
            <small style="color: rgba(108, 117, 125, 0.7); font-size: 12px;">
                <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Only accept characters.
            </small>
        </div>

        <div class="mb-3">
            <label for="phone" style="display: block; color: #333;">Mobile Phone Number</label>
            <div style="display: flex; align-items: center;">
                <img src="assets/images/phiicon.png" alt="Philippines Flag" style="width: 20px; height: auto; margin-right: 10px;">
                <span id="phonePrefix" style="margin-right: 10px; font-size: 16px; color: #333;">+63</span>
                <input type="text" class="form-control" name="phone" id="phone" 
                       value="{{ old('phone', $user->phone) }}" placeholder="9XXXXXXXXX" required 
                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa; transition: border-color 0.3s ease;" 
                       pattern="^9\d{9}$" title="Must start with 9 and be 10 digits long" 
                       oninput="handlePhoneInput(this)">
            </div>
            <small style="color: rgba(108, 117, 125, 0.7); font-size: 12px;">
                <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Format: Must start with 9 and be 10 digits long.
            </small>
            <div id="phoneError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                <i class="fas fa-exclamation-circle"></i> <span></span>
            </div>
        </div>
    </div>

    <div style="flex: 1; background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="mb-3">
            <label for="lname" style="display: block; color: #333;">Last Name</label>
            <div style="display: flex; align-items: center;">
                <i class="fas fa-id-card-alt" style="margin-right: 10px; color: #dc3545;"></i>
                <input type="text" class="form-control" name="lname" id="lname" 
                       value="{{ old('lname', $user->lname) }}" placeholder="Enter your last name" required 
                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa; transition: border-color 0.3s ease;" 
                       oninput="validateName(this)" 
                       onmouseover="if (this.classList.contains('invalid')) this.style.borderColor='red';" 
                       onmouseout="if (this.classList.contains('invalid')) this.style.borderColor='red';">
            </div>
            <small style="color: rgba(108, 117, 125, 0.7); font-size: 12px;">
                <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Only accept characters.
            </small>
        </div>

        <div class="mb-3">
            <label for="email" style="display: block; color: #333;">Email</label>
            <div style="display: flex; align-items: center;">
                <i class="fas fa-envelope" style="margin-right: 10px; color: #dc3545;"></i>
                <input type="email" class="form-control" name="email" id="email" 
                       value="{{ old('email', $user->email) }}" placeholder="Enter your email" required readonly 
                       style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #e9ecef; color: #6c757d; cursor: not-allowed;">
            </div>
        </div>
    </div>
</div>

        <hr style="margin: 20px 0; border-color: #dc3545;">

        <h2 style="font-size: 1.5rem; margin-bottom: 15px; color: #333;">Address</h2>

        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
            <div class="mb-3">
                <label for="address1" style="display: block; color: #333;">House Number, Street Name, Unit/Apartment Number</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-home" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="address1" id="address1" value="{{ old('address1', $user->address1) }}" placeholder="House Number, Street Name, Unit/Apartment Number" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>

            <div class="mb-3">
                <label for="address2" style="display: block; color: #333;">Barangay/Subdivision</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-home" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="address2" id="address2" value="{{ old('address2', $user->address2) }}" placeholder="Barangay/Subdivision" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>

            <div class="mb-3">
                <label for="city" style="display: block; color: #333;">City</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-city" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="city" id="city" value="{{ old('city', $user->city) }}" placeholder="Enter your city" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>

            <div class="mb-3">
                <label for="state" style="display: block; color: #333;">Region</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-map" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="state" id="state" value="{{ old('state', $user->state) }}" placeholder="Enter your region" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>

            <div class="mb-3">
                <label for="country" style="display: block; color: #333;">Country</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-globe" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="country" id="country" value="{{ old('country', $user->country) }}" placeholder="Enter your country" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>

            <div class="mb-3">
                <label for="pincode" style="display: block; color: #333;">Zip Code</label>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-code" style="margin-right: 10px; color: #dc3545;"></i>
                    <input type="text" class="form-control" name="pincode" id="pincode" value="{{ old('pincode', $user->pincode) }}" placeholder="Enter your zip code" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                </div>
            </div>
        </div>

        <button type="submit" id="updateProfileButton" class="btn" style="width: 100%; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;" disabled>
    <i class="fas fa-save" style="margin-right: 5px;"></i> Update Profile
</button>
    </form>

    <hr style="margin: 20px 0; border-color: #dc3545;">

    <h2 style="font-size: 1.5rem; margin-bottom: 15px; color: #333;">Advanced Settings</h2>
    <div style="text-align: center;">
        <button type="button" class="btn btn-success" style="margin-top: 0px; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;" data-toggle="modal" data-target="#changePasswordModal">
            <i class="fas fa-lock" style="margin-right: 8px;"></i> 
            Change Password
        </button>
        <button type="button" class="btn btn-danger" style="margin-top: 0px; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; color: #ffffff" data-toggle="modal" data-target="#changeEmailModal">
                <i class="fas fa-envelope" style="margin-right: 8px;"></i> 
                Change Email
            </button>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-white">
                    <h5 class="modal-title text-dark" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background: transparent;">
                        <span aria-hidden="true" style="font-size: 1.5rem;" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" style="font-family: Arial, sans-serif; font-size: 14px;">Please enter your current password and choose a new password. Ensure it meets the strength requirements.</p>
                    <hr>
                    <form id="change-password-form" action="{{ route('password.change') }}" method="POST" onsubmit="return validatePasswordChange(event)">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0" style="background-color: transparent;"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control border-0 border-bottom" name="current_password" id="current_password" required placeholder="Enter your current password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0" style="background-color: transparent;"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control border-0 border-bottom" name="new_password" id="password" required placeholder="Enter a new password" onfocus="showPasswordRequirements()">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger" onclick="togglePasswordVisibility('password')" style="border: none; background-color: transparent;">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div id="password-requirements" class="form-text" style="opacity: 0.7; font-size: 0.75rem;">
                                    <i class="fas fa-check-circle" style="color: green;"></i> Must include at least one uppercase letter, one number, and one special character. No spaces allowed.
                                </div>
                            </div>
                            <div id="password-alert" class="alert alert-danger mt-2" style="display: none;"></div>
                            <div id="password-strength" style="display: none;">
                                <small>Password Strength: <span id="password-strength-indicator">Weak</span></small>
                                <div class="progress" style="height: 5px;">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0" style="background-color: transparent;"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control border-0 border-bottom" name="new_password_confirmation" id="password-confirm" required placeholder="Confirm your new password">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-danger" onclick="togglePasswordVisibility('password-confirm')" style="border: none; background-color: transparent;">
                                        <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="password-match-alert" class="alert alert-danger mt-2" style="display: none;">Passwords do not match!</div>
                        </div>
                        <button type="submit" class="btn" style="background-color: white; border: 1px solid #a00000; color: #a00000; margin-top: 5px; float: right; transition: background-color 0.3s, color 0.3s, border-color 0.3s;">
                            Change Password
                        </button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Change Email Modal -->
 <div class="modal fade" id="changeEmailModal" tabindex="-1" role="dialog" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-white">
                        <h5 class="modal-title text-dark" id="changeEmailModalLabel">Change Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background: transparent;">
                            <span aria-hidden="true" style="font-size: 1.5rem;" class="text-danger">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="change-email-form" action="{{ route('profile.updateEmail') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="new_email" style="display: block; color: #333;">New Email</label>
                                <div style="display: flex; align-items: center;">
                                    <i class="fas fa-envelope" style="margin-right: 10px; color: #dc3545;"></i>
                                    <input type="email" class="form-control" name="new_email" id="new_email" 
                                           placeholder="Enter your new email" required 
                                           style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="current_password" style="display: block; color: #333;">Current Password</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="password" class="form-control" name="current_password" id="current_password" 
                                           placeholder="Enter your current password" required 
                                           style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger" style="width: 100%; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                                <i class="fas fa-envelope" style="margin-right: 5px;"></i> Update Email
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@include('layouts.inc.frontfooter')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
        const icon = field.type === 'password' ? 'fa-eye' : 'fa-eye-slash';
        document.getElementById(fieldId === 'password' ? 'togglePasswordIcon' : 'toggleConfirmPasswordIcon').className = `fas ${icon}`;
    }
    function showPasswordRequirements() {
        document.getElementById('password-strength').style.display = 'block';
    }

    function validatePassword() {
        const password = document.getElementById('password').value;
        const passwordAlert = document.getElementById('password-alert');
        const passwordStrengthIndicator = document.getElementById('password-strength-indicator');
        const progressBar = document.getElementById('progress-bar');

        let strength = 'Weak';
        let color = '#ff4d4d'; // Red for Weak
        let width = '10%';

        if (password.length < 6) {
            passwordAlert.style.display = 'block';
            passwordAlert.textContent = 'Password must be at least 6 characters!';
            progressBar.style.width = '0%';
        } else {
            passwordAlert.style.display = 'none';
            if (password.length >= 14 && /[A-Za-z]/.test(password) && /\d/.test(password) && /[!@#$%^&*]/.test(password)) {
                strength = 'Excellent';
                color = '#28a745'; // Green
                width = '100%';
            } else if (password.length >= 12 && /[A-Za-z]/.test(password) && /\d/.test(password)) {
                strength = 'Very Strong';
                color = '#4caf50'; // Dark green
                width = '75%';
            } else if (password.length >= 10 && /[A-Za-z]/.test(password)) {
                strength = 'Strong';
                color = '#8bc34a'; // Green
                width = '50%';
            } else if (password.length >= 8) {
                strength = 'Moderate';
                color = '#ffd700'; // Yellow
                width = '25%';
            }
        }

        passwordStrengthIndicator.textContent = strength;
        progressBar.style.width = width;
        progressBar.style.backgroundColor = color;

        return strength !== 'Weak';
    }

    function validateForm() {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password-confirm').value;
        const passwordMatchAlert = document.getElementById('password-match-alert');
        let isValid = true;

        if (password !== passwordConfirm) {
            passwordMatchAlert.style.display = 'block';
            isValid = false;
        } else {
            passwordMatchAlert.style.display = 'none';
        }

        return isValid && validatePassword();
    }

    function validatePasswordChange(event) {
        event.preventDefault();

        const currentPassword = document.getElementById('current_password').value;

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to change your password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#ccc',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('password.validate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ current_password: currentPassword })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        if (validateForm()) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your password has been changed successfully.',
                                confirmButtonText: 'Okay',
                                background: '#fff',
                                color: '#333',
                                iconColor: '#28a745',
                            }).then(() => {
                                event.target.submit(); // Submit form after the alert is acknowledged
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Current Password',
                            text: 'The current password you entered is incorrect. Please try again.',
                            confirmButtonText: 'Okay',
                            background: '#fff',
                            color: '#333',
                            iconColor: '#dc3545',
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
    document.getElementById('password').addEventListener('input', validatePassword);
    document.getElementById('password-confirm').addEventListener('input', validateForm);
    document.addEventListener('DOMContentLoaded', function () {
        // Confirmation for profile update
        document.getElementById('profile-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to update your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0275d8',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form if confirmed
                }
            });
        });
    });
    const profileForm = document.getElementById('profile-form');
    const updateProfileButton = document.getElementById('updateProfileButton');

    profileForm.addEventListener('input', function() {
        updateProfileButton.disabled = false; // Enable the button on input change
    });
    function handlePhoneInput(input) {
    const prefix = document.getElementById('phonePrefix');
    const maxLength = 10;
    const currentLength = input.value.length;

    // Allow only digits and limit to 10 characters
    input.value = input.value.replace(/[^0-9]/g, '').slice(0, maxLength);

    // Change input field border color if max length is reached
    input.style.borderColor = (currentLength >= maxLength) ? 'red' : '#ddd';

    // Change prefix color if max length is reached
    prefix.style.color = (currentLength >= maxLength) ? 'red' : '#333';
    prefix.style.opacity = (currentLength >= maxLength) ? '0.7' : '1';

    // Validate the phone number format
    validatePhoneNumber(input);
}

function validatePhoneNumber(input) {
    const phoneError = document.getElementById('phoneError');
    const messageSpan = phoneError.querySelector('span');
    const pattern = /^9\d{9}$/; // Pattern for a valid phone number

    // Reset error message
    phoneError.style.display = 'none';
    input.style.borderColor = '#ddd'; // Reset border color

    if (input.value.length === 10 && !pattern.test(input.value)) {
        phoneError.style.display = 'block';
        input.style.borderColor = 'red';
        messageSpan.textContent = 'Phone number must start with 9 and be 10 digits long.';
    }
}
function validateName(input) {
    const maxLength = 50; // Set a reasonable max length for names
    const currentLength = input.value.length;

    // Limit the input to letters and spaces, and capitalize first letter of each word
    input.value = input.value
        .replace(/[^\A-Za-z\s]/g, '') // Remove invalid characters
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Capitalize first letter
        .join(' ');

    // Add 'invalid' class if invalid characters are present
    if (/[0-9!@#$%^&*(),.?":{}|<>]/.test(input.value)) {
        input.classList.add('invalid');
        input.style.borderColor = 'red';
    } else {
        input.classList.remove('invalid');
        input.style.borderColor = (currentLength >= maxLength) ? 'red' : '#ddd';
    }
}
</script>
@endsection