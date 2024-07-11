@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')
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
    </style>
    <!-- Start Page content -->
    <section class="content" style="margin-left:25px">
        {{-- <div class="container-fluid"> --}}


        <div class="row" style="margin-top:30px;margin-left:0px">
            <div class="col-12"> 
                
            <div class="box" style="margin-bottom:0px;">
                            <div class="box-header with-border">
                                <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Room Management </h5>  
                                </div>

                            </div>

                            <div class="box-body ">
                            <input name='range' id='cal' /> 
                                <div class="row text-center">
                                <div class="col-12">
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <div style="color:black;font-size:18px;margin-top: 20px;">
                                <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">Book your Room</h5>
                                <div class="row">
<div class="col-md-6 col-12" id="cal" style="
    border: 1px solid #d1d1d1;
    position: relative;
    /* max-width: 367px; */
    display: grid;
    grid-auto-flow: column;
    cursor: pointer;
    padding-top:3px;
    margin-right: 10px;margin-top:20px;
">
<div style="
    display: flex;
    width: 220px;
    position: relative;
"><input type="text" id="from-date" readonly="" value="24th, May 2024">
<span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    left: 70px;
    top: 0px;
">CHECK-IN</span>
<span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    right: 25px;
    top: 8px;
    height: 30px;
    border: 1px solid #bababa;
"></span>
 
 <i class="date-icon fa fa-calendar" aria-hidden="true" style="
    position: absolute;
    left: 15px;
    top: 12px;
    font-size: 22px;
    color: #4a4545;
"></i>
  
</div>



<div style="
    display: inline-flex;
    width: 220px;
    position: relative;
"> 
    <span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    left: 65px;
    top: 0px;
" readonly="">CHECK-OUT</span>
<input type="text" id="from-date" readonly="" value="24th, May 2024">
 
  <i class="date-icon fa fa-calendar" aria-hidden="true" style="
    position: absolute;
    top: 12px;
    font-size: 22px;
    color: #4a4545;
    left: 0px;
"></i>
</div></div>



<div class="col-md-3" id="guest-choose" style="
    border: 1px solid #d1d1d1;
    position: relative;
    /* max-width: 367px; */
    display: grid;
    grid-auto-flow: column;
    cursor: pointer;
    padding-top:3px;
    margin-right: 10px;margin-top:20px;
">
<div style="
    display: flex;
    /* width: 220px; */
    position: relative;
">
<span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    left: 36px;
    top: 15px;
">10 Room</span>
<span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    right: 10px;
    top: 8px;
    height: 30px;
    border: 1px solid #bababa;
"></span>
 
 <i class="date-icon fa fa-calendar" aria-hidden="true" style="
    position: absolute;
    left: 5px;
    top: 12px;
    font-size: 22px;
    color: #4a4545;
"></i>
  
</div>



<div style="
    display: flex;
    /* width: 220px; */
    position: relative;
">
<span class="text1" style="
    position: absolute;
    font-size: 13px;
    font-weight: 600;
    left: 40px;
    top: 15px;
">4 Guest</span>

 
 <i class="date-icon fa fa-calendar" aria-hidden="true" style="
    position: absolute;
    left: 5px;
    top: 12px;
    font-size: 22px;
    color: #4a4545;
"></i>
  
</div></div></div>
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
                <div class="box">

                    <div class="box-header with-border">
                        <div class="row text-right">
                            <div class="col-8 col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="text" id="search_keyword" name="search" class="form-control"
                                            placeholder="@lang('view_pages.enter_keyword')">
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 col-md-2 text-left">
                                <button id="search" class="btn btn-success btn-outline btn-sm py-2" type="submit">
                                    @lang('view_pages.search')
                                </button>
                            </div>


                            <!-- @if(auth()->user()->can('add-vehicle-types'))          -->
                                <div class="col-md-7 text-center text-md-right">
                                    <a href="{{ url('types/create') }}" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-plus-circle mr-2"></i>@lang('view_pages.add_types')</a>
                                    <!--  <a class="btn btn-danger">
                                                Export</a> -->
                                </div>
                            <!-- @endif -->
                            <!-- </form> -->
                        </div>

                    </div>
                    
                    <div class="row text-center" style="
    width: 97%;
    padding: 10px 20px 20px 20px;
    background-color: white;
    margin-left: 10px;
">

    <div id="js-types-partial-target" style="
    width: 100%;
">
                        <div class="box-body no-padding">
    <div class="table-responsive">
      <table class="table table-hover">
<thead>
<tr>


<th> S.No<span style="float: right;">

</span>
</th>

<th> Booking ID<span style="float: right;">
</span>
</th>
<!-- <th> Tansport Type<span style="float: right;">
</span>
</th> -->
 <th> Check-in   <span style="float: right;">
    </span>
</th>
<th> check-out<span style="float: right;">
</span>
</th>
<th> Guest Type<span style="float: right;">
</span>
</th> 
<th> Status<span style="float: right;">
</span>
</th> 

<th> Action<span style="float: right;">
</span>
</th>
 
</tr>
</thead>
<tbody>
 


<tr>
<td>1 </td>
<td> 17112132</td>

<td>                                 24/04/2024
                                </td>


<td>25/04/2024</td>
<td>Self</td>  
<td><button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;
">Booked</button></td>
<td><button class="btn btn-success btn-sm">View</button></td>
</tr>
<tr>
<td>2 </td>
<td> 17112133</td>

<td>                                 24/04/2024
                                </td>


<td>25/04/2024</td>
<td>Self</td>  
<td><button class="btn btn-success btn-sm" style="  background: red;   border-color: transparent;
">Cancelled</button></td>
<td><button class="btn btn-success btn-sm">View</button></td>
</tr>
<tr>
<td>3</td>
<td> 17112134</td>

<td>                                 24/04/2024
                                </td>


<td>25/04/2024</td>
<td>Self</td>  
<td><button class="btn btn-success btn-sm" style="  background: green;   border-color: transparent;
">Completed</button></td>
<td><button class="btn btn-success btn-sm">View</button></td>
</tr> 
</tbody>
</table>
<div class="text-right">
<span style="float:right">

</span>
</div></div></div>

                    </div>
                                
                                
                                
                                
                                </div>
                    
                </div>
            </div>
        </div>

        {{-- </div> --}}
        <!-- container -->


        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
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
