@extends('admin.layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
       #myChartContainer, #myChart1Container {
            max-width: 300px;
            margin: 20px auto;
        }

        #myChartContainer {
            height: 400px; /* Set the height for the pie chart container */
        }

        #myChart {
            height: 100%;
        }

        .morris-hover {
            position:absolute;
            z-index:1000;
        }

        .morris-hover.morris-default-style {
            border-radius:10px;
            padding:6px;
            color:#666;
            background:rgba(255, 255, 255, 0.8);
            border:solid 2px rgba(230, 230, 230, 0.8);
            font-family:sans-serif;
            font-size:12px;
            text-align:center;
        }

        .morris-hover.morris-default-style .morris-hover-row-label {
            font-weight:bold;
            margin:0.25em 0;
        }

        .morris-hover.morris-default-style .morris-hover-point {
            white-space:nowrap;
            margin:0.1em 0;
        }

        svg {
            width: 100%;
        }  
        #myChart {
            width: 600px;  /* Set the width for the pie chart canvas */
            height: 400px; /* Set the height for the pie chart canvas */
            margin: 20px auto;
        }
        canvas#myChart1, canvas#myChart2, canvas#myChart3 {
    max-width: 85%;
    max-height: 400px;
}
.table-responsive {
            overflow-x: auto;
        }
/* Targeting only the <th> elements within the <thead> */
.table thead th {
    width: 200px !important;
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #f4f4f4;
}
body{
    font-size:14px;
}
table th, table td {
    font-size: 14px;
}
.list-action.actv{
    background: #0A7E8C !important;
    color:white !important;
}
/* Absolute Center Spinner */
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  display:none;
}

/* Transparent Overlay */
.loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 89px;
    left: 270px;
    width: 100%;
    height: 100%;
    background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
    background: #e0dfdf;
    opacity: 0.9;
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: 2.5em;
  margin-left: 80px;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: #0A7E8C 1.5em 0 0 0, #0A7E8C 1.1em 1.1em 0 0, #0A7E8C 0 1.5em 0 0, #0A7E8C -1.1em 1.1em 0 0, #0A7E8C -1.5em 0 0 0, #0A7E8C -1.1em -1.1em 0 0, #0A7E8C 0 -1.5em 0 0, #0A7E8C 1.1em -1.1em 0 0;
box-shadow: #0A7E8C 1.5em 0 0 0, #0A7E8C 1.1em 1.1em 0 0, #0A7E8C 0 1.5em 0 0, #0A7E8C -1.1em 1.1em 0 0, #0A7E8C -1.5em 0 0 0, #0A7E8C -1.1em -1.1em 0 0, #0A7E8C 0 -1.5em 0 0, #0A7E8C 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.loading.actv{
    display:block;
}
    </style>
@section('content')
<div class="loading">Loading&#8230;</div>
<!-- Start Page content -->
    <section class="content" style="margin-left:25px"> 


  <div class="row g-3" style="margin-top:30px;margin-left:0px">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Booking Stats</h5>
                                <div class="col-md-12 text-center text-md-right" style=" position: relative;  top: -32px;">
                                <button class="btn btn-outline btn-sm btn-danger py-2 filter_request" type="button" data-toggle="modal" data-target="#request-modal">
                                    Filter Requests                                </button>
                            </div>
                                <h6 class="font-weight-600 p-5 heading-top" style="color:black;font-size:16px">Today</h6>
                                </div>

                            </div>
                            @if(!auth()->user()->hasRole('user'))
                            <div class="box-body "> 
                                <div class="row text-center">
                                @if(auth()->user()->hasRole('mess-manager')) 
                                <div class="col-12 col-md-3">
                                <a  href="{{url('/room-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Days.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Check In</h5> 
                                <h1 class="font-weight-600" style="  text-align: right; padding-right: 20px;font-size:38px">{{$check_in_count}}</h1>
                                </div>
                                </a>
                                </div>
                                @endif
                                    <div class="col-12 col-md-3"> 
                               
                                <a  href="{{url('/room-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Rooms.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Rooms</h5> 
                                <h1 class="font-weight-600 room-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$room_count}}</h1>
                                </div>
                                </a>
                                </div> 
                                    <div class="col-12 col-md-3">
                                  
                                <a  href="{{url('/party-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Party.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Party Hall / Lawn</h5> 
                                <h1 class="font-weight-600 party-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$party_count}}</h1>
                                </div>
                                </a>
                                </div> 
                                    <div class="col-12 col-md-3">
                                 
                                <a  href="{{url('/sports-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Sports.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Sports</h5> 
                                <h1 class="font-weight-600 sports-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$sports_count}}</h1>
                                </div>
                                </a>
                                </div>
                                @if(auth()->user()->hasRole('super-user')) 
                                <div class="col-12 col-md-3">
                                <a  href="{{url('/users')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Days.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Pending Approval Users</h5> 
                                <h1 class="font-weight-600" style="  text-align: right; padding-right: 20px;font-size:38px">{{$pending_users}}</h1>
                                </div>
                                </a>
                                </div>
                                @endif
                                </div> 
                            </div>
                            @endif
                            <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 p-5" style="color:black;font-size:21px;padding-left:20px !important">Booking Options</h5>
                              
                                </div>
                            <div class="box-body ">

