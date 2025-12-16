@extends('layouts.front')

@section('title')
    Welcome to Hound
@endsection

@section('content')
<style>
    /* Custom scrollbar styles */
    .mt-3 div[style*="overflow-y: auto"] {
        scrollbar-width: thin;
        scrollbar-color: darkred #f0f0f0;
    }

    .mt-3 div[style*="overflow-y: auto"]::-webkit-scrollbar {
        width: 8px;
    }

    .mt-3 div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
        background-color: darkred;
        border-radius: 10px;
    }

    .mt-3 div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
        background: #f0f0f0;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

<div class="py-3 mb-4 shadow-sm" style="background-color: #fff; border-top: 2px solid #8B0000;">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}" style="color: #8B0000; text-decoration: none;">
                <i class="fas fa-home"></i> Home
            </a>
            <span style="color: #8B0000; margin: 0 10px;">/</span>
            <i class="fas fa-shopping-cart"></i> Checkout
        </h6>
    </div>
</div>

<div class="container mt-3">
    <form action="{{ url('place-order') }}" method="POST" style="border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        {{ csrf_field() }}
        <input type="hidden" name="delivery_fee" id="deliveryFeeInput" value="0">
        <input type="hidden" name="coupon_discount" id="couponInput" value="0">
        <input type="hidden" name="grand_total" id="grandTotalInput" value="{{ $total }}">
        
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h6 style="font-weight: bold; color: #8B0000;">Basic Details</h6>
                        <hr>
                        <div class="checkout-form">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="fname">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" required class="form-control firstname" 
                                            maxlength="50" 
                                            style="border-radius: 5px; border: 1px solid #ccc; font-size: 14px;" 
                                            value="{{ Auth::user()->name }}" name="fname" 
                                            placeholder="Enter First Name" 
                                            title="Only letters, spaces, and hyphens allowed, max 50 characters" 
                                            oninput="formatName(this); validateName(this, 'fnameError', 'Only letters, spaces, and hyphens allowed, max 50 characters')">
                                    </div>
                                    <div id="fnameError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> <span></span>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="lname">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" required class="form-control lastname" 
                                            maxlength="50" 
                                            style="border-radius: 5px; border: 1px solid #ccc; font-size: 14px;" 
                                            value="{{ Auth::user()->lname }}" name="lname" 
                                            placeholder="Enter Last Name" 
                                            title="Only letters allowed, max 50 characters" 
                                            oninput="formatName(this); validateName(this, 'lnameError', 'Only letters allowed, max 50 characters')">
                                    </div>
                                    <div id="lnameError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> <span></span>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
    <label for="email">Email</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input type="email" required class="form-control email" 
               style="border-radius: 5px; border: 1px solid #ccc; background-color: #f9f9f9; cursor: not-allowed;" 
               value="{{ Auth::user()->email }}" name="email" 
               placeholder="Enter Email" 
               readonly 
               oninput="validateEmail(this, 'emailError', 'Please enter a valid email address')">
    </div>
    <div id="emailError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
        <i class="fas fa-exclamation-circle"></i> <span></span>
    </div>
</div>

                                <div class="col-md-6 mt-3">
                                    <label for="phone">Mobile Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="border: none; background: transparent;">
                                            <img src="assets/images/phiicon.png" alt="Philippines Flag" style="width: 20px; height: 20px;">
                                            <span style="margin-left: 5px;">+63</span>
                                        </span>
                                        <input type="tel" required class="form-control phone" 
                                            pattern="^9[0-9]{9}$" 
                                            maxlength="10" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->phone }}" name="phone" 
                                            placeholder="Enter 10-digit number starting with 9" 
                                            title="Must be 10 digits starting with 9 (e.g., 9123456789)"
                                            oninput="validatePhone(this)">
                                    </div>
                                    <div id="phoneError" style="color: red; display: none; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> 
                                        <span id="errorMessage"></span>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <input type="text" required class="form-control country" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->country }}" name="country" placeholder="Enter Country">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Region</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        <input type="text" required class="form-control state" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->state }}" name="state" placeholder="Enter Region">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <input type="text" required class="form-control city" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->city }}" name="city" placeholder="e.g., Manila">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Barangay</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" required class="form-control address2" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->address2 }}" name="address2" placeholder="Barangay/Subdivision">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Number and Street</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" required class="form-control address1" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->address1 }}" name="address1" placeholder="House Number, Street Name">
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="">Zip Code</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="text" required class="form-control pincode" 
                                            style="border-radius: 5px; border: 1px solid #ccc;" 
                                            value="{{ Auth::user()->pincode }}" name="pincode" placeholder="Enter Zip Code">
                                    </div>
                                </div>
                            </div>

                            <h6 style="font-weight: bold; color: #8B0000; margin-top: 15px;">Location Preview</h6>
