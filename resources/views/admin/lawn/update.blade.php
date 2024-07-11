@extends('admin.layouts.app') @section('title', 'Main page') @section('content')
    <style>
        .book-now.spinner {
        font-size: 0px;
        width: 40px;
        height: 40px;
        padding: 0px !important;
        background: none !important;
        border-radius: 50% !important;
        border-left-color: transparent !important;
        animation: rotate 0.5s ease 0.5s infinite;
        border: 3px solid blue;
    }
    @keyframes rotate{
    0%{
        transform: rotate(360deg);
    }
    }
        .btn-primary {
    background-color: #EC9E9C !important;
    border-color: #EC9E9C !important;
    color: var(--btn_text);
}
.skin-blue-light .main-header .navbar {
    background-color: #EC9E9C !important;
    /* background-color: #fff; */
}
.skin-blue-light .sidebar-menu>li.active>a {
    border-left-color: #EC9E9C !important;
}



.skin-blue-light .sidebar-menu>li.active>a, .skin-blue-light .sidebar-menu>li.menu-open>a {
    color: #fff !important;
    background: #EC9E9C !important;
}
        input {
        width: 200px;
        padding: 10px;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 20px;
    }
    input[readonly] {
                border: none;
                width: 200px;
                padding-left: 60px;
                padding-top: 19px;
                font-size: 15px;
                outline: none;
                cursor: pointer;
                padding-bottom: 7px;
                user-select: none; /* Prevent text selection */
                background-color: transparent; /* Optional: if you want no background */
            }
            .col-3 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 25%;
        flex: 0 0 20% !important;
        max-width: 50%;
    }
    .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
        position: relative;
        width: 100%;
        min-height: 1px;
        padding-right: 0px !important;
        padding-left: 0px !important;
    }
    @media (max-width: 1000px) {
        .col-sm-6 {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50% !important;
            max-width: 50% !important;
        }
    }
    .col-2 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667% !important;
    }
    .party-msg{
        font-size: 13px;
        position: absolute;
        top: -40px;
        width: 351px;
        left: 48px;
        font-weight: 800;
        padding: 6px;
    }
    .party-msg.error{
        background-color: #ffa7a7;
        color: #d50808;
    
    }
    .party-msg.active{
        background: #aaf6aa;
        color: green;
        
    }
    .book-now.active{
        background:#EC9E9C !important;
        color:white;
    }
    .skin-blue-light .sidebar-menu .treeview-menu>li.active>a, .skin-blue-light .sidebar-menu .treeview-menu>li>a:hover {
    color: #EC9E9C !important;
}
.alert-success, .callout.callout-success, .label-success, .modal-success .modal-body{
    background-color: #EC9E9C !important;
}
    button.btn.btn-primary.btn-sm.m-5.book-now.active {
        cursor: pointer !important;
    }
    .btn-outline.btn-success {
    color: black;
    background-color: #EC9E9C;
    border-color: #EC9E9C;
}
.btn-outline.btn-success:hover {
    color: black;
    background-color: #EC9E9C;
    border-color: #EC9E9C;
}
.book-now{
    padding: 10px;
    padding-left: 30px;
    padding-right: 30px;
    cursor: not-allowed;
    background: #dfdddd !important;
    border: 1px solid grey;
    color: black;
}
.book-now.active{
    background:#EC9E9C !important;
    color:white;
}

