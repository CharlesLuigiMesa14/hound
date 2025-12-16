@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
    <h3 style="font-weight: bold; font-family: 'Roboto', sans-serif; margin-bottom: 20px;">
        <i class="material-icons" style="vertical-align: middle;">assignment_return</i> Return Requests
    </h3>

    <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <table class="table" style="border-collapse: collapse; width: 100%; font-family: 'Roboto', sans-serif;">
            <thead style="background-color: white; color: #333;">
                <tr>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">receipt</i> Order ID
                    </th>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">person</i> User Name
                    </th>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">shopping_bag</i> Product Name
                    </th>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">comment</i> Return Reason
                    </th>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">check_circle_outline</i> Return Status
                    </th>
                    <th style="font-weight: bold; text-align: center;">
                        <i class="material-icons" style="display: block;">access_time</i> Created At
                    </th>
                    <th style="font-weight: bold; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($returnRequests as $request)
                    <tr style="border-top: 1px solid #dee2e6; background-color: white;">
                        <td style="text-align: center;">{{ $request->order_id }}</td>
                        <td style="text-align: center;">{{ $request->user->name . ' ' . $request->user->lname }}</td>
                        <td style="text-align: center; color: black;">{{ $request->product->name ?? 'N/A' }}</td>
                        <td style="text-align: center;">
                            @switch($request->return_reason)
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
                            <td style="text-align: center;">
    @if($request->return_status == 0)
        <span class="text-warning" title="Pending" style="display: flex; align-items: center; justify-content: center;">
            <i class="material-icons" style="color: gold; margin-right: 4px;">pending</i>
            Pending
        </span>
    @elseif($request->return_status == 1)
        <span class="text-success" title="Approved" style="display: flex; align-items: center; justify-content: center;">
            <i class="material-icons" style="color: green; margin-right: 4px;">check_circle</i>
            Approved
        </span>
    @elseif($request->return_status == 2)
        <span class="text-danger" title="Rejected" style="display: flex; align-items: center; justify-content: center;">
            <i class="material-icons" style="color: red; margin-right: 4px;">cancel</i>
            Rejected
        </span>
    @endif
</td>
                        <td style="text-align: center;">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                        <td style="text-align: center;">
    <a href="{{ route('returns.view', $request->id) }}" class="btn btn-link" style="padding: 0; color: inherit;">
        <i class="material-icons" style="font-size: 24px; color: #007bff;">visibility</i>
    </a>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection