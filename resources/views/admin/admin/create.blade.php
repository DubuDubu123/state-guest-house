@extends('admin.layouts.app')
@section('title', 'Main page')
<style>
.response-error {
    padding: 10px;
    /* width: 80%;    */
    display: none;
    color:red;
}
.response-error.actv{
	background: #0A7E8C;
    color: black;
}
.verify_button.active{
	background: #0A7E8C !important;
}
.response-error.error{
	background: red;
    color: black;
}
</style>
@section('content')

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">
            @if ($errors)
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @endif
            <div class="row" style="margin: 20px 20px 20px 20px;background: white;padding-top: 30px;border-radius:3px">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <a href="{{ url('admins') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('admins/store') }}" id="user-edit"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}


                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="role">@lang('view_pages.select_role')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="role" id="role" class="form-control" required>
                                            
                                                @foreach ($roles as $key => $role)
                                                @if($key == 0)
                                                <option value="{{ $role->slug }}" selected>{{ $role->name }}
                                                    </option>
                                                @else
                                                <option value="{{ $role->slug }}">{{ $role->name }} 
                                                    </option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-6" id="Dispatchertypes" style="display:none">
                                        <div class="form-group">
                                            <label for="admin_id">@lang('view_pages.select_area')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="dispatcher_type" id="dispatcher_type"
                                                class="form-control"> 
                                                <option selected value="1">Super Dispatcher</option>
                                                <option value="0">Sub Dispatcher</option> 
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="col-6" id="serviceLocation" style="display:none">
                                        <div class="form-group">
                                            <label for="admin_id">@lang('view_pages.select_area')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="service_location_id" id="service_location_id"
                                                class="form-control">
                                                <option value="" selected disabled>@lang('view_pages.select_area')</option>
                                                @foreach ($services as $key => $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ old('service_location_id') == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">@lang('view_pages.name') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name') }}" required=""
                                                placeholder="@lang('view_pages.enter_name')">
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>

                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">@lang('view_pages.name') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name') }}" required=""
                                                placeholder="@lang('view_pages.enter_name')">
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>

                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">@lang('view_pages.address') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="address" name="address"
                                                value="{{ old('address') }}" required=""
                                                placeholder="@lang('view_pages.enter_address')">
                                            <span class="text-danger">{{ $errors->first('address') }}</span>

                                        </div>
                                    </div> -->
                                </div>
                            <div class="row">
                                    <!-- <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">@lang('view_pages.select_country')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="country" id="country" class="form-control" required>
                                                <option value="" selected disabled>@lang('view_pages.select_country')
                                                </option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="state">@lang('view_pages.state') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="state" name="state"
                                                value="{{ old('state') }}" required=""
                                                placeholder="@lang('view_pages.enter_state')">
                                            <span class="text-danger">{{ $errors->first('state') }}</span>

                                        </div>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="city">@lang('view_pages.city') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="city" name="city"
                                                value="{{ old('city') }}" required=""
                                                placeholder="@lang('view_pages.enter_city')">
                                            <span class="text-danger">{{ $errors->first('city') }}</span>

                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="postal_code">@lang('view_pages.postal_code') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="city" name="postal_code" min="1"
                                                value="{{ old('postal_code') }}" required=""
                                                placeholder="@lang('view_pages.enter_postal_code')">
                                            <span class="text-danger">{{ $errors->first('postal_code') }}</span>

                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">@lang('view_pages.email') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                value="{{ old('email') }}" required=""
                                                placeholder="@lang('view_pages.enter_email')">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password">@lang('view_pages.password') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" id="password" name="password"
                                                value="" required="" placeholder="@lang('view_pages.enter_password')">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">@lang('view_pages.email') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                value="{{ old('email') }}" required=""
                                                placeholder="@lang('view_pages.enter_email')">
                                            <span class="text-danger">{{ $errors->first('email') }}</span>

                                        </div>
                                    </div> -->
                                 
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confrim">@lang('view_pages.confirm_password') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" id="password_confirmation"
                                                name="password_confirmation" value="" required=""
                                                placeholder="@lang('view_pages.enter_password_confirmation')">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password_confrim">@lang('view_pages.confirm_password') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" id="password_confirmation"
                                                name="password_confirmation" value="" required=""
                                                placeholder="@lang('view_pages.enter_password_confirmation')">
                                            <span class="text-danger">{{ $errors->first('password') }}</span>

                                        </div>
                                    </div> -->

                                    <div class="col-6" id="dispatcher_type" style="display:none">
                                        <div class="form-group">
                                            <label for="dispatcher_type">@lang('view_pages.select_area')
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="dispatcher_type" id="dispatcher_type" class="form-control"> 
                                                <option value="admin_dispatcher" {{ old('dispatcher_type') == 'admin_dispatcher' ? 'selected' : '' }}>@lang('view_pages.admin_dispatcher')
                                                </option>
                                                <option value="sub_dispatcher" {{ old('dispatcher_type') == 'sub_dispatcher' ? 'selected' : '' }}>@lang('view_pages.sub_dispatcher')
                                                </option>
                                                
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                    <div class="col-6">
                                        <label for="profile_picture">@lang('view_pages.profile') <span style="
    font-size: 12px;
    color: red;
    position: relative;
    top: -1px;
">(File Size should be below 5 MB)</span></label><br>
                                        <img id="blah" src="#" alt=""><br>
                                        <input type="file" id="profile_picture" onchange="readURL1(this)"
                                            name="profile_picture" style="display:none">
                                        <button class="btn btn-primary btn-sm" type="button"
                                            onclick="$('#profile_picture').click()" id="upload">@lang('view_pages.browse')</button>
                                        <button class="btn btn-danger btn-sm" type="button" id="remove_img"
                                            style="display: none;">@lang('view_pages.remove')</button><br>
                                        <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                    </div>
                                </div>

                                <div class="response-error" style="/* display: block; *//* float: right; */text-align: right;"><span style="
    /* float: right; */
    /* background: red; */
    padding: 6px;
    color: red;
"></span></div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5 user-edit" type="button">
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


    
<script>
    function validateEmail(email) {
    // Regular expression for validating an email
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}
    $(".user-edit").click(function(){ 
        $(".response-error").removeClass("error"); 
        var newPassword = document.getElementById('password').value;
			var confirm_password = document.getElementById('password_confirmation').value;
            console.log(validateEmail($("#email").val()));
            if(validateEmail($("#email").val()) === false)
			{
				$(".response-error").html("Email format is Incorrect");
				$(".response-error").show();
				
			}
            else if($("#first_name").val() == "" || $("#first_name").val() === null || $("#first_name").val() === undefined)
			{
				$(".response-error").html("Name cannot be empty");
				$(".response-error").show();
				
			}
			else if($("#password").val() == "" || $("#password").val() === null || $("#password").val() === undefined)
			{
				$(".response-error").html("Password cannot be empty");
				$(".response-error").show();
				
			}
			else if($("#password_confirmation").val() == "" || $("#password_confirmation").val() === null || $("#password_confirmation").val() === undefined)
			{
				$(".response-error").html("Confirm Password cannot be empty");
				$(".response-error").show();
                
			}
			else if(newPassword.length < 8 || confirm_password.length < 8)
			{
				$(".response-error").html("Password length must be at least 8 characters");
				$(".response-error").show();
                
			}
			else if(confirm_password.length < 8)
			{
				$(".response-error").html("Password length must be at least 8 characters");
				$(".response-error").show();
                
			}
			else if($("#password_confirmation").val() != $("#password").val())
			{
				$(".response-error").html("Password entered doesn't match");
				$(".response-error").show();
                
			}
            else{ 
                $("#user-edit").submit();
            } 
    })
 function readURL1(input) {
         var parentDiv = input.closest('div');

        // if label is present childnodes may differ
         if(parentDiv.childNodes.length == 16){
             $keys = [4,9,11];
         }else{
            // for settings page only
            $keys = [1,7,9];
         }

            if (input.files && input.files[0]) {
                const file = input.files[0];
    			const maxSize = 5 * 1024 * 1024; // 5MB in bytes
				if (file) {
        if (file.size > maxSize) {
            alert('File size exceeds 5MB. Please select a smaller file.');
			input.value = ''; 
        } else { 
            var reader = new FileReader();
                reader.onload = function(e) {
                    if(e.target.result){
                        parentDiv.childNodes[$keys[1]].innerText = 'Change';
                        parentDiv.childNodes[$keys[2]].style.display = 'inline-block';
                    }else{
                        parentDiv.childNodes[$keys[2]].style.display = 'none';
                        parentDiv.childNodes[$keys[1]].innerText = 'Browse';
                    }
                    parentDiv.childNodes[$keys[0]].setAttribute('src', e.target.result);
                    parentDiv.childNodes[$keys[0]].style.height = '250px';
                }
                reader.readAsDataURL(input.files[0]);
                $(".sendPush").show();
        }
                
            }
        }
    }
</script>


@endsection