.book-now.spinner {
        font-size: 0px;
        width: 40px;
        height: 40px;
        padding: 0px !important;
        background: none !important;
        border-radius: 50% !important;
        border-left-color: transparent !important;
        animation: rotate 0.5s ease 0.5s infinite;
        border: 3px solid blue;
    }
    @keyframes rotate{
    0%{
        transform: rotate(360deg);
    }
    }
    span#select2-user-container {
    font-size: 14px;
}
span.select2.select2-container.select2-container--default.select2-container--below {
    width: 100% !important;
}
.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    padding: 11px 12px;
    height: 43px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 35px;
    right: 3px;
}
    /* .btn:not(:disabled):not(.disabled){
        cursor: not-allowed !important;
    }
    .btn {
        cursor: not-allowed !important;
    } */
    </style>
    <!-- Start Page content -->
    <section class="content" style="margin-left:25px">
        {{--
        <div class="container-fluid"> --}}


            <div class="row" style="margin-top:30px;margin-left:0px">
                <div class="col-12">

                    <div class="box" style="margin-bottom:0px;">
                        <div class="box-header with-border">
                            <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Party Management </h5>
                            </div>

                        </div>

                        <div class="box-body " style="  padding: 30px;">
                            <!-- <input name='range' id='cal' />  -->
                            <div class="row text-center">
                                <div class="col-12">
                                    <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                    <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                        <div style="color:black;font-size:18px;margin-top: 20px;">
                                            <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">Book Party</h5>
                                            <form id="party-booking" method="post" action="">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$booking->id}}">
                                                @if(auth()->user()->hasRole(("super-user")))
                                                <div class="row" style="
    padding: 20px;
">
 <div class="col-4 col-sm-4" style="
    margin-left: 15px;
    margin-right: 30px;
">
<div class="form-group">
  <label for="from_date" style=" font-size: 14px;">Select user<span class="text-danger">*</span></label>
                                            <select name="user" id="user" class="form-control select2"   data-placeholder="Select User" style="margin-top: 5px;padding:10px;    height: 42px;">  
                                            <option value="{{$booking->user->id}}" selected disabled>{{$booking->user->name}} - {{$booking->user->mobile}} 
                                            </option> 
                                           
    </select> 
</div>
</div>

<div class="col-2 col-sm-6" style="
    margin-left: 15px;
">
                                                    <div class="form-group">
                                                        <label for="room" style="
    font-size: 14px;
">User ID </label>
                                                        <input class="form-control" type="text" id="user_id" name="user_id" value="{{$booking->user->userid}}" required="" placeholder="" style="padding:10px;" disabled>
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

                                                <div class="col-2 col-sm-6" style="
    margin-left: 15px;
">
                                                    <div class="form-group">
                                                        <label for="room" style="
    font-size: 14px;
">Mobile Number </label>
                                                        <input class="form-control" type="text" id="mobile_no" name="mobile_no" value="{{$booking->user->mobile}}" required="" placeholder="" style="padding:10px;" disabled>
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>
                                                <div class="col-3 col-sm-6" style="
    margin-left: 15px;
">
                                                    <div class="form-group">
                                                        <label for="room" style="
    font-size: 14px;
