                            <div class="col-12">
                                <div class="box">           
                                   <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th> @lang('view_pages.s_no')</th>
                                            <th> @lang('view_pages.name')</th>
                                            <th> @lang('view_pages.mobile')</th>
                                            <th> @lang('view_pages.type')</th>
                                        @if(auth()->user()->can('view-driver-rating'))         
                                            <th> @lang('view_pages.rating')</th>
                                        @endif                                            <th> @lang('view_pages.action')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php  $i= $results->firstItem(); @endphp --}}

                                        @forelse($results as $key => $result)

                                        <tr>
                                            <td>{{ $key+1}} </td>
                                            <td>{{$result->name}}</td>
                                            @if(env('APP_FOR')=='demo')
                                            <td>**********</td>
                                            @else
                                            <td>{{$result->mobile}}</td>
                                            @endif                                           
                                            <td>{{$result->vehicleType->name }}</td>
                                            <td>
                                                @php
                                                    $ratingValue = $result->driverRating()->where('user_rating',1)->avg('rating');
                                                    $roundedRating = round($ratingValue,2); // Round the rating to the nearest whole number
                                                @endphp

                                                <span> {{ $roundedRating }}</span>

                                            </td>                                        
                                        <td> <a href="{{ url('driver-ratings/view',$result->id) }}" class="btn btn-primary btn-sm">@lang('view_pages.view')</a></td>

                                        
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
             <div class="text-right">
                <span  style="float:right">
                {{$results->links()}}
                </span>
            </div>
        </div>
    </div>