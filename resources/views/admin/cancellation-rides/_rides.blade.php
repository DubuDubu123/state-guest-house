<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.request_id')</th>
            <th> @lang('view_pages.date')</th>
            <th> @lang('view_pages.user_name')</th>
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.cancelled_by')</th>
            <th> @lang('view_pages.cancellation_reason')</th>
            <th> @lang('view_pages.cancellation_fee')</th>
            <th> @lang('view_pages.paid')</th>
            <th> @lang('view_pages.action')</th>

            
        </tr>
    </thead>

<tbody>
    @php  $i= $results->firstItem(); @endphp

    @forelse($results as $key => $result)
        <tr>
            <td>{{ $i++ }} </td>
            <td>{{$result->request_number}}</td>
            <td>{{$result->getConvertedCancelledAtAttribute()}}</td>
            <!-- <td>
                <span>{{$result->userDetail->name ?? '-' }}</span>
            </td> -->
            @if($result->user_id == null)
            <td>{{$result->adHocuserDetail ? $result->adHocuserDetail->name : '-'}}</td>
            @else
            <td>{{$result->userDetail ? $result->userDetail->name : '-'}}</td>
            @endif   

            <td>
                <span>{{ $result->driverDetail->name ?? '-' }}</span>
            </td>
             <td>
                @if ($result->cancel_method == 0)
                   <span>Automatic</span>
                @else
                   @if ($result->cancel_method == 1)
                        <span>User</span>
                   @else
                        <span>Driver</span>
                   @endif
                @endif
            </td>

             <td>
               {{$result->reason ?? $result->custom_reason }}
            </td> 

            @if ($result->cancel_method == 1)
                <td class="text-center">
                    @if($result->userCancellationFee)

                        <span class="label label-warning">{{$result->requested_currency_symbol ?? $result->requested_currency_code }} {{ $result->userCancellationFee->amount ?? 0 }}</span>
                    @else
                        <span class="label label-warning">{{$result->requested_currency_symbol ?? $result->requested_currency_code }} 0</span>
                    @endif
                </td>
            @elseif ($result->cancel_method == 2)
                <td class="text-center">
                    @if($result->driverCancellationFee)
                        <span class="label label-warning">{{$result->requested_currency_symbol ?? $result->requested_currency_code }} {{ $result->driverCancellationFee->amount ?? 0 }}</span>
                    @else
                        <span class="label label-warning">{{$result->requested_currency_symbol ?? $result->requested_currency_code }} 0</span>
                    @endif
                </td>
            @else
                <td>{{"-"}}</td>
            @endif
     <!-- payment status  -->  
            @if ($result->cancel_method == 1)
                    @if($result->userCancellationFee)
                      @if($result->userCancellationFee->is_paid==true)
                         <td><span class="label label-success">@lang('view_pages.paid')</span></td>
                       @else
                          <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
                       @endif
                    @else
                          <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
                    @endif
            @elseif ($result->cancel_method == 2)
                    @if($result->driverCancellationFee)
                      @if($result->driverCancellationFee->is_paid==true)
                         <td><span class="label label-success">@lang('view_pages.paid')</span></td>
                       @else
                          <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
                       @endif
                    @else
                          <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
                    @endif
            @else
                <td>{{"-"}}</td>
            @endif
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
                    </button>
                    <div class="dropdown-menu">
                             <a class="dropdown-item" href="{{url('requests/track_reqest',$result->id)}}">
                            <i class="fa fa-eye"></i>@lang('view_pages.track_reqest')</a>
                            <a class="dropdown-item" href="{{url('requests/cancelled',$result->id) }}">
                            <i class="fa fa-eye"></i>@lang('view_pages.view')</a>
                    </div>
                </div>
            </td>
            
<!--             <td> <a class="text-white" href="{{url('requests/cancelled',$result->id) }}">
               <button type="button" class="btn btn-info btn-sm">
                 @lang('view_pages.view')
                  </button></a>
            </td> -->
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
