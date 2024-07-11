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
        <form method="post" action="{{ url('vehicle_fare/price_range/store', $zone_type->id) }}">
            @csrf
            @php
             $WeekDays = [
                    'Sunday' => 'Sun',
                    'Monday' => 'Mon',
                    'Tuesday' => 'Tue',
                    'Wednesday' => 'Wed',
                    'Thursday' => 'Thu',
                    'Friday' => 'Fri',
                    'Saturday' => 'Sat',
                ];

            $daysOfWeek = array_intersect_key($WeekDays, [$day => '']);

            $base_price = $base_price->sortBy('base_km_from');

            $distance_price = $distance_price->sortBy('from');

            @endphp
 
{{-- Base Price with Range --}}
<div class="row">
    <div class="col-12">
        <div class="box box-solid box-info">
        <div class="box-header with-border">
        <h4 class="box-title">@lang('view_pages.base_price_range')</h4>
        </div>

        <div class="box-body">
            <table class="table baseTable" id="base_table">
                <thead>
                    <th style="width:100px;"> @lang('view_pages.from_in_km') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.to_in_km') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.day') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.from_time') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.to_time') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.fixed_fare') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.surge_price') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.action')</th>
                </thead>
         @if (!$base_price->isEmpty())

        @foreach ($base_price as $k => $basePriceRange)
                <tbody class="base_append_row">
                            <tr>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="base_km_from[]" value="{{ old('base_km_from.'.$k,$basePriceRange->base_km_from) }}" class="base_km_from form-control ">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_km_from') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="base_km_to[]" value="{{ old('base_km_to.'.$k, $basePriceRange->base_km_to) }}" class="base_km_to form-control ">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_km_to') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="base_price_day[]" class="base_price_day form-control">
                                                        @foreach ($daysOfWeek as $day => $label)
                                                        <option value="{{ $day }}" @if(old('base_price_day.'.$k, $basePriceRange->base_price_day) == $day) selected @endif>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_price_day') }}</span>
                                        </div>
                                    </div>
                                </td>

                               <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="base_from_time[]" value="{{ old('base_from_time.'.$k, $basePriceRange->base_from_time) }}" class="base_from_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_from_time') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="base_to_time[]"  value="{{ old('base_to_time.'.$k, $basePriceRange->base_to_time) }}" class="base_to_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_to_time') }}</span>
                                        </div>
                                    </div>
                                </td> 
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" type="number" id="name" name="base_price[]" value="{{old('base_price.'.$k,$basePriceRange->base_price)}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('base_price.0') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" type="number" id="name" name="surge_price[]" value="{{old('surge_price.'.$k,$basePriceRange->surge_price)}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('surge_price.0') }}</span>
                                    </div>
                                </td>                                
                                <td>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-sm base_add_row"> + </button>
                                       
                                        <button type="button" class="btn btn-danger btn-sm remove_row"> - </button>

                                    </div>
                                </td>
                            </tr>
                      </tbody>

                        @endforeach
                        @else
                <tbody class="base_append_row">
                            <tr>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" id="base_km_from" name="base_km_from[]" value="{{old('base_km_from.0')}}" class="base_km_from form-control" placeholder="Enter From KM">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_km_from') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" id="base_km_to" name="base_km_to[]" value="{{old('base_km_to.0')}}" class="base_km_to form-control" placeholder="Enter To KM">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_km_to') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="base_price_day[]" class="day form-control">
                                                    @foreach ($daysOfWeek as $day => $label)
                                                        <option value="{{ $day }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                             </div>
                                            <span class="text-danger">{{ $errors->first('base_price_day') }}</span>
                                        </div>
                                    </div>
                                </td>    
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="base_from_time[]" value="{{ old('base_from_time.0') }}" class="from_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_from_time') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="base_to_time[]" value="{{ old('base_to_time.0') }}" class="base_to_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('base_to_time') }}</span>
                                        </div>
                                    </div>
                                </td>                                                              
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" id="base_price" type="number" id="name" name="base_price[]" value="{{old('base_price.0')}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('base_price.0') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" id="surge_price" type="number" id="name" name="surge_price[]" value="{{old('surge_price.0')}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('surge_price.0') }}</span>
                                    </div>
                                </td>                                
                                <td>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-sm base_add_row"> + </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endif  
                </table>
            </div>
        </div>




