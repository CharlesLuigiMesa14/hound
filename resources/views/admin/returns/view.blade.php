@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container mt-4" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
    <h3 class="font-weight-bold mb-4">
        <i class="material-icons align-middle">assignment_return</i> Return Request Details
    </h3>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white p-4 rounded shadow-sm">
        <div class="row">
            <!-- Details Column -->
            <div class="col-md-6">
                <h5 class="font-weight-bold">Return Details</h5>
                <div class="form-group">
                    <label><i class="material-icons">receipt</i> Order ID:</label>
                    <input type="text" class="form-control-plaintext border-bottom" value="{{ $returnRequest->order_id }}" readonly>
                </div>
                <div class="form-group">
                    <label><i class="material-icons">person</i> User Name:</label>
                    <input type="text" class="form-control-plaintext border-bottom" value="{{ $returnRequest->user->name . ' ' . $returnRequest->user->lname }}" readonly>
                </div>
                <div class="form-group">
                    <label><i class="material-icons">local_offer</i> Product Name:</label>
                    <input type="text" class="form-control-plaintext border-bottom" value="{{ $returnRequest->product->name ?? 'N/A' }}" readonly>
                </div>
                <div class="form-group">
                    <label><i class="material-icons">expand_less</i> Quantity:</label>
                    <input type="text" class="form-control-plaintext border-bottom" value="{{ $returnRequest->qty }}" readonly>
                </div>
                <div class="form-group">
                    <label><i class="material-icons">info</i> Return Reason:</label>
                    <input type="text" class="form-control-plaintext border-bottom" value="
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
                    " readonly>
                </div>
                <div class="form-group">
                    <label><i class="material-icons">comment</i> Comment:</label>
                    <textarea class="form-control" rows="5" readonly style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 10px;">{{ $returnRequest->comment ?? 'N/A' }}</textarea>
                </div>
            </div>

            <!-- Status and Response Column -->
            <div class="col-md-6">
                <h5 class="font-weight-bold mt-4">Update Return Status</h5>
                <form id="updateStatusForm" action="{{ route('returns.update', $returnRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-check">
                        <input type="radio" id="status_pending" name="return_status" value="0" class="form-check-input" {{ $returnRequest->return_status == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_pending">
                            <span class="circle"></span>
                            <i class="material-icons">hourglass_empty</i>
                            Pending
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="status_approved" name="return_status" value="1" class="form-check-input" {{ $returnRequest->return_status == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_approved">
                            <span class="circle"></span>
                            <i class="material-icons">check_circle</i>
                            Approve
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="status_rejected" name="return_status" value="2" class="form-check-input" {{ $returnRequest->return_status == 2 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_rejected">
                            <span class="circle"></span>
                            <i class="material-icons">cancel</i>
                            Reject
                        </label>
                    </div>
                    <button type="button" id="confirmUpdateBtn" class="btn btn-primary mt-3">
                        <i class="material-icons">update</i> Update Status
                    </button>
                </form>

                <h5 class="font-weight-bold mt-4">Admin Response</h5>
                <textarea class="form-control" rows="5" name="return_response" form="updateStatusForm" placeholder="Type your response here...">{{ $returnRequest->return_response ?? '' }}</textarea>

                <h5 class="font-weight-bold mt-4"><i class="material-icons">image</i> Preview Image</h5>
                @if($returnRequest->images)
                    <div class="image-container" data-toggle="modal" data-target="#imageModal">
                        <img src="{{ asset('assets/uploads/returns/' . $returnRequest->images) }}" alt="Return Image" class="img-fluid rounded" />
                        <div class="overlay">
                            <span>View Image</span>
                        </div>
                    </div>
                @else
                    <p>No image uploaded.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Image</h5>
                <div class="ml-auto">
                    <button id="zoomIn" class="btn btn-secondary shadow" title="Zoom In" style="color: blue; font-weight: bold;">
                        <i class="material-icons" style="color: blue;">zoom_in</i> Zoom In
                    </button>
                    <button id="zoomOut" class="btn btn-secondary shadow" title="Zoom Out" style="color: red; font-weight: bold;">
                        <i class="material-icons" style="color: red;">zoom_out</i> Zoom Out
                    </button>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close" style="margin-left: 10px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body text-center">
                <div class="zoom-container" style="overflow: auto; max-height: 500px; position: relative;" id="zoomContainer">
                    <img id="modalImage" src="{{ asset('assets/uploads/returns/' . $returnRequest->images) }}" alt="Return Image" class="img-fluid" style="transform-origin: top left;"/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.getElementById('confirmUpdateBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update the return status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('updateStatusForm').submit();
            }
        });
    });

    // Variables for zooming and panning
    let scale = 1;
    const modalImage = document.getElementById('modalImage');
    const zoomInButton = document.getElementById('zoomIn');
    const zoomOutButton = document.getElementById('zoomOut');
    const zoomContainer = document.getElementById('zoomContainer');

    let isDragging = false;
    let startX, startY, scrollLeft, scrollTop;

    zoomInButton.addEventListener('click', function() {
        scale += 0.1;
        updateImageScale();
    });

    zoomOutButton.addEventListener('click', function() {
        if (scale > 1) {
            scale -= 0.1; // Limit zoom out to not go below original size
            updateImageScale();
        }
    });

    function updateImageScale() {
        modalImage.style.transform = `scale(${scale})`;
        modalImage.style.transition = "transform 0.2s ease";

        // Center the image if it's fully zoomed out
        if (scale <= 1) {
            modalImage.style.transform = `scale(1)`;
            zoomContainer.scrollLeft = (zoomContainer.scrollWidth - zoomContainer.clientWidth) / 2;
            zoomContainer.scrollTop = (zoomContainer.scrollHeight - zoomContainer.clientHeight) / 2;
        }
    }

    // Dragging functionality
    zoomContainer.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - zoomContainer.offsetLeft;
        startY = e.pageY - zoomContainer.offsetTop;
        scrollLeft = zoomContainer.scrollLeft;
        scrollTop = zoomContainer.scrollTop;
    });

    zoomContainer.addEventListener('mouseleave', () => {
        isDragging = false;
    });

    zoomContainer.addEventListener('mouseup', () => {
        isDragging = false;
    });

    zoomContainer.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - zoomContainer.offsetLeft;
        const y = e.pageY - zoomContainer.offsetTop;

        const walkX = (x - startX) * 1; // Amount to scroll
        const walkY = (y - startY) * 1; // Amount to scroll

        zoomContainer.scrollLeft = scrollLeft - walkX;
        zoomContainer.scrollTop = scrollTop - walkY;
    });
