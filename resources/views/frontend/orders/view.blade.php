@extends('layouts.front')

@section('title')
    My Orders
@endsection

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow" style="background-color: #ffffff;">
                    <div class="card-header"
                        style="background-color: #dc3545; color: white; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0;">Order Receipt</h4>
                        <a href="{{ url('my-orders') }}" class="btn btn-light"
                            style="border-radius: 5px; padding: 8px 15px; color: #dc3545; font-weight: bold;">Back</a>
                    </div>
                    <div class="card-body" style="background-color: #ffffff;">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                 <!-- Order Items Table -->
     <h4 style="margin-bottom: 15px; color: #333;">Order Items</h4>
     <hr>   
     <table class="table table-bordered table-hover" style="border-color: #ccc;">
    <thead style="background-color: #f8f9fa; color: #333;">
        <tr>
            <th style="width: 25%; text-align: center;">Product Name</th> <!-- Reduced width -->
            <th style="text-align: center;">Quantity</th>
            <th style="white-space: nowrap; width: 20%;">Price</th> <!-- Prevent line break -->
            <th style="text-align: center;">Image</th>
            <th style="text-align: center;">Return Status</th> <!-- Centered header -->
        </tr>
    </thead>
    <tbody>
        @foreach ($orders->orderitems as $item)
            <tr>
                <td>{{ $item->products->name }}</td>
                <td style="text-align: right;">{{ $item->qty }}</td>
                <td style="white-space: nowrap; text-align: center;">₱ {{ number_format($item->price, 2) }}</td> <!-- Prevent line break -->
                <td style="text-align: center;">
                    <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                        width="100px" alt="Product Image "> <!-- Slightly larger image -->
                </td>
                <td style="text-align: center;"> <!-- Return Status -->
    @if ($item->returnRequest) <!-- Check if return request exists -->
        <strong style="color: #333; opacity: 0.7; font-size: 0.8em;">
            Return Requested
        </strong>
        <br>
        @if ($item->returnRequest->return_status == 0) <!-- Pending -->
            <span style="color: darkgoldenrod; font-size: 0.8em;">
                <i class="fas fa-clock" style="margin-right: 5px;"></i>Pending
            </span>
        @elseif ($item->returnRequest->return_status == 1) <!-- Approved -->
            <span style="color: green; font-size: 0.8em;">
                <i class="fas fa-check" style="margin-right: 5px;"></i>Approved
            </span>
        @elseif ($item->returnRequest->return_status == 2) <!-- Rejected -->
            <span style="color: red; font-size: 0.8em;">
                <i class="fas fa-times" style="margin-right: 5px;"></i>Rejected
            </span>
        @else
            <span style="color: gold; font-size: 0.8em;">
                <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Unknown Status
            </span>
        @endif
        
        <br>
        <!-- Display Refund Status -->
        @if (is_null($item->returnRequest->refund_status)) <!-- No refund status -->
            <span style="color: #333; font-size: 0.8em;">
                <i class="fas fa-ban" style="margin-right: 5px;"></i>No Refund Issued
            </span>
        @elseif ($item->returnRequest->refund_status == 0) <!-- Refund in Process -->
            <span style="color: orange; font-size: 0.8em;">
                <i class="fas fa-spinner fa-spin" style="margin-right: 5px;"></i>Refund in Process
            </span>
        @elseif ($item->returnRequest->refund_status == 1) <!-- Refund Given -->
            <span style="color: green; font-size: 0.8em;">
                <i class="fas fa-check-circle" style="margin-right: 5px;"></i>Refund Given
            </span>
        @endif
    @else
        <strong style="color: #333; font-size: 0.8em;">
            <i class="fas fa-ban" style="margin-right: 5px;"></i>No Return Request
        </strong>
    @endif

</td>
            </tr>
        @endforeach
    </tbody>
