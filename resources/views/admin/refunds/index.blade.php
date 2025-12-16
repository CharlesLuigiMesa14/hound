@extends('layouts.admin')

@section('content')

<div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
    <h3 style="font-weight: bold; font-family: 'Roboto', sans-serif; margin-bottom: 20px;">
        <i class="material-icons" style="vertical-align: middle;">receipt</i> Refund Requests
    </h3>

    <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div id="current-time" style="text-align: right; font-size: 14px; color: #555; margin-bottom: 10px;"></div>
        <table class="table" style="border-collapse: collapse; width: 100%; font-family: 'Roboto', sans-serif;">
            <thead style="background-color: white; color: #333;">
                <tr>
                    <th style="text-align: center;">User Name</th>
                    <th style="text-align: center;">Refund Amount</th>
                    <th style="text-align: center;">Payment Mode</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($refundRequests as $request)
                    @if($request->return_status == 1)
                        <tr id="refund-row-{{ $request->id }}">
                            <td style="text-align: center;">{{ $request->user->name . ' ' . $request->user->lname }}</td>
                            <td style="text-align: center;">₱ {{ number_format($request->refund_amount, 2) }}</td>
                            <td style="text-align: center;">
                                {{ $request->order->payment_mode == 'COD' ? 'Cash on Delivery' : $request->order->payment_mode }}
                            </td>
                            <td style="text-align: center;" id="refund-status-{{ $request->id }}">
                                <span class="status-icon" id="status-icon-{{ $request->id }}">
                                    @if($request->refund_status === 1)
                                        <i class="fas fa-check-circle" style="color: green;"></i> <span style="color: green; margin-left: 5px;">Completed</span>
                                    @elseif($request->refund_status === 0)
                                        <i class="fas fa-clock" style="color: orange;"></i> <span style="color: orange; margin-left: 5px;">Pending</span>
                                    @elseif($request->refund_status === null)
                                        <i class="fas fa-times-circle" style="color: #333;"></i> <span style="color: #333; margin-left: 5px;">Unprocessed</span>
                                    @else
                                        <i class="fas fa-question-circle" style="color: gray;"></i> <span style="color: gray; margin-left: 5px;">Unknown</span>
                                    @endif
                                </span>
                                <div id="remaining-time-{{ $request->id }}" class="remaining-time" style="margin-top: 5px; font-size: 12px; color: #555;">
                                    @if($request->refund_status === 0 && $request->refund_date)
                                        @php
                                            $refundDate = \Carbon\Carbon::parse($request->refund_date);
                                            $remainingSeconds = $refundDate->diffInSeconds(now());
                                        @endphp
                                        Remaining Time: <span id="remaining-time-value-{{ $request->id }}">{{ formatTime($remainingSeconds) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                @if($request->refund_status === 0 || $request->refund_status === 1)
                                    <button class="btn btn-primary" id="process-btn-{{ $request->id }}" disabled style="opacity: 0.5;">
                                        <i class="material-icons">monetization_on</i> Process Refund
                                    </button>
                                @elseif($request->refund_status === null)
                                    <button class="btn btn-primary" id="process-btn-{{ $request->id }}" onclick="confirmProcessRefund({{ $request->id }})">
                                        <i class="material-icons">monetization_on</i> Process Refund
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <script>
                            (function() {
                                const refundStatus = "{{ $request->refund_status }}";
                                const refundDate = "{{ $request->refund_date }}"; 
                                
                                if (refundStatus === '0' && refundDate) {
                                    const refundDateTime = new Date(refundDate).getTime();
                                    let now = Date.now();
                                    let remainingTime = Math.max(0, Math.floor((refundDateTime - now) / 1000)); 

                                    function updateTime(id) {
                                        const remainingTimeElement = document.getElementById(`remaining-time-value-${id}`);
                                        if (remainingTime > 0) {
                                            remainingTime--;
                                            remainingTimeElement.innerText = formatTime(remainingTime);
                                        } else {
                                            clearInterval(interval);
                                            checkRefundStatus(id);
                                        }
                                    }

                                    let interval = setInterval(() => updateTime({{ $request->id }}), 1000); 
                                }
                            })();
                        </script>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
.status-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background-color: #007bff; 
    color: white;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
function formatTime(seconds) {
    const days = Math.floor(seconds / (3600 * 24));
    const hours = Math.floor((seconds % (3600 * 24)) / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;
    return `${days}d ${hours}h ${minutes}m ${secs}s`;
}

function confirmProcessRefund(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to process this refund?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, process it!'
    }).then((result) => {
        if (result.isConfirmed) {
            processRefund(id);
            location.reload();
        }
    });
}

function processRefund(id) {
    fetch(`/refunds/update-status/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            startTimer(id, 3 * 24 * 60 * 60);
            setTimeout(() => {
                location.reload();
            }, 259200 * 1000); 
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

function startTimer(id, remainingTime) {
    const interval = setInterval(function() {
        if (remainingTime <= 0) {
            clearInterval(interval);
            checkRefundStatus(id);
        } else {
            document.getElementById(`remaining-time-value-${id}`).innerText = formatTime(remainingTime);
            remainingTime--;
        }
    }, 1000);
}

function checkRefundStatus(id) {
    fetch(`/refunds/check-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); 
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

@endsection