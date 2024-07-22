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
                            <a href="{{ url('branch/inactive') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('branch/inactive') }}" id="user-inactive"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-6">
                                        <input type="hidden" value = "{{$branch[0]->id}}" name="id">               
                                    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name">Branch Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="first_name" name="branch_name"
                                                value="{{$branch[0]->title}}" required=""
                                                placeholder="@lang('view_pages.enter_name')">
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>

                                             <textarea id="address" name="address" style="width:100%;border: 1px solid #dedede;" > </textarea>
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>

                                        </div>
                                    </div>


                                </div> 

                               
                                <div class="row">
                               

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
                                        <button class="btn btn-primary btn-sm pull-right m-5 user-inactive" type="Submit">
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
$ (".form-horizontal").click(function(){
    var Branch_Name =$("Branch_Name").val()

    var Address=$("Address").val()
});
$.ajax({
    type : 'post',
    data : {Branch_Name:Branch_Name, Address:Address},
    url : "{{ url('branch/store') }}",
    data : FormData,
    sucess : function (result,status){
        console.log ( Your Booking Have Been Saved Successfully!!);
    }
    error : function (xhr, status, error)  {
        console.error(xhr.responseText);
        
    }
});
    </script>

@endsection