<div class="row text-center">
<div class="col-12 col-md-4">
<a href="{{url('/')}}/types">
<div class="box p-5" style="text-align: left;border-radius:10px;/* padding-left: 25px !important; *//* background: #fff !important; */height: 188px;width: 100%;">
<img src="{{url('/')}}/assets/images/Book Room.gif" style="/* width:60px; */height: 100%;" class="img-fluid" alt="">
<!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
 

</div>
</a>
</div>
<div class="col-12 col-md-4">
<a href="{{url('/')}}/party">
<div class="box p-5" style="text-align: left;border-radius:10px;/* padding-left: 25px !important; *//* background: #fff !important; */height: 188px;width: 100%;">
<img src="{{url('/')}}/assets/images/Book Party Hall.gif" style="/* width:60px; */height: 100%;" class="img-fluid" alt="">
<!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
 

</div>
</a>
</div>
<div class="col-12 col-md-4">
<a href="{{url('/')}}/sports">
<div class="box p-5" style="text-align: left;border-radius:10px;/* padding-left: 25px !important; *//* background: #fff !important; */height: 188px;width: 100%;">
<img src="{{url('/')}}/assets/images/Book Sport.gif" style="/* width:60px; */height: 100%;" class="img-fluid" alt="">
<!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
 

</div>
</a>
</div>


</div>
<!-- on boarding  -->
 