<hr>
<div class="col-md-12 mt-3 mb-3">
    <label for="">Shipping Address</label>
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-home"></i></span>
        <input type="text" required class="form-control" id="shippingAddress"
            style="border-radius: 5px; border: 1px solid #ccc;" 
            value="{{ Auth::user()->address1 }}, {{ Auth::user()->address2 }}, {{ Auth::user()->city }}, {{ Auth::user()->state }}, {{ Auth::user()->country }}, {{ Auth::user()->pincode }}"
            name="shippingAddress" placeholder="Shipping Address">
    </div>
</div>


            
                            <button type="button" id="findLocation" 
    style="width: 100%; padding: 12px; font-size: 16px; background-color: #8B0000; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s, transform 0.2s; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
    <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #fff;"></i> Find Location
</button>
                            <div id="map" style="height: 380px; border: 1px solid #ccc; border-radius: 5px; margin-top: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h6 style="font-weight: bold; color: #8B0000;">Order Details</h6>
                        <hr>
                        @if($cartitems->count() > 0)
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th style="border: 1px solid #ccc; padding: 8px; text-align: left;">Product Name</th>
                                    <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Quantity</th>
                                    <th style="border: 1px solid #ccc; padding: 8px; text-align: right;">Price</th>
                                    <th style="border: 1px solid #ccc; padding: 8px; text-align: right;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cartitems as $item)
                                    @php
                                        $itemTotal = $item->products->selling_price * $item->prod_qty;
                                        $total += $itemTotal;
                                    @endphp
                                    <tr>
                                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $item->products->name }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $item->prod_qty }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px; text-align: right; white-space: nowrap;">₱ {{ number_format($item->products->selling_price, 2) }}</td>
                                        <td style="border: 1px solid #ccc; padding: 8px; text-align: right; white-space: nowrap;">₱ {{ number_format($itemTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h6 id="distanceDisplay" style="font-size: 0.9em; margin-top: 20px; display: none;">
                            <i class="fas fa-road"></i> Total Distance: <span id="distanceValue" style="float: right;"></span>
                        </h6>
                        <h6 id="deliveryFeeDisplay" style="font-size: 0.9rem; margin-top: 20px; display: none;">
    <i class="fas fa-truck" style="margin-right: 8px;"></i> Delivery Fee: <span id="deliveryFeeValue" style="float: right;"></span>
</h6>
<h6 id="discountCouponDisplay" style="font-size: 0.9rem; color: red; margin-top: 20px; display: none;">
    <i class="fas fa-percent" style="margin-right: 8px;"></i> Applied Discount: <span id="discountValue" style="float: right;">₱ 0.00</span>
</h6>

                        <h6 style="font-size: 1.2rem; font-weight: bold;">Grand Total 
                            <span id="grandTotal" style="font-size: 1.5rem; float: right;">₱ {{ number_format($total, 2) }}</span>
                        </h6>
                        
                        <hr>
<!-- Discount Coupon Section -->
<div class="mt-3">
    <h6 style="font-weight: bold; color: #8B0000;">
        <i class="fas fa-tags" style="margin-right: 8px;"></i> Discount Coupon
    </h6>
    <div class="input-group">
        <input type="text" id="coupon_discount" class="form-control" placeholder="Enter coupon code" style="margin-right: 8px;">
        <button type="button" id="apply_coupon" class="btn btn-danger" 
                style="border-radius: 5px; background-color: #dc3545; border: none;"
                disabled>
            <i class="fas fa-tag" style="margin-right: 5px;"></i> Apply
        </button>
    </div>
    <div id="coupon_message" style="color: red; margin-top: 10px;"></div>

<!-- Available Coupons List -->
<h6 style="font-weight: bold; margin-top: 15px;">
    <i class="fas fa-gift" style="margin-right: 8px;"></i> Available Coupons
</h6>
<div style="max-height: 363px; overflow-y: auto; background-color: #f0f0f0; border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <ul class="list-group" style="list-style: none; padding: 0;">
        @foreach($coupons as $coupon)
            <li class="list-group-item coupon-item" 
                style="border: none; border-radius: 5px; background-color: #ffffff; cursor: {{ $coupon->usage_count >= $coupon->max_usage ? 'not-allowed' : 'pointer' }}; padding: 0; display: flex; flex-direction: column; position: relative; transition: background-color 0.3s, box-shadow 0.3s; margin-bottom: 10px; {{ $coupon->usage_count >= $coupon->max_usage ? 'opacity: 0.5;' : '' }}; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);"
                onclick="{{ $coupon->usage_count < $coupon->max_usage ? "selectCoupon('{$coupon->code}')" : '' }}"
                onmouseover="this.style.backgroundColor='#e0e0e0';"
                onmouseout="this.style.backgroundColor='';">
                <div style="position: relative; padding-left: 60px; padding-right: 10px;">
                    <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 60px; background: linear-gradient(135deg, {{ $coupon->discount_type == 'fixed' ? '#A00000' : '#0056B3' }} 0%, {{ $coupon->discount_type == 'fixed' ? '#8B0000' : '#007BFF' }} 100%);  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
                        <i class="{{ $coupon->discount_type == 'fixed' ? 'fas fa-tags' : 'fas fa-percent' }}" style="color: white; font-size: 30px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);"></i>
                    </div>
                    <span style="font-weight: bold; font-size: 14px; font-style: italic; position: absolute; right: 10px; text-align: right; color: #C65D1B;">
                        {{ $coupon->discount_type == 'percentage' ? $coupon->discount_amount . '% OFF' : '₱ ' . number_format($coupon->discount_amount, 2) }}
                    </span>
                    <strong style="font-size: 16px; margin: 0 0 4px 10px;">{{ $coupon->name }}</strong>

                    <hr style="margin: 4px 10px;"/>
                    <span style="font-size: 13px; color: #555; margin-left: 10px;">{{ $coupon->description }}</span>
                    @if($coupon->usage_count >= $coupon->max_usage)
                        <span style="font-size: 11px; color: red; font-weight: bold; position: absolute; bottom: 0px; right: 10px;"> Unavailable</span>
                    @endif
                    <br>
                    <span style="font-size: 12px; color: #333; margin-left: 10px;">Minimum Spend: <span style="color: #8B0000; font-weight: bold;">₱ {{ number_format($coupon->min_checkout_amount, 2) }}</span></span>
                    <?php
                    $remainingTime = \Carbon\Carbon::parse($coupon->end_date)->diff(\Carbon\Carbon::now());
                    $days = $remainingTime->days;
                    $hours = $remainingTime->h;
                    $minutes = $remainingTime->i;

                    if ($days > 0) {
                        $timeDisplay = "{$days} days";
                    } elseif ($hours > 0) {
                        $timeDisplay = "{$hours} hours";
                    } else {
                        $timeDisplay = "{$minutes} minutes";
                    }
                    ?>
                    <span style="font-size: 12px; color: #333; margin-left: 10px;">
                        Remaining Time: <span style="color: #007BFF; font-weight: bold;">{{ $timeDisplay }}</span>
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
</div>
                        <input type="hidden" name="payment_mode" value="COD">
                        <button type="submit" id="placeOrderButton" class="btn btn-success w-100" 
                            style="border-radius: 5px; background-color: #28a745; border: none; height: 50px; margin-top: 10px;" disabled>
                            <i class="fas fa-money-bill-wave" style="margin-right: 5px;"></i> Place Order | COD
                        </button>
                        <div id="paypal-button-container" style="margin-top: 20px;"></div>
                        @else
                            <h4 class="text-center">No products in cart</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@include('layouts.inc.frontfooter')
@endsection

@section('scripts')

<script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyNAN2MjM9271XzgDWqp0y-yf0ST6u-FXPO&libraries=places"></script>
<script src="https://www.paypal.com/sdk/js?client-id=ARdVeMw7UQyMwyxQKtiqZr4TA3oG6_VYaiyHa0fSP4dtMlwGRDq5UeEH_FwfWSd1I1tV3QQPuHf82z2x"></script>

<script>
    const conversionRate = 0.018; // Example conversion rate from PHP to USD
    const totalInPHP = {{ $total }}; // Base total
    let totalDistance = 0; // Variable to store the total distance
    let map; // Variable to hold the map instance
    let directionsService; // Directions service
    let directionsRenderer; // Directions renderer

    function calculateTotalInUSD() {
        // Fetch current delivery fee and discount value from hidden inputs
        const deliveryFee = parseFloat(document.getElementById('deliveryFeeInput').value) || 0;
        const discountValue = parseFloat(document.getElementById('couponInput').value) || 0;
        const grandTotal = totalInPHP + deliveryFee - discountValue; // Calculate grand total
        return (grandTotal * conversionRate).toFixed(2); // Convert to USD
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            if (totalDistance === 0) {
                swal({
                    title: 'Warning',
                    text: 'Please find your location first.',
                    icon: 'warning',
                });
                return; // Prevent further actions if location is not found
            }

            const totalInUSD = calculateTotalInUSD(); // Fetch the total dynamically

            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalInUSD 
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            if (totalDistance === 0) {
                swal({
                    title: 'Warning',
                    text: 'Please find your location first.',
                    icon: 'warning',
                });
                return; // Prevent further actions if location is not found
            }

            return actions.order.capture().then(function(details) {
                var firstname = $('.firstname').val();
                var lastname = $('.lastname').val();
                var email = $('.email').val();
                var phone = $('.phone').val();
                var address1 = $('.address1').val();
                var address2 = $('.address2').val();
                var city = $('.city').val();
                var state = $('.state').val();
                var country = $('.country').val();
                var pincode = $('.pincode').val();
                var deliveryFee = document.getElementById('deliveryFeeInput').value; // Get delivery fee
                var discountValue = document.getElementById('couponInput').value; // Get discount
                var grandTotal = document.getElementById('grandTotalInput').value; // Get grand total

                $.ajax({
                    method: "POST",
                    url: "/place-order",
                    data: {
                        'fname': firstname,
                        'lname': lastname,
                        'email': email,
                        'phone': phone,
                        'address1': address1,
                        'address2': address2,
                        'city': city,
                        'state': state,
                        'country': country,
                        'pincode': pincode,
                        'payment_mode': "Paid by Paypal",
                        'payment_id': details.id,
                        'coupon_discount': discountValue,
                        'delivery_fee': deliveryFee, // Send delivery fee
                        'grand_total': grandTotal, // Send grand total
                    },
                    success: function(response) {
                        swal(response.status)
                        .then((value) => {
                            window.location.href = "/my-orders";
                        });
                    }
                });
            });
        }
    }).render('#paypal-button-container');

    function initMap() {
    const storeLocation = { lat: 14.62597139417142, lng: 121.06185054904118 }; // Store location coordinates
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 13,
        center: storeLocation,
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);

    // Add a marker for the store location
    new google.maps.Marker({
        position: storeLocation,
        map: map,
        title: 'Store Location',
    });
}

