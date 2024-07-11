<style>
     table.table.table-hover{
        text-align:center;
    }
        .demo-radio-button label {
            min-width: 100px;
            margin: 0 0 5px 50px;
        }
        input[type=file]::file-selector-button {
  margin-right: 10px;
  border: none;
  background: #084cdf;
  padding: 10px 10px;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
  font-size: 10px;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}

/* CSS for toggle switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #043c6c;
}

input:focus + .slider {
    box-shadow: 0 0 1px #043c6c;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
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
 
<th> @lang('view_pages.free_trail')<span style="float: right;"></span></th>
<th> @lang('view_pages.action')
<th>Welcome Call<span style="float: right;"></span></th>
<th>Status<span style="float: right;"></span></th>

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
@if($result->approve == 0)
<img src="https://ddatab.com/images/Disapproved.png" alt="" style=" width: 60px; height: 60px;">
@elseif($result->approve == 1)
<img src="https://ddatab.com/images/Approved.png" alt="" style=" width: 60px; height: 60px;"> 
@elseif($result->is_deleted == 1)
<img src="https://ddatab.com/images/Deleted.png" alt="" style=" width: 60px; height: 60px;">
@elseif($result->approve == 2)
<img src="https://ddatab.com/images/Pending.png" alt="" style=" width: 60px; height: 60px;">
@endif

    {{$result->name}}
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
    <!-- Replace 'ON/OFF' with actual status from backend -->
    <span class="online-status"></span>
    <label class="switch">
        <input type="checkbox" class="online-toggle" data-user-id="{{ $result->id }}" {{ $result->is_free_trial == 1 ? 'checked' : '' }}>
        <span class="slider round"></span>
    </label>
</td>


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
        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>0])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.disapproved')</a>

         
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
        <a class="dropdown-item" href="{{url('drivers/cancellation-wallet',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.cancellation_wallet')</a> 
    @if(auth()->user()->can('get-invoice'))         
        <a class="dropdown-item get-invoice" href="#" data-toggle="modal" data-target="#alertModal" data-driver-id="{{ $result->user->username }}" data-phone-number="{{ $result->mobile }}" data-driver-name="{{ $result->name }}" data-driver-num="{{ $result->id }}" data-driver-location="{{ $result->serviceLocation->name }}">
         <i class="fa fa-dot-circle-o"></i>@lang('view_pages.get_invoice')
        </a>
    @endif
    @if(auth()->user()->can('list-invoice'))         
        <a class="dropdown-item" href="{{url('drivers/list-invoice',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.invoice_list')
        </a>
    @endif
    @if(auth()->user()->can('driver-subscriptions'))         
         <a class="dropdown-item" href="{{url('drivers/subscriptions',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.subscriptions')
        </a>
    @endif
    @if(auth()->user()->can('driver-details'))             
        <a class="dropdown-item" href="{{ route('generate-driver-details.pdf',$result->id) }}" target="_blank">
        <i class="fa fa-dot-circle-o"></i>Driver-Details
        </a>
    @endif        
    </div>
@else
    <div class="dropdown-menu">
        @if(auth()->user()->can('edit-drivers'))         
            <a class="dropdown-item" href="{{url('drivers',$result->id)}}">
                <i class="fa fa-pencil"></i>@lang('view_pages.edit')
            </a>
        @endif
        @if(auth()->user()->can('toggle-drivers'))         
        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>0])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.disapproved')</a>

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
<td>
    <!-- Replace 'ON/OFF' with actual status from backend -->
    <span class="online-status"></span>
    <label class="switch">
        <input type="checkbox" class="online-toggle1" data-user-id="{{ $result->id }}" {{ $result->is_welcome_call == 1 ? 'checked' : '' }}>
        <span class="slider round"></span>
    </label>
</td>
<td>
<div style=" display: inline-block; width: 90%;margin-right: 5px;">
<select name="dispatcher_driver_list_acess" class="form-control" data-val="{{$result->id}}" id="decomposition">
    <option value="" selected disabled>Select</option>
    <option value="not_reachable" @if($result->decomposition == "not_reachable") selected @endif>Not Reachable</option>
    <option value="rnr" @if($result->decomposition == "rnr") selected @endif>RNR</option> 
    <option value="call_back" @if($result->decomposition == "call_back") selected @endif>Call Back</option> 
    <option value="pending_docs" @if($result->decomposition == "pending_docs") selected @endif>Pending Docs</option> 
    <option value="Others" @if($result->decomposition == "Others") selected @endif>Others</option>  
</select>

</div><div class="data" style="position: absolute;/* right: 10px; */background: #454545;display: inline-block;height: 35px;width: 40px;cursor: pointer;border-radius: 3px;">
<img src="{{asset('images/Notes Icon.png')}}" style="width: 100%;/* margin-top:25px; *//* margin-bottom:25px; */height: 100%;" alt="" id="notes" data-val="{{$result->id}}">
</div>
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

