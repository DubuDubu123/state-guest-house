@extends('admin.layouts.app')
@section('title', 'Main page')
@section('extra-css')
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{!! asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.css') !!}">
@endsection

@section('content')
<!-- Start Page content -->
<div class="content">
<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
    <div class="box">

        <div class="box-header with-border">
            <a href="{{ url('vehicle_fare') }}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>

        <div class="col-sm-12">
                <form method="post" action="{{ url('vehicle_fare/update', $zone_price->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="admin_id">@lang('view_pages.select_zone')
                                <span class="text-danger">*</span>
                                </label>
                                    <select name="zone" id="zone" class="form-control" disabled required>
                                        <option value="{{ $zone_price->zoneType->zone->id }}" disabledi>{{ $zone_price->zoneType->zone->name }}</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type">@lang('view_pages.select_type')
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="type" id="type" class="form-control" disabled required>
                                        <option value="{{ $zone_price->zoneType->vehicleType->id }}">{{ $zone_price->zoneType->vehicleType->name }}</option>
                                    </select>
                                </div>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                        </div>
                    </div>
                <div class="row">
                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="">@lang('view_pages.order_by') <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" id="order_by" name="order_by" value="{{ old('order_by', $zone_price->zoneType->order_by) }}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.order_by')">
                           <span class="text-danger">{{ $errors->first('order_by') }}</span>
                       </div>
                   </div>
                    <div class="col-6">
                        <div class="form-group">
                        <label for="payment_type">@lang('view_pages.payment_type')
                            <span class="text-danger">*</span>
                        </label>
                 @php
                   $card = $cash = $upi = $wallet = '';
                 @endphp
                    @if (old('payment_type'))
                        @foreach (old('payment_type') as $item)
                            @if ($item == 'card')
                                @php
                                    $card = 'selected';
                                @endphp
                            @elseif($item == 'cash')
                                @php
                                    $cash = 'selected';
                                @endphp
                            @elseif($item == 'upi')
                                @php
                                    $upi = 'selected';
                                @endphp
                            @elseif($item == 'wallet')
                                @php
                                    $wallet = 'selected';
                                @endphp
                            @endif
                        @endforeach
                    @else
                        @php
                            $paymentType = explode(',',$zone_price->zoneType->payment_type);
                        @endphp
                        @foreach ($paymentType as $val)
                            @if ($val == 'card')
                                @php
                                    $card = 'selected';
                                @endphp
                            @elseif($val == 'cash')
                                @php
                                    $cash = 'selected';
                                @endphp
                            @elseif($val == 'upi')
                                @php
                                    $upi = 'selected';
                                @endphp
                            @elseif($val == 'wallet')
                                @php
                                    $wallet = 'selected';
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    <select name="payment_type[]" id="payment_type" class="form-control select2" multiple="multiple" data-placeholder="@lang('view_pages.select') @lang('view_pages.payment_type')" required>
                        <option value="cash" {{ $cash }}>@lang('view_pages.cash')</option>
                        <!-- <option value="card" {{ $card }}>@lang('view_pages.card')</option> -->
                        <option value="upi" {{ $upi }}>@lang('view_pages.upi')</option>
                        <option value="wallet" {{ $wallet }}>@lang('view_pages.wallet')</option>
                         </select>
                     </div>
                     <span class="text-danger">{{ $errors->first('payment_type') }}</span>
                </div>
        </div>
                    @if ($zone_price->price_type == 1)
                        <div class="row">
                            <div class="col-12 ">
                                <h2 class="fw-medium fs-base me-auto">
                                    Ride Now
                                </h2>
                            </div>
                            </div>
                            <div class="row ml-2 mr-2">
                            <div class="col-12 col-lg-6 mt-4">
                                <label for="price_per_time" class="form-label">@lang('view_pages.price_per_time')(minutes)</label>
                                <input id="ride_now_price_per_time" name="ride_now_price_per_time" value="{{ old('ride_now_price_per_time', $zone_price->price_per_time) }}" type="text" class="form-control w-full" placeholder="@lang('view_pages.enter') @lang('view_pages.price_per_time')" required>
                                <span class="text-danger">{{ $errors->first('ride_now_price_per_time') }}</span>
                            </div>

                            <div class="col-12 col-lg-6 mt-4">
                                <label for="cancellation_fee" class="form-label">@lang('view_pages.cancellation_fee')</label>
                                <input id="ride_now_cancellation_fee" name="ride_now_cancellation_fee" value="{{ old('ride_now_cancellation_fee', $zone_price->cancellation_fee) }}" type="text" class="form-control w-full" placeholder="@lang('view_pages.enter') @lang('view_pages.cancellation_fee')" required>
                                <span class="text-danger">{{ $errors->first('ride_now_cancellation_fee') }}</span>
                        </div>
                         <div class="col-12 col-lg-6 mt-4">
                            <div class="form-group">
                                <label for="waiting_charge">@lang('view_pages.waiting_charge')<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="ride_now_waiting_charge" name="ride_now_waiting_charge" value="{{old('ride_now_waiting_charge',$zone_price->waiting_charge)}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.waiting_charge')">
                            <span class="text-danger">{{ $errors->first('ride_now_waiting_charge') }}</span>

                            </div>
                        </div>

                    <div class="col-12 col-lg-6 mt-4">
                        <div class="form-group">
                        <label for="free_waiting_time_in_mins_before_trip_start">@lang('view_pages.free_waiting_time_in_mins_before_trip_start')<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="ride_now_free_waiting_time_in_mins_before_trip_start" name="ride_now_free_waiting_time_in_mins_before_trip_start" value="{{old('ride_now_free_waiting_time_in_mins_before_trip_start',$zone_price->free_waiting_time_in_mins_before_trip_start)}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.free_waiting_time_in_mins_before_trip_start')">
                        <span class="text-danger">{{ $errors->first('ride_now_free_waiting_time_in_mins_before_trip_start') }}</span>

                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-4">
                        <div class="form-group">
                        <label for="free_waiting_time_in_mins_after_trip_start">@lang('view_pages.free_waiting_time_in_mins_after_trip_start')<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="ride_now_free_waiting_time_in_mins_after_trip_start" name="ride_now_free_waiting_time_in_mins_after_trip_start" value="{{old('ride_now_free_waiting_time_in_mins_after_trip_start',$zone_price->free_waiting_time_in_mins_after_trip_start)}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.free_waiting_time_in_mins_after_trip_start')">
                        <span class="text-danger">{{ $errors->first('ride_now_free_waiting_time_in_mins_after_trip_start') }}</span>

                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mt-4">
                        <div class="form-group">
                        <label for="flat_discount">@lang('view_pages.flat_discount')<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="ride_now_flat_discount" name="ride_now_flat_discount" value="{{old('ride_now_flat_discount',$zone_price->flat_discount)}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.flat_discount')">
                        <span class="text-danger">{{ $errors->first('ride_now_flat_discount') }}</span>

                        </div>
                    </div>                    
            </div>
@endif
            
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm pull-right m-5">{{ __('view_pages.save') }}</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<script>
    $('.select2').select2({
        placeholder : "Select ...",
    });
$('.timepicker').timepicker({
    showInputs: false,
    minuteStep: 1, // Set the time interval to 1 minute
    showMeridian: false, // Disable AM/PM selection
});



    $(document).on('change', '#zone', function() {
        let zone = $(this).val();

        $.ajax({
            url: "{{ url('vehicle_fare/fetch/vehicles') }}",
            type: 'GET',
            data: {
                '_zone': zone,
            },
            success: function(result) {
                var vehicles = result.data;
                var option = ''
                vehicles.forEach(vehicle => {
                    option += `<option value="${vehicle.id}">${vehicle.name}</option>`;
                });

                $('#type').html(option)
            }
        });
    });




</script>



@endsection