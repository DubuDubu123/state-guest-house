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

<form  method="post" class="form-horizontal" action="{{url('vehicle_fare/store')}}" enctype="multipart/form-data">
{{csrf_field()}}

<div class="row">
    <div class="col-6">
        <div class="form-group">
        <label for="admin_id">@lang('view_pages.select_zone')
            <span class="text-danger">*</span>
        </label>
        <select name="zone" id="zone" class="form-control" required>
            <option value="" selected disabled>@lang('view_pages.select_zone')</option>
            @foreach($zones as $key=>$zone)
            <option value="{{$zone->id}}" {{ old('zone') == $zone->id ? 'selected' : '' }}>{{$zone->name}}</option>
            @endforeach
        </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type">@lang('view_pages.select_type')
                <span class="text-danger">*</span>
            </label>
            <select name="type" id="type" class="form-control" required>
                <option value="" >@lang('view_pages.select_type')</option>
            </select>
            </div>
        </div>
    </div>
<div class="row">
<div class="col-sm-6">
           <div class="form-group">
               <label for="">@lang('view_pages.order_by') <span class="text-danger">*</span></label>
                <input class="form-control" type="number" id="order_by" name="order_by" value="{{old('order_by')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.order_by')">
               <span class="text-danger">{{ $errors->first('order_by') }}</span>
           </div>
    </div>

<div class="col-sm-6">
<div class="form-group">
<label for="payment_type">@lang('view_pages.payment_type')
    <span class="text-danger">*</span>
</label>
@php
    $card = '';
    $cash = '';
    $wallet = '';
    $upi = '';

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
@endif
<select name="payment_type[]" id="payment_type" class="form-control select2" multiple="multiple" data-placeholder="@lang('view_pages.select') @lang('view_pages.payment_type')" required>
    <option value="cash" {{ $cash }}>@lang('view_pages.cash')</option>
    <option value="wallet" {{ $wallet }}>@lang('view_pages.wallet')</option>
    <option value="upi" {{ $upi }}>@lang('view_pages.upi')</option>
    <!-- <option value="card" {{ $card }}>@lang('view_pages.card')</option> -->

</select>
</div>
</div>

</div>
    {{-- Ride now price --}}
<div class="row">
<div class="col-12">
    <div class="box box-solid box-info">
        <div class="box-header with-border">
        <h4 class="box-title">@lang('view_pages.ride_now')</h4>
        </div>

        <div class="box-body">
                <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                           <label for="price_per_distance">@lang('view_pages.price_per_distance')&nbsp (@lang('view_pages.kilometer')) <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="ride_now_price_per_distance" name="ride_now_price_per_distance" value="{{old('ride_now_price_per_distance')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.distance_price')">
                            <span class="text-danger">{{ $errors->first('ride_now_price_per_distance') }}</span>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <label for="price_per_time">@lang('view_pages.price_per_time')(minutes)<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="ride_now_price_per_time" name="ride_now_price_per_time" value="{{old('ride_now_price_per_time')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.price_per_time')">
                        <span class="text-danger">{{ $errors->first('ride_now_price_per_time') }}</span>

                        </div>
                    </div>
                </div>

                <div class="row">                    
                     <div class="col-sm-6">
                          <div class="form-group">
                            <label for="cancellation_fee">@lang('view_pages.cancellation_fee')<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="ride_now_cancellation_fee" name="ride_now_cancellation_fee" value="{{old('ride_now_cancellation_fee')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.cancellation_fee')">
                            <span class="text-danger">{{ $errors->first('ride_now_cancellation_fee') }}</span>
                        </div>
                    </div>                    
                <div class="col-sm-6">
                    <div class="form-group">
                    <label for="waiting_charge">@lang('view_pages.waiting_charge')<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="ride_now_waiting_charge" name="ride_now_waiting_charge" value="{{old('ride_now_waiting_charge')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.waiting_charge')">
                    <span class="text-danger">{{ $errors->first('ride_now_waiting_charge') }}</span>

                    </div>
                </div>
                </div>

            <div class="row">
                <div class="col-sm-6">
                <div class="form-group">
                <label for="free_waiting_time_in_mins_before_trip_start">@lang('view_pages.free_waiting_time_in_mins_before_trip_start')<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="ride_now_free_waiting_time_in_mins_before_trip_start" name="ride_now_free_waiting_time_in_mins_before_trip_start" value="{{old('ride_now_free_waiting_time_in_mins_before_trip_start')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.free_waiting_time_in_mins_before_trip_start')">
                <span class="text-danger">{{ $errors->first('ride_now_free_waiting_time_in_mins_before_trip_start') }}</span>

                </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                <label for="free_waiting_time_in_mins_after_trip_start">@lang('view_pages.free_waiting_time_in_mins_after_trip_start')<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="ride_now_free_waiting_time_in_mins_after_trip_start" name="ride_now_free_waiting_time_in_mins_after_trip_start" value="{{old('ride_now_free_waiting_time_in_mins_after_trip_start')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.free_waiting_time_in_mins_after_trip_start')">
                <span class="text-danger">{{ $errors->first('ride_now_free_waiting_time_in_mins_after_trip_start') }}</span>

                </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                <label for="flat_discount">@lang('view_pages.flat_discount')<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="ride_now_flat_discount" name="ride_now_flat_discount" value="{{old('ride_now_flat_discount')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.flat_discount')">
                <span class="text-danger">{{ $errors->first('ride_now_flat_discount') }}</span>

                </div>
                </div>                
        </div>
    </div>
</div>
</div>
</div>

  </div>
</div>
<div class="form-group">
    <div class="col-12">
        <button class="btn btn-primary btn-sm pull-right mb-4" id="saveSetprice" type="submit">
            @lang('view_pages.save')
        </button>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- content -->
<!-- jQuery 3 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
$('.select2').select2({
    placeholder : "Select ...",
});
$('.timepicker').timepicker({
    showInputs: false,
    minuteStep: 1, // Set the time interval to 1 minute
    showMeridian: false, // Disable AM/PM
    defaultTime: false, // Do not set a default time
}).on('changeTime.timepicker', function(e) {
    var selectedTime = e.time.value;
    var convertedTime = moment(selectedTime, 'hh:mm A').format('HH:mm');
    $(this).val(convertedTime);
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

