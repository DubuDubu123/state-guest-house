@extends('admin.layouts.app') @section('title', 'Main page') @section('content')
<style>
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
span.danger-book.pull-right {
    position: relative;
    top: 10px;
    right: 100px;
    font-size: 15px;
    
    padding: 5px;
    
    font-weight: 600;
    padding-left: 30px;
    padding-right: 30px;
}
.danger-book.error{
    background: #ffdada;
    color: red;
}
span.danger-book.pull-right.active {
    background: #aaf6aa;
    color: green;
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
    background:#86BEBD !important;
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
    .check_availabiity.spinner {
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
table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }
        tbody#tariff tr td {
            border: 1px solid #d1d1d1;
            padding: 5px 10px 5px 10px;
            text-align: center;
            width: 33.33%; /* Ensure equal width */
            font-size:15px;
        }
        thead tr td {
            border: 1px solid #d1d1d1;
            padding: 5px 10px 5px 10px;
            text-align: center;
            width: 33.33%; /* Ensure equal width */
            font-size:15px;
        }
        /* th {
            background-color: #f2f2f2;
        } */
        .checkbox-cell {
            text-align: center;
        }
        [type="checkbox"]:checked, [type="checkbox"]:not(:checked){
            position: relative !important;
    opacity: 1 !important;
    left: 0px;
    transform: scale(1.5); /* Make checkbox larger */
            -webkit-transform: scale(1.5); /* Safari and Chrome */
            -moz-transform: scale(1.5); /* Firefox */
            -o-transform: scale(1.5); /* Opera */
            -ms-transform: scale(1.5); /* IE 9 */

        }
        tr.total td{
                border:none;
        }
        span.party-msg.pull-right {
    position: relative;
    top: 10px;
    right: 100px;
    font-size: 15px;
    
    padding: 5px;
    
    font-weight: 600;
    padding-left: 30px;
    padding-right: 30px;
}
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
                            <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Room Management </h5>
                        </div>

                    </div>

                    <div class="box-body " style=" padding: 30px;">
                        <!-- <input name='range' id='cal' />  -->
                        <div class="row text-center">
                            <div class="col-12">
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;padding-bottom: 25px !important;background: #fff !important;">
                                    <div style="color:black;font-size:18px;margin-top: 20px;">
                                        <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">Book your Room</h5> 
                                        <form id="room-booking" method="post" action="">
                                            @csrf
                                            @if(auth()->user()->hasRole('super-user')) 
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
                                            <option value="" selected >Arun</option>
                                                @foreach($user as $key=>$value)
                                                <option value="{{$value->id}}" >{{$value->name}} - {{$value->mobile}}</option>
                                                @endforeach
                                           
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
                                                        <input class="form-control" type="text" id="user_id" name="user_id" value="" required="" placeholder="" style="padding:10px;" disabled>
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
                                                        <input class="form-control" type="text" id="mobile_no" name="mobile_no" value="" required="" placeholder="" style="padding:10px;" disabled>
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
                                                        <input class="form-control" type="text" id="email_address" name="email_address" value="" required="" placeholder="" style="padding:10px;" disabled>
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>
</div>
@endif
                                            <div class="row" style="
    padding: 20px;
">
 

                                                <div class="col-3 col-sm-6" style="
    margin-left: 15px;
    margin-right: 15p;
">
                                                    <div class="form-group">
                                                        <label for="from_date" style="
    font-size: 14px;
">Check-IN <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" id="from_date" name="from_date" value="" required="" placeholder="" style="
    border-right&quot;: n&quot;;  border-right&quot;: inherit&quot;;  border-right&quot;: n&quot;;   border-right: none; border-bottom-right-radius: 0% !important;  border-top-right-radius: 0% !important;padding:10px !important;">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

                                                <div class="col-3 col-sm-6" style="
    /* padding-right: 20px; */
    margin-right: 15px;
">
                                                    <div class="form-group">
                                                        <label for="to_date" style="
    font-size: 14px;
">Check-OUT <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="date" id="to_date" name="to_date" value="" required="" placeholder="Enter Name" style="
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;padding:10px;
">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

                                                <div class="col-2 col-sm-6" style="
    margin-left: 15px;
">
                                                    <div class="form-group">
                                                        <label for="room" style="
    font-size: 14px;
">No of Room <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="number" id="room" name="room" value="" required="" placeholder="" style="padding:10px;">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>
                                                
                                                <div class="col-2 col-sm-6" style="
    margin-left: 15px;
:
    auto;
    margin-right: 15px;
">
                                                    <div class="form-group">
                                                        <label for="guest" style="
    font-size: 14px;