</script>

<style>
    .form-control-plaintext {
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0;
        padding: 0.375rem 0;
    }
    .form-control-plaintext:focus {
        box-shadow: none;
        border-bottom-color: #007bff;
    }
    .form-check {
        position: relative;
        padding-left: 40px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .form-check-input {
        position: absolute;
        opacity: 0;
    }
    .form-check-label {
        display: flex;
        align-items: center;
        font-size: 1rem;
        cursor: pointer;
        transition: color 0.3s, border-color 0.3s;
    }
    .form-check-label .circle {
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 50%;
        background-color: transparent;
        transition: border-color 0.3s, background-color 0.3s;
        margin-right: 10px;
    }

    #status_pending:checked + .form-check-label {
        color: gold;
    }
    #status_pending:checked + .form-check-label .circle {
        background-color: gold;
        border-color: gold;
    }

    #status_approved:checked + .form-check-label {
        color: green;
    }
    #status_approved:checked + .form-check-label .circle {
        background-color: green;
        border-color: green;
    }

    #status_rejected:checked + .form-check-label {
        color: red;
    }
    #status_rejected:checked + .form-check-label .circle {
        background-color: red;
        border-color: red;
    }

    .form-check-label i {
        margin-right: 5px;
    }

    .image-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .image-container img {
        transition: 0.3s;
    }
    .image-container:hover img {
        opacity: 0.7;
    }
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        border: 2px solid white;
        padding: 10px;
        box-sizing: border-box;
    }
    .image-container:hover .overlay {
        opacity: 1;
    }
    .overlay span {
        border: 1px solid white;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .zoom-container {
        position: relative;
        display: inline-block;
        overflow: auto;
        max-height: 500px;
        cursor: grab; /* Change cursor to indicate drag */
    }
    .zoom-container:active {
        cursor: grabbing; /* Change cursor when grabbing */
    }
    .modal-header .btn {
        margin-left: 10px;
    }
    .btn.secondary {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }
</style>
@endsection