</table>
                                <h4 style="margin-bottom: 15px; color: #333;">Shipping Details</h4>
                                <hr style="border-color: #dc3545;">
                                @foreach ([['label' => 'First Name', 'value' => $orders->fname, 'icon' => 'fas fa-user'], ['label' => 'Last Name', 'value' => $orders->lname, 'icon' => 'fas fa-user'], ['label' => 'Email', 'value' => $orders->email, 'icon' => 'fas fa-envelope'], ['label' => 'Mobile Contact Number', 'value' => '+63 ' . $orders->phone, 'icon' => 'fas fa-phone'], ['label' => 'Shipping Address', 'value' => "{$orders->address1}, {$orders->address2}, {$orders->city}, {$orders->state}, {$orders->country}", 'icon' => 'fas fa-map-marker-alt'], ['label' => 'Zip Code', 'value' => $orders->pincode, 'icon' => 'fas fa-code-branch']] as $field)
                                    <div class="mb-3">
                                        <label style="font-weight: bold; color: #444;">
                                            <i class="{{ $field['icon'] }}"
                                                style="margin-right: 8px;"></i>{{ $field['label'] }}:
                                        </label>
                                        <div style="padding: 8px; border-bottom: 1px solid #ccc;">{{ $field['value'] }}
                                        </div>
                                    </div>
                                @endforeach
                             

</div>
         
                            <div class="col-md-6">       
    
                  <!-- Order Details -->
<h4 style="margin-bottom: 15px; color: #333;">Order Details</h4>
<div class="mb-3">
    <label style="font-weight: bold; color: #444;">
        <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>Order Date:
    </label>
    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
        {{ date('d-m-Y', strtotime($orders->created_at)) }}
    </div>
</div>
<div class="mb-3" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
    <label style="font-weight: bold; color: #444; display: block; padding: 12px; background-color: #f8f9fa;">
        <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Order Status:
    </label>
    <div style="padding: 16px; background-color: #fff;">
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <span class="badge"
                style="background-color: 
                {{ $orders->status == '0' ? '#FFC107' : ($orders->status == '1' ? '#28a745' : ($orders->status == '2' ? '#007bff' : ($orders->status == '3' ? '#17a2b8' : ($orders->status == '4' ? '#ffc107' : '#dc3545')))) }}; 
                color: white; padding: 10px 15px; border-radius: 5px; display: inline-flex; align-items: center; margin-right: 10px; ">
                <i class="{{ $orders->status == '0' ? 'fas fa-clock' : ($orders->status == '1' ? 'fas fa-check' : ($orders->status == '2' ? 'fas fa-cog' : ($orders->status == '3' ? 'fas fa-shipping-fast' : 'fas fa-times'))) }}"></i>
                <strong style="margin-left: 8px;">
                    {{ $orders->status == '0' ? 'Pending' : ($orders->status == '1' ? 'Completed' : ($orders->status == '2' ? 'Preparing' : ($orders->status == '3' ? 'Ready for Delivery' : ($orders->status == '4' ? 'Shipped' : 'Cancelled')))) }}
                </strong>
            </span>
            <div>
                <p style="margin: 0; color: #555;">
                    @if ($orders->status == '0')
                        <strong style="color: darkred;">Your order is currently pending.</strong> <em>We are working to process it as soon as possible.</em>
                    @elseif ($orders->status == '1')
                        <strong style="color: darkred;">Congratulations!</strong> <em>Your order has been successfully completed and is ready for you.</em>
                    @elseif ($orders->status == '2')
                        <strong style="color: darkred;">Your order is being prepared.</strong> <em>Our team is carefully handling your items to ensure quality.</em>
                    @elseif ($orders->status == '3')
                        <strong style="color: darkred;">Your order is now ready for delivery.</strong> <em>It will be shipped shortly to your address.</em>
                    @elseif ($orders->status == '4')
                        <strong style="color: darkred;">Your order has been shipped.</strong> <em>It is on its way to you. You can track it using the provided link.</em>
                    @else
                        <strong style="color: darkred;">Unfortunately, your order has been cancelled.</strong> <em>Please reach out to support for further assistance.</em>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>


                                <div class="mb-3">
                                    <label style="font-weight: bold; color: #444;">
                                        <i class="fas fa-credit-card" style="margin-right: 8px;"></i>Payment Mode:
                                    </label>
                                    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                        {{ $orders->payment_mode == 'COD' ? 'Cash on Delivery' : 'Online Payment' }}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label style="font-weight: bold; color: #444;">
                                        <i class="fas fa-truck" style="margin-right: 8px;"></i>Tracking Number:
                                    </label>
                                    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                        {{ $orders->tracking_no ?? 'N/A' }}
                                    </div>
                                </div>

                                <!-- Delivery Fee Calculation -->
                                @php
                                    $totalPrice = $orders->orderitems->sum(function ($item) {
                                        return $item->price * $item->qty;
                                    });
                                    $grandTotal = $orders->total_price;
                                    $discountAmount = $orders->discount_amount ?? 0; // Get the discount amount or default to 0
                                    $deliveryFee = max(0, $grandTotal - $totalPrice + $discountAmount); // Ensure delivery fee is not negative
                                @endphp

                                <!-- Delivery Fee -->
                                <div class="mb-3">
                                    <label style="font-weight: bold; color: #444;">
                                        <i class="fas fa-shipping-fast" style="margin-right: 8px;"></i>Delivery Fee:
                                    </label>
                                    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                        ₱ {{ number_format($deliveryFee, 2) }}
                                    </div>
                                </div>

                                <!-- Coupon Code -->
                                <div class="mb-3">
                                    <label style="font-weight: bold; color: #444;">
                                        <i class="fas fa-tag" style="margin-right: 8px;"></i>Coupon Code:
                                    </label>
                                    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                        {{ $orders->applied_coupon ?? 'N/A' }}
                                    </div>
                                </div>

                                <!-- Discount Amount -->
                                <div class="mb-3">
                                    <label style="font-weight: bold; color: #444;">
                                        <i class="fas fa-percent" style="margin-right: 8px;"></i>Discount Amount:
                                    </label>
                                    <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                                        ₱ {{ number_format($orders->discount_amount, 2) }}
                                    </div>
                                </div>

                                <!-- Grand Total -->
                                <h4
                                    style="padding: 10px; color: #333; font-weight: bold; border-top: 1px solid #dc3545; margin-top: 28px;">
                                    Grand Total:
                                    <span style="float: right; font-size: 1.5rem; color: #dc3545;">₱
                                        {{ number_format($orders->total_price, 2) }}</span>
                                </h4>
                                <br>
