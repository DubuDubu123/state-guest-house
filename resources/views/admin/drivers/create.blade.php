@extends('admin.layouts.app')
@section('title', 'Main page')


@section('content')
    <!-- bootstrap datepicker -->   
<link rel="stylesheet" href="{{ asset('assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>

<!-- Start Page content -->
<div class="content">
<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
    <div class="box">

        <div class="box-header with-border">
            <a href="{{ url('drivers/waiting-for-approval') }}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>

<div class="col-sm-12">

<form  method="post" class="form-horizontal" action="{{url('drivers/store')}}" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row">
<div class="col-6">
<div class="form-group">
<label for="admin_id">@lang('view_pages.select_area')
    <span class="text-danger">*</span>
</label>
<select name="service_location_id" id="service_location_id" class="form-control" onchange="getypesAndCompanys()" required>
    <option value="" selected disabled>@lang('view_pages.select_area')</option>
    @foreach($services as $key=>$service)
    <option value="{{$service->id}}" {{ old('service_location_id') == $service->id ? 'selected' : '' }}>{{$service->name}}</option>
    @endforeach
</select>
</div>
</div>
<div class="col-sm-6">
    <div class="form-group">
    <label for="name">@lang('view_pages.name') <span class="text-danger">*</span></label>
    <input class="form-control" type="text" id="name" name="name" value="{{$driver_data->name}}" required="" placeholder="@lang('view_pages.enter_name')">
    <span class="text-danger">{{ $errors->first('name') }}</span>

</div>

</div>

<div class="row">

    </div>
</div>

<div class="row">
    <div class="col-6">
<div class="form-group">
<label for="gender">@lang('view_pages.gender')
    <span class="text-danger">*</span>
</label>
<select name="gender" id="gender" class="form-control" required>
    <option value="" >@lang('view_pages.select_gender')</option>
    <option value= 'male' {{ old('gender') == 'male' ? 'selected' : '' }}>@lang('view_pages.male')</option>
    <option value= 'fe-male' {{ old('gender') == 'fe-male' ? 'selected' : '' }}>@lang('view_pages.female')</option>
    <option value= 'others' {{ old('gender') == 'others' ? 'selected' : '' }}>@lang('view_pages.others')</option>
   </select>
<span class="text-danger">{{ $errors->first('gender') }}</span>

</div>
</div>
<div class="col-sm-6">
    <div class="form-group">
    <label for="name">@lang('view_pages.mobile') <span class="text-danger">*</span></label>
    <input class="form-control" type="text" id="mobile" name="mobile" value="{{$driver_data->mobile}}" required="" placeholder="@lang('view_pages.enter_mobile')">
    <span class="text-danger">{{ $errors->first('mobile') }}</span>

</div>
</div>

</div>

