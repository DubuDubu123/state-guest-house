<table class="table table-hover">
    <thead>
        <tr>
            <th> S.No</th>
            <th> Booking ID</th>
            <th>Officer's ID</th>
            <th>Officer's Name</th>
            <th>Check-in</th>
            <th>Guest Type</th>
            <th>Booked By</th>
            <th>Payment Status</th>
            <th>Price</th> 
        </tr>
    </thead>
    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)
            <tr>
                <td>{{ $i++ }} </td>
                <td>{{$result->booking_id}} </td>
                <td>{{$result->user->userid}} </td>
                <td>{{$result->user->name}} </td>
                <td><?php echo date('Y-m-d', strtotime($result->checkin_date));?></td>
                <td>{{ucfirst($result->guest_type)}}</td>
                <td>{{$result->booked_user->userid}} </td>
                <td style="font-size:11px;text-align:center"> 
                @if($result->is_paid == 1)
                <button class="btn btn-success btn-sm" style="background: green;color:white;border-color: transparent;">
                Paid
                </button>
                @else
                <button class="btn btn-danger btn-sm" style="background: green;color:white;border-color: transparent;">
                Unpaid
                </button>
                @endif 
                </td>
                <td>₹{{$result->tariff}}</td> 
            </tr>
        @empty
            <tr>
                <td colspan="11">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </td>
            </tr>
        @endforelse

    </tbody>
</table>
