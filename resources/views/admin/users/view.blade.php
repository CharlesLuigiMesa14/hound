@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="d-flex justify-content-between align-items-center">

                    <h4 class="mt-3" style="color: #333; font-weight: bold; font-size: 26px; margin-left: 20px;">
                        <i class="fas fa-user-circle"></i> User Details
                    </h4>

                    <a href="{{ url('users') }}" class="btn btn-danger btn-sm" style="width: 80px; text-align: center; margin-right: 30px;">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>

                </div>

                <hr>

                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            @if($users->profile_image && File::exists(public_path('assets/uploads/userprofile/' . $users->profile_image)))
                            <img src="{{ asset('assets/uploads/userprofile/' . $users->profile_image) }}" alt="Profile Picture" class="img-fluid" style="width: 230px; height: auto; margin-top: 50px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                            @else
                                <i class="fas fa-user-circle" style="font-size: 200px; margin-top: 50px; color: #ccc;"></i>
                            @endif
                        </div>

                        <div class="col-md-8">
                            <h5 class="mt-3 font-weight-bold"><i class="fas fa-info-circle"></i> Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-user"></i> First Name</label>
                                    <div class="p-3 border rounded">{{ $users->name }}</div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-user"></i> Last Name</label>
                                    <div class="p-3 border rounded">{{ $users->lname }}</div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-envelope"></i> Email Address</label>
                                    <div class="p-3 border rounded">{{ $users->email }}</div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-phone"></i> Mobile Phone Number</label>
                                    <div class="p-3 border rounded">
                                        <img src="{{ asset('assets/images/phiicon.png') }}" alt="Philippines Flag" style="width: 20px; height: 20px; margin-right: 5px;">
                                        +63 {{ $users->phone }}
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-calendar-alt"></i> Account Creation:</label>
                                    <div class="p-3 border rounded">{{ $users->created_at->format('F j, Y') }}</div> <!-- Only date -->
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label><i class="fas fa-id-badge"></i> User ID:</label>
                                    <div class="p-3 border rounded">{{ $users->id }}</div> <!-- No leading zeros -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Section -->
                    <h5 class="mt-4 font-weight-bold"><i class="fas fa-user-tag"></i> Role Information</h5>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-user"></i> User Role</label>
                            <div class="p-3 border rounded d-flex align-items-center">
                                @switch($users->role_as)
                                    @case('0') 
                                        <span class="badge badge-secondary"><i class="fas fa-user"></i> User</span> 
                                    @break
                                    @case('1') 
                                        <span class="badge badge-danger"><i class="fas fa-user-shield"></i> System Administrator</span>
                                    @break
                                    @case('2') 
                                        <span class="badge badge-warning"><i class="fas fa-box"></i> Inventory Manager</span>
                                    @break
                                    @case('3') 
                                        <span class="badge badge-info"><i class="fas fa-shopping-cart"></i> Order Manager</span>
                                    @break
                                    @case('4') 
                                        <span class="badge badge-success"><i class="fas fa-bullhorn"></i> Marketing Manager</span>
                                    @break
                                    @case('5') 
                                        <span class="badge badge-primary"><i class="fas fa-store"></i> Store Manager</span>
                                    @break
                                    @default 
                                        <span class="badge badge-light">Unknown Role</span>
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-info-circle"></i> Role Description</label>
                            <div class="p-3 border rounded text-muted">
                                @switch($users->role_as)
                                    @case('0') Standard user with limited access. @break
                                    @case('1') Administrator with full access.
                                    <ul class="text-muted mt-2">
                                        <li>Can manage users</li>
                                        <li>Can edit settings</li>
                                        <li>Has access to all reports</li>
                                    </ul>
                                    @break
                                    @case('2') Responsible for managing inventory.
                                    <ul class="text-muted mt-2">
                                        <li>Tracks stock levels</li>
                                        <li>Manages supplier relationships</li>
                                    </ul>
                                    @break
                                    @case('3') Oversees order processing.
                                    <ul class="text-muted mt-2">
                                        <li>Coordinates with suppliers</li>
                                        <li>Ensures timely deliveries</li>
                                    </ul>
                                    @break
                                    @case('4') Handles marketing strategies.
                                    <ul class="text-muted mt-2">
                                        <li>Develops campaigns</li>
                                        <li>Analyzes market trends</li>
                                    </ul>
                                    @break
                                    @case('5') Manages store operations.
                                    <ul class="text-muted mt-2">
                                        <li>Supervises staff</li>
                                        <li>Ensures customer satisfaction</li>
                                    </ul>
                                    @break
                                    @default No specific role description available.
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <!-- Location Details Section -->
                    <h5 class="mt-4 font-weight-bold"><i class="fas fa-map-marker-alt"></i> Location Details</h5>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-map-marker-alt"></i> House Number, Street Name, Unit/Apartment Number</label>
                            <div class="p-3 border rounded">{{ $users->address1 }}</div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-map-marker-alt"></i> Barangay/Subdivision</label>
                            <div class="p-3 border rounded">{{ $users->address2 }}</div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-city"></i> City</label>
                            <div class="p-3 border rounded">{{ $users->city }}</div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-map"></i> State/Province</label>
                            <div class="p-3 border rounded">{{ $users->state }}</div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-globe"></i> Country</label>
                            <div class="p-3 border rounded">{{ $users->country }}</div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label><i class="fas fa-code-branch"></i> Postal Code</label>
                            <div class="p-3 border rounded">{{ $users->pincode }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.card-body {
    padding: 20px;
}
.border {
    border: 1px solid #dee2e6;
}
.rounded {
    border-radius: 5px;
}
label {
    font-weight: bold;
    color: #333;
}
.p-3 {
    padding: 10px;
    background-color: #ffffff;
}
.text-muted {
    font-size: 0.9em;
}
ul {
    margin-top: 5px;
}
.input-group-text {
    color: #333;
    opacity: 1;
}
@media (max-width: 768px) {
    .col-md-6 {
        margin-bottom: 15px;
    }
}
</style>

<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection