<div class="container">
    @if($results->isEmpty())
        <p id="no_data" class="lead no-data text-center">
            <img src="{{ asset('assets/img/dark-data.svg') }}" style="width: 150px; margin-top: 25px; margin-bottom: 25px;" alt="">
            <h4 class="text-center" style="color: #333; font-size: 25px;">@lang('view_pages.no_data_found')</h4>
        </p>
    @else
        <ul class="nav nav-tabs" id="cityTabs" role="tablist">
            @foreach($results->groupBy('rentalCategory.city') as $city => $cityResults)
                <li class="nav-item">
                   <a class="nav-link @if ($loop->first) active @endif" id="{{ Str::slug($city) }}-tab" data-toggle="tab" href="#{{ Str::slug($city) }}" role="tab" aria-controls="{{ Str::slug($city) }}" aria-selected="{{ $loop->first }}" data-city="{{ $city }}">{{ $city }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="cityTabsContent">
            @foreach($results->groupBy('rentalCategory.city') as $city => $cityResults)
                <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ Str::slug($city) }}" role="tabpanel" aria-labelledby="{{ Str::slug($city) }}-tab">
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
                                <th> @lang('view_pages.status')</th>
                                <th> @lang('view_pages.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @forelse($cityResults as $result)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $result->city ? $result->city : '-' }}</td>
                                    <td>{{ $result->userDetail ? $result->userDetail->name : '-' }}</td>
                                    <td>{{ $result->userDetail ? $result->userDetail->mobile : '-' }}</td>
                                    <td>{{ $result->getConvertedFromAttribute() ?? '-' }}</td>
                                    <td>{{ $result->getConvertedToAttribute() ?? '-' }}</td>
                                  
                                    @if($result->rentalCategory->name == "maruthi_800")
                                    <td>{{ "Maruthi 800" }}</td>
                                    @elseif($result->rentalCategory->name == "scooter")
                                    <td>{{ "Scooter" }}</td>
                                    @elseif($result->rentalCategory->name == "bike")
                                    <td>{{ "Bike" }}</td>
                                    @elseif($result->rentalCategory->name == "vintage_car")
                                    <td>{{ "Vintage Cars" }}</td>
                                    @else
                                    <td>{{ "Royal Enfield" }}</td>
                                    @endif


                                    <td>{{ $result->no_of_vehicles ?? '-' }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <p class="text-center">@lang('view_pages.no_data_found')</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="pagination">
    {{ $results->links() }}
</div>