">Email Address </label>
                                                        <input class="form-control" type="text" id="email_address" name="email_address" value="{{$booking->user->email}}"  required="" placeholder="" style="padding:10px;" disabled>
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>
</div>
@endif
                                            <div class="row" style="
        padding: 20px;
    ">




                                                    <div class="col-md-3 col-sm-6" style="
        margin-left: 15px;
        margin-right: 15p;
    ">
                                                        <div class="form-group">
                                                            <label for="from_date" style="
        font-size: 14px;
    ">Select Date<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="date" id="from_date" name="from_date" value="<?php echo date('Y-m-d', strtotime($booking->checkin_date)); ?>" requi#d50808="" placeholder="Enter Name" style="padding:10px">
                                                            <span class="text-danger"></span>

                                                        </div>
                                                    </div>

                                                    

                                                    

                                                    <div class="col-md-3 col-sm-6" style="
        font-size: 14px;margin-left:15px
    ">
                                                         <div class="form-group">
                                                        <label for="role">Select Guest type  <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="guest_type" id="guest_type" class="form-control" required="" style="margin-top: 5px;padding:10px;    height: 42px;">
                                                            
                                                            <option value="self" 
                                                            @if($booking->guest_type == "self") selected @endif>Self
                                                            </option>
                                                            <option value="family"  @if($booking->guest_type == "family") selected @endif>Family
                                                            </option>
                                                            <option value="guest"  @if($booking->guest_type == "guest") selected @endif>Guest
                                                            </option>
                                                        </select>
                                                    </div>
                                                    </div> 

                                


    <div class="col-md-3 col-sm-6" style="margin-top: 29px !important;text-align:center;position:relative">
    <span class="party-msg" style="  font-size: 13px;  position: absolute;top: -40px;width: 351px; left: 48px;font-weight: 800; padding: 6px;"></span>
                                                        <div class="form-group">
                                                            <div class="col-12">
                                                                <button class="btn btn-primary btn-sm m-5 check_availability" type="button" style=" padding: 10px; cursor: pointer;padding-left: 30px;padding-right: 30px;">Check Availability</button>
                                                            </div>
                                                        </div>
                                                    </div><div class="col-md-2 col-sm-6" style="margin-top: 29px !important;/* text-align:center; *//* background: green; */;position:relative">
                                                
                                                        <div class="form-group">
                                                            <div class="col-12">
                                    <button class="btn btn-primary btn-sm m-5 book-now" type="button" style="
        padding: 10px;
        padding-left: 30px;
        padding-right: 30px;
        cursor: not-allowed;
        background: #dfdddd;
        border: 1px solid grey;
        /* color: black; */
    ">Book Now</button>
                                                            </div>
                                                        </div>
                                                    </div>
        </form>
                                                </div>
                                        


                                        </div>
                                        <!-- </a> -->
                                    </div>

                                </div>

                            </div>
                            <!-- on boarding  -->


                            <!-- end -->
                        </div>
                         
                    </div>
                </div>

                {{-- </div> --}}
            <!-- container -->


            <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
            <script>

    $(document).ready(function() {
                    // Get current date in Indian Standard Time (IST)
                    var currentDateIST = new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' });
                    console.log('Current IST Date: ' + currentDateIST);

                    // Create a new Date object using the IST date string
                    var currentDate = new Date(currentDateIST);
                    console.log('Current Date Object: ' + currentDate);

                    // Extract date components
                    var year = currentDate.getFullYear();
                    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
                    var day = currentDate.getDate().toString().padStart(2, '0');

                    // Format date as YYYY-MM-DD
                    var currentDateFormatted = year + '-' + month + '-' + day;
                    console.log('Formatted Current Date: ' + currentDateFormatted);

                    // Set min attribute of date inputs to current date in IST
                    $('#from_date').attr('min', currentDateFormatted);
                    // $('#to_date').attr('min', currentDateFormatted);
                    console.log('Min attribute for #from_date and #to_date set to: ' + currentDateFormatted);

                    // Set the default value of the date inputs to current date
                    // $('#from_date').val(currentDateFormatted);
                    // $('#to_date').val(currentDateFormatted);
            
        });
                var search_keyword = '';
                $(function() {
                    $('body').on('click', '.pagination a', function(e) {
                        e.preventDefault();
                        var url = $(this).attr('href');
                        $.get(url, $('#search').serialize(), function(data) {
                            $('#js-types-partial-target').html(data);
                        });
                    });

                    $('#search').on('click', function(e) {
                        e.preventDefault();
                        search_keyword = $('#search_keyword').val();

                        fetch('lawn/fetch?search=' + search_keyword)
                            .then(response => response.text())
                            .then(html => {
                                document.querySelector('#js-types-partial-target').innerHTML = html
                            });
                    });


                });

                $(document).on('click', '.sweet-delete', function(e) {
                    e.preventDefault();

                    let url = $(this).attr('data-url');

                    swal({
                        title: "Are you sure to delete ?",
                        type: "error",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No! Keep it",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {
                            swal.close();

                            $.ajax({
                                url: url,
                                cache: false,
                                success: function(res) {

                                    fetch('lawn/fetch?search=' + search_keyword)
                                        .then(response => response.text())
                                        .then(html => {
                                            document.querySelector('#js-types-partial-target')
                                                .innerHTML = html
                                        });

                                    $.toast({
                                        heading: '',
                                        text: res,
                                        position: 'top-right',
                                        loaderBg: '#ff6849',
                                        icon: 'success',
                                        hideAfter: 5000,
                                        stack: 1
                                    });
                                }
                            });
                        }
                    });
                });
                var dates = [];
    $(document).ready(function() {
    $("#cal").daterangepicker();
    $("#cal").on('apply.daterangepicker', function(e, picker) {
        e.preventDefault();
        const obj = {
        "key": dates.length + 1,
        "start": picker.startDate.format('MM/DD/YYYY'),
        "end": picker.endDate.format('MM/DD/YYYY')
        }
        dates.push(obj);
        showDates();
    })
    $(".remove").on('click', function() {
        removeDate($(this).attr('key'));
    })
    })
    function showDates() {
    $("#ranges").html("");
    $.each(dates, function() {
        const el = "<li>" + this.start + "-" + this.end + "<button class='remove' onClick='removeDate(" + this.key + ")'>-</button></li>";
        $("#ranges").append(el);
    })
    }
    function removeDate(i) {
    dates = dates.filter(function(o) {
        return o.key !== i;
    })
    showDates();
    }

    $('#from_date').on('change', function() {
        $(".book-now").removeClass("active");
                        $(".party-msg").removeClass("active");
                        $(".party-msg").html('');
                    $(".party-msg").removeClass("error");
    });
    $('.check_availability').on('click', function(e) {
                var from_date =  $("#from_date").val(); 
                var guest_type =  $("#guest_type").val();
                if(from_date == "")
                {
                        $(".book-now").removeClass("active");
                        $(".party-msg").addClass("error");
                        $(".party-msg").html("Please select the Date");
                        $(".party-msg").removeClass("active");
                } 
                else if(guest_type == "" || guest_type === null)
                {
                    $(".book-now").removeClass("active");
                    $(".party-msg").addClass("error");
                    $(".party-msg").html("Please select the Date");
                    $(".party-msg").removeClass("active");
                    $(".party-msg").html("Please select the Guest Type");
                }
                else{
                    let url = "{{url('/')}}/lawn/check-availability";
                    var form_data = new FormData($("#party-booking")[0]);
                    $.ajax({
                                url: url,
                                type:'post',
                                data: form_data,
                                cache: false,
                                contentType:false, // Default for form submissions
                                processData: false, // Tells jQuery to process the data (default: true)
                                success: function(res) { 
                                    console.log(res.status);
                                    if(res.status)
                                    {
                                        $(".book-now").addClass("active");
                                        $(".party-msg").removeClass("error");
                                        $(".party-msg").addClass("active");
                                        $(".party-msg").html(res.message);
                                    }
                                    else{
                                        $(".book-now").removeClass("active");
                                        $(".party-msg").addClass("error");
                                        $(".party-msg").removeClass("active");
                                        $(".party-msg").html(res.message);
                                    }
                                }
                    }); 
                } 
                });
                $(".book-now").click(function(){
                let url = "{{url('/')}}/lawn/book-now";
                var form_data = new FormData($("#party-booking")[0]);
                $(".book-now").addClass("active");
                $.ajax({
                            url: url,
                            type:'post',
                            data: form_data,
                            cache: false,
                            contentType:false, // Default for form submissions
                            processData: false, // Tells jQuery to process the data (default: true)
                            success: function(res) { 
                                if(res.status)
                                {
                                    $(".book-now").removeClass("active");
                                    popup_init();
                                popup_data(`<div class="popup-card"> 
                                    <div class="popup-card-content" style="  text-align: center;"> 
                                        <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                                    <h4 style=" font-weight: 600;">Booking Confirmed Successfully</h4>
                                        <a class="btn btn-success" style="font-size:16px;margin: auto;margin-top: 20px;" href="#">Close</a>
                                    </div>
                                    </div>
                                `);
                                setTimeout(function() {
                                    window.location.assign('{{url("/")}}/lawn');
                                    }, 1000);
                                }
                                else{
                                    $(".book-now").removeClass("active");
                                    $(".danger-book").addClass("error");
                                    $(".danger-book").removeClass("active");
                                    $(".danger-book").html(res.message);
                                }
                            }
                        });
                    }); 
                    $('#user').on('change', function() {
                    var url = "{{url('/')}}/get-user-details";
                    var data = $(this).val();   
                    $.ajax({
                            url: url,
                            data: {data:data},
                            cache: false,
                            success: function(res) {
                                if(res.status)
                                {
                                    $("#user_id").val(res.user.userid);
                                    $("#mobile_no").val(res.user.mobile);
                                    $("#email_address").val(res.user.email);
                                }
                            }
                        });
                });
            </script>


            @endsection 