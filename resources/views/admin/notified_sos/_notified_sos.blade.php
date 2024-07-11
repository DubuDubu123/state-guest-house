<table class="table table-hover">
    <thead>
    <tr>


    <th> @lang('view_pages.s_no')
    <span style="float: right;">

    </span>
    </th>

    <th> @lang('view_pages.sos_name')
    <span style="float: right;">
    </span>
    </th>
    <th> @lang('view_pages.sos_type')
    <span style="float: right;">
    </span>
    </th>
    <th> @lang('view_pages.mobile')
    <span style="float: right;">
    </span>
    </th> 
    <th> @lang('view_pages.notified_date')
    <span style="float: right;">
    </span>
    </th> 
    <th> @lang('view_pages.status')
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


    @php  $i= $results->firstItem(); @endphp

    @forelse($results as $key => $result)

    <tr>
    <td>{{ $i++ }} </td>
    <td>{{$result->request_number}}</td>
    <td>{{$result->sos_type}}</td>
    @if($result->sos_type == "user")
    <td>{{$result->userDetail->mobile}}</td>
    @elseif($result->sos_type == "driver")
    <td>{{$result->driverDetail->mobile}}</td>
    @else
    <td>-</td>    
    @endif    
   
    <td>{{ $result->converted_created_at}} </td>
   
    @if($result->is_verified)
    <td><span class="label label-success">Taken</span></td>
    @else
    <td><span class="label label-danger">Not Taken</span></td>
    @endif
    <td>

    <div class="dropdown">
    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
    </button>
 <div class="dropdown-menu">
        @if(auth()->user()->can('toggle-sos'))         
            @if(!$result->is_verified)
            <a class="dropdown-item" href="{{url('notified_sos/toggle_status',$result->id)}}">
            <i class="fa fa-dot-circle-o"></i>@lang('view_pages.taken')</a>
            @endif
        @endif
        </div>  
    </div>

    </td>
    </tr>
  @empty
        <tr>
            <td colspan="11">
                <p id="no_data" class="lead no-data text-center">
                    <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </p>
            </td>
        </tr>
    @endforelse

    </tbody>
    </table>
    <ul class="pagination pagination-sm pull-right">
        <li>
            <a href="#">{{$results->links()}}</a>
        </li>
    </ul>
