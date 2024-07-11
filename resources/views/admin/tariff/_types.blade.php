<div class="box-body no-padding">
    <div class="table-responsive">
      <table class="table table-hover">
<thead>
<tr>


<th> @lang('view_pages.s_no')
<span style="float: right;">

</span>
</th>

<th> @lang('view_pages.vehicle_type')
<span style="float: right;">
</span>
</th>
<!-- <th> @lang('view_pages.tansport_type')
<span style="float: right;">
</span>
</th> -->
 <th> @lang('view_pages.icon_types_for')
    <span style="float: right;">
    </span>
</th>
<th> @lang('view_pages.icon')
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

<th> @lang('view_pages.status')
<span style="float: right;">
</span>
</th>
@if(!auth()->user()->company_key)
<th> @lang('view_pages.action')
<span style="float: right;">
</span>
</th>
@endif
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
<td>{{ $i++ }} </td>
<td> {{$result->name}}</td>

<td> @if($result->icon_types_for == 'taxi' )
                                {{ "Taxi" }}
                                @elseif($result->icon_types_for == 'truck' )
                                    {{ "Truck" }}
                                @elseif($result->icon_types_for == 'auto' )
                                    {{ "Auto" }}
                                @else
                                {{ "Motor Bike" }}
                            @endif</td>


<td><img class="img-circle" src="{{asset($result->icon)}}" alt=""></td>
<td>{{$result->createdUser->name ?? "-"}}</td>
<td>{{$result->updatedUser->name ?? "-"}}</td>   
@if($result->active)
<td><button class="btn btn-success btn-sm">@lang('view_pages.active')</button></td>
@else
<td><button class="btn btn-danger btn-sm">@lang('view_pages.inactive')</button></td>
@endif
@if(!auth()->user()->company_key)
<td>

<button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
</button>

    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
    <!-- @if(auth()->user()->can('edit-vehicle-types'))          -->
        <a class="dropdown-item" href="{{url('types/edit',$result->id)}}"><i class="fa fa-pencil"></i>@lang('view_pages.edit')</a>
<!--     @endif
     @if(auth()->user()->can('toggle-vehicle-types'))     -->     

        @if($result->active)
            <a class="dropdown-item" href="{{url('types/toggle_status',$result->id)}}">
            <i class="fa fa-dot-circle-o"></i>@lang('view_pages.inactive')</a>
        @else
            <a class="dropdown-item" href="{{url('types/toggle_status',$result->id)}}">
            <i class="fa fa-dot-circle-o"></i>@lang('view_pages.active')</a>
        @endif
    <!-- @endif -->
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('types/delete',$result->id)}}"><i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a>
    </div>

</td>
@endif
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
