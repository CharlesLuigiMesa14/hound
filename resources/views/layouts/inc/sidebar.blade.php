<div class="sidebar" style="background: linear-gradient(to bottom, #1a1a1a, #333); color: white; height: 100vh; padding: 20px; display: flex; flex-direction: column; font-family: 'Roboto', sans-serif;">
    <div class="logo" style="text-align: center; margin-bottom: 10px;">
        <img src="{{ asset('assets/images/navbaricon.png') }}" alt="Logo" style="max-width: 100px;">
    </div>
    <div class="sidebar-wrapper" style="overflow-y: auto; flex-grow: 1;">
        <ul class="nav" style="list-style: none; padding: 0;">

            @if(Auth::user()->role_as == '1') <!-- Admin -->
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('/dashboard') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('dashboard') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">dashboard</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Admin Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('categories') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('categories') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('categories') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">grid_view</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Categories</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('add-category') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('add-category') }}" 
                       style="color: white; padding: 10px 20px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-category') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">add_circle</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Category</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('products') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('products') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('products') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">inventory</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('add-products') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('add-products') }}" 
                       style="color: white; padding: 10px 20px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-products') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">add_shopping_cart</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('warehouse') ? 'active' : '' }}" style="margin: 5px 0;">
        <a class="nav-link" href="{{ url('warehouse') }}" 
           style="color: white; padding: 10px 20px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('warehouse') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">store</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Warehouse</p>
        </a>
    </li>
                <li class="nav-item {{ Request::is('orders') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('orders') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('orders') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">content_paste</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Orders</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('returns') ? 'active' : '' }}" style="margin: 5px 0;">
    <a class="nav-link" href="{{ url('returns') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('returns') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">assignment_return</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Returns Catalogue</p>
    </a>
</li>
<li class="nav-item {{ Request::is('refunds') ? 'active' : '' }}" style="margin: 5px 0;">
    <a class="nav-link" href="{{ url('refunds') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('refunds') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">monetization_on</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Refund Process</p>
    </a>
</li>
                <li class="nav-item {{ Request::is('users') ? 'active' : '' }}" style="margin: 10px 0;">
                    <a class="nav-link" href="{{ url('users') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('users') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">people</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Users</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('coupons') ? 'active' : '' }}" style="margin: 10px 0;">
        <a class="nav-link" href="{{ url('/coupons') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('coupons') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">local_offer</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Coupons</p>
        </a>
    </li>
    <li class="nav-item {{ Request::is('add-coupon') ? 'active' : '' }}" style="margin: 0 0 10px 20px;">
        <a class="nav-link" href="{{ url('/add-coupon') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-coupon') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">add_circle</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Coupon</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('popups') ? 'active' : '' }}" style="margin: 10px 0;">
    <a class="nav-link" href="{{ route('popups.index') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('popups') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">campaign</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Popups</p>
    </a>
</li>
    
    <li class="nav-item {{ Request::is('admin/popups/create') ? 'active' : '' }}" style="margin: 0 0 10px 20px;">
    <a class="nav-link" href="{{ route('popups.create') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('admin/popups/create') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">add_alert</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Popups</p>
    </a>
</li>

                <li class="nav-item {{ Request::is('reports') ? 'active' : '' }}" style="margin: 10px 0;">
                    <a class="nav-link" href="{{ route('reports.index') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('reports') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">assessment</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Reports</p>
                    </a>
                </li>

            @elseif(Auth::user()->role_as == '2') <!-- Inventory Manager -->
                <li class="nav-item {{ Request::is('inventory-dashboard') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('/inventory-dashboard') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('inventory-dashboard') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">dashboard</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Inventory Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('products') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('products') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('products') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">inventory</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('add-products') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('add-products') }}" 
                       style="color: white; padding: 10px 20px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-products') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">add_shopping_cart</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Products</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('warehouse') ? 'active' : '' }}" style="margin: 5px 0;">
        <a class="nav-link" href="{{ url('warehouse') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('warehouse') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">store</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Warehouse</p>
        </a>
    </li>
    
            @elseif(Auth::user()->role_as == '3') <!-- Order Manager -->
                <li class="nav-item {{ Request::is('orders-dashboard') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('/orders-dashboard') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('orders-dashboard') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">dashboard</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Orders Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('orders') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('orders') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('orders') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">content_paste</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Manage Orders</p>
                    </a>
                </li>

                @elseif(Auth::user()->role_as == '4') <!-- Marketing Manager -->
    <li class="nav-item {{ Request::is('marketing-dashboard') ? 'active' : '' }}" style="margin: 5px 0;">
        <a class="nav-link" href="{{ url('/marketing-dashboard') }}" 
           style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('marketing-dashboard') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">dashboard</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Marketing Dashboard</p>
        </a>
    </li>
    <li class="nav-item {{ Request::is('reports') ? 'active' : '' }}" style="margin: 10px 0;">
        <a class="nav-link" href="{{ route('reports.index') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('reports') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">assessment</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Reports</p>
        </a>
    </li>
    
    @if(Auth::user()->role_as == '4')
    <li class="nav-item {{ Request::is('coupons') ? 'active' : '' }}" style="margin: 10px 0;">
        <a class="nav-link" href="{{ url('/coupons') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('coupons') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">local_offer</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Coupons</p>
        </a>
    </li>
    <li class="nav-item {{ Request::is('add-coupon') ? 'active' : '' }}" style="margin: 0 0 10px 20px;">
        <a class="nav-link" href="{{ url('/add-coupon') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-coupon') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">add_circle</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Coupon</p>
        </a>
    </li>

    <li class="nav-item {{ Request::is('popups') ? 'active' : '' }}" style="margin: 10px 0;">
        <a class="nav-link" href="{{ url('/popups') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('popups') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">campaign</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Popups</p>
        </a>
    </li>
    
    <li class="nav-item {{ Request::is('add-popup') ? 'active' : '' }}" style="margin: 0 0 10px 20px;">
        <a class="nav-link" href="{{ url('/add-popup') }}" 
           style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-popup') ? '1' : '0.8' }};">
            <i class="material-icons" style="font-size: 20px;">add_alert</i>
            <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Popups</p>
        </a>
    </li>
