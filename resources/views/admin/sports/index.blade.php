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
        .col-md-3 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 25%;
    flex: 0 0 23% !important;
    max-width: 50%;
}
.col-1, .col-2, .col-md-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col, .col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm, .col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md, .col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg, .col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl, .col-xl-auto {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 0px !important;
    padding-left: 0px !important;
}

.col-2 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667% !important;
}
table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }
        tbody#tariff tr td {
            border: 1px solid #d1d1d1;
            padding: 10px;
            text-align: center;
            width: 33.33%; /* Ensure equal width */
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
.party-msg.error{
    background: #ffdada;
    color: red;
}
.book-now{
    padding: 10px;
    padding-left: 30px;
    padding-right: 30px;
    cursor: not-allowed;
    background:#0FBED2 !important;
    color:black;
}
span.party-msg.pull-right.active {
    background: #aaf6aa;
    color: green;
}
    button.btn.btn-primary.btn-sm.m-5.book-now.active {
        cursor: pointer !important;
    }
    .skin-blue-light .sidebar-menu .treeview-menu>li.active>a, .skin-blue-light .sidebar-menu .treeview-menu>li>a:hover {
    color: #898937 !important;
}
.alert-success, .callout.callout-success, .label-success, .modal-success .modal-body{
    background-color: #0FBED2 !important;
}
    button.btn.btn-primary.btn-sm.m-5.book-now.active {
        cursor: pointer !important;
    }
    .btn-primary {
    background-color: #0FBED2 !important;
    border-color: #0FBED2 !important;
    color: var(--btn_text);
}
.skin-blue-light .main-header .navbar {
    background-color: #0FBED2 !important;
    /* background-color: #fff; */
}
.skin-blue-light .sidebar-menu>li.active>a {
    border-left-color: #0FBED2 !important;
}
.btn-primary {
    background-color: var(--btn_color);
    border-color: var(--btn_color);
    color: white !important;
}
.label{
    color:white !important;
}

.skin-blue-light .sidebar-menu>li.active>a, .skin-blue-light .sidebar-menu>li.menu-open>a {
    color: white !important;
    background: #0FBED2 !important;
}
.sidebar-menu>li.active>a>i, .sidebar-menu>li:hover>a>i, .sidebar-menu>li.menu-open>a>i{
    color: white !important;
}
.btn-outline.btn-success {
    color: white;
    background-color: #0FBED2;
    border-color: #0FBED2;
}
.btn-outline.btn-success:hover {
    color: white;
    background-color: #0FBED2;
    border-color: #0FBED2;
}
@media (max-width: 1000px) {
    .col-sm-6 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50% !important;
        max-width: 50% !important;
    }
}
.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    padding: 11px 12px;
    height: 43px;
}
span#select2-user-container {
    font-size: 14px;
}
.col-3 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 25%;
    flex: 0 0 23% !important;
    max-width: 50%;
}
</style>
<!-- Start Page content -->
<section class="content" style="margin-left:25px">
    {{--
    <div class="container-fluid"> --}}


        <div class="row" style="margin-top:30px;margin-left:0px">
            <div class="col-12">

                <div class="box" style="padding: 15px 0px 15px 20px;">
                    <div class="box-header with-border">
                        <div style="color:black;font-size:18px">
                            <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Sports Management </h5>
                        </div>

                    </div>

                    <div class="box-body " style="padding: 30px;">
                        <!-- <input name='range' id='cal' />  -->
                        <div class="row text-center">
                            <div class="col-12">
                            <form id="sports-booking" method="post" action="">
                                @csrf
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 20px !important;padding-bottom: 20px !important;background: #fff !important;">
                                    <div style="color:black;font-size:18px;margin-top: 20px;">
                                        <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">Book a Sport</h5>
                                        @if(auth()->user()->hasRole(("super-user")))
                                                <div class="row" style="
    padding: 10px;
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
    padding: 20px 20px 0px 0px;
    width: 100%;
    margin-left: 5px;
">




                                                <div class="col-md-2 col-sm-12" style="
    font-size: 14px;