{{-- Distance Price with Range --}}
<div class="row">
    <div class="col-12">
        <div class="box box-solid box-info">
        <div class="box-header with-border">
        <h4 class="box-title">@lang('view_pages.price_range')</h4>
        </div>

        <div class="box-body">
            <table class="table" id="distance_table">
                <thead>
                    <th style="width:100px;"> @lang('view_pages.from_in_km') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.to_in_km') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.day') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.from_time') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.to_time') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.fare_per_km') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.surge_price') <span class="text-danger">*</span></th>
                    <th style="width:100px;">@lang('view_pages.action')</th>
                </thead>
          @if (!$distance_price->isEmpty())
            @foreach ($distance_price as $k => $priceRange)
                <tbody class="append_row">
                            <tr>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="from[]" value="{{ old('from.'.$k,$priceRange->from) }}" class="from form-control ">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('from') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="to[]" value="{{ old('to.'.$k, $priceRange->to) }}" class="to form-control ">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('to') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="day[]" class="day form-control">
                                                    @foreach ($daysOfWeek as $day => $label)
                                                        <option value="{{ $day }}" @if(old('day.'.$k, $priceRange->day) == $day) selected @endif>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">{{ $errors->first('day') }}</span>
                                        </div>
                                    </div>
                                </td>
                               <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="from_time[]" value="{{ old('from_time.'.$k, $priceRange->from_time) }}" class="from_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('from_time') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="to_time[]"  value="{{ old('to_time.'.$k, $priceRange->to_time) }}" class="to_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('to_time') }}</span>
                                        </div>
                                    </div>
                                </td> 
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" type="number" id="name" name="price[]" value="{{old('price.'.$k,$priceRange->price)}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('price.0') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" type="number" id="name" name="distance_surge[]" value="{{old('distance_surge.'.$k,$priceRange->surge_price)}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('distance_surge.0') }}</span>
                                    </div>
                                </td>                                
                                <td>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-sm add_row"> + </button>
                                        <button type="button" class="btn btn-danger btn-sm remove_row"> - </button>
                                    </div>
                                </td>
                            </tr>
                      </tbody>

                        @endforeach
                        @else
                <tbody class="append_row">
                            <tr>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" id="form" name="from[]" value="{{old('from.0')}}" class="from form-control" placeholder="Enter From KM">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('from') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" id="to" name="to[]" value="{{old('to.0')}}" class="to form-control" placeholder="Enter To KM">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('to') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select name="day[]" class="day form-control">
                                                    @foreach ($daysOfWeek as $day => $label)
                                                        <option value="{{ $day }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                             </div>
                                            <span class="text-danger">{{ $errors->first('day') }}</span>
                                        </div>
                                    </div>
                                </td>    
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="from_time[]" value="{{ old('from_time') }}" class="from_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('from_time') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="text" name="to_time[]" value="{{ old('to_time') }}" class="to_time form-control timepicker">
                                            </div>
                                            <span class="text-danger">{{ $errors->first('to_time') }}</span>
                                        </div>
                                    </div>
                                </td>                                                              
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" id="price" type="number" id="name" name="price[]" value="{{old('price.0')}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('price.0') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                            <input class="form-control" id="distance_surge" type="number" id="name" name="distance_surge[]" value="{{old('distance_surge.0')}}" required="" placeholder="@lang('view_pages.enter_price')">
                                            <span class="text-danger">{{ $errors->first('distance_surge.0') }}</span>
                                    </div>
                                </td>                                
                                <td>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success btn-sm add_row"> + </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
            
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
<script>
$(document).on("click", ".add_row", function () {
    //empty field validation
        var emptyFields = false;

        // Check if any input fields are empty or have the "disabled" value
        var inputs = $(this).closest("tr").find('input[type="text"], input[type="number"], select');
        inputs.each(function () {
            if (!$(this).val() || $(this).val() === 'disabled') {
                emptyFields = true;
                return false; // exit the loop early
            }
        });

        if (emptyFields) {
            alert("Please fill in all fields.");
            return;
        }

    // km validation
        var fromInput = $(this).closest("tr").find('.from');
        var toInput = $(this).closest("tr").find('.to');


        if (fromInput.val() === toInput.val()) {
            alert("From KM and To KM cannot be the same.");
            return;
        }

        var fromValue = parseFloat(fromInput.val());
        var toValue = parseFloat(toInput.val());

        if (fromValue >= toValue) {
            alert("From KM must be less than To KM.");
            return;
        }

    //time validation
        var fromTimeInput = $(this).closest("tr").find('.from_time');
        var toTimeInput = $(this).closest("tr").find('.to_time');


        if (fromTimeInput.val() === toTimeInput.val()) {
            alert("From Time and To Time cannot be the same.");
            return;
        }   


        var table = document.getElementById("distance_table");
        var append_row = "";

        append_row +='<tr>';
        append_row += '<td>\
                            <div class="bootstrap">\
                                <div class="form-group">\
                                    <div class="input-group">\
                                        <input type="text" id="form" name="from[]" value="{{old('from.0')}}" class="from form-control" placeholder="Enter From KM">\
                                    </div>\
                                    <span class="text-danger">{{ $errors->first('from') }}</span>\
                                </div>\
                            </div>\
                        </td>';

        append_row += '<td>\
                            <div class="bootstrap">\
                                <div class="form-group">\
                                    <div class="input-group">\
                                        <input type="text" id="to" name="to[]" value="{{old('to.0')}}" class="from form-control" placeholder="Enter To KM">\
                                    </div>\
                                    <span class="text-danger">{{ $errors->first('to') }}</span>\
                                </div>\
                            </div>\
                        </td>';
        append_row += '<td>\
                            <div class="bootstrap">\
                                <div class="form-group">\
                                    <div class="input-group">\
                                        <select name="day[]" class="day form-control">\
                                                @foreach ($daysOfWeek as $day => $label)\
                                                <option value="{{ $day }}">{{ $label }}</option>\
                                                @endforeach\
                                        </select>\
                                     </div>\
                                    <span class="text-danger">{{ $errors->first('day') }}</span>\
                                </div>\
                            </div>\
                        </td>';
         append_row += '<td>\
                            <div class="bootstrap-timepicker">\
                                <div class="form-group">\
                                    <div class="input-group">\
                                        <div class="input-group-addon">\
                                        <i class="fa fa-clock-o"></i>\
                                        </div>\
                                        <input type="text" name="from_time[]" value="{{ old('from_time') }}" class="from_time form-control timepicker">\
                                    </div>\
                                    <span class="text-danger">{{ $errors->first('from_time') }}</span>\
                                </div>\
                            </div>\
                        </td>';
        append_row += '<td>\
                            <div class="bootstrap-timepicker">\
                                <div class="form-group">\
                                    <div class="input-group">\
                                        <div class="input-group-addon">\
                                        <i class="fa fa-clock-o"></i>\
                                        </div>\
                                        <input type="text" name="to_time[]" value="{{ old('to_time') }}" class="to_time form-control timepicker">\
                                    </div>\
                                    <span class="text-danger">{{ $errors->first('to_time') }}</span>\
                                </div>\
                            </div>\
                        </td>';                                
        append_row += '<td>\
                            <div class="form-group">\
                                <input class="form-control" type="number"   id="name" name="price[]" value="" required="" placeholder="@lang('view_pages.enter_price')">\
                            </div>\
                        </td>';
        append_row += '<td>\
                            <div class="form-group">\
                                <input class="form-control" type="number"  id="name" name="distance_surge[]" value="" required="" placeholder="@lang('view_pages.enter_price')">\
                            </div>\
                        </td>';                                
        append_row +='<td>\
                            <div class="form-group">\
                                <button type="button" class="btn btn-success btn-sm add_row"> + </button>\
                                <button type="button" class="btn btn-danger btn-sm remove_row"> - </button>\
                            </div>\
                        </td>\
                </tr>';

        var currentRow = $(this).closest("tr");
        currentRow.after(append_row);

        $(".select2").select2({
            tags: true,
            tokenSeparators: [',', ' '],
            selectOnClose: true,
            placeholder: "select a day",
            allowClear: true
        })

        $('.timepicker').timepicker({
            showInputs: false,
            minuteStep: 1, // Set the time interval to 1 minute
            showMeridian: false, // Disable AM/PM selection
        });
        // Initialize select2 and timepicker components for the new row
        currentRow.next().find(".select2").select2({
            tags: true,
            tokenSeparators: [',', ' '],
            selectOnClose: true,
            placeholder: "select a day",
            allowClear: true
        });

        currentRow.next().find('.timepicker').timepicker({
            showInputs: false,
            minuteStep: 1,
            showMeridian: false,
        });
    });


    $(document).on("click", ".remove_row", function () {
            $(this).closest("tr").remove();
        });

</script>

<script>
/*base price add Row*/
$(document).on("click", ".base_add_row", function () {
//empty field validation
    var emptyFields = false;
        // Check if any input fields are empty or have the "disabled" value
        var inputs = $(this).closest("tr").find('input[type="text"], input[type="number"], select');
        inputs.each(function () {
            if (!$(this).val() || $(this).val() === 'disabled') {
                emptyFields = true;
                return false; // exit the loop early
            }
        });

        if (emptyFields) {
            alert("Please fill in all fields.");
            return;
        }

// km validation
    var baseFromInput = $(this).closest("tr").find('.base_km_from');
    var baseToInput = $(this).closest("tr").find('.base_km_to');

    if (baseFromInput.val() === baseToInput.val()) {
        alert("From KM and To KM cannot be the same.");
        return;
    }

    var baseFromValue = parseFloat(baseFromInput.val());
    var baseToValue = parseFloat(baseToInput.val());

    if (baseFromValue >= baseToValue) {
        alert("From KM must be less than To KM.");
        return;
    }

//time validation
    var baseFromTimeInput = $(this).closest("tr").find('.base_from_time');
    var baseToTimeInput = $(this).closest("tr").find('.base_to_time');
    if (baseFromTimeInput.val() === baseToTimeInput.val()) {
        alert("From Time and To Time cannot be the same.");
        return;
    }   

    var newRow = $(this).closest("tr");
    var baseFromValue = newRow.find('.base_km_from').val();
    var baseToValue = newRow.find('.base_km_to').val();
 
            var base_table = document.getElementById("base_table");
                var base_append_row = "";

                base_append_row +='<tr>';
                base_append_row += '<td>\
                                    <div class="bootstrap">\
                                        <div class="form-group">\
                                            <div class="input-group">\
                                                <input type="text" id="form" name="base_km_from[]" value="{{old('base_km_from.0')}}" class="base_km_from form-control" placeholder="Enter From KM">\
                                            </div>\
                                            <span class="text-danger">{{ $errors->first('base_km_from') }}</span>\
                                        </div>\
                                    </div>\
                                </td>';

                base_append_row += '<td>\
                                    <div class="bootstrap">\
                                        <div class="form-group">\
                                            <div class="input-group">\
                                                <input type="text" id="base_km_to" name="base_km_to[]" value="{{old('base_km_to.0')}}" class="from form-control" placeholder="Enter To KM">\
                                            </div>\
                                            <span class="text-danger">{{ $errors->first('base_km_to') }}</span>\
                                        </div>\
                                    </div>\
                                </td>';
                base_append_row += '<td>\
                                    <div class="bootstrap">\
                                        <div class="form-group">\
                                            <div class="input-group">\
                                                <select name="base_price_day[]" class="base_price_day form-control">\
                                                       @foreach ($daysOfWeek as $day => $label)\
                                                        <option value="{{ $day }}">{{ $label }}</option>\
                                                        @endforeach\
                                                </select>\
                                             </div>\
                                            <span class="text-danger">{{ $errors->first('base_price_day') }}</span>\
                                        </div>\
                                    </div>\
                                </td>';
                 base_append_row += '<td>\
                                    <div class="bootstrap-timepicker">\
                                        <div class="form-group">\
                                            <div class="input-group">\
                                                <div class="input-group-addon">\
                                                <i class="fa fa-clock-o"></i>\
                                                </div>\
                                                <input type="text" name="base_from_time[]" value="{{ old('base_from_time.0') }}" class="base_from_time form-control timepicker">\
                                            </div>\
                                            <span class="text-danger">{{ $errors->first('base_from_time') }}</span>\
                                        </div>\
                                    </div>\
                                </td>';
                base_append_row += '<td>\
                                    <div class="bootstrap-timepicker">\
                                        <div class="form-group">\
                                            <div class="input-group">\
                                                <div class="input-group-addon">\
                                                <i class="fa fa-clock-o"></i>\
                                                </div>\
                                                <input type="text" name="base_to_time[]" value="{{ old('base_to_time.0') }}" class="base_to_time form-control timepicker">\
                                            </div>\
                                            <span class="text-danger">{{ $errors->first('base_to_time') }}</span>\
                                        </div>\
                                    </div>\
                                </td>';                                
                base_append_row += '<td>\
                                    <div class="form-group">\
                                        <input class="form-control" type="number"  id="name" name="base_price[]" value="" required="" placeholder="@lang('view_pages.enter_price')">\
                                    </div>\
                                </td>';
                base_append_row += '<td>\
                                    <div class="form-group">\
                                        <input class="form-control" type="number"   id="name" name="surge_price[]" value="" required="" placeholder="@lang('view_pages.enter_price')">\
                                    </div>\
                                </td>';
                base_append_row +='<td>\
                                    <div class="form-group">\
                                        <button type="button" class="btn btn-success btn-sm base_add_row"> + </button>\
                                        <button type="button" class="btn btn-danger btn-sm base_remove_row"> - </button>\
                                    </div>\
                                </td>\
                        </tr>';

                newRow.after(base_append_row);
                
                $(".select2").select2({
                    tags: true,
                    tokenSeparators: [',', ' '],
                    selectOnClose: true,
                    placeholder: "select a day",
                    allowClear: true
                })
                $('.timepicker').timepicker({
                    showInputs: false,
                    minuteStep: 1, // Set the time interval to 1 minute
                    showMeridian: false, // Disable AM/PM selection
                });  
            // Initialize select2 and timepicker components for the new row
            newRow.next().find(".select2").select2({
                tags: true,
                tokenSeparators: [',', ' '],
                selectOnClose: true,
                placeholder: "select a day",
                allowClear: true
            });

            newRow.next().find('.timepicker').timepicker({
                showInputs: false,
                minuteStep: 1,
                showMeridian: false,
            });                         
        });


    $(document).on("click", ".base_remove_row", function () {
            $(this).closest("tr").remove();
        });

</script>


@endsection