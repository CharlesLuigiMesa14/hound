$(document).ready(function() {
    loadCart();
    loadWishlist();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadCart() {
        $.ajax({
            method: "GET",
            url: "/load-cart-data",
            success: function(response) {
                $('.cart-count').html(response.count);
                updateTotalPrice();
            }
        });
    }

    function loadWishlist() {
        $.ajax({
            method: "GET",
            url: "/load-wishlist-count",
            success: function(response) {
                $('.wishlist-count').html(response.count);
            }
        });
    }

    $(document).on('click', '.addToCartBtn', function(e) {
        e.preventDefault();
        var product_data = $(this).closest('.product_data');
        var product_id = product_data.find('.prod_id').val();
        var product_qty = product_data.find('.qty-input').val();
        var stock = parseInt(product_data.find('.stock').val(), 10);

        if (parseInt(product_qty) > stock) {
            swal("Error", "Cannot add more than available stock (" + stock + ")", "error");
            return;
        }

        $.ajax({
            method: "POST",
            url: "/add-to-cart",
            data: {
                'product_id': product_id,
                'product_qty': product_qty,
            },
            success: function(response) {
                swal(response.status);
                loadCart();
            }
        });
    });

    $(document).on('click', '.increment-btn', function(e) {
        e.preventDefault();
        var product_data = $(this).closest('.product_data');
        var inc_value = parseInt(product_data.find('.qty-input').val(), 10);
        var stock = parseInt(product_data.find('.stock').val(), 10);
        var new_value = inc_value + 1;

        if (new_value > stock) {
            swal("Error", "Cannot exceed available stock (" + stock + ")", "error");
            return;
        }

        product_data.find('.qty-input').val(new_value);
        updateTotalPrice();
        toggleIncrementButton(product_data, new_value, stock);
    });

    $(document).on('click', '.decrement-btn', function(e) {
        e.preventDefault();
        var product_data = $(this).closest('.product_data');
        var dec_value = parseInt(product_data.find('.qty-input').val(), 10);

        if (dec_value > 1) {
            product_data.find('.qty-input').val(dec_value - 1);
            updateTotalPrice();
        }
        toggleIncrementButton(product_data, dec_value - 1, parseInt(product_data.find('.stock').val(), 10));
    });

    function toggleIncrementButton(product_data, current_value, stock) {
        var incrementBtn = product_data.find('.increment-btn');
        var isDisabled = current_value >= stock;
        incrementBtn.prop('disabled', isDisabled);
        setButtonOpacity(incrementBtn, isDisabled);
    }

    function setButtonOpacity(button, isDisabled) {
        if (isDisabled) {
            button.css('opacity', '0.5');
            button.css('cursor', 'not-allowed');
        } else {
            button.css('opacity', '1');
            button.css('cursor', 'pointer');
        }
    }

    $(document).on('click', '.addToWishlist', function(e) {
        e.preventDefault();
        var product_data = $(this).closest('.product_data');
        var product_id = product_data.find('.prod_id').val();
        var product_qty = product_data.find('.qty-input').val(); // Get the quantity
        
        $.ajax({
            method: "POST",
            url: "/add-to-wishlist",
            data: {
                'product_id': product_id,
                'product_qty': product_qty, // Include quantity
            },
            success: function(response) {
                swal(response.status);
                loadWishlist(); 
            }
        });
    });

    $(document).on('click', '.delete-cart-item', function(e) {
        e.preventDefault();
        var that = this;

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var prod_id = $(that).closest('.product_data').find('.prod_id').val();
                $.ajax({
                    method: "POST",
                    url: "delete-cart-item",
                    data: {
                        'prod_id': prod_id,
                    },
                    success: function(response) {
                        loadCart();
                        $('.cartitems').load(location.href + " .cartitems");
                        swal("", response.status, "success");
                    }
                });
            }
        });
    });

    $(document).on('click', '.remove-wishlist-item', function(e) {
        e.preventDefault();
        var that = this;

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var prod_id = $(that).closest('.product_data').find('.prod_id').val();
                $.ajax({
                    method: "POST",
                    url: "delete-wishlist-item",
                    data: {
                        'prod_id': prod_id,
                    },
                    success: function(response) {
                        loadWishlist();
                        $('.wishlistitems').load(location.href + " .wishlistitems");
                        swal("", response.status, "success");
                    }
                });
            }
        });
    });

    $(document).on('click', '.changeQuantity', function(e) {
        e.preventDefault();

        var product_data = $(this).closest('.product_data');
        var prod_id = product_data.find('.prod_id').val();
        var qty = product_data.find('.qty-input').val();
        var data = {
            'prod_id': prod_id,
            'prod_qty': qty,
        };

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function(response) {
                $('.cartitems').load(location.href + " .cartitems");
                updateTotalPrice();
            }
        });
    });

    function updateTotalPrice() {
        let total = 0;
        $('.product_data').each(function() {
            var price = parseFloat($(this).find('.product_price').text().replace('₱ ', '').replace(',', ''));
            var qty = parseInt($(this).find('.qty-input').val(), 10);
            if (!isNaN(price) && !isNaN(qty)) { // Check valid numbers
                total += (price * qty);
            }
        });
        $('.total-price').html('₱ ' + total.toFixed(2));
    }

    // Initialize button states
    $('.product_data').each(function() {
        var product_data = $(this);
        var current_value = parseInt(product_data.find('.qty-input').val(), 10);
        var stock = parseInt(product_data.find('.stock').val(), 10);
        toggleIncrementButton(product_data, current_value, stock);
    });
});