">No of Guest <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="number" id="guest" name="guest" value="" required="" placeholder="" style="padding:10px">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

                                                <!-- <div class="col-2 col-sm-11" style="
    font-size: 14px;
">
                                                    <div class="form-group">
                                                        <label for="role">Select Guest type  <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="guest_type" id="guest_type" class="form-control" required="" style="margin-top: 5px;padding:10px;    height: 42px;">
                                                            <option value="" selected="" disabled="">Select Guest</option>
                                                            <option value="self">Self
                                                            </option>
                                                            <option value="family">Family
                                                            </option>
                                                            <option value="guest">Guest
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> -->

                                                <div class="table-container col-md-6" style="
    margin: 0px 40px 20px 7px;
">
    <table id ="room-tariff">
       
    </table>
</div>

                                                <div class="col-md-12" style="
    padding-right: 30px !important;
">
                                                    <div class="form-group">
                                                        <div class="col-12">
                                                            
                                                            <button class="btn btn-primary btn-sm pull-right m-5 check_availabiity" type="button" style="
    padding: 10px;
    cursor: pointer;
">Check Availability</button>
<button class="btn pull-right btn-sm m-5 book-now " type="button" disabled>Book Now</button>
<span class="danger-book pull-right"></span>
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
                    <div style="color:black;font-size:18px">
                        <h5 class="font-weight-600 p-5" style="color:black;font-size: 17px;padding-left: 20px !important;">My Bookings </h5>
                    </div>
                    <div class="box" style="padding:15px">

                        <div class="box-header with-border">
                            <div class="row text-right">
                                <div class="col-8 col-md-3" style="margin-right:20px">
                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="text" id="search_keyword" name="search" class="form-control" placeholder="@lang('view_pages.enter_keyword')">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 col-md-2 text-left">
                                    <button id="search" class="btn btn-success btn-outline btn-sm py-2" type="submit">
                                        @lang('view_pages.search')
                                    </button>
                                </div> 
                            </div>

                        </div>

                        <div class="row text-center" style="
    width: 97%;
    padding: 10px 20px 20px 20px;
    background-color: white;
    margin-left: 5px;