">
                                                    <div class="form-group">
                                                        <label for="role">Subscription Type<span class="text-danger">*</span>
                                                        </label>
                                                        <select name="subscription_type" id="subscription_type" class="form-control" required="" style="
    margin-top: 5px;
    /* padding-right: 89px; */
">
                                                        
                                                            <option value="daily" selected="">Daily
                                                            </option>
                                                            <option value="monthly">Monthly
                                                            </option>
                                                            <option value="yearly">Yearly
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-6" style="
    margin-left: 15px;
    padding-right: 10px !important;
">
                                                    <div class="form-group">
                                                        <label for="day" id="day-label" style="
    font-size: 14px;
">No of Days<span class="text-danger">*</span></label>
                                                        <input class="form-control" type="number" id="day" name="day" value="1" required="" placeholder="">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>
                                                


                                                
                                                
                                                <div class="col-md-3 col-sm-6" style="
    /* margin-left: 15px; */
    margin-right: 15p;
">
                                                    <div class="form-group">
                                                        <label for="from_date" style="
    font-size: 14px;
">From Date<span class="text-danger">*</span></label>
                                                        <input class="form-control from_date" type="date" id="from_date" name="from_date" value="" required="" placeholder="Enter Name" style="
    border-right&quot;: n&quot;;
    border-right&quot;: inherit&quot;;
    border-right&quot;: n&quot;;
    border-right: none;
    border-bottom-right-radius: 0% !important;
    border-top-right-radius: 0% !important;
    padding: 0px 7px;
" min="2024-06-06">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-sm-6" style="
    padding-right: 20px !important;
    /* margin-right: 15px; */
">
                                                    <div class="form-group">
                                                        <label for="to_date" style="
    font-size: 14px;
">To date<span class="text-danger">*</span></label>
                                                        <input class="form-control to_date" type="date" id="to_date" name="to_date" value="" required="" placeholder="Enter Name" style="
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    padding: 0px 7px;
" disabled="" min="2024-06-06">
                                                        <span class="text-danger"></span>

                                                    </div>
                                                </div>

<div class="col-md-2 col-sm-6" style="
    /* margin-left: 15px; */
    /* padding-right: 20px !important; */
"> <label for="day" id="day-label" style="
    font-size: 14px;
">Guest Type<span class="text-danger">*</span></label>
                                                <select name="guest_type" id="guest_type" class="form-control" requi#d50808="" style="padding:7px;"> 
                                                                <option value="self" selected>Self
                                                                </option>
                                                                <option value="family">Family
                                                                </option>
                                                                <option value="guest">Guest
                                                                </option>
                                                            </select>
                                                </div>



                                      
                                            </div>
                                            <div>
                                                <input type="hidden" id="total-amount" name="total_amount" value="">
                                                <input type="hidden" id="to-date1" name="to_date" value="2024-06-07">
                                            </div>

  
                                    </div>
                 

                                    
                                    <div class="table-container" style="
    margin: 0px 40px 20px 7px;
">
    <table>
        
        <tbody id="tariff">
            @foreach($sports_tariff as $key=>$value)
                        <tr>
                <td> {{$value->name}}</td>
                <td><string>₹{{$value->daily_tariff}}</string></td>
                <td class="checkbox-cell"><input type="checkbox" id="checkbox1" name="name[]" class="check-tariff" data-val="{{$value->daily_tariff}}" value="{{$value->id}}"></td>
            </tr>
             @endforeach
            <tr class="total" style="
    border: none !important;
    margin-top: 20px;
">
                <td style="
    font-size: 17px;
">Total Amount</td>
                <td><strong style="
    font-weight: 600;
    font-size: 25px;
" id="total-amount1">₹0</strong></td>
                <td class="checkbox-cell"></td>
            </tr>
           
        </tbody>
    </table>
</div>
                                    <!-- </a> -->

                                    <div class="col-md-12" style="
    padding-right: 50px !important;
