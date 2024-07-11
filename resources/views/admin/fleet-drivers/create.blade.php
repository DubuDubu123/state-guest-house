@extends('admin.layouts.app')
@section('title', 'Main page')


@section('content')

<!-- Start Page content -->
<div class="content">
<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
    <div class="box">

        <div class="box-header with-border">
            <a href="{{ url('fleet-drivers') }}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>

<div class="col-sm-12">

<form  method="post" class="form-horizontal" action="{{url('fleet-drivers/store')}}" enctype="multipart/form-data">
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
    <input class="form-control" type="text" id="name" name="name" value="{{old('name')}}" required="" placeholder="@lang('view_pages.enter_name')">
    <span class="text-danger">{{ $errors->first('name') }}</span>

</div>

</div>

<div class="row">

    </div>
<!--  <div class="col-sm-6">
            <div class="form-group">
            <label for="address">@lang('view_pages.address')</label>
            <input class="form-control" type="text" id="address" name="address" value="{{old('address')}}" required="" placeholder="@lang('view_pages.enter_address')">
            <span class="text-danger">{{ $errors->first('address') }}</span>

        </div>
    </div> -->
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
    <input class="form-control" type="text" id="mobile" name="mobile" value="{{old('mobile')}}" required="" placeholder="@lang('view_pages.enter_mobile')">
    <span class="text-danger">{{ $errors->first('mobile') }}</span>

</div>
</div>
<!-- <div class="col-6">
    <div class="form-group">
        <label for="">@lang('view_pages.is_company_driver') <span class="text-danger">*</span></label>
        <select name="is_company_driver" id="is_company_driver" class="form-control">
            <option value="" selected disabled>@lang('view_pages.select')</option>
            <option value="1" {{ old('is_company_driver') == '1' ? 'selected' : '' }}>@lang('view_pages.yes')</option>
            <option value="0" {{ old('is_company_driver') == '0' ? 'selected' : '' }}>@lang('view_pages.no')</option>
        </select>
        <span class="text-danger">{{ $errors->first('is_company_driver') }}</span>
    </div>
</div> -->

<!-- <div class="col-6" style="display:none" id="companyShow">
<div class="form-group">
<label for="company">@lang('view_pages.select_company')
    <span class="text-danger">*</span>
</label>
<select name="company" id="company" class="form-control">
    <option value="" >@lang('view_pages.select_company')</option>
    <option value=0 >@lang('view_pages.individual')</option>
    @foreach($companies as $key=>$company)
    <option value="{{$company->id}}"{{ old('company') == $company->id ? 'selected' : '' }}>{{$company->name}}</option>
    @endforeach
</select>
<span class="text-danger">{{ $errors->first('company') }}</span>
</div>
</div> -->
</div>

<div class="row">
       <div class="col-sm-6">
        <div class="form-group">
            <label for="email">@lang('view_pages.email') <span class="text-danger">*</span></label>
            <input class="form-control" type="email" id="email" name="email" value="{{old('email')}}" required="" placeholder="@lang('view_pages.enter_email')">
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
            <label for="owner">@lang('view_pages.owner')
                <span class="text-danger">*</span>
            </label>
            <select name="owner_id" id="owner_id" class="form-control" required>
                <option value="" >@lang('view_pages.select_owner')</option>
                @foreach($owner as $key=>$owners)
                <option value="{{$owners->id}}" {{ old('owners') == $owners->id ? 'selected' : '' }}>{{$owners->owner_name}}</option>
                @endforeach
            </select>
            </div>
       </div> 

<!-- documents -->
    <div class="col-6">
        <div class="form-group">
            <label for="aadhar_number">@lang('view_pages.aadhar_number')<span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="aadhar_number" name="aadhar_number" value="{{old('aadhar_number')}}" required="" placeholder="@lang('view_pages.enter_aadhar_number')">
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

<!-- <div class="col-6">
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
</div> -->


<!-- documents -->


<div class="col-sm-6">
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
    <script src="{{asset('assets/vendor_components/jquery/dist/jquery.js')}}"></script>
<script>
    let oldCarMake = "{{ old('car_make') }}";
    let oldCarModel = "{{ old('car_model') }}";

    if(oldCarMake){
        getCarModel(oldCarMake,oldCarModel);
    }

    $('#is_company_driver').change(function() {
        var value = $(this).val();
        if(value == 1){
            $('#companyShow').show();
        }else{
            $('#companyShow').hide();
        }
    });

    function getypesAndCompany(){

            var admin_id = document.getElementById('admin_id').value;
            var ajaxPath = "<?php echo url('types/by/admin');?>";
            var ajaxCompanyPath = "<?php echo url('company/by/admin');?>";

            $.ajax({
                url: ajaxPath,
                type:  'GET',
                data: {
                    'admin_id': admin_id,
                },
                success: function(result)
                {
                    $('#type').empty();

                    $("#type").append('<option value="">Select Type</option>');

                    for(var i = 0 ; i < result.data.length ; i++)
                    {
                        console.log(result.data[i]);
                        $("#type").append('<option  class="left" value="'+result.data[i].id+'" data-icon="'+result.data[i].icon+'"  >'+result.data[i].name+'</option>');
                    }

                    $('#type').select();
                },
                error: function()
                {

                }
            });

            $.ajax({
                url: ajaxCompanyPath,
                type:  'GET',
                data: {
                    'admin_id': admin_id,
                },
                success: function(result)
                {
                    $('#company').empty();

                    $("#company").append('<option value="">Select Company</option>');
                    $("#company").append('<option value="0">Individual</option>');

                    for(var i = 0 ; i < result.data.length ; i++)
                    {
                        console.log(result.data[i]);
                        $("#company").append('<option  class="left" value="'+result.data[i].id+'" >'+result.data[i].name+'</option>');
                    }

                    $('#company').select();
                },
                error: function()
                {

                }
            });
    }

    function getCarModel(value,model=''){
        var selected = '';
        $.ajax({
            url: "{{ route('getCarModel') }}",
            type:  'GET',
            data: {
                'car_make': value,
            },
            success: function(result)
            {
                $('#car_model').empty();
                $("#car_model").append('<option value="" selected disabled>Select</option>');
                result.forEach(element => {

                    if(model == element.id){
                        selected = 'selected';
                    }else{
                        selected='';
                    }

                    $("#car_model").append('<option value='+element.id+' '+selected+'>'+element.name+'</option>')
                });
                $('#car_model').select();
            }
        });
        alert("count==="+count);
    }

    $(document).on('change','#car_make',function(){
        getCarModel($(this).val());
    });
</script>

@endsection

