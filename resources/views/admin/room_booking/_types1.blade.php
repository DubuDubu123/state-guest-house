<div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr> 
                                            <th style="width: 5% !important;">S.No</th>
                                            <th style="width: 10%;">Booking ID</th> 
                                            <th style="width: 10%;"> Booked By
                                                        <span style="float: right;"></span>
                                                    </th>
                                            <th style="width: 13% !important;">Officer's Name</th>
                                            <th style="width: 13% !important;">Check-in</th>
                                            <th style="width: 12% !important;">Check-out</th>
                                            <th style="width: 12% !important;">Status</th>
                                            <th style="width: 15% !important;">Payment Status</th>
                                            <th style="width: 10%;">Action</th>

                                            </tr>
                                            </thead>
                                       
<tbody>
 @if(count($results)<1)
    <tr>
        <td colspan="11">
        <p id="no_data" class="lead no-data text-center">
       
     <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
 </p>
    </tr>
    @else

@php  $i= $results->firstItem(); @endphp

@foreach($results as $key => $result)

<tr>
<td>{{ $i++ }} </td>
<td> {{$result->booking_id}}</td>   
<td> {{$result->booked_user->name}}</td> 
<td> {{$result->user->name}}</td> 

<td><?php echo date('Y-m-d', strtotime($result->checkin_date)); ?></td>
<td><?php echo date('Y-m-d', strtotime($result->checkout_date)); ?></td>  
<td>@if($result->status == 0)
@if($result->is_admin_approve == 0)
<button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Waiting for admin approval</button>
@else
<button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Booked</button>
@endif
    @elseif($result->status == 1)
    <button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Booked</button>
    @elseif($result->status == 2)
    <button class="btn btn-success btn-sm" style="  background: red;   border-color: transparent;
">Cancelled</button>
    @else<button class="btn btn-success btn-sm" style="  background: green;   border-color: transparent;
">Completed</button>
@endif
</td>   
<td>@if($result->is_paid == 0) 
<button class="btn btn-success btn-sm" style="  background: red;color:white;border-color: transparent;
">Not Paid</button>
@else
<button class="btn btn-success btn-sm" style="  background: green;color:white;border-color: transparent;
">Paid</button>
@endif
</td>   
<td><a class="dropdown-item" href="{{url('room-booking/view',$result->id)}}"><span class="label label-success">View   </span></a> </td> 
</tr>
@endforeach
@endif
</tbody>
</table>  
<div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div></div></div>
