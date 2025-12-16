<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Processed Notification</title>
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
            text-align: justify; /* Justify text */
            text-indent: 20px; /* First line indent */
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
            border-left: 4px solid darkgreen;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .icon {
            margin-right: 5px;
            vertical-align: middle;
        }
        .payment-mode-image {
            width: 320px; /* Adjusted size */
            height: auto;
            margin: 20px auto;
            display: block; /* Center the image */
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
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/cod.png')) }}" alt="Cash on Delivery"  width="480" height="120">
            @elseif($returnRequest->order->payment_mode == 'Paid by Paypal')
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/paypal.png')) }}" alt="PayPal"  width="480" height="120">
            @else
                <img class="payment-mode-image" src="{{ $message->embed(public_path('assets/images/other.png')) }}" alt="Other Payment">
            @endif
        </div>

        <h1>Refund Processed Notification</h1>
        <p>Dear <strong>{{ $returnRequest->user->name }}</strong>,</p>

        <p>We would like to inform you that your refund request for <strong>Order ID:</strong> <span class="important">{{ $returnRequest->order_id }}</span> has been 
            <strong class="status-approved">
                <i class="icon">✅</i>
                FULLY PROCESSED
            </strong>. This refund pertains to the product <strong>{{ $returnRequest->product->name ?? 'N/A' }}</strong> with a quantity of <strong>{{ $returnRequest->qty }}</strong>. We appreciate your patience in this matter as we worked to ensure your satisfaction with our service.
        </p>

        <div class="refund-details">
            <p><strong>Refund Amount:</strong> <span class="important">₱{{ number_format($returnRequest->refund_amount, 2) }}</span></p>
            <p><strong>Status:</strong> 
                <span class="status-approved">
                    <i class="icon">✅</i> Completed
                </span>
            </p>
        </div>

        <p><strong>Payment Mode:</strong> 
            <span class="important">{{ $returnRequest->order->payment_mode == 'COD' ? 'Cash on Delivery' : $returnRequest->order->payment_mode }}</span>
        </p>

        <p>We sincerely apologize for any inconvenience this may have caused you. Thank you for your patience and understanding.</p>

        <p class="footer">Best Regards,<br><span class="hound-name">Hound</span></p>
    </div>
</body>
</html>