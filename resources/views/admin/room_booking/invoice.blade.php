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
*{
  margin: 0;
  box-sizing: border-box;

}
body{
  background: #E0E0E0;
  font-family: 'Roboto', sans-serif;
  background-image: url('');
  background-repeat: repeat-y;
  background-size: 100%;
}
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
} 
#invoiceholder {
  width: 100%;
  height: 100%;
}

#headerimage {
  z-index: -1;
  position: relative;
  top: -50px;
  height: 350px;
  background-image: url('http://michaeltruong.ca/images/invoicebg.jpg');
  -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, .15), inset 0 -2px 4px rgba(0, 0, 0, .15);
  -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, .15), inset 0 -2px 4px rgba(0, 0, 0, .15);
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, .15), inset 0 -2px 4px rgba(0, 0, 0, .15);
  overflow: hidden;
  background-attachment: fixed;
  background-size: 1920px 80%;
  background-position: 50% -90%;
}

#invoice1 {
  position: relative;
  margin: 0 auto;
  width: 100%;
  max-width: 800px;
  background: #FFF;
}

[id*='invoice-'] {
  padding: 0px 30px 6px 30px;
}

.logo1 {
  height: 60px;
  width: 60px;
  background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
  background-size: 60px 60px;
}

.info {
  display: block;
  margin-top: 1px;
  text-align: center;
  width: 100%;
}

.info1 {
  margin-top: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

td {
  padding: 5px 15px; 
}

.tabletitle {
  padding: 5px;
  background: #EEE;
}

.itemtext {
  font-size: .9em;
}

#legalcopy {
  margin-top: 30px;
}

form {
  float: right;
  margin-top: 30px;
  text-align: right;
}

.effect2 {
  position: relative;
}

.effect2:before,
.effect2:after {
  z-index: -1;
  position: absolute;
  content: "";
  bottom: 15px;
  left: 10px;
  width: 50%;
  top: 80%;
  max-width: 300px;
  background: #777;
  -webkit-box-shadow: 0 15px 10px #777;
  -moz-box-shadow: 0 15px 10px #777;
  box-shadow: 0 15px 10px #777;
  -webkit-transform: rotate(-3deg);
  -moz-transform: rotate(-3deg);
  -o-transform: rotate(-3deg);
  -ms-transform: rotate(-3deg);
  transform: rotate(-3deg);
}

.effect2:after {
  -webkit-transform: rotate(3deg);
  -moz-transform: rotate(3deg);
  -o-transform: rotate(3deg);
  -ms-transform: rotate(3deg);
  transform: rotate(3deg);
  right: 10px;
  left: auto;
}

.legal {
  width: 70%;
}

h2 {
  font-size: .9em;
  padding: 0px !important;
  margin: 0px;
  line-height: 25px;
}

.table > tbody > tr > td,
.table > tbody > tr > th,
.table > tfoot > tr > td,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > thead > tr > th {
  padding: 6px 0px 3px 0px !important;
}

table.table.border-gray-200.mt-3 tr td {
  border: none;
}

#invoice {
  position: relative;
  margin: 0 auto;
  width: 450px;
}

.content {
  margin-top: 0px !important;
}

table#room-tariff thead tr td{
    background:#0eb7cc;
    color:white
} 
i.mdi.mdi-keyboard-backspace.mr-2 {
    color: white;
}
</style>
<!-- Start Page content --> 
<section class="content" style="margin-left:25px">
    


        <div class="row" style="margin-top:30px;margin-left:0px">
        <div style="
    display: block;
    width: 100%;
    text-align: right;
    margin-right: 20px;
