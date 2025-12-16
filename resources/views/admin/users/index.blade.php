@extends('layouts.admin')

@section('content')
<style>
    .card {
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .table {
        border-collapse: collapse;
        width: 100%;
    }
    .table th, .table td {
        padding: 10px;
        text-align: center;
        border: none;
        border-bottom: 1px solid #dee2e6;
        font-size: 14px;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .btn {
        margin: 0 2px;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        border: none;
        background: transparent;
        cursor: pointer;
        outline: none;
        box-shadow: none;
        transition: background-color 0.3s;
        font-size: 1em; /* Increase the font size */
    }
    .btn:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
    #roleSelect {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        transition: border-color 0.3s;
        background-color: #f8f9fa;
    }
    #roleSelect:focus {
        border-color: #80bdff;
        outline: none;
    }
    .role-info {
        font-size: 12px;
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 5px;
        white-space: pre-line;
    }
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
        }
    }
    .activity-status {
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
    }
    .online {
        background-color: green; /* Green dot for online */
    }
    .offline {
        background-color: gray; /* Gray dot for offline */
    }
    .use-tabs {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
  
}

.use-item {
    margin-right: 15px; /* Space between tabs */
}

.use-link {
    text-decoration: none;
    padding: 10px 15px;
    color: #555; /* Default text color */
    transition: color 0.3s ease; /* Smooth transition for color change */
}

.use-link.active {
    color: rgba(51, 51, 51, 0.8); /* Active text color with low opacity */
    font-weight: bold; /* Optional: make it bold */
    border-bottom: 2px solid darkred; /* Optional: underline effect */
}

.use-link:hover {
    color: darkred; /* Change color on hover */
}
</style>
@php
function getOfflineDuration($lastActiveAt) {
    $now = new DateTime();
    $lastActive = new DateTime($lastActiveAt);
    $diff = $now->diff($lastActive);

    if ($diff->m > 0 || $diff->d > 30) {
        return 'Offline';
    }

    $duration = [];
    if ($diff->d > 0) {
        $duration[] = $diff->d . ' days';
    }
    if ($diff->h > 0) {
        $duration[] = $diff->h . ' hours';
    }
    if ($diff->i > 0) {
        $duration[] = $diff->i . ' minutes';
    }
    if ($diff->i === 0 && $diff->s > 0) {
        $duration[] = $diff->s . ' seconds';
    }

    return empty($duration) ? 'Offline' : 'Offline - ' . implode(', ', $duration);
}

function formatAddress($user) {
    $addressComponents = [
        $user->address1,
        $user->address2,
        $user->city,
        $user->state,
        $user->country,
        $user->pincode
    ];
    $formattedAddress = implode(', ', array_filter($addressComponents));
    return strlen($formattedAddress) > 50 ? substr($formattedAddress, 0, 47) . '...' : $formattedAddress;
}

$customers = $users->filter(function($user) {
    return $user->role_as == 0;
});
$admins = $users->filter(function($user) {
    return $user->role_as != 0;
});
@endphp

