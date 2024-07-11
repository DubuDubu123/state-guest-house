<style>
    table.table.table-hover{
        text-align:center;
    }
    </style>

<div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover">
      <thead style="  background-color: #454545; color: white;">
<tr>


<th> @lang('view_pages.s_no')
<span style="float: right;">

</span>
</th>
<th> DID
<span style="float: right;">
</span>
</th>

<th style="padding-left:36px;text-align:left"> Driver Name
<span style="float: right;">
</span>
</th>
<th> Location
<span style="float: right;">
</span>
</th>
<th> @lang('view_pages.mobile')
<span style="float: right;">
</span>
</th>
<th> @lang('view_pages.type')
<span style="float: right;">
</span>
<th> @lang('view_pages.created_by')
<span style="float: right;">
</span>
</th> 
<th> @lang('view_pages.updated_by')
<span style="float: right;">
</span>
</th>  
 
<th> @lang('view_pages.action')
<span style="float: right;">
</span>
</th>
</tr>
</thead>
<tbody>
 @if(count($results)<1)
    <tr>
        <td colspan="11">
        <p id="no_data" class="lead no-data text-center">
        <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
     <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
 </p>
    </tr>
    @else

@php  $i= $results->firstItem(); @endphp

@foreach($results as $key => $result)

<tr>
<td>{{ $key+1 }} </td>
<td> <a  href="{{url('driver_profile_dashboard_view',$result->id)}}" style="text-decoration: underline; color: blue;">{{ $result->user->username }} </a>
</td>

<td style="    text-align: left;">
<img src="https://ddatab.com/images/Pending.png" alt="" style=" width: 60px; height: 60px;"> {{$result->name}}
</td>
@if($result->serviceLocation)
<td>{{$result->serviceLocation->name}}</td>
@else
<td>--</td>
@endif

@if(env('APP_FOR')=='demo')
<td>**********</td>
@else
<td>{{$result->mobile}}</td>
<!-- <td>{{$result->gender}}</td> -->
@endif
@if($result->vehicleType)
<td>{{$result->vehicleType->name}}</td>
@else
<td>--</td>
@endif
<td>{{$result->createdUser->name ?? "-"}}</td>
<td>{{$result->updatedUser->name ?? "-"}}</td> 

 
 

 

<td>

<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
</button>
@if($result->approve == 1)
     <div class="dropdown-menu w-48 ">
    @if(auth()->user()->can('edit-drivers'))         
      <a class="dropdown-item" href="{{url('drivers',$result->id)}}">
            <i class="fa fa-pencil"></i>@lang('view_pages.edit')
      </a>
    @endif
    @if(auth()->user()->can('toggle-drivers'))         
        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>3])}}?type=1">
        <i class="fa fa-dot-circle-o"></i>Send Back</a>

        <a class="dropdown-item" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>1])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.approved')</a>
    @endif
    @if(auth()->user()->can('delete-drivers'))         
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('drivers/delete',$result->id)}}">
        <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a> 
    @endif 
    @if(auth()->user()->can('view-request-list'))         
        <a class="dropdown-item" href="{{url('drivers/request-list',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.request_list')</a> 
    @endif
    @if(auth()->user()->can('driver-payment-history'))         
        <a class="dropdown-item" href="{{url('drivers/payment-history',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.driver_payment_history')</a>
    @endif
        <a class="dropdown-item get-invoice" href="#" data-toggle="modal" data-target="#alertModal" data-driver-id="{{ $result->user->username }}" data-phone-number="{{ $result->mobile }}" data-driver-num="{{ $result->id }}">
         <i class="fa fa-dot-circle-o"></i>@lang('view_pages.get_invoice')
        </a>
        <a class="dropdown-item" href="{{url('drivers/list-invoice',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.invoice_list')
        </a>
    </div>
@else
    <div class="dropdown-menu">
        @if(auth()->user()->can('edit-drivers'))         
            <a class="dropdown-item" href="{{url('drivers',$result->id)}}">
                <i class="fa fa-pencil"></i>@lang('view_pages.edit')
            </a>
        @endif
        @if(auth()->user()->can('toggle-drivers'))         
        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>3])}}?type=1">
        <i class="fa fa-dot-circle-o"></i>Send Back</a>

        <a class="dropdown-item" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>1])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.approved')</a>
        @endif
        @if(auth()->user()->can('delete-drivers'))         
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('drivers/delete',$result->id)}}">
        <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a> 
        @endif
</div>
@endif
                     
</td>   
</a>
</tr>
@endforeach
@endif
</tbody>
</table>
<div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div>
</div>
</div>

