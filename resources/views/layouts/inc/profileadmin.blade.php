@extends('layouts.admin')

@section('content')
<div class="container my-4" style="background-color: #f8f9fa; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h1 class="mb-4 text-left" style="font-size: 2rem; font-weight: 700; color: #343a40;">
        Admin Profile
        <span class="badge 
    {{ 
        $adminUser->role_as == 1 ? 'badge-danger' : 
        ($adminUser->role_as == 2 ? 'badge-warning' : 
        ($adminUser->role_as == 3 ? 'badge-info' : 
        ($adminUser->role_as == 4 ? 'badge-success' : 
        ($adminUser->role_as == 5 ? 'badge-primary' : 'badge-secondary')))) 
    }}"
    style="padding: 10px 15px; font-size: 1rem; border-radius: 20px; margin-left: 10px; float: right; 
           background: {{ 
               $adminUser->role_as == 1 ? '#dc3545' : 
               ($adminUser->role_as == 2 ? '#ffc107' : 
               ($adminUser->role_as == 3 ? '#17a2b8' : 
               ($adminUser->role_as == 4 ? '#28a745' : 
               ($adminUser->role_as == 5 ? '#007bff' : '#6c757d')))) 
           }};
           color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
    <i class="{{ 
        $adminUser->role_as == 1 ? 'fas fa-user-shield' : 
        ($adminUser->role_as == 2 ? 'fas fa-warehouse' : 
        ($adminUser->role_as == 3 ? 'fas fa-shopping-cart' : 
        ($adminUser->role_as == 4 ? 'fas fa-bullhorn' : 
        ($adminUser->role_as == 5 ? 'fas fa-store' : 'fas fa-user')))) 
    }} mr-1"></i>
    {{ 
        $adminUser->role_as == 1 ? 'System Administrator' : 
        ($adminUser->role_as == 2 ? 'Inventory Manager' : 
        ($adminUser->role_as == 3 ? 'Order Manager' : 
        ($adminUser->role_as == 4 ? 'Marketing Manager' : 
        ($adminUser->role_as == 5 ? 'Store Manager' : 'User')))) 
    }}
