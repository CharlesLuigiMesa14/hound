<!-- Navbar -->
<style>
    .navbar {
        padding: 15px 30px;
        background: linear-gradient(to right, #000000, #434343);
        z-index: 1;
    }

    .nav-item {
        padding: 0 10px; /* Uniform padding for all nav items */
    }

    .notification {
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 0.8em;
        position: absolute;
        top: -5px;
        right: -10px;
    }

    .dropdown-menu {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        min-width: 600px;
        max-height: 400px;
        overflow-y: auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        scrollbar-width: thin;
    }

    .profile-dropdown {
        min-width: 200px;
    }

    .dropdown-menu::-webkit-scrollbar {
        width: 8px;
    }

    .dropdown-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .dropdown-menu::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .dropdown-menu::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .dropdown-header {
        padding: 10px;
        font-weight: 600;
        font-size: 14px;
        text-align: left;
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        color: #3C4043;
    }

    .dropdown-item {
        color: black;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 6px 10px;
        font-size: 12px;
        transition: background 0.3s;
    }

    .dropdown-item:hover {
        background: rgba(255, 0, 0, 0.1);
        color: #000;
    }

    .dropdown-item i {
        margin-right: 4px;
        font-size: 1.4em;
    }

    .profile-image {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }

    .content {
        flex: 1;
        text-align: left;
    }

    .timestamp {
        font-size: 10px;
        color: #888;
        text-align: right;
    }

    .no-notifications {
        text-align: center;
        padding: 10px;
        color: #777;
    }

    .message-icon, .notification-icon {
        color: white;
        font-size: 1.5em;
        cursor: pointer;
        transition: color 0.3s;
        padding: 10px; /* Add consistent padding */
    }

    .message-icon:hover, .notification-icon:hover {
        color: #ff0000; /* Change to red on hover */
    }

    .message-icon.active {
        color: white; /* Keep the color white when active */
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 10px 15px;
        }

        .dropdown-menu {
            min-width: 100%;
        }

        .profile-dropdown {
            min-width: 150px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;" id="navbar-title" style="color: white; font-weight: bold;">Dashboard</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    @php
                        // Fetch notifications
                        $lowStockProducts = App\Models\Product::where('qty', '<', 3)->where('qty', '>', 0)->get();
                        $outOfStockProducts = App\Models\Product::where('qty', 0)->get();
                        $now = now();

                        // Check for new user registrations in the last 24 hours
                        $newUsers = App\Models\User::where('created_at', '>=', $now->subDay())->get();
                        $weeklyNewUsers = App\Models\User::where('created_at', '>=', $now->subWeek())->get();
                        $todayCheckouts = App\Models\Order::whereDate('created_at', today())->get();
                        $weeklyCheckouts = App\Models\Order::where('created_at', '>=', $now->subWeek())->get();

                        // Filter weekly checkouts to count only those within the last 7 days
                        $recentWeeklyCheckouts = $weeklyCheckouts->filter(function ($checkout) {
                            return $checkout->created_at >= now()->subDays(7);
                        });

                        // Determine the user's role
                        $userRole = auth()->user()->role_as;
                    @endphp
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="updateTitle('Notifications')" style="color: white;">
                        <i class="material-icons" style="color: white;">notifications</i>
                        <span class="notification">
                            @if($userRole == 1)
                                {{ $lowStockProducts->count() + $outOfStockProducts->count() + $newUsers->count() + $todayCheckouts->count() + $weeklyNewUsers->count() + $recentWeeklyCheckouts->count() }}
                            @elseif($userRole == 2)
                                {{ $lowStockProducts->count() + $outOfStockProducts->count() }}
                            @elseif($userRole == 3 || $userRole == 4 || $userRole == 5)
                                {{ $todayCheckouts->count() + $recentWeeklyCheckouts->count() }}
                            @else
                                0
                            @endif
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        @if($userRole == 1)
                            @if($lowStockProducts->count() > 0)
                                <div class="dropdown-header">Low Stock Alerts ({{ $lowStockProducts->count() }})</div>
                                @foreach($lowStockProducts as $product)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #ffcc00;">warning</i>
                                        <div class="content">{{ $product->name }}: {{ $product->qty }} left.</div>
                                        <div class="timestamp">{{ $product->updated_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($outOfStockProducts->count() > 0)
                                <div class="dropdown-header">Out of Stock Alerts ({{ $outOfStockProducts->count() }})</div>
                                @foreach($outOfStockProducts as $product)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #ff0000;">cancel</i>
                                        <div class="content">{{ $product->name }} is out of stock.</div>
                                        <div class="timestamp">{{ $product->updated_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($newUsers->count() > 0)
                                <div class="dropdown-header">New User Registrations ({{ $newUsers->count() }})</div>
                                @foreach($newUsers as $user)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #28a745;">person_add</i>
                                        <div class="content">{{ $user->full_name }} (ID: {{ $user->id }})</div>
                                        <div class="timestamp">{{ $user->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($weeklyNewUsers->count() > 0)
                                <div class="dropdown-header">Weekly New User Registrations ({{ $weeklyNewUsers->count() }})</div>
                                @foreach($weeklyNewUsers as $user)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #28a745;">person_add</i>
                                        <div class="content">{{ $user->full_name }} (ID: {{ $user->id }})</div>
                                        <div class="timestamp">{{ $user->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($todayCheckouts->count() > 0)
                                <div class="dropdown-header">Today's Checkouts ({{ $todayCheckouts->count() }})</div>
                                @foreach($todayCheckouts as $checkout)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #007bff;">shopping_cart</i>
                                        <div class="content">Checkout ID: {{ $checkout->id }} at {{ $checkout->created_at->format('H:i') }}</div>
                                        <div class="timestamp">{{ $checkout->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="no-notifications">No checkouts today.</div>
                            @endif
                            @if($recentWeeklyCheckouts->count() > 0)
                                <div class="dropdown-header">Weekly Checkouts ({{ $recentWeeklyCheckouts->count() }})</div>
                                @foreach($recentWeeklyCheckouts as $checkout)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #007bff;">shopping_cart</i>
                                        <div class="content">Checkout ID: {{ $checkout->id }} at {{ $checkout->created_at->format('H:i') }}</div>
                                        <div class="timestamp">{{ $checkout->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="no-notifications">No checkouts this week.</div>
                            @endif
                        @elseif($userRole == 2)
                            @if($lowStockProducts->count() > 0)
                                <div class="dropdown-header">Low Stock Alerts ({{ $lowStockProducts->count() }})</div>
                                @foreach($lowStockProducts as $product)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #ffcc00;">warning</i>
                                        <div class="content">{{ $product->name }}: {{ $product->qty }} left.</div>
                                        <div class="timestamp">{{ $product->updated_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($outOfStockProducts->count() > 0)
                                <div class="dropdown-header">Out of Stock Alerts ({{ $outOfStockProducts->count() }})</div>
                                @foreach($outOfStockProducts as $product)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #ff0000;">cancel</i>
                                        <div class="content">{{ $product->name }} is out of stock.</div>
                                        <div class="timestamp">{{ $product->updated_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @endif
                            @if($lowStockProducts->count() == 0 && $outOfStockProducts->count() == 0)
                                <div class="no-notifications">No new notifications.</div>
                            @endif
                        @elseif($userRole == 3 || $userRole == 4 || $userRole == 5)
                            @if($todayCheckouts->count() > 0)
                                <div class="dropdown-header">Today's Checkouts ({{ $todayCheckouts->count() }})</div>
                                @foreach($todayCheckouts as $checkout)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #007bff;">shopping_cart</i>
                                        <div class="content">Checkout ID: {{ $checkout->id }} at {{ $checkout->created_at->format('H:i') }}</div>
                                        <div class="timestamp">{{ $checkout->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="no-notifications">No checkouts today.</div>
                            @endif
                            @if($recentWeeklyCheckouts->count() > 0)
                                <div class="dropdown-header">Weekly Checkouts ({{ $recentWeeklyCheckouts->count() }})</div>
                                @foreach($recentWeeklyCheckouts as $checkout)
                                    <a class="dropdown-item" href="#">
                                        <i class="material-icons" style="color: #007bff;">shopping_cart</i>
                                        <div class="content">Checkout ID: {{ $checkout->id }} at {{ $checkout->created_at->format('H:i') }}</div>
                                        <div class="timestamp">{{ $checkout->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="no-notifications">No checkouts this week.</div>
                            @endif
                        @else
                            <div class="no-notifications">No new notifications.</div>
                        @endif
                    </div>
                </li>
                <li class="nav-item">
                    <a class="message-icon" href="https://www.tawk.to/login" target="_blank" title="Message" onclick="toggleActive(this)">
                        <i class="material-icons">chat</i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="updateTitle('Account')" style="color: white;">
                        @if(Auth::check() && Auth::user()->profile_image)
                            <img src="{{ asset('assets/uploads/userprofile/' . Auth::user()->profile_image) }}" alt="Profile Image" class="profile-image">
                        @else
                            <i class="fas fa-user-circle" style="color: white; font-size: 1.2rem;"></i>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="{{ route('profile.admin') }}">
                            <i class="material-icons">account_circle</i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="material-icons">logout</i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


<script>
    function toggleActive(element) {
        // Remove active class from all message icons
        const messageIcons = document.querySelectorAll('.message-icon');
        messageIcons.forEach(icon => {
            icon.classList.remove('active');
        });

        // Add active class to the clicked icon
        element.classList.add('active');
    }
</script>
<!-- End Navbar -->