">
                                                    <div class="form-group">
                                                        <div class="col-12">
                                                            <button class="btn btn-sm pull-right m-5 book-now" type="button" style="
    padding: 10px;
    cursor: pointer;
    padding-left:30px;padding-right:30px;
">Book Now</button>
<span class="party-msg pull-right"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                </div>
                                </form>
                            </div>

                        </div>
                        <!-- on boarding  -->


                        <!-- end -->
                    </div>
                    <div style="color:black;font-size:18px">
                        <h5 class="font-weight-600 p-5" style="color:black;font-size: 17px;padding-left: 20px !important;">My Bookings </h5>
                    </div>
                    <div class="box">

                        <div class="box-header with-border">
                            <div class="row text-right">
                                <div class="col-8 col-md-3">
                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="text" id="search_keyword" name="search" class="form-control" placeholder="@lang('view_pages.enter_keyword')">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 col-md-2 text-left">
                                    <button id="search" class="btn btn-success btn-outline btn-sm py-2" type="button">
                                        @lang('view_pages.search')
                                    </button>
                                </div>

 
                                <!-- </form> -->
                            </div>

                        </div>

                        <div class="row text-center" style="
    width: 97%;
    padding: 10px 20px 20px 20px;
    background-color: white;
    margin-left: 5px;
"> 
  <div id="js-types-partial-target" style=" width: 100%;">
                                <include-fragment src="sports/fetch">
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
            $('#guest_type').on('change', function() {
                if($(this).val() == "guest")
                {
                    $(".book-now").removeClass("active");
                $(".party-msg").addClass("active");
                $(".party-msg").html('Please note that Guest cannot use facilities alone unless accompanied by the booking officer.');
                $(".party-msg").removeClass("error");
                }
                else{   
                     $(".book-now").removeClass("active");
                $(".party-msg").removeClass("active");
                $(".party-msg").html('');
                $(".party-msg").removeClass("error");
                }
        
    });
    var totalAmountElement = document.getElementById('total-amount1');
    var checkboxes = document.querySelectorAll('.check-tariff');
    var prices = 0;
    var total_amount = 0;
            function updateTotalAmount() { 
            //    console.log("sfsfsddfdsffffffffffff");
        let totalAmount = 0;
        prices = 0;
        console.log(prices);
        console.log(totalAmount);
        
        checkboxes.forEach(checkbox => {
            // alert("sdsfsfs");
            // console.log(checkbox);
            if (checkbox.checked) {
                console.log(checkbox.getAttribute('data-val'));
                totalAmount += parseInt(checkbox.getAttribute('data-val'), 10);
            }
        }); 
        console.log(prices);
        if($("#day").val() == "")
        {
            var day = 0; 
        }
        else{
            var day = parseInt($("#day").val());
        }
        prices = totalAmount * day; 
        $("#total-amount").val(prices);  
        totalAmountElement.textContent = `₹${prices}`;
    }
function attachCheckboxListeners() {
    console.log("dfsdfsfsf");
        var checkboxes = document.querySelectorAll('.check-tariff');
        checkboxes.forEach(checkbox => {
            // console.log("fdsfsdfsdfsdfffffffff");
            checkbox.addEventListener('change', updateTotalAmount);
        });
    }
            var currentDate;
            var currentDateFormatted,nextDayDateFormatted;
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
    currentDateFormatted = year + '-' + month + '-' + day;
    console.log('Formatted Current Date: ' + currentDateFormatted);

    // Set min attribute of date inputs to current date in IST
    $('#from_date').attr('min', currentDateFormatted);
    $('#to_date').attr('min', currentDateFormatted); 
    $('#to-date1').attr('min', currentDateFormatted); 
    console.log('Min attribute for #from_date and #to_date set to: ' + currentDateFormatted);

    // Set the default value of the date inputs to current date
    
    var nextDayDate = new Date(currentDate);
                nextDayDate.setDate(nextDayDate.getDate() + 1);

                // Extract date components for the next day date
                var nextYear = nextDayDate.getFullYear();
                var nextMonth = (nextDayDate.getMonth() + 1).toString().padStart(2, '0');
                var nextDay = nextDayDate.getDate().toString().padStart(2, '0');

                // Format date as YYYY-MM-DD
                nextDayDateFormatted = nextYear + '-' + nextMonth + '-' + nextDay;
                console.log('Formatted Next Day Date: ' + nextDayDateFormatted);

                // Set the default value of the to_date input to the next day date
                $('#from_date').val(nextDayDateFormatted);
                $('#to_date').val(nextDayDateFormatted);
                $('#to-date1').val(nextDayDateFormatted); 
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalAmount);
    });
    
     // Function to attach event listeners to checkboxes
     
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

                    fetch('sports/fetch?search=' + search_keyword)
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

                                fetch('sports/fetch?search=' + search_keyword)
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



