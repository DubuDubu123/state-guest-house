@extends('admin.layouts.app') @section('title', 'Main page') @section('content')
<style>
    .switch2, .switch3,.switch4,.switch6,.switch8,.switch9,.switch4.actv {
  position: relative;
  top:-23px;
  display: inline-block;
  margin: 0 5px;
}

.switch2 > span,.switch3 > span,.switch4 > span,.switch6 > span,.switch8 > span,.switch9 > span,.switch,.switch4.actv > span {
  position: absolute;
  top:30px;
  pointer-events: none;
  font-family: 'Helvetica', Arial, sans-serif;
  font-weight: bold;
  font-size: 12px;
  text-transform: uppercase;
  text-shadow: 0 1px 0 rgba(0, 0, 0, .06);
  width: 50%;
  text-align: center;
}

input.check-toggle-round-flat:checked ~ .off {
  color: #fff;
}

input.check-toggle-round-flat:checked ~ .on {
  color: #fff;
}

.switch2 > span.on,.switch3 > span.on,.switch4 > span.on,.switch6 > span.on,.switch8 > span.on,.switch9 > span.on,.switch4.actv > span.on {
  left: 0;
  padding-left: 2px;
  color: #fff;
}

.switch2 > span.off,.switch3 > span.off,.switch4 > span.off,.switch6 > span.off,.switch8 > span.off,.switch9 > span.off,.switch4.actv > span.off {
  right: 0;
  padding-right: 4px;
  color: #000;
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
    .bio-row{
        width:100% !important;
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
.confimr.spinner {
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
.image {
    height: 150px;
    width: 150px;
    /* border-radius: 50%; */
}
img {
    max-width: 100%;
    border-radius: 50%;
}
@media (max-width: 768px) {
    .col-sm-6 {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
}
i{
    color:#86BEBD;
}
.row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    justify-content: center;
    align-items: center;
}


.profile-nav .user-heading {
    background: #fbc02d;
    color: #fff;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    padding: 30px;
    text-align: center;
}

.profile-nav .user-heading.round a  {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.3);
    display: inline-block;
}

.profile-nav .user-heading a img {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
}

.profile-nav .user-heading h1 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 5px;
}

.profile-nav .user-heading p {
    font-size: 12px;
}

.profile-nav ul {
    margin-top: 1px;
}

.profile-nav ul > li {
    border-bottom: 1px solid #ebeae6;
    margin-top: 0;
    line-height: 30px;
}

.profile-nav ul > li:last-child {
    border-bottom: none;
}

.profile-nav ul > li > a {
    border-radius: 0;
    -webkit-border-radius: 0;
    color: #89817f;
    border-left: 5px solid #fff;
}

.profile-nav ul > li > a:hover, .profile-nav ul > li > a:focus, .profile-nav ul li.active  a {
    background: #f8f7f5 !important;
    border-left: 5px solid #fbc02d;
    color: #89817f !important;
}

.profile-nav ul > li:last-child > a:last-child {
    border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
}

.profile-nav ul > li > a > i{
    font-size: 16px;
    padding-right: 10px;
    color: #bcb3aa;
}

.r-activity {
    margin: 6px 0 0;
    font-size: 12px;
}


.p-text-area, .p-text-area:focus {
    border: none;
    font-weight: 300;
    box-shadow: none;
    color: #c3c3c3;
    font-size: 16px;
}

.profile-info .panel-footer {
    background-color:#f8f7f5 ;
    border-top: 1px solid #e7ebee;
}

.profile-info .panel-footer ul li a {
    color: #7a7a7a;
}

.bio-graph-heading {
    background: #fbc02d;
    color: #fff;
    text-align: center;
    font-style: italic;
    padding: 40px 110px;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    font-size: 16px;
    font-weight: 300;
}

.bio-graph-info {
    color: #89817e !important;
}
.bio-graph-info {
    font-size: 14px !important;
    font-weight: 300;
    margin: 0 0 20px;
}
.bio-graph-info h1 {
    font-size: 22px;
    font-weight: 300;
    margin: 0 0 20px;
}

.bio-row {
    width: 50%;
    float: left;
    margin-bottom: 10px;
    padding:0 15px;
}

.bio-row p span {
    width: 200px;
    display: inline-block;
}
/* .bio-row p span.value-data {
   padding-left:20px
} */

.bio-chart, .bio-desk {
    float: left;
}

.bio-chart {
    width: 40%;
}

.bio-desk {
    width: 60%;
}

.bio-desk h4 {
    font-size: 15px;
    font-weight:400;
}

.bio-desk h4.terques {
    color: #4CC5CD;
}

.bio-desk h4.red {
    color: #e26b7f;
}

.bio-desk h4.green {
    color: #97be4b;
}

.bio-desk h4.purple {
    color: #caa3da;
}

.file-pos {
    margin: 6px 0 10px 0;
}

.profile-activity h5 {
    font-weight: 300;
    margin-top: 0;
    color: #c3c3c3;
}

.summary-head {
    background: #ee7272;
    color: #fff;
    text-align: center;
    border-bottom: 1px solid #ee7272;
}

.summary-head h4 {
    font-weight: 300;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.summary-head p {
    color: rgba(255,255,255,0.6);
}

ul.summary-list {
    display: inline-block;
    padding-left:0 ;
    width: 100%;
    margin-bottom: 0;
}

ul.summary-list > li {
    display: inline-block;
    width: 19.5%;
    text-align: center;
}

ul.summary-list > li > a > i {
    display:block;
    font-size: 18px;
    padding-bottom: 5px;
}

ul.summary-list > li > a {
    padding: 10px 0;
    display: inline-block;
    color: #818181;
}

ul.summary-list > li  {
    border-right: 1px solid #eaeaea;
}

ul.summary-list > li:last-child  {
    border-right: none;
}

.activity {
    width: 100%;
    float: left;
    margin-bottom: 10px;
}

.activity.alt {
    width: 100%;
    float: right;
    margin-bottom: 10px;
}

.activity span {
    float: left;
}

.activity.alt span {
    float: right;
}
.activity span, .activity.alt span {
    width: 45px;
    height: 45px;
    line-height: 45px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    background: #eee;
    text-align: center;
    color: #fff;
    font-size: 16px;
}

.activity.terques span {
    background: #8dd7d6;
}

.activity.terques h4 {
    color: #8dd7d6;
}
.activity.purple span {
    background: #b984dc;
}

.activity.purple h4 {
    color: #b984dc;
}
.activity.blue span {
    background: #90b4e6;
}

.activity.blue h4 {
    color: #90b4e6;
}
.activity.green span {
    background: #aec785;
}

.activity.green h4 {
    color: #aec785;
}

.activity h4 {
    margin-top:0 ;
    font-size: 16px;
}

.activity p {
    margin-bottom: 0;
    font-size: 13px;
}

.activity .activity-desk i, .activity.alt .activity-desk i {
    float: left;
    font-size: 18px;
    margin-right: 10px;
    color: #bebebe;
}

.activity .activity-desk {
    margin-left: 70px;
    position: relative;
}

.activity.alt .activity-desk {
    margin-right: 70px;
    position: relative;
}

.activity.alt .activity-desk .panel {
    float: right;
    position: relative;
}

.activity-desk .panel {
    background: #F4F4F4 ;
    display: inline-block;
}


.activity .activity-desk .arrow {
    border-right: 8px solid #F4F4F4 !important;
}
.activity .activity-desk .arrow {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    left: -7px;
    position: absolute;
    top: 13px;
    width: 0;
}

.activity-desk .arrow-alt {
    border-left: 8px solid #F4F4F4 !important;
}

.activity-desk .arrow-alt {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    right: -7px;
    position: absolute;
    top: 13px;
    width: 0;
}

.activity-desk .album {
    display: inline-block;
    margin-top: 10px;
}

.activity-desk .album a{
    margin-right: 10px;
}

.activity-desk .album a:last-child{
    margin-right: 0px;
}
/* Style the Image Used to Trigger the Modal */
img {
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s;
}

.bio-graph-info {
    color: #89817e;
}
button.btn.btn-primary.btn-sm.pull-right.m-5.sendPush {
    padding: 10px 20px 10px 20px;
    /* margin-right: 105px; */
    margin-left: 10px !important;
    margin-right: 20px !important;
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

.check-toggle {
  position: absolute;
  margin-left: -9999px;
  visibility: hidden;
}
.check-toggle + label {
  display: block;
  position: relative;
  cursor: pointer;
  outline: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

input.check-toggle-round-flat + label {
  padding: 2px;
  width: 97px;
  height: 34px;
  background-color:#d4d7d4;
  -webkit-border-radius: 60px;
  -moz-border-radius: 60px;
  -ms-border-radius: 60px;
  -o-border-radius: 60px;
  border-radius: 60px;
}
input.check-toggle-round-flat + label:before, input.check-toggle-round-flat + label:after {
  display: block;
  position: absolute;
  content: "";
}

input.check-toggle-round-flat + label:before {
  top: 2px;
  left: 2px;
  bottom: 2px;
  right: 2px;
  background-color: #d4d7d4; 
  border-radius: 60px;
}
input.check-toggle-round-flat + label:after {
  top: 4px;
  left: 4px;
  bottom: 4px;
  width: 46px;
  background-color: #e31b1b;
  -webkit-border-radius: 52px;
  -moz-border-radius: 52px;
  -ms-border-radius: 52px;
  -o-border-radius: 52px;
  border-radius: 52px;
  -webkit-transition: margin 0.2s;
  -moz-transition: margin 0.2s;
  -o-transition: margin 0.2s;
  transition: margin 0.2s;
}

input.check-toggle-round-flat:checked + label {
}

input.check-toggle-round-flat:checked + label:after {
  margin-left: 44px;
  background: #46a31d;
}

.activity-desk .album a{
    margin-right: 10px;
}

.activity-desk .album a:last-child{
    margin-right: 0px;
}
/* Style the Image Used to Trigger the Modal */
img {
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s;
}

.bio-graph-info {
    color: #89817e;
}
button.btn.btn-primary.btn-sm.pull-right.m-5.sendPush {
    padding: 10px 20px 10px 20px;
    /* margin-right: 105px; */
    margin-left: 10px !important;
    margin-right: 20px !important;
}
[type="checkbox"]:not(.filled-in)+label:after {
    border: 0;
  
    transform: none !important;
}
[type="checkbox"]+label:before, [type="checkbox"]:not(.filled-in)+label:after {
    border:none !important;
}
input.check-toggle-round-flat + label:after {
    top: 3px !important;
    left: 4px !important;
    bottom: 23px !important;
    width: 46px !important;
    height: 25px !important;
    background-color: #e31b1b;
    -webkit-border-radius: 52px;
    -moz-border-radius: 52px;
    -ms-border-radius: 52px;
    -o-border-radius: 52px;
    border-radius: 52px !important;
    -webkit-transition: margin 0.2s;
    -moz-transition: margin 0.2s;
    -o-transition: margin 0.2s;
    transition: margin 0.2s;
}
input.check-toggle-round-flat + label:before {
    top: 2px !important;
    left: 2px !important;
    bottom: 2px;
    right: 2px;
    background-color: #d4d7d4;
    border-radius: 60px;
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
                <a href="{{url('/')}}/party-booking">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2" ></i>
                                    Back                                </button>
                            </a>
                        </div>
                    <div class="box-header with-border">
                        <div style="color:black;font-size:18px">
                            <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">Booking Detail Overview </h5>
                        </div>

                    </div>

                    <div class="box-body " style=" padding: 30px;">
                        <!-- <input name='range' id='cal' />  -->
                        <div class="row text-center">
                            <div class="col-12">
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;padding-bottom: 25px !important;background: #fff !important;">
                                    <div style="color:black;font-size:18px;margin-top: 20px;">
                                        <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">User Details</h5> 
                                        <div class="row" style="
    padding: 20px;
">
 <div class="col-3 col-sm-6" style="
    margin-left: 15px;
    margin-right: 30px;
">
<div class="image">

<img src="{{$booking->user->profile_picture}}" width="100%" height="100%"> 
</div>

 
                                        </div>
                                        <div class="col-6 col-sm-6" style="
    margin-left: 15px;
    margin-right: 30px;
    /* margin-top: 20px; */
">


<p><i class="fa fa-user" aria-hidden="true"></i> <span style="
    
    font-size: 15px;
">{{$booking->user->salutation}} {{$booking->user->name}} </span></p>




<p><i class="fa fa-phone" aria-hidden="true"></i> <span style="
    
    font-size: 15px;
">{{$booking->user->mobile}} </span></p><p><i class="fa fa-envelope" aria-hidden="true"></i> <span style="
    
    font-size: 15px;
">{{$booking->user->email}} </span></p>
<p><i class="fa fa-home" aria-hidden="true"></i> <span style="
    
    font-size: 15px;
">{{$booking->user->address}} </span></p>

                                        </div>
                                        </div>
                                        </div>


                                    </div>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12">
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                <div class="box p-5" style="text-align: left;border-radius:10px;padding-left: 25px !important;padding-bottom: 25px !important;background: #fff !important;">
                                    <div style="color:black;font-size:18px;margin-top: 20px;">
                                        <h5 class="font-weight-600 p-5" style="color:black;font-size:17px">Booking Details</h5> 
                                        <div class="row bio-graph-info" style="padding: 20px;">
                                <div class="bio-row">
                                    <p><span>Booking ID </span><span class="value-data">: {{$booking->booking_id}}</span></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Booked By </span>: <span>{{$booking->user->name}}</span> </p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Check In Date </span><span class="value-data">:<?php echo date('Y-m-d', strtotime($booking->checkin_date)); ?></span></p>
                                </div>
                                
                                <div class="bio-row">
                                    <p><span>Booked On </span><span class="value-data">:  <?php echo date('Y-m-d', strtotime($booking->created_at)); ?></span></p>
                                </div>
                                
                                <div class="bio-row">
                                    <p><span>Guest Type </span><span class="value-data">: {{$booking->guest_type}}</span></p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Tariff Amount </span><span class="value-data">: ₹{{$booking->tariff}}</span></p>
                                </div> 
                                
                                </div>
                                @if(auth()->user()->hasRole('mess-manager'))
                                @if($date_diff <= 0 && $booking->status == 0)
                                <div class="form-group">
                                    <div class="col-12"> 
                                            <button class="btn btn-primary btn-sm pull-right m-5 sendPush sweet-delete1" type="button" data-id="{{$booking->id}}">
                                            <i class="fa fa-sign-out" aria-hidden="true" style="color:white" ></i>
                                            Check In </button> 
                                    </div>
                                </div>
                                @endif
                                @if($date_diff <= 0 && $booking->status == 1)
                                <div class="form-group">
                                    <div class="col-12"> 
                                            <button class="btn btn-primary btn-sm pull-right m-5 sendPush sweet-delete2" type="button" data-id="{{$booking->id}}">
                                            <i class="fa fa-sign-out" aria-hidden="true" style="color:white" ></i>
                                            Check Out </button> 
                                    </div>
                                </div>
                                @endif
                                @elseif($date_diff >= 0 && $booking->status == 0)
                                @if(!auth()->user()->hasRole('mess-manager'))
                                <div class="form-group">
                                    <div class="col-12">
                                       
                                            <button class="btn btn-primary btn-sm pull-right m-5 sendPush sweet-delete" type="button" data-id="{{$booking->id}}">
                                            <i class="fa fa-trash" aria-hidden="true" style="color:white" ></i>
                                            Cancel Booking  </button>
                                            <a href="{{url('/')}}/party/edit/{{$booking->id}}">
                                            <button class="btn btn-primary btn-sm pull-right m-5 sendPush" type="button">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" style="color:white"></i>
                                            Modify Booking</button>
                                            
                                        </a>
                                    </div>
                                </div>
                                @endif
                                @endif
                                        </div>


                                    </div>
                                    <!-- </a> -->
                                </div>
                            </div>

                        </div> 
                    </div> 
                </div>
            </div> 
        <!-- container -->


        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
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
                    });
                    $('#to_date').on('change', function() {
                    var checkinDate = $(this).val();

                    $('#from_date').attr('max', checkinDate);
                    $(".book-now").removeClass("active");
                     $(".danger-book").removeClass("active");
                     $(".danger-book").html('');
                $(".danger-book").removeClass("error");
                    });
                    $('#room').on('keyup', function() {
                        $(".book-now").removeClass("active");
                        $(".danger-book").removeClass("active");
                        $(".danger-book").removeClass("error");
                        $(".danger-book").html('');
                    });
            });

            $(".book-now").click(function(){
                let url = "{{url('/')}}/partybook-now";
                
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
">Booking Confirmed Successfully</h4>
                                        <a class="btn btn-success" style="font-size:16px;margin: auto;margin-top: 20px;" href="#">Close</a>
                                    </div>
                                    </div>
                                `);
                                setTimeout(function() {
                                    
                                    window.location.reload();
                                    }, 2000);
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
            $('.check_availabiity').on('click', function(e) {
               var from_date =  $("#from_date").val();
               var to_date =  $("#to_date").val();
               var room =  $("#room").val();
               var guest =  $("#guest").val();
               var guest_type =  $("#guest_type").val();
               var user =  $("#user").val(); 
               if(from_date == "" || to_date == "")
               {
                $(".danger-book").addClass("error");
                   $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select Check In and Check Out date");
               }
               else if(room == "")
               {
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select No of Rooms");
               } 
               else if(guest == "")
               {
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Enter the Guest Count");
               }
               else if(guest_type == "" || guest_type === null)
               {
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select the Guest Type");
               }
               else{
                var status = true; 
                @if(auth()->user()->hasrole("super-user"))
                alert("dfdfgfg");
                if(user == "")
               {

                status = false;
                $(".danger-book").addClass("error");
                $(".danger-book").removeClass("active");
                $(".danger-book").html("Please Select Users");
               } 
                @endif
                if(status)
                {
                    let url = "{{url('/')}}/partycheck-availability";
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
                                    $(".book-now").addClass("active");
                                    $(".danger-book").removeClass("error");
                                    $(".danger-book").addClass("active");
                                    $(".danger-book").html(res.message);
                                }
                                else{
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

                    fetch('partyfetch?search=' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-types-partial-target').innerHTML = html
                        });
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

$(document).on('click', '.sweet-delete', function(e) {
                e.preventDefault();

                let url = $(this).attr('data-url');
                let data_id = $(this).attr('data-id'); 

                swal({
                    title: "Are you sure to cancel the booking?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Cancel Booking",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        swal.close();  
                        $.ajax({
                            url: '{{url("/")}}/party/cancel-booking/'+data_id+'', 
                            cache: false,
                            success: function(res) {
                                if(res.status)
                                {
                                    $.toast({
                                    heading: '',
                                    text: res.message,
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 5000,
                                    stack: 1
                                });
                                window.location.reload();
                                }

                            }
                        });
                    }
                });
            });



            $(document).on('click', '.sweet-delete1', function(e) {
                e.preventDefault();  
                let url = $(this).attr('data-url');
                let data_id = $(this).attr('data-id'); 

                swal({
                    title: "Are you sure to make checkin the booking?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#86BEBD",
                    confirmButtonText: "Make Check In",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        swal.close();  
                        popup_init();
                        var content = `<div class="popup_deceased">
                        <form id="confirm-checkin-booking" style="margin-top:30px">
                        @csrf 
                    <input type="hidden" name="id" value="{{$booking->id}}"> 
<div class="form-group "> 
<label for="amount">Minimum advance amount </label>
<div class="switch4" style="vertical-align:middle;float:right"> <input id="amount" class="check-toggle check-toggle-round-flat" type="checkbox" name="amount">        <label for="amount"></label>
<span class="on">No</span>  <span class="off">Yes</span>
                                                        </div>
                                                    </div><div class="form-group amount-data" style="
margin-top: 20px;display:none;
">
                    <label for="image" style="font-size: 16px;">Enter the amount</label>
<br> 
                    <input type="number" id="number" placeholder="Enter the amount" style="width: 100%; "name="price">
</div><div class="form-group">
    <label for="image" style=" font-size: 16px;
                                ">Total Price
                                </label> 
                                <br><span class="membership-price" style="
                                    font-size: 26px;
                                ">₹{{$booking->tariff}}</span> 
                                <br>
                                <div class="response-error" style="
                                    text-align: center;
                                    margin-bottom: 10px;
                                    color: red;
                                    font-size: 14px;
                                    display: none;
                                    ">
                                </div>
                                <div class="text-center m-b-0" style="/* background: #86BEBD; */">
                                <button class="confimr btn btn-custom waves-effect waves-light make-confirm" data-url="{{url('/')}}/party/confirm-checkin/{{$booking->id}}" type="button" style="background: #86BEBD;
                                        padding-left: 30px;padding-right: 30px;">Confirm</button>
                                </div>
                            <br> 
                                            </div>
                                            </form>
                                </div>`;
                        popup_data(content);

                        $("#amount").change(function() {
                            if ($(this).is(':checked')) {
                                console.log('Checkbox is checked');
                                $(".amount-data").show();   
                            } else {
                                $(".amount-data").hide();   
                                console.log('Checkbox is not checked');
                            }
                        });
                      
                        function formatDateToYMD(date) {
                            let year = date.getFullYear();
                            let month = String(date.getMonth() + 1).padStart(2, '0'); // Ensure two digits
                            let day = String(date.getDate()).padStart(2, '0'); // Ensure two digits
                        return `${year}-${month}-${day}`;
            }

            // Parse the check-in date from the backend and set it as the minimum date
            let checkinDate = new Date('{{$booking->checkin_date}}');
            let checkoutDate = new Date('{{$booking->checkout_date}}');
            $('#date').attr('min', formatDateToYMD(checkinDate));
            $('#date').attr('max', formatDateToYMD(checkoutDate));
            
                    }
                });
            });

            
$(document).on('click', '.sweet-delete2', function(e) {
                e.preventDefault();  
                let url = $(this).attr('data-url');
                let data_id = $(this).attr('data-id'); 

                swal({
                    title: "Are you sure to make checkout the booking?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#86BEBD",
                    confirmButtonText: "Make Check Out",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        swal.close();   
                        var form_data = new FormData($("#checkout-booking")[0]);
                    $.ajax({
                            url: '{{url("/")}}/party/confirm-checkout/{{$booking->id}}',
                            type:'get',  
                            cache: false, 
                            dataType:'json', 
                            success: function(res) {  
                                if(res.status)
                                {
                                   
                                    popup_init();
                                    popup_data(`<div class="popup-card"> 
                                        <div class="popup-card-content" style="text-align: center;"> 
                                        <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                                        <h4 style="font-weight: 600; ">Checkout Done Successfully</h4>
                                       
                                       
                    <div class="text-center m-b-0" style="/* background: #86BEBD; */">
                                <button class="generate_invoice btn btn-custom waves-effect waves-light make-confirm" data-url="{{url('/')}}/partyconfirm-checkout/{{$booking->id}}" type="button" style="background: #86BEBD;
                                        padding-left: 30px;padding-right: 30px;">Confirm</button>
                                </div> 
                                                                </div>
                                                                </div>
                                `);
                                window.location.href = '{{url("/")}}/party/view-invoice/{{$booking->id}}';
                                }

                            }
                        });
                                $("#add_charge").change(function() 
                                {
                                    if ($(this).is(':checked')) {
                                        console.log('Checkbox is checked');
                                        $(".amount-data1").show();   
                                    } else {
                                        $(".amount-data1").hide();   
                                        console.log('Checkbox is not checked');
                                    }
                                });
                        $(document).on('click', '.generate_invoice', function(e) {
                e.preventDefault();
                // alert("add_charge");
                let url = $(this).attr('data-url');
                let data_id = $(this).attr('data-id');
                $(".response-error").hide();
                $(this).addClass("spinner");
                console.log($("#date").val());
                console.log($("#add_charge").is(':checked'));
                var status = 1; 
                // alert($("#add_charge").is(':checked'));
                if($("#add_charge").is(':checked') === true){
                    if($("#number").val() == "" || $("#number").val() === undefined || $("#number").val() === null)
                    {
                        status = 0;
                        $(this).removeClass("spinner");
                    $(".response-error").show();
                    $(".response-error").html("Please select the amount");
                    } 
                } 
                if(status == 1)
                {
                    var form_data = new FormData($("#checkout-booking")[0]);
                    $.ajax({
                            url: '{{url("/")}}/party/confirm-checkout/{{$booking->id}}',
                            type:'post', 
                            data:form_data,
                            cache: false, 
                            dataType:'json',
                            contentType:false, // Default for form submissions
                            processData: false, // Tells jQuery to process the data (default: true) 
                            success: function(res) {  
                                if(res.status)
                                {
                                    window.location.href = '{{url("/")}}/party/view-invoice/{{$booking->id}}';
                    //                 popup_init();
                    //                 popup_data(`<div class="popup-card"> 
                    //                     <div class="popup-card-content" style="text-align: center;"> 
                    //                     <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                    //                     <h4 style="font-weight: 600; ">Checkout Done Successfully</h4>
                                       
                                       
                    // <div class="text-center m-b-0" style="/* background: #86BEBD; */">
                    //             <button class="generate_invoice btn btn-custom waves-effect waves-light make-confirm" data-url="{{url('/')}}/partyconfirm-checkout/{{$booking->id}}" type="button" style="background: #86BEBD;
                    //                     padding-left: 30px;padding-right: 30px;">Confirm</button>
                    //             </div> 
                    //                                             </div>
                    //                                             </div>
                    //             `);
                    //             $("#add_charge").change(function() {
                    //         if ($(this).is(':checked')) {
                    //             console.log('Checkbox is checked');
                    //             $(".amount-data1").show();   
                    //         } else {
                    //             $(".amount-data1").hide();   
                    //             console.log('Checkbox is not checked');
                    //         }
                    //     });
                                }

                            }
                        });
                    }

            });
                                
                        
            let checkinDate = new Date('{{$booking->checkin_date}}'); 
                       
                    }
                });
            });
            $(document).on('click', '.confimr', function(e) {
                let url = $(this).attr('data-url');
                let data_id = $(this).attr('data-id');
                $(".response-error").hide();
                $(this).addClass("spinner");
                console.log($("#date").val());
                console.log($("#amount").is(':checked'));
                var status = 1;
               
               
                if($("#amount").is(':checked') === true){
                    if($("#number").val() == "" || $("#number").val() === undefined || $("#number").val() === null)
                    {
                        status = 0;
                        $(this).removeClass("spinner");
                    $(".response-error").show();
                    $(".response-error").html("Please select the amount");
                    } 
                }
                console.log(status);
                if(status == 1)
                {
                    var form_data = new FormData($("#confirm-checkin-booking")[0]);
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
                                    popup_data(`  <div class="popup-card"> 
                                        <div class="popup-card-content" style="text-align: center;"> 
                                        <img src="{{asset('assets/img/Booking Confirmed.png')}}" style="margin:auto;width: 200px;height: 200px;" alt="">
                                        <h4 style="font-weight: 600; ">Checkin Done Successfully</h4>
                                        <a class="btn btn-success" style="font-size:16px;margin: auto;margin-top: 20px;" href="{{url("/")}}/party/view-invoice/{{$booking->id}}">View Invoice</a>
                                                                </div>
                                                                </div>
                                `);
                                window.location.href = '{{url("/")}}/party/view-invoice/{{$booking->id}}';

                                }

                            }
                        });
                }
            });
        </script>


        @endsection 