</span>
    </h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex align-items-center mb-4" style="justify-content: flex-start;">
        <div class="mr-3">
            @if ($adminUser->profile_image)
                <img src="{{ asset('assets/uploads/userprofile/' . $adminUser->profile_image) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 150px; border-radius: 50%;">
            @else
                <div class="bg-light border rounded-circle" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user fa-3x" style="color: #6c757d;"></i>
                </div>
            @endif
        </div>
        <div class="position-relative" style="text-align: left;">
            <h5>User ID: <span class="text-muted">{{ $adminUser->id }}</span></h5>
            <h5>Role: <span class="text-muted">{{ $adminUser->role_as == 1 ? 'System Administrator' : ($adminUser->role_as == 2 ? 'Inventory Manager' : ($adminUser->role_as == 3 ? 'Order Manager' : ($adminUser->role_as == 4 ? 'Marketing Manager' : 'Store Manager'))) }}</span></h5>
        </div>
    </div>

    <div class="form-group text-left mb-4">
        <button type="button" class="btn btn-danger" id="changeImageBtn" style="background-color: #dc3545; border-color: #dc3545;">
            <i class="fas fa-image"></i> {{ $adminUser->profile_image ? 'Change Image' : 'Upload Image' }}
        </button>
    </div>

    <form id="adminProfileForm" action="{{ route('profile.admin.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="file" name="profile_image" id="profile_image" class="form-control-file mb-2" style="display: none;" accept="image/*">

        <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name"><i class="fas fa-user-circle"></i> First Name</label>
            <input type="text" required class="form-control firstname" 
                maxlength="50" 
                style="background-color: transparent; border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 10px;" 
                value="{{ old('name', $adminUser->name) }}" name="name" 
                placeholder="Enter First Name" 
                title="Only letters, spaces, and hyphens allowed, max 50 characters" 
                oninput="formatName(this); validateName(this, 'fnameError', 'Only letters, spaces, and hyphens allowed, max 50 characters')">
            <div id="fnameError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                <i class="fas fa-exclamation-circle"></i> <span></span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="lname"><i class="fas fa-user-tag"></i> Last Name</label>
            <input type="text" required class="form-control lastname" 
                maxlength="50" 
                style="background-color: transparent; border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 10px;" 
                value="{{ old('lname', $adminUser->lname) }}" name="lname" 
                placeholder="Enter Last Name" 
                title="Only letters allowed, max 50 characters" 
                oninput="formatName(this); validateName(this, 'lnameError', 'Only letters allowed, max 50 characters')">
            <div id="lnameError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                <i class="fas fa-exclamation-circle"></i> <span></span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                   value="{{ old('email', $adminUser->email) }}" readonly 
                   style="background-color: transparent; cursor: not-allowed; opacity: 0.6; border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 10px;">
            <input type="hidden" name="email" value="{{ $adminUser->email }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone"><i class="fas fa-phone-alt"></i> Mobile Phone Number</label>
            <div style="display: flex; align-items: center;">
                <span class="input-group-text" style="border: none; background: transparent; padding: 0; margin-right: 5px;">
                    <img src="assets/images/phiicon.png" alt="Philippines Flag" style="width: 20px; height: 20px;">
                    <span style="margin-left: 5px;">+63</span>
                </span>
                <input type="tel" required class="form-control phone" 
                    pattern="^9[0-9]{9}$" 
                    maxlength="10" 
                    style="background-color: transparent; border: none; border-bottom: 1px solid #ccc; border-radius: 0; padding: 10px;" 
                    value="{{ old('phone', $adminUser->phone) }}" name="phone" 
                    placeholder="Enter 10-digit number starting with 9" 
                    title="Must be 10 digits starting with 9 (e.g., 9123456789)"
                    oninput="validatePhone(this)">
            </div>
            <div id="phoneError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
            </div>
        </div>
    </div>
</div>
        <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-danger mt-3 mr-2" id="submitBtn">
                <i class="fas fa-save"></i> Update Profile
            </button>
            <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#changePasswordModal">
                <i class="fas fa-lock" style="margin-right: 8px;"></i> Change Password
            </button>
            <button type="button" class="btn btn-info mt-3" data-toggle="modal" data-target="#changeEmailModal">
        <i class="fas fa-envelope" style="margin-right: 8px;"></i> Change Email
    </button>
        </div>
    </form>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #fff;">
                    <h5 class="modal-title" id="changePasswordModalLabel" style="color: #343a40;">
                        <i class="fas fa-key"></i> Change Password
                    </h5>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" style="font-family: Arial, sans-serif;">
                        Please enter your current password and choose a new password. Ensure it meets the strength requirements.
                    </p>
                    <hr>
                    <form id="change-password-form" action="{{ route('password.change') }}" method="POST" onsubmit="return validatePasswordChange(event)">
                        @csrf
                        <div class="form-group">
                            <label for="current_password"><i class="fas fa-unlock-alt"></i> Current Password</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" required placeholder="Enter your current password">
                        </div>
                        <div class="form-group">
                            <label for="new_password"><i class="fas fa-lock"></i> New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="new_password" id="new_password" required placeholder="Enter a new password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggleNewPassword" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="newPasswordIcon"></i>
                                    </span>
                                </div>
                                <div id="password-requirements" class="form-text" style="opacity: 0.7; font-size: 0.75rem;">
                                    <i class="fas fa-check-circle" style="color: green;"></i> Must include at least one uppercase letter, one number, and one special character. No spaces allowed.
                                </div>
                            </div>
                            <div id="password-strength" style="display: none;">
                                <small>Password Strength: <span id="password-strength-indicator">Weak</span></small>
                                <div class="progress" style="height: 5px;">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation"><i class="fas fa-check"></i> Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required placeholder="Confirm your new password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggleConfirmPassword" style="cursor: pointer;">
                                        <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div id="password-match-alert" class="alert alert-danger mt-2" style="display: none;">Passwords do not match!</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Change Password
                            </button>
                        </div>
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
            <div class="modal-header" style="background-color: #fff;">
                <h5 class="modal-title" id="changeEmailModalLabel" style="color: #343a40;">
                    <i class="fas fa-envelope"></i> Change Email
                </h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <h5>Current Email: <span id="currentEmailDisplay" class="text-muted">{{ $adminUser->email }}</span></h5>
                </div>
                <p class="text-muted">Please enter your current password and your new email address.</p>
                <form id="change-email-form" action="{{ route('email.change') }}" method="POST" onsubmit="return validateEmailChange(event)">
                    @csrf
                    <div class="form-group">
                        <label for="new_email">
                            <i class="fas fa-envelope"></i> New Email
                        </label>
                        <input type="email" class="form-control" name="new_email" id="new_email" required placeholder="Enter new email">
                        <small class="form-text text-muted">Make sure it's a valid email format (e.g., example@domain.com).</small>
                    </div>
                    <div class="form-group">
                        <label for="email_password">
                            <i class="fas fa-unlock-alt"></i> Current Password
                        </label>
                        <input type="password" class="form-control" name="email_password" id="email_password" required placeholder="Enter your current password">
                        <small class="form-text text-muted">Enter your current password to authorize the change.</small>
                    </div>
                    <div id="emailChangeError" class="alert alert-danger" style="display: none;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Change Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    // Function to validate password strength
    function validatePassword() {
        const password = document.getElementById('new_password').value;
        const strengthIndicator = document.getElementById('password-strength-indicator');
        const progressBar = document.getElementById('progress-bar');
        let strength = 'Weak';
        let width = '10%';
        let color = '#ff4d4d'; // Red for Weak

        if (password.length < 6) {
            strengthIndicator.textContent = 'Weak';
            progressBar.style.width = width;
            progressBar.style.backgroundColor = color;
            return false;
        }

        if (password.length >= 14 && /[A-Za-z]/.test(password) && /\d/.test(password) && /[!@#$%^&*]/.test(password)) {
            strength = 'Excellent';
            width = '100%';
            color = '#28a745'; // Green
        } else if (password.length >= 12 && /[A-Za-z]/.test(password) && /\d/.test(password)) {
            strength = 'Very Strong';
            width = '75%';
            color = '#4caf50'; // Dark green
        } else if (password.length >= 10 && /[A-Za-z]/.test(password)) {
            strength = 'Strong';
            width = '50%';
            color = '#8bc34a'; // Green
        } else if (password.length >= 8) {
            strength = 'Moderate';
            width = '25%';
            color = '#ffd700'; // Yellow
        }

        strengthIndicator.textContent = strength;
        progressBar.style.width = width;
        progressBar.style.backgroundColor = color;
        return strength !== 'Weak';
    }

    // Validate password change
    function validatePasswordChange(event) {
        event.preventDefault();
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;

        if (newPassword !== confirmPassword) {
            Swal.fire('Error', 'New passwords do not match!', 'error');
            return;
        }

        if (!validatePassword()) {
            Swal.fire('Error', 'Password does not meet strength requirements!', 'error');
            return;
        }

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
                // Submit the form
                event.target.submit();
                // Redirect after submission
                event.target.addEventListener('submit', function() {
                    window.location.href = "{{ route('profile.admin') }}"; // Replace with your actual profile route
                });
            }
        });
    }

    // Event listeners for password strength and match validation
    document.getElementById('new_password').addEventListener('input', function() {
        document.getElementById('password-strength').style.display = 'block';
        validatePassword();
    });

    document.getElementById('new_password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('new_password').value;
        const confirmPassword = this.value;
        const alertElement = document.getElementById('password-match-alert');

        alertElement.style.display = password !== confirmPassword ? 'block' : 'none';
    });

    // Toggle password visibility
    document.getElementById('toggleNewPassword').addEventListener('click', function() {
        const newPasswordField = document.getElementById('new_password');
        const newPasswordIcon = document.getElementById('newPasswordIcon');
        newPasswordField.type = newPasswordField.type === 'password' ? 'text' : 'password';
        newPasswordIcon.classList.toggle('fa-eye');
        newPasswordIcon.classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const confirmPasswordField = document.getElementById('new_password_confirmation');
        const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');
        confirmPasswordField.type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        confirmPasswordIcon.classList.toggle('fa-eye');
        confirmPasswordIcon.classList.toggle('fa-eye-slash');
    });

    // Change image button functionality
    document.getElementById('changeImageBtn').addEventListener('click', function() {
        document.getElementById('profile_image').click();
    });
    function validatePhone(input) {
    const errorDiv = document.getElementById('phoneError');
    const errorMessage = document.getElementById('errorMessage');
    const pattern = /^9[0-9]{9}$/;

    // Reset error message by default
    errorDiv.style.display = 'none';

    if (input.value.length === 0) {
        return; // No input, no validation
    }

    // Combined error message
    let messages = [];

    if (input.value.length < 10) {
        messages.push('Must be 10 digits long.');
    }
    if (input.value[0] !== '9') {
        messages.push('Must start with 9.');
    }

    // If there are any messages, show the error
    if (messages.length > 0) {
        errorDiv.style.display = 'block';
        input.style.border = '1px solid red';
        errorMessage.textContent = messages.join(' '); // Combine messages
    } else if (!pattern.test(input.value)) {
        errorDiv.style.display = 'block';
        input.style.border = '1px solid red';
        errorMessage.textContent = 'Must be 10 digits starting with 9.';
    } else {
        errorDiv.style.display = 'none'; // Valid input
    }
}

function formatName(input) {
    // Automatically capitalize the first letter of each name
    input.value = input.value
        .replace(/[^A-Za-z\s\-]/g, '') // Remove invalid characters
        .replace(/\b\w/g, char => char.toUpperCase()) // Capitalize first letter of each word
        .substring(0, 50); // Limit to 50 characters
}

function validateName(input, errorId, errorMessage) {
    const errorDiv = document.getElementById(errorId);
    const messageSpan = errorDiv.querySelector('span');

    // Reset error message
    errorDiv.style.display = 'none';
 

    const pattern = /^[A-Za-z]{1}[A-Za-z\s\-]{0,49}$/; // Allow letters, spaces, and hyphens, max 50 characters

    if (!pattern.test(input.value)) {
        errorDiv.style.display = 'block';
        input.style.border = '1px solid red';
        messageSpan.textContent = errorMessage;
    }
}
async function validateEmailChange(event) {
        event.preventDefault();
        const newEmail = document.getElementById('new_email').value;
        const currentPassword = document.getElementById('email_password').value;
        const errorDiv = document.getElementById('emailChangeError');
        const currentEmailDisplay = document.getElementById('currentEmailDisplay');

        // Reset error message
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        // Basic validation
        if (!newEmail || !currentPassword) {
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'Please fill in all fields!';
            return false;
        }

        const currentEmail = currentEmailDisplay.textContent; // Get the current email from display

        // Check if the new email is the same as the current email
        if (newEmail === currentEmail) {
            Swal.fire('Info', 'The new email is the same as the current email.', 'info');
            return false;
        }

        try {
            // AJAX request to validate the current password
            const response = await fetch('/validate-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
                },
                body: JSON.stringify({ password: currentPassword })
            });

            const result = await response.json();

            if (!result.success) {
                errorDiv.style.display = 'block';
                errorDiv.textContent = 'Incorrect current password!';
                return false;
            }

            // Show confirmation dialog
            const confirmChange = await Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to change your email to " + newEmail + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#ccc',
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel'
            });

            if (!confirmChange.isConfirmed) {
                return; // User canceled the email change
            }

            // If password is valid and user confirmed, proceed to change the email
            const emailChangeResponse = await fetch('{{ route('email.change') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: newEmail })
            });

            const emailResult = await emailChangeResponse.json();

            if (emailResult.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your email has been changed successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Auto-refresh the page
                    location.reload(); // Refresh the page after a successful email change
                });
            } else {
                errorDiv.style.display = 'block';
                errorDiv.textContent = emailResult.message || 'Failed to change email.';
            }

        } catch (error) {
            console.error('Error:', error);
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'An error occurred while changing your email.';
        }
    }
</script>
@endsection