@endif

            @elseif(Auth::user()->role_as == '5') <!-- Store Manager -->

                <li class="nav-item {{ Request::is('storemanager-dashboard') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ route('storemanager.dashboard') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('storemanager-dashboard') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">dashboard</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('users') ? 'active' : '' }}" style="margin: 10px 0;">
                    <a class="nav-link" href="{{ url('users') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('users') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">people</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Users</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('categories') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('categories') }}" 
                       style="color: white; padding: 10px 0; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('categories') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">grid_view</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Categories</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('add-category') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('add-category') }}" 
                       style="color: white; padding: 10px 20px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('add-category') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">add_circle</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Add Category</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('orders') ? 'active' : '' }}" style="margin: 5px 0;">
                    <a class="nav-link" href="{{ url('orders') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('orders') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">content_paste</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Orders</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('returns') ? 'active' : '' }}" style="margin: 5px 0;">
    <a class="nav-link" href="{{ url('returns') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('returns') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">assignment_return</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Returns Catalogue</p>
    </a>
</li>
<li class="nav-item {{ Request::is('refunds') ? 'active' : '' }}" style="margin: 5px 0;">
    <a class="nav-link" href="{{ url('refunds') }}" 
       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 1px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('refunds') ? '1' : '0.8' }};">
        <i class="material-icons" style="font-size: 20px;">monetization_on</i>
        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Refund Process</p>
    </a>
</li>
                <li class="nav-item {{ Request::is('reports') ? 'active' : '' }}" style="margin: 10px 0;">
                    <a class="nav-link" href="{{ route('reports.index') }}" 
                       style="color: white; padding: 10px 2px; display: flex; align-items: center; text-decoration: none; border-radius: 8px; transition: background-color 0.3s, transform 0.3s; position: relative; opacity: {{ Request::is('reports') ? '1' : '0.8' }};">
                        <i class="material-icons" style="font-size: 20px;">assessment</i>
                        <p style="margin-left: 5px; font-weight: 500; font-size: 14px;">Reports</p>
                    </a>
                </li>
        
            @endif

        </ul>
    </div>
</div>

<!-- Link to Google Fonts for Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

<style>
    .nav-link {
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s, color 0.3s, transform 0.3s, opacity 0.
        3s;
    }
    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 0, 0, 0.9);
        transition: left 0.8s ease;
        z-index: 0;
    }
    .nav-link:hover::before {
        left: 0;
    }
    .nav-link:hover {
        background-color: rgba(255, 0, 0, 0.9);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.9);
        color: white;
        opacity: 1;
    }
    .nav-link p {
        position: relative;
        z-index: 1;
        transition: color 0.3s;
    }
    .nav-link:hover p {
        color: white;
    }
    .nav-link i {
        transition: color 1.3s, transform 1.3s;
    }
    .nav-link:hover i {
        color: white;
        transform: scale(1.1);
    }

    /* Active state styling */
    .nav-item.active .nav-link {
        background-color: #444;
        color: #ffcc00;
        font-weight: bold;
    }
</style>

<script>
    // Mark active links with a distinct background
    document.querySelectorAll('.nav-item.active .nav-link').forEach(link => {
        link.style.backgroundColor = '#444'; // Active background color
        link.style.color = '#ffcc00'; // Active text color
        link.style.fontWeight = 'bold'; // Active font weight
    });
</script>