document.getElementById('findLocation').addEventListener('click', function() {
    const address1 = document.querySelector('.address1').value.trim(); // House Number, Street Name
    const barangay = document.querySelector('.address2').value.trim(); // Barangay/Subdivision
    const city = document.querySelector('.city').value.trim(); // City
    const state = document.querySelector('.state').value.trim(); // Region
    const country = document.querySelector('.country').value.trim(); // Country

    if (address1 && barangay && city && state && country) {
        const fullAddress = `${address1}, ${barangay}, ${city}, ${state}, ${country}`;
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'address': fullAddress }, (results, status) => {
            if (status === google.maps.GeocoderStatus.OK && results[0]) {
                const customerLocation = results[0].geometry.location;

                // Set the map to the customer location
                map.setCenter(customerLocation);

                // Clear previous directions
                directionsRenderer.setMap(null);

                // Calculate and display the route
                directionsService.route({
                    origin: { lat: 14.62597139417142, lng: 121.06185054904118 }, // Store location
                    destination: customerLocation,
                    travelMode: google.maps.TravelMode.DRIVING
                }, (response, status) => {
                    if (status === google.maps.DirectionsStatus.OK) {
                        directionsRenderer.setMap(map);
                        directionsRenderer.setDirections(response);
                        totalDistance = response.routes[0].legs[0].distance.value / 1000; // Distance in kilometers

                        document.getElementById('distanceDisplay').style.display = 'block';
                        document.getElementById('distanceValue').innerText = totalDistance.toFixed(2) + ' km';

                        // Calculate delivery fee
                        const baseFare = 55;
                        const additionalFeePer5Km = 6;
                        const additionalKm = Math.max(0, Math.ceil(totalDistance / 5) - 1);
                        const deliveryFee = baseFare + (additionalKm * additionalFeePer5Km);
                        document.getElementById('deliveryFeeDisplay').style.display = 'block';
                        document.getElementById('deliveryFeeValue').innerText = '₱ ' + deliveryFee.toFixed(2);

                        // Update grand total
                        const grandTotal = {{ $total }} + deliveryFee;
                        document.getElementById('grandTotal').innerText = '₱ ' + grandTotal.toFixed(2);

                        // Set the hidden input values
                        document.getElementById('deliveryFeeInput').value = deliveryFee.toFixed(2);
                        document.getElementById('grandTotalInput').value = grandTotal.toFixed(2);

                        // Enable the order button and apply coupon button after finding the location
                        document.getElementById('placeOrderButton').disabled = false;
                        document.getElementById('apply_coupon').disabled = false; // Enable apply coupon button
                    } else {
                        alert('Directions request failed due to ' + status);
                    }
                });
            } else {
                alert('Location not found. Please check your address and try again. Status: ' + status);
            }
        });
    } else {
        alert('Please fill in all address fields.');
    }
});


