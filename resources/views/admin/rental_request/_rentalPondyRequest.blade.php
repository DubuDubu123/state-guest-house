<div class="box-body no-padding">
    <div class="table-responsive">
      <table class="table table-hover">
<thead>
<tr>

    <th> @lang('view_pages.s_no')</th>
    <th> @lang('view_pages.city')</th>
    <th> @lang('view_pages.user_name')</th>
    <th> @lang('view_pages.mobile')</th>
    <th> @lang('view_pages.from_date')</th>
    <th> @lang('view_pages.to_date')</th>
    <th> @lang('view_pages.vehicle')</th>
    <th> @lang('view_pages.no_of_vehicles')</th>
    <th> @lang('view_pages.days')</th>
    <th> @lang('view_pages.price')</th>    
    <th> @lang('view_pages.status')</th>
    <th> @lang('view_pages.action')</th>
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
    <td>{{ $i++ }}</td>
    @if($result->city == "goa")
    <td>{{ "Goa" }}</td>
    @else
    <td>{{ "Pondicherry" }}</td>
    @endif
    <td>{{ $result->userDetail ? $result->userDetail->name : '-' }}</td>
    <td>{{ $result->userDetail ? $result->userDetail->mobile : '-' }}</td>
    <td>{{ $result->getConvertedFromAttribute() ?? '-' }}</td>
    <td>{{ $result->getConvertedToAttribute() ?? '-' }}</td>
    <td>{{ $result->vehicle ?? "-" }}</td>


<!--     @if($result->rentalCategory->name == "maruthi_800")
    <td>{{ "Maruthi 800" }}</td>
    @elseif($result->rentalCategory->name == "scooter")
    <td>{{ "Scooter" }}</td>
    @elseif($result->rentalCategory->name == "bike")
    <td>{{ "Bike" }}</td>
    @elseif($result->rentalCategory->name == "vintage_car")
    <td>{{ "Vintage Car" }}</td>
    @else
    <td>{{ "Royal Enfield" }}</td>
    @endif
 -->

    <td>{{ $result->no_of_vehicles ?? '-' }}</td>


    @if ($result->from && $result->to)
        @php
            $fromDate = \Carbon\Carbon::parse($result->from);
            $toDate = \Carbon\Carbon::parse($result->to);
            $numberOfDays = $fromDate->diffInDays($toDate);
        @endphp
        <td>{{ $numberOfDays }}</td>
    @else
        <td>-</td>
    @endif

        <td>{{ $result->amount ?? '-'}}</td>
    

    @if($result->is_cancelled == true)
        <td><button class="btn btn-danger btn-sm">{{ trans('view_pages.cancelled') }}</button></td>
    @elseif($result->is_completed == true)
        <td><button class="btn btn-success btn-sm">{{ trans('view_pages.completed') }}</button></td>
    @elseif($result->is_confirmed == true)
        <td><button class="btn btn-primary btn-sm">{{ trans('view_pages.confirmed') }}</button></td>
    @else
        <td><button class="btn btn-warning btn-sm">{{ trans('view_pages.booked') }}</button></td>
    @endif
    <td class="overflow-scroll">
        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')</button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('rental_requests/confirmation_status', ['rental_request' => $result->id, 'status' => 'confirm']) }}">
                <i class="fa fa-dot-circle-o"></i>@lang('view_pages.confirm')
            </a>
            <a class="dropdown-item" href="{{ url('rental_requests/confirmation_status', ['rental_request' => $result->id, 'status' => 'completed']) }}">
                <i class="fa fa-dot-circle-o"></i>@lang('view_pages.completed')
            </a>
            <a class="dropdown-item" href="{{ url('rental_requests/confirmation_status', ['rental_request' => $result->id, 'status' => 'cancel']) }}">
                <i class="fa fa-dot-circle-o"></i>@lang('view_pages.cancel')
            </a>
        </div>
    </td>
</tr>
@endforeach
@endif
</tbody>
</table>
        <div class="text-right">
            <span style="float:right">
                {{ $results->links() }}
            </span>
        </div>

    </div>
</div>
