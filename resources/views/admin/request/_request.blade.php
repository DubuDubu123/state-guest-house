<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.request_id')</th>
            <th> @lang('view_pages.date')</th>
            <th> @lang('view_pages.user_name')</th>
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.trip_status')</th>
            <th> @lang('view_pages.is_paid')</th>
            <th> @lang('view_pages.payment_option')</th>
            <th> @lang('view_pages.action')</th>
        </tr>
    </thead>
    <tbody>


        @php $i= $results->firstItem(); @endphp

        @forelse($results as $key => $result)

        <tr>
            <td>{{ $i++ }} </td>
            <td>{{$result->request_number}}</td>
            <td>{{ $result->converted_trip_start_time ?? $result->created_at }}</td>
            @if($result->user_id == null)
            <td>{{$result->adHocuserDetail ? $result->adHocuserDetail->name : '-'}}</td>
            @else
            <td>{{$result->userDetail ? $result->userDetail->name : '-'}}</td>
            @endif
            <td>{{$result->driverDetail ? $result->driverDetail->name : '-'}}</td>

            @if($result->is_cancelled == 1)
            <td><span class="label label-danger">@lang('view_pages.cancelled')</span></td>
            @elseif($result->is_completed == 1)
            <td><span class="label label-success">@lang('view_pages.completed')</span></td>
            @elseif($result->is_trip_start == 0 && $result->is_cancelled == 0)
            <td><span class="label label-warning">@lang('view_pages.not_started')</span></td>
            @else
            <td>-</td>
            @endif

            @if ($result->is_paid)
            <td><span class="label label-success">@lang('view_pages.paid')</span></td>
            @else
            <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
            @endif

            @if ($result->payment_opt == 0)
            <td><span class="label label-danger">@lang('view_pages.card')</span></td>
            @elseif($result->payment_opt == 1)
            <td><span class="label label-primary">@lang('view_pages.cash')</span></td>
            @elseif($result->payment_opt == 2)
            <td><span class="label label-warning">@lang('view_pages.wallet')</span></td>
            @elseif($result->payment_opt == 4)
            <td><span class="label label-warning">@lang('view_pages.upi')</span></td>            
            @else
            <td><span class="label label-info">@lang('view_pages.cash_wallet')</span></td>
            @endif

            @if ($result->is_completed)
            <td>
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> @lang('view_pages.action')
                    
                    </button>
                    <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{url('requests',$result->id)}}">
                            <i class="fa fa-eye"></i>@lang('view_pages.view')</a>
                            <a class="dropdown-item" href="{{url('requests/track_reqest',$result->id)}}">
                            <i class="fa fa-eye"></i>@lang('view_pages.track_reqest')</a>
                            <a class="dropdown-item" target="_blank" href="{{url('requests/delete',$result->id)}}">
                            <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a>
                            
                    </div>
                </div>
            </td>
            @else
                 @if (($result->is_completed == 0) && ($result->is_cancelled == 0))
            <td>
                <!-- <div class="dropdown"> -->
                <a class="text-white" href="{{url('requests/trip_view',$result->id) }}">
                <button type="button" class="btn btn-info btn-sm">
                   @lang('view_pages.view')
                </button></a>
            </td>
            @else
               <td>
               <a class="text-white" href="{{url('requests/cancelled',$result->id) }}">
               <button type="button" class="btn btn-info btn-sm">
                 @lang('view_pages.view')
                  </button></a>
               </td>
                  @endif
            @endif
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