// Initialize the map
window.onload = initMap;

function validatePhone(input) {
    const errorDiv = document.getElementById('phoneError');
    const errorMessage = document.getElementById('errorMessage');
    const pattern = /^9[0-9]{9}$/;

    // Reset error message by default
    errorDiv.style.display = 'none';
    input.style.border = '1px solid #ccc'; 

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
    input.style.border = '1px solid #ccc';

    const pattern = /^[A-Za-z]{1}[A-Za-z\s\-]{0,49}$/; // Allow letters, spaces, and hyphens, max 50 characters

    if (!pattern.test(input.value)) {
        errorDiv.style.display = 'block';
        input.style.border = '1px solid red';
        messageSpan.textContent = errorMessage;
    }
}

function validateEmail(input, errorId, errorMessage) {
    const errorDiv = document.getElementById(errorId);
    const messageSpan = errorDiv.querySelector('span');

    // Reset error message
    errorDiv.style.display = 'none';
    input.style.border = '1px solid #ccc';

    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation

    if (!pattern.test(input.value)) {
        errorDiv.style.display = 'block';
        input.style.border = '1px solid red';
        messageSpan.textContent = errorMessage;
    }
}


document.getElementById('apply_coupon').addEventListener('click', function() {
    const couponCode = document.getElementById('coupon_discount').value;

    fetch('/validate-coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: couponCode })
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById('coupon_message');
        if (data.success) {
            let discount = Number(data.coupon.discount_amount);
            let discountType = data.coupon.discount_type;

            // Get the current grand total and delivery fee
            let productTotal = parseFloat(document.getElementById('grandTotalInput').value);
            let grandTotal = productTotal
            // Calculate the discount
            let discountValue = 0;
            if (discountType === 'percentage') {
                discountValue = (discount / 100) * (grandTotal); // Discount off the total including delivery
            } else if (discountType === 'fixed') {
                discountValue = discount; // Use fixed amount
            }

            // Ensure discount does not exceed the total amount (product total + delivery fee)
            discountValue = Math.min(discountValue, grandTotal);

            document.getElementById('couponInput').value = discountValue;
            
            // Update grand total after applying discount
            grandTotal -= discountValue;

            // Update displayed values
            document.getElementById('grandTotal').innerText = '₱ ' + grandTotal.toFixed(2);
            document.getElementById('grandTotalInput').value = grandTotal.toFixed(2);

            // Display discount info
            document.getElementById('discountCouponDisplay').style.display = 'block';
            document.getElementById('discountValue').innerText = '₱ ' + discountValue.toFixed(2);
            messageDiv.innerText = `Coupon applied! Discount: ₱ ${discountValue.toFixed(2)}`;

            // Disable the button after applying the discount
            document.getElementById('apply_coupon').disabled = true;
        } else {
            messageDiv.innerText = data.message;
        }
    });
});
function selectCoupon(code) {
        document.getElementById('coupon_discount').value = code;
    }

    function initAutocomplete() {
        const input = document.getElementById('shippingAddress');
        const options = {
            types: ['address'],
            componentRestrictions: {'country': ['PH']} // Restrict to the Philippines
        };

        // Create the autocomplete object
        const autocomplete = new google.maps.places.Autocomplete(input, options);

        // When the user selects an address from the dropdown
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                alert("No details available for input: '" + place.name + "'");
                return;
            }

            // Autofill related fields
            const addressComponents = place.address_components;

            for (const component of addressComponents) {
                const componentType = component.types[0];

                switch (componentType) {
                    case 'street_number':
                        document.querySelector('.address1').value = component.long_name; // House Number
                        break;
                    case 'route':
                        document.querySelector('.address1').value += ' ' + component.long_name; // Street Name
                        break;
                    case 'locality':
                        document.querySelector('.city').value = component.long_name; // City
                        break;
                    case 'administrative_area_level_1':
                        document.querySelector('.state').value = component.long_name; // State/Region
                        break;
                    case 'country':
                        document.querySelector('.country').value = component.long_name; // Country
                        break;
                    case 'postal_code':
                        document.querySelector('.pincode').value = component.long_name; // Zip Code
                        break;
                }
            }
        });
    }

    // Initialize the autocomplete functionality
    window.onload = function() {
        initMap(); // Your existing map initialization
        initAutocomplete(); // Initialize address autocomplete
    };
</script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

@endsection