<!-- Other Actions -->
<h4 style="margin-bottom: 15px; color: #333; display: flex; align-items: center;">
    <i class="fas fa-cogs" style="margin-right: 8px;"></i> Other Actions
</h4>
<hr>
@if ($orders->status == '1') <!-- Show return button only for completed orders -->
<button id="returnRequestBtn" class="btn btn-primary"
        style="border: none; background: #007bff; color: white; text-decoration: none; font-size: 0.85em; padding: 10px; border-radius: 5px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; width: 100%; margin-bottom: 10px;" 
        onmouseover="this.style.background='#0056b3'; this.style.transform='translateY(-2px)';"
        onmouseout="this.style.background='#007bff'; this.style.transform='translateY(0);'">
    <i class="fas fa-reply" style="margin-right: 5px;"></i>
    Request Return
</button>
@endif

<!-- Modal for Return Request -->
<div id="returnModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Return Request <i class="fas fa-reply"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background: none; color: #dc3545;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="returnForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $orders->id }}">
                    
                    <div class="form-group">
                        <label for="prod_id">Product <i class="fas fa-box"></i></label>
                        <select class="form-control" name="prod_id" id="prod_id" required>
                            <option value="">Select Product</option>
                            @foreach ($orders->orderitems as $item)
                                <option value="{{ $item->products->id }}" data-qty="{{ $item->qty }}">
                                    {{ $item->products->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="qty">Quantity <i class="fas fa-sort-numeric-up"></i></label>
                        <input type="number" class="form-control" name="qty" min="1" value="1" placeholder="Enter quantity" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="return_reason">Reason for Return <i class="fas fa-reason"></i></label>
                        <select class="form-control" name="return_reason" required>
                            <option value="">Select Reason</option>
                            <option value="defective">Defective</option>
                            <option value="not_as_described">Not as Described</option>
                            <option value="changed_mind">Changed My Mind</option>
                            <option value="wrong_item">Wrong Item Received</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="comments">Comments (optional) <i class="fas fa-comment-alt"></i></label>
                        <textarea class="form-control" name="comment" rows="3" placeholder="Any additional comments..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="images">Upload Image (optional) <i class="fas fa-file-upload"></i></label>
                        <input type="file" class="form-control" name="images" accept="image/*" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitReturnRequest">
                    <i class="fas fa-paper-plane"></i> Submit Return Request
                </button>
            </div>
        </div>
    </div>
</div>

@if ($orders->status == '1') <!-- Only for completed orders -->
    <button class="btn-reorder" data-id="{{ $orders->id }}"
        style="border: none; background: #28a745; color: white; text-decoration: none; font-size: 0.85em; padding: 10px; border-radius: 5px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; width: 100%; margin-top: 10px;" 
        onmouseover="this.style.background='#218838'; this.style.transform='translateY(-2px)';"
        onmouseout="this.style.background='#28a745'; this.style.transform='translateY(0);'">
        <i class="fas fa-redo" style="margin-right: 5px;"></i> Reorder
    </button>
@endif
    <!-- Conditional Cancel Order Button -->
    @if (in_array($orders->status, [0, 2]))
        <div class="mb-3" style="margin-left: auto;">
            <button id="cancelOrderBtn" class="btn btn-danger"
                style="border: none; background: #dc3545; color: white; padding: 10px; font-weight: bold; border-radius: 5px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: background 0.3s, transform 0.2s; width: 100%;"
                onmouseover="this.style.background='#c82333'; this.style.transform='translateY(-2px)';"
                onmouseout="this.style.background='#dc3545'; this.style.transform='translateY(0)';">
                <i class="fas fa-times" style="margin-right: 5px;"></i> Cancel Order
            </button>
        </div>
    @endif

    <!-- Message for Other Statuses -->
    @if (!in_array($orders->status, [1, 0, 2]))
        <div style="text-align: center; opacity: 0.7; color: #333; margin-top: 20px;">
            <i class="fas fa-info-circle" style="font-size: 24px;"></i>
            <p style="margin: 5px 0;">No actions available for this order status.</p>
        </div>
    @endif


    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.inc.frontfooter')
<!-- Include necessary styles and scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cancel Order Button Functionality
    const cancelOrderBtn = document.getElementById('cancelOrderBtn');

    if (cancelOrderBtn) {
        cancelOrderBtn.addEventListener('click', function() {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to cancel the order?",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "No, keep it",
                        value: null,
                        visible: true,
                        className: "btn-secondary"
                    },
                    confirm: {
                        text: "Yes, cancel it",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: true
                    }
                },
                dangerMode: true,
            }).then((willCancel) => {
                if (willCancel) {
                    // Ask for the cancellation reason
                    swal({
                        title: "Cancellation Reason",
                        text: "Please select a reason for cancellation:",
                        content: {
                            element: "select",
                            attributes: {
                                id: "cancelReason",
                                style: "width: 100%;", // Ensures full width
                                innerHTML: `
                                    <option value="0">Select a reason</option>
                                    <option value="1">Changed my mind</option>
                                    <option value="2">Found a better price</option>
                                    <option value="3">Product not needed anymore</option>
                                    <option value="4">Other</option>
                                `,
                            },
                        },
                        buttons: {
                            confirm: {
                                text: "Submit",
                                value: true,
                                visible: true,
                                className: "btn-primary",
                                closeModal: true
                            }
                        },
                        icon: "info" // Optional: Add an icon to the modal
                    }).then(() => {
                        const reason = document.getElementById("cancelReason").value;

                        if (reason === "0") {
                            swal("Please select a valid reason!", {
                                icon: "error",
                            });
                            return; // Exit if no valid reason is selected
                        }

                        // Proceed with AJAX request only if a valid reason is selected
                        $.ajax({
                            url: '{{ route('cancel.order', $orders->id) }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                reason: reason
                            },
                            success: function(response) {
                                if (response.success) {
                                    swal("Order has been cancelled!", {
                                        icon: "success",
                                    }).then(() => {
                                        window.location.href = '{{ url('my-orders') }}';
                                    });
                                } else {
                                    swal("Error!", response.message, "error");
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                swal("Error!", "There was an error cancelling your order: " + xhr.responseText, "error");
                            }
                        });
                    });
                } else {
                    swal("Your order is safe!");
                }
            });
        });
    }


        // Reorder Button Functionality
        document.querySelectorAll('.btn-reorder').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    html: `
                        <div style="text-align: center;">
                            <p style="font-weight: bold; color: #333;">Note!</p>
                            <p style="margin-top: 10px; font-style: italic; color: #555;">
                                All current items in your cart will be removed.
                            </p>
                            <p style="font-style: italic; color: #555;">
                                Do you want to reorder all the items?
                            </p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fas fa-check"></i> Yes, Reorder it!',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ url('reorder') }}/" + orderId;
                    }
                });
            });
        });

   
    // Update quantity input based on selected product
    document.getElementById('prod_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const availableQty = selectedOption.getAttribute('data-qty');
        const qtyInput = document.querySelector('input[name="qty"]');
        qtyInput.max = availableQty; // Set max quantity based on availability
        qtyInput.value = 1; // Reset to 1 when product changes
    });

    // Show return modal
    document.getElementById('returnRequestBtn').addEventListener('click', function() {
        $('#returnModal').modal('show');
    });

// Submit return request
document.getElementById('submitReturnRequest').addEventListener('click', function() {
    const form = document.getElementById('returnForm');
    const formData = new FormData(form);
    const images = formData.getAll('images[]');

    // Validation checks
    const qtyInput = form.querySelector('input[name="qty"]');
    const returnReason = form.querySelector('select[name="return_reason"]');
    const validExtensions = ['image/jpeg', 'image/png', 'image/gif'];
    let validImages = true;

    // Check quantity
    if (qtyInput.value < 1 || qtyInput.value > qtyInput.max) {
        swal("Error!", "Please enter a valid quantity.", "error");
        return;
    }

    // Check return reason
    if (!returnReason.value) {
        swal("Error!", "Please select a reason for return.", "error");
        return;
    }

    // Validate images
    images.forEach(image => {
        if (!validExtensions.includes(image.type)) {
            validImages = false;
        }
    });

    if (!validImages) {
        swal("Error!", "Please upload valid image files (JPEG, PNG, GIF) only.", "error");
        return;
    }

       // Confirmation dialog before submitting
       swal({
        title: "Confirm Return Request",
        text: "Are you sure you want to submit this return request? You will be notified once your return is processed.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSubmit) => {
        if (willSubmit) {
            // AJAX request to submit return request
            $.ajax({
                url: '{{ route('return.order') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (!response.success) {
                        // Alert if a return request already exists
                        swal({
                            title: "Return Request Exists",
                            text: "You have already requested a return for this item. Please wait for the response to your previous request.",
                            icon: "info",
                            buttons: {
                                cancel: false,
                                confirm: {
                                    text: "Okay",
                                    value: true,
                                    visible: true,
                                    className: "btn-info",
                                    closeModal: true
                                }
                            }
                        });
                        return;
                    }

                    // Confirmation of successful submission
                    swal("Return request submitted!", "You will receive a notification once your return is processed.", { icon: "success" });
                    $('#returnModal').modal('hide'); // Close modal
                },
                error: function(xhr) {
                    console.log(xhr);
                    // Handle error response
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        swal("Error!", errorResponse.message || "There was an error submitting your return request.", "error");
                    } catch (e) {
                        swal("Error!", "There was an error submitting your return request: " + xhr.responseText, "error");
                    }
                }
            });
        } else {
            swal("Return request cancelled.");
        }
    });
});

    // Close modal on cancel button click or 'x' button click
    document.querySelectorAll('.close, .btn-danger').forEach(button => {
        button.addEventListener('click', function() {
            $('#returnModal').modal('hide');
        });
    });
});
</script>

@endsection