<div class="row">
       <div class="col-sm-6">
        <div class="form-group">
            <label for="email">@lang('view_pages.email') <span class="text-danger"></span></label>
            <input class="form-control" type="email" id="email" name="email" value="{{old('email')}}" placeholder="@lang('view_pages.enter_email')">
            <span class="text-danger">{{ $errors->first('email') }}</span>


        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="type">@lang('view_pages.select_type')
                <span class="text-danger">*</span>
            </label>
            <select name="type" id="type" class="form-control" required>
                <option value="" >@lang('view_pages.select_type')</option>
                @foreach($types as $key=>$type)
                <option value="{{$type->id}}" {{ old('type') == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                @endforeach
            </select>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="car_make">@lang('view_pages.car_make')<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="car_make" name="car_make" value="{{old('car_make')}}" required="" placeholder="@lang('view_pages.enter_car_make_name')">
                <span class="text-danger">{{ $errors->first('car_make') }}</span>
        </div>
</div>

<div class="col-6">
    <div class="form-group">
        <label for="car_model">@lang('view_pages.car_model')<span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="car_model" name="car_model" value="{{old('car_model')}}" required="" placeholder="@lang('view_pages.enter_car_model_name')">
        <span class="text-danger">{{ $errors->first('car_model') }}</span>
    </div>
</div>

<div class="col-6">
    <div class="form-group">
        <label for="car_color">@lang('view_pages.car_color') <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="car_color" name="car_color" value="{{old('car_color')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.car_color')">
        <span class="text-danger">{{ $errors->first('car_color') }}</span>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="car_number">@lang('view_pages.car_number') <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="car_number" name="car_number" value="{{old('car_number')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.car_number')">
        <span class="text-danger">{{ $errors->first('car_number') }}</span>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="vehicle_year">@lang('view_pages.vehicle_year') <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="vehicle_year" name="vehicle_year" value="{{old('vehicle_year')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.vehicle_year')">
        <span class="text-danger">{{ $errors->first('vehicle_year') }}</span>
    </div>
</div>

<!-- documents -->
    <div class="col-6">
        <div class="form-group">
            <label for="aadhar_number">@lang('view_pages.aadhar_number')<span class="text-danger">*</span></label>
                <input class="form-control" type="number" id="aadhar_number" name="aadhar_number" value="{{old('aadhar_number')}}" required="" placeholder="@lang('view_pages.enter_aadhar_number')">
                <span class="text-danger">{{ $errors->first('aadhar_number') }}</span>
        </div>
</div>

<div class="col-6">
    <div class="form-group">
        <label for="driving_license_number">@lang('view_pages.driving_license_number')<span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="driving_license_number" name="driving_license_number" value="{{old('driving_license_number')}}" required="" placeholder="@lang('view_pages.enter_driving_license_number')">
        <span class="text-danger">{{ $errors->first('driving_license_number') }}</span>
    </div>
</div>

<div class="col-6">
    <div class="form-group">
        <label for="vehicle_insurence_number">@lang('view_pages.vehicle_insurence_number') <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="vehicle_insurence_number" name="vehicle_insurence_number" value="{{old('vehicle_insurence_number')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.vehicle_insurence_number')">
        <span class="text-danger">{{ $errors->first('vehicle_insurence_number') }}</span>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label for="rc_number">@lang('view_pages.rc_number') <span class="text-danger">*</span></label>
        <input class="form-control" type="text" id="rc_number" name="rc_number" value="{{old('rc_number')}}" required="" placeholder="@lang('view_pages.enter') @lang('view_pages.rc_number')">
        <span class="text-danger">{{ $errors->first('rc_number') }}</span>
    </div>
</div>

<!-- documents -->


<div class="col-sm-12">
    <label for="profile_picture">@lang('view_pages.profile')</label><br>
    <img id="blah" src="#" alt=""><br>
    <input type="file" id="icon" onchange="readURL(this)" name="profile_picture" style="display:none">
    <button class="btn btn-primary btn-sm" type="button" onclick="$('#icon').click()" id="upload">@lang('view_pages.browse')</button>
    <button class="btn btn-danger btn-sm" type="button" id="remove_img" style="display: none;">@lang('view_pages.remove')</button><br>
    <span class="text-danger">{{ $errors->first('icon') }}</span>
</div>
</div>
</div>


<div class="form-group">
        <div class="col-6">

</div>


<div class="form-group">
        <div class="col-12">
            <button class="btn btn-primary btn-sm m-5 pull-right" type="submit">
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
<!-- container -->

</div>
<!-- content -->
<!-- jQuery 3 -->
<script src="{{ asset('assets/vendor_components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    // Date and time picker
    $('.datetimepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd hh:ii:ss', // Updated format to include time
        startDate: 'today',
        todayBtn: 'linked',
        todayHighlight: true,
        showMeridian: true,
        minuteStep: 1,
        pickerPosition: "bottom-left" // Adjust the position if needed
    });

    $('#driver_has_free_trail').change(function() {
        var value = $(this).val();
        if(value == 1){
            $('#companyShow').show();
        } else {
            $('#companyShow').hide();
        }
    });
</script>
@endsection