<!-- end -->
            </div>            


            @if(auth()->user()->hasRole('user'))
                            <div class="box-body "> 
                                <div class="row text-center">
                               
                                    <div class="col-12 col-md-4"> 
                               
                                <a  href="{{url('/room-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Rooms.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Rooms</h5> 
                                <h1 class="font-weight-600 room-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$room_count}}</h1>
                                </div>
                                </a>
                                </div> 
                                    <div class="col-12 col-md-4">
                                  
                                <a  href="{{url('/party-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Party.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Party Hall / Lawn</h5> 
                                <h1 class="font-weight-600 party-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$party_count}}</h1>
                                </div>
                                </a>
                                </div> 
                                    <div class="col-12 col-md-4">
                                 
                                <a  href="{{url('/sports-booking')}}">
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;background: #fff !important;">
                                <img src="{{asset('assets/img/Sports.png')}}" style="width:60px;" class="img-fluid" alt="">
                                <!-- <span class="info-box-icon " style="background-color:#0A7E8C;border-radius:50%;dispaly:block;margin:auto;width:50px;height:50px;line-height:54px;"><i class="ion ion-clipboard text-dark"></i></span> -->
                                <h5 class="font-weight-600 p-5" >Sports</h5> 
                                <h1 class="font-weight-600 sports-count" style="  text-align: right; padding-right: 20px;font-size:38px">{{$sports_count}}</h1>
                                </div>
                                </a>
                                </div>
                                 
                                </div> 
                            </div>
                            @endif
          
            <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 earning-heading" style="color:black;font-size:21px;    padding-left: 10px;">
                                @if(auth()->user()->hasRole("user"))
                                Today Bookings
                                @else
                                Today Earnings
                                @endif
                                
                            </h5>
                           
                                </div>
                                    
            <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box p-5" style="">
                           
                      

                        <div class="box-body row">
                                <div class="col-md-6 p-5" style="background:white;border-radius:15px;">
                             
                            <div style="display:flex;justify-content:center;align-items:center;height:400px">
                            @if($status == 1)
                            <span class="download_pdf" data-label="1" style="  float: right;  vertical-align: top;  position: absolute;  right: 0;  top: 0px; font-size: 15px; padding: 10px; background: #0a7e8c; cursor: pointer;    border-top-right-radius: 15px;color:white">Download PDF</span>
                            @else
                            <span class="download_pdf" data-label="1" style="  float: right;  vertical-align: top;  position: absolute;  right: 0;  top: 0px; font-size: 15px; padding: 10px; background: #0a7e8c; cursor: pointer;    border-top-right-radius: 15px;color:white;display:none">Download PDF</span>
                            @endif
                            <canvas id="myChart" style="width:300px"></canvas>
                            </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        
                                        <div class="col-md-12" style="display:flex;justify-content:center;">
                                            <div class="info-box" style="    width: 400px;border-radius:10px;height:110px;">
                                            <span class="info-box-icon rounded" style="background:none">
                                                <img src="{{asset('assets/img/Rooms.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                                                <div class="info-box-content" style="color: #455a80;">
                                                    <h4 class="font-weight-600">
                                                    @if(auth()->user()->hasRole("user"))
                                                    {{$month_earnings[0]}}
                                                    @else
                                                    ₹{{$month_earnings[0]}}
                                                    @endif 
                                                        <br>                                                         
                                                    </h4>
                                                    <p>
                                                    @if(auth()->user()->hasRole("user"))
                                                    Total Room Bookings
                                                    @else
                                                    Total Room Earnings
                                                    @endif
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display:flex;justify-content:center;">
                                            <div class="info-box" style="    width: 400px;border-radius:10px;height:110px;">
                                            <span class="info-box-icon rounded" style="background:none">
                                                <img src="{{asset('assets/img/Party.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">
                                                    @if(auth()->user()->hasRole("user"))
                                                    {{$month_earnings[1]}}
                                                    @else
                                                    ₹{{$month_earnings[1]}}
                                                    @endif
                                                    
                                                        <br>
                                                    </h4>
                                                    <p>
                                                    @if(auth()->user()->hasRole("user"))
                                                    Total Party Hall / Lawn Bookings
                                                    @else
                                                    Total Party Hall / Lawn Earnings
                                                    @endif
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display:flex;justify-content:center;">
                                            <div class="info-box" style="    width: 400px;border-radius:10px;height:110px;">
                                            <span class="info-box-icon rounded" style="background:none">
                                                <img src="{{asset('assets/img/Sports.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">
                                                    @if(auth()->user()->hasRole("user"))
                                                    {{$month_earnings[2]}}
                                                    @else
                                                    ₹{{$month_earnings[2]}}
                                                    @endif  
                                                        <br>
                                                    </h4>
                                                    <p>
                                                    @if(auth()->user()->hasRole("user"))
                                                    Total Sports Bookings
                                                    @else
                                                    Total Sports Earnings
                                                    @endif
                                                        
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                         
                                        
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- Cancellation stats end -->
 </div>

 @if(auth()->user()->hasRole('super-user'))
 <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600" style="color:black;font-size:21px">Overall Earnings</h5>
                           
                                </div>         
            <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
               
                    <div class="col-12">
                        <div class="box p-5" style=""> 
                        <div class="box-body row">
                                <div class="col-md-12 p-5" style="background:white;border-radius:15px;">
                                <div style="color:black;font-size:18px;padding-left:20px;padding-top:20px">
                            <h5 class="font-weight-600" style="color:black;font-size:15px">Room Earnings</h5> 
                            <!-- <span class="download_pdf" data-label="2" style="  float: right;  vertical-align: top;  position: absolute;  right: 0;  top: 0px; font-size: 15px; padding: 10px; background: #0a7e8c; cursor: pointer;    border-top-right-radius: 15px;color:white">Download PDF</span> -->
                                </div>
                            <div style="display:flex;justify-content:center;align-items:center;padding-bottom:35px;padding-top: 10px;">
                            <canvas id="myChart1" style="width:300px"></canvas>
                            </div>
                                </div> 
                            </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- Cancellation stats end -->
 </div> 

 <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
               
                    <div class="col-12">
                        <div class="box p-5" style=""> 
                        <div class="box-body row">
                                <div class="col-md-12 p-5" style="background:white;border-radius:15px;">
                                <div style="color:black;font-size:18px;padding-left:20px;padding-top:20px">
                                <h5 class="font-weight-600" style="color:black;font-size:15px">Party Hall / Lawn Earnings</h5> 
                                <!-- <span class="download_pdf" data-label="3" style="  float: right;  vertical-align: top;  position: absolute;  right: 0;  top: 0px; font-size: 15px; padding: 10px; background: #0a7e8c; cursor: pointer;    border-top-right-radius: 15px;color:white">Download PDF</span> -->
                                </div>
                            <div style="display:flex;justify-content:center;align-items:center;padding-bottom:35px;padding-top: 10px;">
                            <canvas id="myChart2" style="width:300px"></canvas>
                            </div>
                                </div> 
                            </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- Cancellation stats end -->
 </div> 

 <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
               
                    <div class="col-12">
                        <div class="box p-5" style=""> 
                        <div class="box-body row">
                                <div class="col-md-12 p-5" style="background:white;border-radius:15px;">
                                <div style="color:black;font-size:18px;padding-left:20px;padding-top:20px">
                                <h5 class="font-weight-600" style="color:black;font-size:15px">Sports Earnings</h5> 
                                <!-- <span class="download_pdf" data-label="4" style="  float: right;  vertical-align: top;  position: absolute;  right: 0;  top: 0px; font-size: 15px; padding: 10px; background: #0a7e8c; cursor: pointer;    border-top-right-radius: 15px;color:white">Download PDF</span> -->
                                </div>
                                <div style="display:flex;justify-content:center;align-items:center;padding-bottom:35px;padding-top: 10px;">
                            <canvas id="myChart3" style="width:300px"></canvas>
                            </div>
                                </div> 
                            </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- Cancellation stats end -->
 </div> 
 @endif
 <div class="row g-3" style="margin-top:30px;margin-left:0px">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                        <div class="box-header with-border" style="padding-left: 12px;">
                                <div style="color:black;font-size:18px">
                                <h5 class="font-weight-600 booking-label" style="color:black;font-size:21px">
                                @if(auth()->user()->hasRole('user'))
                                Last Six Month Booking 
                                @else
                                Recent Booking
                                @endif
                                

                            </h5>
                           
                                </div>

                            </div>
                            <div class="nav-tabs" style="
    display: flex;
    flex-direction: row;
    padding-left: 14px;
