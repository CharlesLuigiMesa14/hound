<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Request Status Update</title>
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
        .admin-response {
            background-color: #f9f9f9;
            border-left: 4px solid darkred;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .status-rejected {
            color: red;
            font-weight: bold;
        }
        .product-name {
            color: darkblue;
            font-weight: bold;
        }
        .icon {
            margin-right: 5px;
        }
        .details {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
        <img src="{{$message->embed(public_path('assets/images/navbariconn.png'))}}" alt="Hound Icon" width="240" height="60">
        </div>
        <h1>Return Request Status Update</h1>
        <p>Dear <strong>{{ $returnRequest->user->name }}</strong>,</p>

        <p>Your return request for <strong>Order ID:</strong> <span class="important">{{ $returnRequest->order_id }}</span> has been 
            <strong class="{{ $returnRequest->return_status == 1 ? 'status-approved' : 'status-rejected' }}">
                <i class="icon">{{ $returnRequest->return_status == 1 ? '✅' : '❌' }}</i>
                {{ $returnRequest->return_status == 1 ? 'APPROVED' : 'REJECTED' }}
            </strong>.
        </p>

        <div class="details">
            <p><strong>Product Name:</strong> <span class="product-name">{{ $returnRequest->product->name ?? 'N/A' }}</span></p>
            <p><strong>Quantity:</strong> <span class="important">{{ $returnRequest->qty }}</span></p>
            <p><strong>Return Reason:</strong>
                <span class="important">
                    @switch($returnRequest->return_reason)
                        @case('defective')
                            Defective Item
                            @break
                        @case('not_as_described')
                            Not as Described
                            @break
                        @case('changed_mind')
                            Changed My Mind
                            @break
                        @case('wrong_item')
                            Wrong Item Received
                            @break
                        @default
                            Other Reason
                    @endswitch
                </span>
            </p>
            <p><strong>Request Created At:</strong> <span class="important">{{ $returnRequest->created_at->format('h:i A, d M Y') }}</span></p>
        </div>

        <div class="admin-response">
            <p><strong>Admin Response:</strong></p>
            <p>{{ $returnRequest->return_response ?? 'No response provided.' }}</p>
        </div>

        <p>Thank you for your understanding.</p>

        <p class="footer">Best Regards,<br><span class="hound-name">Hound</span></p>
    </div>
</body>
</html>