<div class="card">
    <div class="card-body">
        <h4 style="font-size: 1.5em;"><strong>User Management <i class="fas fa-users-cog"></i></strong></h4>
        <hr>

        <input type="text" id="searchInput" placeholder="Search by Name, ID or Role..." class="form-control mb-3">

        <ul class="use use-tabs">
            <li class="use-item">
                <a class="use-link active" data-toggle="tab" href="#customers">
                    <i class="fas fa-users"></i> Customers
                </a>
            </li>
            <li class="use-item">
                <a class="use-link" data-toggle="tab" href="#admins">
                    <i class="fas fa-user-shield"></i> Admins
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="customers" class="tab-pane fade show active">
                <h5 class="mt-3"></h5>
                <div style="overflow-x: auto;">
                    <table class="table table-bordered" id="customersTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-badge"></i><br><strong>ID</strong></th>
                                <th><i class="fas fa-user"></i><br><strong>Name</strong></th>
                                <th><i class="fas fa-envelope"></i><br><strong>Email</strong></th>
                                <th><img src="{{ asset('assets/images/phiicon.png') }}" alt="Phone Icon" style="width: 16px; vertical-align: middle;"><br><strong>Mobile Phone</strong></th>
                                <th><i class="fas fa-map-marker-alt"></i><br><strong>Address</strong></th>
                                <th><i class="fas fa-bolt"></i><br><strong>Activity</strong></th>
                                <th><i class="fas fa-cogs"></i><br><strong>Action</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name . ' ' . $item->lname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->phone)
                                       <span> +63{{ $item->phone }}</span>
                                    @else
                                        <span style="color: #ccc;">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->address1 || $item->address2 || $item->city || $item->state || $item->country || $item->pincode)
                                        {{ formatAddress($item) }}
                                    @else
                                        <span style="color: #ccc;">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="activity-status">
                                        <div class="status-dot {{ $item->is_active ? 'online' : 'offline' }}"></div>
                                        <div class="status-text">
                                            {{ $item->is_active ? 'Active/Online' : getOfflineDuration($item->last_active_at) }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; justify-content: space-around; align-items: center;">
                                        <a href="{{ url('view-user/'.$item->id) }}" class="btn" title="View User">
                                            <i class="fas fa-eye" style="color: #007bff;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="admins" class="tab-pane fade">
                <h5 class="mt-3"></h5>
                <div style="overflow-x: auto;">
                    <table class="table table-bordered" id="adminsTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-badge"></i><br><strong>ID</strong></th>
                                <th><i class="fas fa-user"></i><br><strong>Name</strong></th>
                                <th><i class="fas fa-envelope"></i><br><strong>Email</strong></th>
                                <th><img src="{{ asset('assets/images/phiicon.png') }}" alt="Phone Icon" style="width: 16px; vertical-align: middle;"><br><strong>Mobile Phone</strong></th>
                                <th><i class="fas fa-map-marker-alt"></i><br><strong>Address</strong></th>
                                <th><i class="fas fa-user-tag"></i><br><strong>Role (UCIBS)</strong></th>
                                <th><i class="fas fa-bolt"></i><br><strong>Activity</strong></th>
                                <th><i class="fas fa-cogs"></i><br><strong>Action</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name . ' ' . $item->lname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->phone)
                                       <span> +63{{ $item->phone }}</span>
                                    @else
                                        <span style="color: #ccc;">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->address1 || $item->address2 || $item->city || $item->state || $item->country || $item->pincode)
                                        {{ formatAddress($item) }}
                                    @else
                                        <span style="color: #ccc;">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($item->role_as)
                                        @case('1') System Administrator @break
                                        @case('2') Inventory Manager @break
                                        @case('3') Order Manager @break
                                        @case('4') Marketing Manager @break
                                        @case('5') Store Manager @break
                                        @default User
                                    @endswitch
                                </td>
                                <td>
                                    <div class="activity-status">
                                        <div class="status-dot {{ $item->is_active ? 'online' : 'offline' }}"></div>
                                        <div class="status-text">
                                            {{ $item->is_active ? 'Active/Online' : getOfflineDuration($item->last_active_at) }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; justify-content: space-around; align-items: center;">
                                        <a href="{{ url('view-user/'.$item->id) }}" class="btn" title="View User">
                                            <i class="fas fa-eye" style="color: #007bff;"></i>
                                        </a>
                                        <button class="btn change-role" data-id="{{ $item->id }}" data-role="{{ $item->role_as }}" title="Change Role">
                                            <i class="fas fa-user-tag" style="color: #ffc107;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal" id="changeRoleModal" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change User Role <i class="fas fa-user-cog"></i></h5>
                <button type="button" class="close" onclick="closeModal()">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="verification-section" style="text-align: center;">
                    <p id="verificationText" style="font-weight: bold; color: red;">Please verify the characters below:</p>
                    <div id="jumbledLetters" style="font-size: 28px; user-select: none; font-weight: bold; background-color: #f8f9fa; padding: 10px; border-radius: 5px; border: 2px dashed #ced4da;"></div>
                    <input type="text" id="userVerification" placeholder="Enter verification characters" class="form-control" style="margin-top: 10px; text-align: center;">
                </div>
                <form id="changeRoleForm" onsubmit="submitForm(event)" style="margin-top: 10px;">
                    <input type="hidden" id="userId" name="userId">
                    <div class="form-group">
                        <label for="roleSelect">Select Role <i class="fas fa-user-tag"></i></label>
                        <select class="form-control" id="roleSelect" name="role" onchange="updateRoleInfo()">
                            <option value="2">Inventory Manager</option>
                            <option value="3">Order Manager</option>
                            <option value="4">Marketing Manager</option>
                            <option value="5">Store Manager</option>
                            <option value="0">User</option>
                        </select>
                        <div id="roleInfo" class="role-info" style="margin-top: 10px;"></div>
                    </div>
                    <div style="display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-warning" style="padding: 5px 15px; text-transform: capitalize; font-size: 15px;">
                            <i class="fas fa-exchange-alt" style="margin-right: 5px;"></i> Change role
                        </button>
                    </div>
                    <div id="roleChangeFeedback" style="margin-top: 10px;"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Include SweetAlert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function generateVerification() {
        const characters = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        let result = '';
        for (let i = 0; i < 8; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        document.getElementById('jumbledLetters').textContent = result;
    }

    function openModal(userId, userRole) {
        document.getElementById('userId').value = userId;
        document.getElementById('roleSelect').value = userRole;
        updateRoleInfo(); // Update role info on modal open
        generateVerification(); // Generate verification characters
        document.getElementById('changeRoleModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('changeRoleModal').style.display = 'none';
    }

    function updateRoleInfo() {
        const roleSelect = document.getElementById('roleSelect');
        const roleInfo = document.getElementById('roleInfo');
        const roleDescriptions = {
            '2': '• <i class="fas fa-box"></i> Manages inventory levels.\n• <i class="fas fa-check-circle"></i> Ensures product availability.\n• <i class="fas fa-truck"></i> Tracks stock movement.',
            '3': '• <i class="fas fa-shopping-cart"></i> Processes customer orders.\n• <i class="fas fa-clock"></i> Ensures timely order fulfillment.\n• <i class="fas fa-reply"></i> Manages returns and inquiries.',
            '4': '• <i class="fas fa-bullhorn"></i> Develops marketing strategies.\n• <i class="fas fa-chart-line"></i> Analyzes market trends.\n• <i class="fas fa-tags"></i> Implements promotional campaigns.',
            '5': '• <i class="fas fa-store"></i> Oversees store operations.\n• <i class="fas fa-users"></i> Manages staff and customer service.\n• <i class="fas fa-shield-alt"></i> Ensures compliance with policies.',
            '0': '• <i class="fas fa-user"></i> Standard user with limited access.\n• <i class="fas fa-tasks"></i> Can perform basic tasks but does not manage others.'
        };
        roleInfo.innerHTML = roleDescriptions[roleSelect.value] || '';
    }

    function submitForm(e) {
        e.preventDefault();
        const userId = document.getElementById('userId').value;
        const newRole = document.getElementById('roleSelect').value;
        const userVerification = document.getElementById('userVerification').value;

        if (userVerification === document.getElementById('jumbledLetters').textContent) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the user's role!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/change-role/' + userId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ role: newRole })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('roleChangeFeedback').innerHTML = '<div class="alert alert-success">Role changed successfully!</div>';
                        setTimeout(() => {
                            closeModal();
                            location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        document.getElementById('roleChangeFeedback').innerHTML = '<div class="alert alert-danger">Error changing role: ' + error.message + '</div>';
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Verification characters do not match!',
            });
        }
    }

    document.querySelectorAll('.change-role').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const userRole = this.getAttribute('data-role');
            openModal(userId, userRole);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.use-link');
        const tabContents = document.querySelectorAll('.tab-pane');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                tabs.forEach(t => {
                    t.classList.remove('active');
                });

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('show', 'active');
                });

                // Add active class to the clicked tab
                this.classList.add('active');

                // Show the corresponding tab content
                const target = this.getAttribute('href');
                document.querySelector(target).classList.add('show', 'active');
            });
        });
    });

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        filterTable('customersTable', searchTerm);
        filterTable('adminsTable', searchTerm);
    });

    function filterTable(tableId, searchTerm) {
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            // Check each cell in the row
            for (let j = 0; j < cells.length; j++) {
                const cellValue = cells[j].textContent.toLowerCase();
                if (cellValue.includes(searchTerm)) {
                    match = true;
                    break; // Stop checking once a match is found
                }
            }

            rows[i].style.display = match ? '' : 'none'; // Show or hide the row
        }
    }
</script>

@endsection