">


<button class="btn btn-success btn-sm list-action actv" data-val="1" style="background: white;border-color: transparent;margin-right: 18px;color: #0A7E8C;">Room</button>  
<button class="btn btn-success btn-sm list-action" data-val="2" style="background: white;border-color: transparent;color: #0A7E8C;font-weight: 500;border: 1px solid #cdcdcd;margin-right: 18px;">Party Hall / Lawn</button><button class="btn btn-success btn-sm list-action" data-val="3" style="background: white;border-color: transparent;color: #0A7E8C;font-weight: 500;border: 1px solid #cdcdcd;margin-right: 18px;">Sports</button>
</div>

                            <div class="box-body ">

                                <div class="row text-center">
                                <div class="row text-center" style="
    width: 100%;
    padding: 10px 20px 20px 20px;
    background-color: white;
    margin-left: 10px;
">

    <div id="js-type-partial-target" style="width: 100%;">  
                <span style="text-align: center;font-weight: bold;">@lang('view_pages.loading')</span> 
                            <script>
                                 function get_bookings_data(type,data_ref){ 

                                    data = {type:type,data:data_ref};
                                    console.log(data);
                                    console.log("datasdfsdfsfsfd");
                            $.ajax({
                            url:'{{url("/")}}/room-booking/fetch1',
                            data:data,
                            cache:false,
                            dataType:'html',
                            success:function(res)
                            {  
                                document.querySelector('#js-type-partial-target').innerHTML = res;
                                
                            },
                            error: function(xhr, status, error) {
                                console.error("Error:", error);
                                // Handle errors if needed
                            }
                        })
    }
                                get_bookings_data(1,{});
                                </script>
                            
                    </div> 
                                </div>
                                </div>
    
                            </div>
                          