">
<a href="http://iasmess.dubudubutechnologies.com/room-booking">
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    Back                                </button>
                            </a>
 </div>
        <div class="box-header with-border">
        
                        <div style="color:black;font-size:18px">
                            <h5 class="font-weight-600 p-5" style="color:black;font-size:21px">View Invoice </h5>
                        </div>

                    </div>
                    <div class="col-12">
                                <!-- <a href="http://localhost/ias-mess/public/users"> -->
                                 <div id="invoiceholder">
  <div id="invoice" class="effect2">
    <div class="page-tools" style="text-align: right;">
      <div class="action-buttons" style="margin-bottom: 20px;">
        <a class="btn bg-white btn-light mx-1px text-95" href="{{url('/')}}/types/export_pdf/{{$booking->id}}" data-title="PDF" style="background: #86bebd !important; color: white;">
          <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2" style="color: white;"></i> Export PDF
        </a>
      </div>
    </div>
    
    <div id="invoice1" class="effect3">
      <table style="width: 100%;">
        <tr>
        <td colspan="2" style="text-align: center;padding-top: 15px;width: 100%;">
            <img src="{{asset('assets/img/logo.png')}}" style="width: 90px;padding-right: 5px;" alt="logo">
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">
            <div class="info">
              <h2 style="line-height:14px"><b>IAS Officer's MESS</b></h2>
              <p style="font-size: 10px; line-height: 17px; margin-bottom: 0px !important;">protocol@tn.gov.in</p>
              <p style="font-size: 10px; line-height: 14px;">289-335-6503</p>
            </div>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top; margin-top: 10px;">
            <div class="info1">
              <h2><b>Officer's Details</b></h2>
              <p style="line-height: 14px;width:230px">{{$booking->user->name}}<br>{{$booking->user->address}}<br>{{$booking->user->mobile}}<br></p>
            </div>
          </td>
          <td style="text-align: right; margin-top: 10px;">
            <div class="info1">
              <h2><b>Invoice Details</b></h2>
              <p style="line-height: 14px;">
                <b style="font-weight: 800;">#{{$invoice->invoice_number}}</b><br>
                Issue date:
                <?php
                $now = time();
                echo date('Y-m-d', $now);
                 ?><br>
                Payment Due:<?php echo date('Y-m-d', strtotime($booking->checkout_date)); ?><br><br>
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <table class="table border-gray-200 mt-3">
              <tbody>
                <tr>
                  <td class="px-0">Checkin Date</td>
                  <td class="text-end px-0" style="text-align: right;">
                <?php echo date('Y-m-d', strtotime($booking->checkin_date)); ?></td>
                </tr>
                <tr>
                  <td class="px-0">Checkout Date</td>
                  <td class="text-end px-0" style="text-align: right;">
                <?php echo date('Y-m-d', strtotime($booking->checkout_date)); ?></td>
                </tr>
                <tr>
                  <td class="px-0">Total Rooms Booked</td>
                  <td class="text-end px-0" style="text-align: right;">{{$booking->no_of_rooms}}</td>
                </tr>
                <tr>
                  <td class="px-0">No of Guests</td>
                  <td class="text-end px-0" style="text-align: right;">{{$booking->no_of_guests}}</td>
                </tr>
                <tr>
                <td class="px-0" style="font-weight: 700;padding-bottom:10px !important;">Room Pricing Details : </td>
                </tr>
                
                <tr style="
    width: 100%;
    border: 1px solid #e7e7e7;
">
                  <td colspan="5" style="
    border: 1px solid #d0d0d0;
    padding-top: 1px !important;
    padding-bottom: 0px !important;
">
    <table id="room-tariff"> <thead> 
                                    <tr style="
    border-bottom: 1px solid #c9c9c9;
    /* border-right: 1px solid #c9c9c9; */
">
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align:center;
"> Room</td>
                                    
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align:center;
">Guest Type</td>

<td style="
    /* border-right: 1px solid #c9c9c9; */
    border-bottom: 1px solid #c9c9c9;text-align:center;
">Price</td>
                                    </tr> 
                                        </thead> 
                                        <tbody id="tariff">
                                              <tr>
                                              @foreach($booking->booking_guest_details as $key=>$value)
               
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align:center;
">Room {{$key+1}}</td>
                                                <td style="  border-right: 1px solid #c9c9c9;border-bottom: 1px solid #c9c9c9;text-align:center;">
                                                {{ucfirst($value->guest_type)}} 
                </td> 
                <td style=" border-bottom: 1px solid #c9c9c9;text-align:center;">
                ₹{{$value->per_day_price}}

                </td> 
                </tr> 
                @endforeach
                </tbody></table>
                </td>
                </tr> 
                @if($booking->status == 3 && $invoice->additional_charge > 0)
                <tr>
                <br>
                  <td class="px-0" style="padding-top:10px">Restaurant Fee</td>
                  <td class="text-end px-0" style="text-align: right;color:#86bebd !important;font-size:12px"> + ₹{{$invoice->additional_charge}}</td>
                </tr>
                @endif
              
                <tr>
                  <td class="px-0">Total Amount</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice->total_amount}}</b>
                  </td>
                </tr>
                @if($booking->status == 3 && $booking->booked_price->initial_price > 0)
                <tr>
                  <td class="px-0">Advance Paid</td>
                  <td class="text-end px-0" style="text-align: right;color:red !important;font-size:12px"> - ₹{{$booking->booked_price->initial_price}}</td>
                </tr>

                @if($booking->booked_price->amount_need_to_paid > 0)
                @if($invoice->additional_charge > 0)
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice->amount_need_to_paid + $invoice->additional_charge}}</b></td>
                </tr>
                @else
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice->additional_charge}}</b></td>
                </tr>
                @endif
                @endif
                @endif
                @if($booking->status == 1)
                @if($booking->booked_price->initial_price_status)
                <tr>
                  <td class="px-0">Advance Paid</td>
                  <td class="text-end px-0" style="text-align: right;color:#86bebd !important;font-size:12px"> - ₹{{$booking->booked_price->initial_price}}</td>
                </tr>
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$booking->booked_price->amount_need_to_paid}}</b></td>
                </tr>
                @endif
                @endif
                
              </tbody>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

                                    <!-- </a> -->
                                </div>
                            </div>

                        </section>
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
                let url = "{{url('/')}}/types/book-now";
                
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

                    fetch('types/fetch?search=' + search_keyword)
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
                            url: '{{url("/")}}/types/cancel-booking/'+data_id+'', 
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
        </script>


        @endsection 