$('#day').on('keyup', function(e) {
		var yearInput = $('#day').val();
        // if(yearInput == "")
        // {
        //     yearInput = 1;
        //     this.value = 1;
        // } 

        var isValid = true;
        var errorMessage = '';

       
		if (this.value.length > 3) {
            this.value = this.value.slice(0, 3); // Limit to 10 digits
			yearInput = this.value;
        } 
		 
        // Check if the input is not greater than the current year
        if (parseInt(yearInput) > 100) {
			this.value = 100;
            isValid = true;
            // errorMessage = 'Year cannot be greater than the current year.';
        }

        if (isValid) {
            // alert('Year is valid!');
            $('#error-message').hide();
			// $(this).submit();
            // Here you can add code to handle the valid input, e.g., submit the form via AJAX
        } else {

            $('#error-message').text(errorMessage).show();
        }
        var day = $(this).val(); 
        if($(this).val() == "")
        {
           var day = 0; 
        }
       updateTotalAmount();
        // alert("dgdgdg");
		calculate_price();
		}); 

        $("#from_date").change(function(){
            from_date = $(this).val();
            currentDate = new Date(from_date.split('/').reverse().join('-')); 
            currentDate.setDate(currentDate.getDate() - 1); 
            calculate_price();
        });

        $("#to_date").change(function(){
            calculate_price();
        });

        $("#subscription_type").change(function(){ 
            console.log("nextDayDateFormatted");
            console.log(nextDayDateFormatted);
            $('#from_date').attr('min', nextDayDateFormatted);
            $('#from_date').val(nextDayDateFormatted);
            var currentDateIST = new Date().toLocaleString('en-US', { timeZone: 'Asia/Kolkata' });
            console.log('Current IST Date: ' + currentDateIST); 
            // Create a new Date object using the IST date string
            currentDate = new Date(currentDateIST); 
            calculate_price(true);
        });
        // $("#day").keyup(function(){
        //     calculate_price();
        // });

        function calculate_price(subscriction_type_action = false){

            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var subscription_type = $("#subscription_type").val();
            var day = $("#day").val();
            // alert(day);
            var row_data = "";  
            @foreach($sports_tariff as $key=>$value)
            console.log('{{$value->id}}');
            if(subscription_type == "daily")
            {
                $("#day-label").html('No of Days <span class="text-danger">*</span>');
                var price = '{{$value->daily_tariff}}';

                var nextDayDate = new Date(currentDate);
                nextDayDate.setDate(nextDayDate.getDate() + parseInt(day));

                // Extract date components for the next day date
                var nextYear = nextDayDate.getFullYear();
                var nextMonth = (nextDayDate.getMonth() + 1).toString().padStart(2, '0');
                var nextDay = nextDayDate.getDate().toString().padStart(2, '0');

                // Format date as YYYY-MM-DD
                var nextDayDateFormatted = nextYear + '-' + nextMonth + '-' + nextDay;
                console.log('Formatted Next Day Date: ' + nextDayDateFormatted);

                // Set the default value of the to_date input to the next day date
                $('#to_date').val(nextDayDateFormatted);
                $('#to-date1').val(nextDayDateFormatted);

            }
            if(subscription_type == "monthly")
            {
                $("#day-label").html('No of Month <span class="text-danger">*</span>');
                var price = '{{$value->mothly_tariff}}';

                var nextMonthDate = new Date(currentDate);
                nextMonthDate.setMonth(nextMonthDate.getMonth() + parseInt(day));

                // Handle year change if the new date is in the next year
                if (nextMonthDate.getMonth() < currentDate.getMonth()) {
                    nextMonthDate.setFullYear(currentDate.getFullYear() + 1);
                }

                // Extract date components for the next month date
                var nextYear = nextMonthDate.getFullYear();
                var nextMonth = (nextMonthDate.getMonth() + 1).toString().padStart(2, '0');
                var nextDay = nextMonthDate.getDate().toString().padStart(2, '0');

                // Format date as YYYY-MM-DD
                var nextMonthDateFormatted = nextYear + '-' + nextMonth + '-' + nextDay;
                console.log('Formatted Next Month Date: ' + nextMonthDateFormatted);

                // Set the default value of the to_date input to the next month date
                $('#to_date').val(nextMonthDateFormatted);
                $('#to-date1').val(nextMonthDateFormatted);
            }
            if(subscription_type == "yearly")
            {
                $("#day-label").html('No of Year <span class="text-danger">*</span>');
                var price = '{{$value->yearly_tariff}}';
                var nextYearDate = new Date(currentDate);
                nextYearDate.setFullYear(nextYearDate.getFullYear() + parseInt(day));

                // Extract date components for the next year date
                var nextYear = nextYearDate.getFullYear();
                var nextMonth = (nextYearDate.getMonth() + 1).toString().padStart(2, '0');
                var nextDay = nextYearDate.getDate().toString().padStart(2, '0');

                // Format date as YYYY-MM-DD
                var nextYearDateFormatted = nextYear + '-' + nextMonth + '-' + nextDay;
                console.log('Formatted Next Year Date: ' + nextYearDateFormatted);

                // Set the default value of the to_date input to the next year date
                $('#to_date').val(nextYearDateFormatted);
                $('#to-date1').val(nextYearDateFormatted);

            }
            if(price > 0)
            {
                row_data+= `<tr>
                <td> {{$value->name}}</td>
                <td><string>₹${price}</string></td>
                <td class="checkbox-cell"><input type="checkbox" name="name[]" id="checkbox1" class="check-tariff" data-val="${price}" value="{{$value->id}}"></td>
            </tr>`;
            }
           
            @endforeach 
            row_data += `<tr class="total" style="
    border: none !important;
    margin-top: 20px;
">
                <td style="
    font-size: 17px;
">Total Amount</td>
                <td><strong style="
    font-weight: 600;
    font-size: 25px;
" id="total-amount1">₹0</strong></td>
                <td class="checkbox-cell"></td>
            </tr>`;
            if (subscriction_type_action) {
                $("#tariff").html(row_data); 
                $('.check-tariff').prop('checked', false);
                checkboxes = document.querySelectorAll('.check-tariff');
                totalAmountElement = document.getElementById('total-amount1'); 
                attachCheckboxListeners(); 
            }  

        }
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
                    let url = "{{url('/')}}/sports/check-availability";
                    var form_data = new FormData($("#lawn-booking")[0]);
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
                let url = "{{url('/')}}/sports/book-now";
                var form_data = new FormData($("#sports-booking")[0]);
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
                                popup_data(`<div class="popup-card"> 
                                    <div class="popup-card-content" style="  text-align: center;"> 
                                        <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                                    <h4 style=" font-weight: 600;">Booking Confirmed Successfully</h4>
                                        <a class="btn btn-success" style="font-size:16px;margin: auto;margin-top: 20px;" href="#">Close</a>
                                    </div>
                                    </div>
                                `);
                                setTimeout(function() {
                                    window.location.reload();
                                    }, 1500);
                                }
                                else{
                                    $(".book-now").removeClass("active");
                                    $(".party-msg").addClass("error");
                                    $(".party-msg").removeClass("active");
                                    $(".party-msg").html(res.message);
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