">

                            <div id="js-types-partial-target" style=" width: 100%;">
                                <include-fragment src="types/fetch">
                            <span style="text-align: center;font-weight: bold;"> @lang('view_pages.loading')</span>
                            </include-fragment> 
                            </div> 
                        </div>

                    </div>
                </div>
            </div>

            {{-- </div> --}}
        <!-- container -->


        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
            // alert("fdggdfgdfg");
            var currentDate;
                $(document).ready(function() {
                // Get current date in Indian Standard Time (IST)
                var currentDateIST = new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' });
                console.log('Current IST Date: ' + currentDateIST);

                // Create a new Date object using the IST date string
                 currentDate = new Date(currentDateIST);
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
                $('#to_date').attr('min', currentDateFormatted);
                console.log('Min attribute for #from_date and #to_date set to: ' + currentDateFormatted);

                // Set the default value of the date inputs to current date
                // $('#from_date').val(currentDateFormatted);
                // $('#to_date').val(currentDateFormatted);
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
                $('#from_date').on('change', function() {
                    from_date = $(this).val();
                    currentDate = new Date(from_date.split('/').reverse().join('-')); 
                    var nextDayDate = new Date(currentDate);
                    nextDayDate.setDate(nextDayDate.getDate() + 1);

                    // Extract date components for the next day date
                    var nextYear = nextDayDate.getFullYear();
                    var nextMonth = (nextDayDate.getMonth() + 1).toString().padStart(2, '0');
                    var nextDay = nextDayDate.getDate().toString().padStart(2, '0');

                    // Format date as YYYY-MM-DD
                    var nextDayDateFormatted = nextYear + '-' + nextMonth + '-' + nextDay;
                    console.log('Formatted Next Day Date: ' + nextDayDateFormatted);

                    // Set the default value of the to_date input to the next day date 
                    $('#to_date').attr('min', nextDayDateFormatted);
                    $(".book-now").removeClass("active");
                    $(".danger-book").removeClass("active");
                    $(".danger-book").html('');
                    $(".danger-book").removeClass("error");
                    $('#to_date').val('');
                    });
                    $('#to_date').on('change', function() {
                    var checkinDate = $(this).val();

                    $('#from_date').attr('max', checkinDate);
                    $(".book-now").removeClass("active");
                     $(".danger-book").removeClass("active");
                     $(".danger-book").html('');
                $(".danger-book").removeClass("error");
                    });
                    $('#room').on('keyup', function(e) {
                        $(".book-now").removeClass("active");
                        $(".danger-book").removeClass("active");
                        $(".danger-book").removeClass("error");
                        $(".danger-book").html('');
                        const numRooms = parseInt(e.target.value, 10);
                        if (numRooms > 8) { 
                            e.target.value = 8;
                        }
                    });
            });

            $(".book-now").click(function(){
                let url = "{{url('/')}}/types/book-now";
                $(".book-now").addClass("spinner");
                var form_data = new FormData($("#room-booking")[0]);
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
                                    popup_init();
                                popup_data(` 
                                <div class="popup-card"> 
                                    <div class="popup-card-content" style="
    text-align: center;
"> 
                                        <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                                        <h4 style="
    font-weight: 600;
">${res.message}</h4>
                                        <a class="btn btn-success" style="font-size:16px;margin: auto;margin-top: 20px;" href="#">Close</a>
                                    </div>
                                    </div>
                                `);
                                setTimeout(function() {
                                    window.location.reload();
                                    }, 2000);
                                }
                                else{
                                    $(".book-now").removeClass("spinner");
                                    $(".book-now").removeClass("active");
                                    $(".danger-book").addClass("error");
                                    $(".danger-book").removeClass("active");
                                    $(".danger-book").html(res.message);
                                }
                            }
                        });
                    }); 
            $('.check_availabiity').on('click', function(e) {
               var from_date =  $("#from_date").val();
               var to_date =  $("#to_date").val();
               var room =  $("#room").val();
               var guest =  $("#guest").val();
               var guest_type =  $("#guest_type").val();
               var user =  $("#user").val(); 
               $(".check_availabiity").addClass("spinner");
               if(from_date == "" || to_date == "")
               {
                $(".check_availabiity").removeClass("spinner");
                $(".danger-book").addClass("error");
                   $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select Check In and Check Out date");
               }
               else if(room == "")
               {
                $(".check_availabiity").removeClass("spinner");
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select No of Rooms");
               }
            //    else if(user == "")
            //    {
            //     $(".danger-book").addClass("error");
            //     $(".danger-book").removeClass("active");
            //     $(".danger-book").html("Please Select Users");
            //    }
               else if(guest == "")
               {
                $(".check_availabiity").removeClass("spinner");
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Enter the Guest Count");
               }
            //    else if(guest_type == "" || guest_type === null)
            //    {
            //     $(".check_availabiity").removeClass("spinner");
            //     $(".danger-book").addClass("error");
            //     $(".danger-book").removeClass("active");
            //     $(".danger-book").html("Please Select the Guest Type");
            //    }
               else{
                var status = true; 
                @if(auth()->user()->hasrole("super-user"))
                // alert("dfdfgfg");
                if(user == "")
               {
                $(".check_availabiity").removeClass("spinner");
                status = false;
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select Users");
               } 
                @endif
                if(status)
                {
                    let url = "{{url('/')}}/types/check-availability";
                var form_data = new FormData($("#room-booking")[0]);
                $.ajax({
                            url: url,
                            type:'post',
                            data: form_data,
                            cache: false,
                            contentType:false, // Default for form submissions
                            processData: false, // Tells jQuery to process the data (default: true)
                            success: function(res) { 
                                $(".check_availabiity").removeClass("spinner");
                                if(res.status)
                                {
                                    var html_data = ` <thead> 
                                    <tr>
                                                <td> Room</td>
                                    
                                                <td> Select Guest Type</td>
                                    </tr> 
                                        </thead> 
                                        <tbody id="tariff">`;
                                        for(var i=1;i<=room;i++)
                                        {
                                            html_data+=`  <tr>
                                                <td> ${i}</td>
                                                <td>
                                                <select name="guest_type[${i}]" class="form-control" required="" style="padding:10px;height: 40px;"> 
                                                    <option value="self" selected>Self
                                                    </option>
                                                    <option value="family">Family
                                                    </option>
                                                    <option value="guest">Guest
                                                    </option>
                                                </select> 
                                                </td> 
                                            </tr>`;
                                        }
                                html_data+= `</tbody>`;
                                $("#room-tariff").html(html_data);
                                $(".book-now").addClass("active");
                                $(".book-now").attr("disabled",false);
                                $(".danger-book").removeClass("error");
                                $(".danger-book").addClass("active");
                                $(".danger-book").html(res.message);
                                }
                                else{
                                    $(".book-now").attr("disabled",true);
                                    $(".book-now").removeClass("active");
                                    $(".danger-book").addClass("error");
                                    $(".danger-book").removeClass("active");
                                    $(".danger-book").html(res.message);
                                } 
                            }
                }); 
                }
               
              
                
               }
              
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

                    fetch('types/fetch?search=' + search_keyword)
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

                                fetch('types/fetch?search=' + search_keyword)
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
        </script>


        @endsection 