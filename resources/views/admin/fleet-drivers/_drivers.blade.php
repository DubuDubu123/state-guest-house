<div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover">
<thead>
<tr>


<th> @lang('view_pages.s_no')
<span style="float: right;">

</span>
</th>

<th> @lang('view_pages.user_name')
<span style="float: right;">
</span>
</th>

<th> @lang('view_pages.name')
<span style="float: right;">
</span>
</th>
<th> @lang('view_pages.area')
<span style="float: right;">
</span>
</th>
<th> @lang('view_pages.email')
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
</th>
<th> @lang('view_pages.created_by')
<span style="float: right;">
</span>
</th> 
<th> @lang('view_pages.updated_by')
<span style="float: right;">
</span>
</th> 
<th> @lang('view_pages.approve_status')<span style="float: right;"></span></th>
<th> @lang('view_pages.declined_reason')<span style="float: right;"></span></th>
<th> @lang('view_pages.rating')
<span style="float: right;">
</span>
</th>
<!-- <th> @lang('view_pages.online_status')<span style="float: right;"></span></th> -->
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
<td>
 {{$result->name}} 
</td>
@if($result->serviceLocation)
<td>{{$result->serviceLocation->name}}</td>
@else
<td>--</td>
@endif
<td>{{$result->email}}</td>
@if(env('APP_FOR')=='demo')
<td>**********</td>
@else
<td>{{$result->mobile}}</td>
@endif
<td>{{$result->vehicleType?$result->vehicleType->name:'-'}}</td>
<td>{{$result->createdUser->name ?? "-"}}</td>
<td>{{$result->updatedUser->name ?? "-"}}</td> 
@if($result->approve)
<td><button class="btn btn-success btn-sm">{{ trans('view_pages.approved') }}</button></td>
@else
<td><button class="btn btn-danger btn-sm">{{ trans('view_pages.disapproved') }}</button></td>
@endif
@if($result->reason)
<td>{{$result->reason}}</td>
@else
<td>--</td>
@endif
<td>
  @php $rating = $result->rating($result->user_id); @endphp  

            @foreach(range(1,5) as $i)
                <span class="fa-stack" style="width:1em">
                   
                    @if($rating > 0)
                        @if($rating > 0.5)
                            <i class="fa fa-star checked"></i>
                        @else
                            <i class="fa fa-star-half-o"></i>
                        @endif
                    @else
                     <i class="fa fa-star-o "></i>
                    @endif
                    @php $rating--; @endphp
                </span>
            @endforeach 

<td>

<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
</button>
@if($result->approve == 1)
    <div class="dropdown-menu w-48 ">
         @if(auth()->user()->can('edit-fleet-drivers'))         

        <a class="dropdown-item" href="{{url('fleet-drivers',$result->id)}}">
            <i class="fa fa-pencil"></i>@lang('view_pages.edit')
        </a>
        @endif
        @if(auth()->user()->can('toggle-fleet-drivers'))         
        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('fleet-drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>0])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.disapproved')</a>

        <a class="dropdown-item" href="{{url('fleet-drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>1])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.approved')</a>
        @endif
        @if(auth()->user()->can('delete-fleet-drivers'))         
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('fleet-drivers/delete',$result->id)}}">
        <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a> 
        @endif

<!--        @if(auth()->user()->can('view-fleet-driver-profile'))         
        <a class="dropdown-item" href="{{url('driver_profile_dashboard_view',$result->id)}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.view_profile')</a>
      @endif -->
    </div>
@else
            <div class="dropdown-menu">
     @if(auth()->user()->can('edit-fleet-drivers'))         

        <a class="dropdown-item" href="{{url('fleet-drivers',$result->id)}}">
            <i class="fa fa-pencil"></i>@lang('view_pages.edit')
        </a>
     @endif
    @if(auth()->user()->can('toggle-fleet-drivers'))         

        <a class="dropdown-item decline" data-reason="{{ $result->reason }}" data-id="{{ $result->id }}" href="{{url('fleet-drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>0])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.disapproved')</a>

        <a class="dropdown-item" href="{{url('fleet-drivers/toggle_approve',['driver'=>$result->id,'approval_status'=>1])}}">
        <i class="fa fa-dot-circle-o"></i>@lang('view_pages.approved')</a>
     @endif
    @if(auth()->user()->can('delete-fleet-drivers'))         
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('fleet-drivers/delete',$result->id)}}">
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