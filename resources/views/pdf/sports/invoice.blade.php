<!DOCTYPE html><html><head> 
    <title>IAS Mess - Admin App</title> 
    <!-- App favicon --> 
    <style>
    body {
            font-family: 'DejaVu Sans', sans-serif;
        }
p{
  font-size: .7em;
  color: #666; 
} 
#invoiceholder {
  width: 100%;
  height: 100%;
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
  /* background: #EEE; */
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

.legal {
  width: 70%;
}

h2 {
  font-size: .9em;
  padding: 0px !important;
  margin: 0px; 
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
  width: 550px;
}

.content {
  margin-top: 0px !important;
}
table#room-tariff thead tr td{
    background:#0eb7cc;
    color:white
} 
</style>
</head> 
<body>
<div id="invoiceholder">
  <div id="invoice" class="effect2">
   
    
    <div id="invoice1" class="effect3">
      <table style="width: 100%;">
        <tbody><tr>
        <td colspan="2" style="text-align: center;padding-top: 15px;width: 100%;">
            <img src="http://localhost/ias-mess/public/assets/img/logo.png" style="width: 90px;padding-right: 5px;" alt="logo">
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">
            <div class="info">
              <h2 style="line-height:14px"><b>IAS Office's MESS</b></h2>
              <p style="font-size: 10px; line-height: 10px !important; margin-bottom: 0px !important;">protocol@tn.gov.in</p>
              <p style="font-size: 10px; line-height: 10px !important">289-335-6503</p>
            </div>
          </td>
        </tr>
        <tr>
          <td style="vertical-align: top; margin-top: 10px;">
            <div class="info1">
              <h2><b>Officer's Details</b></h2>
              <p style="line-height: 14px;">{{$booking->user->name}}<br>{{$booking->user->address}}<br>{{$booking->user->mobile}}<br></p>
            </div>
          </td>
          <td style="text-align: right; margin-top: 10px;">
            <div class="info1">
              <h2><b>Invoice Details</b></h2>
              <p style="line-height: 14px;">
                <b style="font-weight: 800;">#500008</b><br>
                Booked date: <?php echo date('Y-m-d', strtotime($booking->created_at)); ?><br>
                Payment Date:<?php echo date('Y-m-d', strtotime($booking->checkin_date)); ?><br><br>
              </p>
            </div>
          </td>
        </tr>
        
</tbody></table><table style="width: 100%;">
        <tbody>
        
        <tr>
          <td style="
    /* width: 75%; */
">
            <table class="table border-gray-200 mt-3" style="
    width: 100%;
">
              <tbody>
              <tr>
               <td class="px-0">Booking ID</td>
                  <td class="text-end px-0" style="text-align: right;">
                {{$booking->booking_id}}</td>
                </tr>
                <tr>
                  <td class="px-0">Start Date</td>
                  <td class="text-end px-0" style="text-align: right;">
                  <?php echo date('Y-m-d', strtotime($booking->checkin_date)); ?></td>
                </tr>
                
                <tr>
                <td class="px-0" style="
    padding-bottom: 15px !important;
">End Date</td>
                 <td class="text-end px-0" style="text-align: right;padding-bottom: 13px !important;">
                 <?php echo date('Y-m-d', strtotime($booking->checkout_date)); ?></td>
                </tr>
                
</tbody>
</table>
<table id="room-tariff" style="    border: 1px solid #d0d0d0;    padding-top: 1px !important;    padding-bottom: 0px !important;">
<thead> 
                                    <tr style="
    border-bottom: 1px solid #c9c9c9;
    /* border-right: 1px solid #c9c9c9; */
">
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align:center;
"> S.No</td>
                                    
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align:center;
">Sports Type</td>

<td style="
    /* border-right: 1px solid #c9c9c9; */
    border-bottom: 1px solid #c9c9c9;text-align:center;
">Price</td>
                                    </tr> 
                                        </thead> 
                                        <tbody id="tariff">
@foreach($booking->details as $key=>$value)
 <tr> 
  <td style=" border-right: 1px solid #c9c9c9;  border-bottom: 1px solid #c9c9c9;text-align:center;">
  {{$key+1}}</td>
  <td style="  border-right: 1px solid #c9c9c9;border-bottom: 1px solid #c9c9c9;text-align:center;">{{$value->tariff->name}}
                </td> 
  <td style=" border-bottom: 1px solid #c9c9c9;text-align:center;">
                ₹{{$value->price}}
                </td> 
  </tr>  
@endforeach  
</tbody></table>  
<table class="table border-gray-200 mt-3" style="  width: 100%;">
<tbody>  
        <tr>
          <td class="px-0">Total Amount</td>
          <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
            <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$booking->tariff}}</b>
          </td>
        </tr>
      </tbody></table>    
</td></tr>
        
</tbody></table></div></div></div>





 </body></html>