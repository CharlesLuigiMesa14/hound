<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Pending Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        p {
            color: #555;
            margin: 10px 0;
            text-align: justify;
            text-indent: 20px;
        }
        .important {
            color: darkred;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
        .footer .hound-name {
            color: darkred;
            font-weight: bold;
        }
        .logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .refund-details {
            background-color: #f9f9f9;
            border-left: 4px solid darkorange;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .status-pending {
            color: darkorange;
            font-weight: bold;
        }
        .icon {
            margin-right: 5px;
            vertical-align: middle;
        }
        .payment-mode-image {
            width: 320px;
            height: auto;
            margin: 20px auto;
            display: block;
        }
        .payment-mode-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .date {
            text-align: right;
            font-size: 0.9em;
            color: #777;
            margin-bottom: 20px;
        }
        .estimated-time {
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{$message->embed(public_path('assets/images/navbariconn.png'))}}" alt="Hound Icon" width="240" height="60">
        </div>
        <div class="date">{{ date('F j, Y') }}</div>
        
        <div class="payment-mode-container">
            @if($returnRequest->order->payment_mode == 'COD')
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/cod.png')) }}" alt="Cash on Delivery" width="480" height="120">
            @elseif($returnRequest->order->payment_mode == 'Paid by Paypal')
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/paypal.png')) }}" alt="PayPal" width="480" height="120">
            @else
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/other.png')) }}" alt="Other Payment">
            @endif
        </div>

        <h1>Refund Pending Notification</h1>
        <p>Dear <strong>{{ $returnRequest->user->name }}</strong>,</p>

        <p>We would like to inform you that your refund request for <strong>Order ID:</strong> <span class="important">{{ $returnRequest->order_id }}</span> is currently 
            <strong class="status-pending">
                <i class="icon">⏳</i> PENDING
            </strong>. This refund pertains to the product <strong>{{ $returnRequest->product->name ?? 'N/A' }}</strong> with a quantity of <strong>{{ $returnRequest->qty }}</strong>.
        </p>

        <p>Please allow us <span class="estimated-time">1-3 business days</span> to process your refund request.</p>

        <div class="refund-details">
            <p><strong>Refund Amount:</strong> <span class="important">₱{{ number_format($returnRequest->refund_amount, 2) }}</span></p>
            <p><strong>Status:</strong> 
                <span class="status-pending">
                    <i class="icon">⏳</i> Pending <strong>(Estimated waiting time: <span class="estimated-time">1-3 business days</span>)</strong>
                </span>
            </p>
        </div>

        <p><strong>Payment Mode:</strong> 
            <span class="important">{{ $returnRequest->order->payment_mode == 'COD' ? 'Cash on Delivery' : $returnRequest->order->payment_mode }}</span>
        </p>

        <p>We sincerely apologize for any inconvenience this may have caused you. Thank you for your understanding and patience.</p>

        <p class="footer">Best Regards,<br><span class="hound-name">Hound</span></p>
    </div>
</body>
</html>