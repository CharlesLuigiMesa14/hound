<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Site Title</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .nav-link {
            color: white;
            transition: color 0.3s ease;
            font-size: 0.9rem; /* Smaller font size */
            margin: 0 5px; /* Add horizontal margin for spacing */
        }
        .nav-link:hover {
            color: #ffffff !important;
        }
        .nav-link.active {
            color: #ffffff !important;
        }
        .nav-link.active i {
            color: #ffffff;
            transform: scale(1.2);
        }
        .nav-link.disabled {
            color: #6c757d;
            pointer-events: none;
        }

        .search-bar {
            flex-grow: 1;
            margin-right: 15px;
        }
        .search-bar input[type="search"] {
            border: none;
            border-radius: 5px 0 0 5px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            color: #343a40;
            background-color: #ffffff;
        }
        .search-bar .input-group-text {
            background-color: #9B1B30;
            border: none;
            color: white;
            transition: background-color 0.3s ease;
            border-radius: 0 5px 5px 0; /* Adjusted to match input */
        }

        .navbar-nav {
            margin-left: auto; /* Align items to the right */
        }

        .dropdown-menu {
            display: none;
            background-color: #343a40;
            border: none;
            margin-top: 0;
            overflow: hidden;
        }
        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            color: #ffffff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .dropdown-item:hover {
            background-color: #495057;
            color: #ffffff;
        }
        .dropdown-item:focus {
            outline: none;
            background-color: #495057;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark shadow" style="background: #1a1a1a;">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{ asset('assets/images/navbaricon.png') }}" alt="Hound Icon" width="60" height="30" class="d-inline-block align-text-top">
    </a>

    <div class="search-bar">
      <form action="{{ url('searchproduct') }}" method="POST">
        @csrf
        <div class="input-group">
          <input type="search" class="form-control" id="search_product" name="product_name" required placeholder="Search Product" aria-describedby="basic-addon1">
          <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
        </div>
      </form>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
            <i class="fa fa-home"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('category') ? 'active' : '' }}" href="{{ url('category') }}">
            <i class="fa fa-list"></i> Category
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cart') ? 'active' : '' }}" href="{{ url('cart') }}">
            <i class="fa fa-shopping-cart"></i> Cart
            <span class="badge badge-pill bg-danger cart-count">0</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('wishlist') ? 'active' : '' }}" href="{{ url('wishlist') }}">
            <i class="fa fa-heart"></i> Wishlist
            <span class="badge badge-pill bg-success wishlist-count">0</span>
          </a>
        </li>

        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                <i class="fa fa-sign-in-alt"></i> {{ __('Login') }}
              </a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                <i class="fa fa-user-plus"></i> {{ __('Register') }}
              </a>
            </li>
          @endif
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
              <i class="fa fa-user"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="{{ url('my-orders') }}">
                  <i class="fa fa-box"></i> My Orders
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#">
                  <i class="fa fa-user-circle"></i> My Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out-alt"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            var $dropdownMenu = $(this).next('.dropdown-menu');

            if ($dropdownMenu.is(':visible')) {
                $dropdownMenu.slideUp(250);
                $dropdownMenu.removeClass('show');
            } else {
                $('.dropdown-menu').slideUp(250).removeClass('show');
                $dropdownMenu.slideDown(250);
                $dropdownMenu.addClass('show');
            }
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').slideUp(250).removeClass('show');
            }
        });
    });
</script>

</body>
</html>