<!-- on boarding  -->
 

<!-- end -->
            </div>   
<!-- new dashboard end -->

    </section>


    <script src="{{ asset('assets/vendor_components/jquery.peity/jquery.peity.js') }}"></script>
   
 

    <!-- Morris.js charts -->
    <script src="{{ asset('assets/vendor_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/morris.js/morris.min.js') }}"></script>
    <script> 
    var selected_value,from_dates,to_dates;
     $(".list-action").click(function(){
        $(".list-action").removeClass("actv");
        $(this).addClass("actv");
        var data_val = $(this).attr("data-val");
        
        $("#js-type-partial-target").html('<span style="text-align: center;font-weight: bold;">@lang('view_pages.loading')</span> ')
        var date_value = $("#date").val();
    var status = $("#status").val(); 
    selected_value = date_value;
    var status = 1; 
    var data = {};
    if(date_value !== undefined && date_value !== null)
    {
    if(date_value == 1)
    { 
        from_dates = $("#from_date").val();
        to_dates = $("#to_date").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val(); 
        if(from_date != "" && from_date != null && to_date != "" && to_date != null)
        {
            data.date_value = date_value;
            data.from_date = from_date;
            data.to_date = to_date;
        } 
        else{
            status = 0;
            $(".resp-error").html("Please Select From date and To date");
            $(".resp-error").show();
        }
    }
    else{
        data.date_value = date_value;
    }
    }
    get_bookings_data(data_val,data);

     })
      const chartData = {
            labels: ['Room (₹)', 'Party (₹)', 'Sports (₹)'],
            datasets: [{ 
                backgroundColor: [
                    '#0A7E8C',
                    '#EC9E9C',
                    '#09AAB8',
                ],
                hoverBackgroundColor: [
                            "#0A7E8C",
                            "#EC9E9C",
                            "#09AAB8"
                        ],
                data: {!! json_encode($month_earnings) !!}
            }]
        };

        const chartOptions = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', 
                },
                title: {
                    display: true,
                    text: 'Chart.js Pie Chart'
                }
            }
        };

        // Initialize Chart.js
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: chartOptions,
            weight:500
        }); 
        const lineChartData = {
            labels: {!! json_encode($data['label']) !!},
            datasets: [{ 
                label: 'Room Earnings (₹)',
                data: {!! json_encode($data['room_price']) !!},
                fill: false,
                borderColor: '#0A7E8C',
                tension: 0.1
            }]
        };
        const lineChartData1 = {
            labels: {!! json_encode($data['label']) !!},
            datasets: [{ 
                label: 'Party Hall Earnings (₹)',
                data: {!! json_encode($data['party_price']) !!},
                fill: false,
                borderColor: '#EC9E9C',
                tension: 0.1
            }]
        };
        const lineChartData2 = {
            labels: {!! json_encode($data['label']) !!},
            datasets: [{ 
                label: 'Sports Earnings (₹)',
                data: {!! json_encode($data['sports_price']) !!},
                fill: false,
                borderColor: '#09AAB8',
                tension: 0.1
            }]
        };

        const lineChartOptions1 = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', 
                },
                title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                },
                tooltip: {
                    enabled: false // Disable tooltips
                }
            }
        };

        

       

        $(".filter_request").click(function(){
    popup_init();
    popup_data(`<div class="">
    <h3 style="
    text-align: center;
    margin: 0;
    padding: 0 !important;
    line-height: 18px;
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #0A7E8C;
"> Apply Filters</h3>
<form id="apply-filters">
<h5 style="
    font-weight: 600;
    margin-bottom: 20px;
    display: inline-block;
    background: #0A7E8C;
    padding: 7px;
    color: white;
    border-radius: 3px;
    font-size: 13px;
">Select Date </h5>
    <select name="date" id="date" style="
    width: 100%;
    padding: 10px;
    border: 1px solid #d7d7d7;
    border-radius: 3px;
    cursor: pointer;
    margin-top&quot;: 2&quot;;
"> 
<option selected="" value="2">Today</option> 
<option value="3">This Week</option>
<option value="4">This Month</option>
<option value="5">This Year</option>
<option  value="1">Custom date</option>
</select>

<div class="form" style="
    padding: 15px;
">
<div class="row custom-dates" style="display:none">
<div class="col-md-6" style="padding-left:0px !important;">
    <label>From Date</label>
<input type="date" id="from_date" name="from_date" style="
    width: 95%;
    border-radius: 3px;
    border: 1px solid #cbc6c6;padding:10px
"> 
</div>
<div class="col-md-6">
      <label>To Date</label>
<input type="date" id="to_date" name="to_date" style="
    width: 95%;
    border: 1px solid #ccc9c9;
    border-radius: 3px;padding:10px
"> 
</div>
</div>
</div>
 
 
<div class="col-12" style="
    margin-top: 10px;
">
<div class="resp-error" style="
    text-align: right;
    color: red;
    display: none;
">Please select From date and To date</div>       
                                                            <button class="btn btn-primary btn-sm pull-right m-5 apply_filter" type="button" style="
    padding: 10px;
    cursor: pointer;
">Apply Filter</button>
<button class="btn btn-primary btn-sm pull-right m-5 clear_filter" type="button" style="
    padding: 10px;
    cursor: pointer;
    background-color: white;
    color: black;
    cursor: pointer;
">Clear Filter</button>

<span class="danger-book pull-right"></span>
                                                        </div>
                                                        </form>
</div>`);
if(selected_value !== undefined)
{
    $('#date').val(selected_value); 
    if(selected_value == 1)
    {
        $(".custom-dates").show();
        $("#from_date").val(from_dates);
        $("#to_date").val(to_dates);
    }
    
}
$("#from_date").change(function(){ 
    $("#to_date").attr("min",$(this).val());
})
$(".clear_filter").click(function(){
    // alert("gdgdfgdfg");
    $("#from_date").val('');
    $(".custom-dates").hide();
    $("#to_date").val('');
    $("#to_date").attr("min",false); 
    $('#status').val('1');
    $('#date').val('2'); 
})
$(".apply_filter").click(function(){ 
    var data_val = $(".list-action").attr("data-val");
    
    $(".resp-error").hide();

    var data = {};  
    var date_value = $("#date").val();
    var status = $("#status").val(); 
    selected_value = date_value;
    var status = 1;
    if(date_value == 1)
    { 
        from_dates = $("#from_date").val();
        to_dates = $("#to_date").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val(); 
        if(from_date != "" && from_date != null && to_date != "" && to_date != null)
        {
            data.date_value = date_value;
            data.from_date = from_date;
            data.to_date = to_date;
        } 
        else{
            status = 0;
            $(".resp-error").html("Please Select From date and To date");
            $(".resp-error").show();
        }
    }
    else{
        data.date_value = date_value;
    }
    search_keyword = $('#search_keyword').val(); 
    data.search = search_keyword;
    if($("input[type='radio']").is(':checked'))
    {
        var payment_status = $("input[type='radio']:checked").val();
        data.payment_status = payment_status;
    }  
   
    data.status = status; 
    data.type = "json"; 
    get_bookings_data(data_val,data);
    
    $(".loading").addClass("actv");
    if(status == 1){
        popup_close();
    $.ajax({
        url:'{{url("/")}}/dashboard',
        data:data,
        cache:false,
        dataType:'json',
        success:function(res)
        {  
            $(".loading").removeClass("actv"); 
            $(".room-count").html(res.room_count);
            $(".party-count").html(res.party_count);
            $(".sports-count").html(res.sports_count); 
            if(res.status == 1)
            {
                $("span.download_pdf").show();
            }
            else{
                $("span.download_pdf").hide();
            }
            var earning_text = "Earning";
            @if(auth()->user()->hasRole("user"))
            var earning_text = "Booking";
            @endif
            if(date_value == 1)
            {
                const fromDate = new Date($("#from_date").val());
                const toDate = new Date($("#to_date").val()); 
                function formatDate(date) {
                const months = [
                    "Jan", "Feb", "Mar", "Apr", "May", "June", 
                    "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];
                
                const day = date.getDate();
                const month = months[date.getMonth()];
                const year = date.getFullYear();
                
                // Append the correct suffix to the day
                const daySuffix = (day) => {
                    if (day > 3 && day < 21) return 'th'; // because 11th, 12th, 13th
                    switch (day % 10) {
                        case 1:  return "st";
                        case 2:  return "nd";
                        case 3:  return "rd";
                        default: return "th";
                    }
                };

                return `${day}${daySuffix(day)} ${month} ${year}`;
                }
                const formattedFromDate = formatDate(fromDate);
                const formattedToDate = formatDate(toDate); 
                $(".heading-top").html(`${formattedFromDate} - ${formattedToDate}`); 
                $(".earning-heading").html(`${earning_text} - (${formattedFromDate} to ${formattedToDate})`);
                $(".booking-label").html(`${earning_text} - (${formattedFromDate} to ${formattedToDate})`);
            }
            if(date_value == 2)
            {
                $(".heading-top").html("Today");
                $(".earning-heading").html(`Today ${earning_text}`);   
                $(".booking-label").html(`Today ${earning_text}`);   
            }
            if(date_value == 3)
            {
                $(".heading-top").html("This Week");
                $(".earning-heading").html(`This Week ${earning_text}`);
                $(".booking-label").html(`This Week ${earning_text}`);
            }
            if(date_value == 4)
            {
                $(".heading-top").html("This Month");
                $(".earning-heading").html(`This Month ${earning_text}`);
                $(".booking-label").html(`This Month ${earning_text}`);
            }
            if(date_value == 5)
            {
                $(".heading-top").html("This year");
                $(".earning-heading").html(`This Year ${earning_text}`);
                $(".booking-label").html(`This Year ${earning_text}`);
            }
            chart.data.datasets[0].data = res.month_earnings;
            chart.update();

        }
    })
}
})


$("#date").change(function(){
    var data_val = $(this).val();
    if(data_val == 1)
    {
        $(".custom-dates").show();
    }
    else{
        $(".custom-dates").hide();
    }
})
})
$(document).ready(function(){
   
    
    $(".download_pdf").click(function(){ 
    var data = {
        _token: '{{ csrf_token() }}',  // Add CSRF token
        label: $(this).data('label')  // Add any additional data
    };
    var date_value = $("#date").val();
    if(date_value == 1)
    { 
        from_dates = $("#from_date").val();
        to_dates = $("#to_date").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val(); 
        if(from_date != "" && from_date != null && to_date != "" && to_date != null)
        {
            data.date_value = date_value;
            data.from_date = from_date;
            data.to_date = to_date;
        }  
    }
    else{
        data.date_value = date_value;
    }
    
    $.ajax({
            url:'{{url("/")}}/export_pdf',
            data:data, 
            type: 'POST',
            xhrFields: {
                responseType: 'blob'
            },
            success:function(response)
            {  
                var blob = new Blob([response], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob); 
                link.download = "overall_earinings_"+Date.now()+".pdf";
                link.click(); 
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                // Handle errors if needed
            }
        })
})
})
@if(auth()->user()->hasRole('super-user'))
// Initialize Line Chart
const ctx1 = document.getElementById('myChart1').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions1
        });
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: lineChartData1,
            options: lineChartOptions1
        });
        const ctx3 = document.getElementById('myChart3').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: lineChartData2,
            options: lineChartOptions1
        });
@endif
    </script> 


@endsection
