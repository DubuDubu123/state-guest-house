<!DOCTYPE html> 

<html><head> 
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
  width: 100%;
}

.content {
  margin-top: 0px !important;
}
table#room-tariff thead tr td{
    background:#0eb7cc;
    color:white
} 
table.table.table-hover thead th, table.table.table-hover tr td {
    border: 1px solid #d8d8d8;
    padding: 10px !important;
    font-size: 13px;
}
table.table.table-hover {
        width: 100%;
        border-collapse: collapse;
        font-size: 5px !important; /* Adjust the font size as needed */
    }
.table .total-row td {
  font-weight: bold;
}

.table .total-row td:first-child {
    text-align: right;
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
            <img src="http://iasmess.dubudubutechnologies.com/assets/img/logo.png" style="width: 90px;padding-right: 5px;" alt="logo">
          </td>
        </tr>
        
        <tr>
          <td colspan="2" style="text-align: center;">
            <div class="info">
              <h2 style="line-height:14px"><b>IAS Officer's MESS</b></h2>
              <p style="font-size: 10px; line-height: 10px !important; margin-bottom: 0px !important;">protocol@tn.gov.in</p>
              <p style="font-size: 10px; line-height: 10px !important">289-335-6503</p>
            </div>
          </td>
        </tr><tr>
          <td colspan="2" style="text-align: left;">
            <div class="info" style="
    text-align: left;
">
              <h2 style="line-height:14px;font-size: 20px;margin-bottom: 0px;"><b>Today Earnings : </b></h2>


              
              
            </div>
          </td>
        </tr>
        


        <tr>
          <td colspan="2" style="text-align: left;">
<h3 style="line-height:14px;font-size: 15px;margin-bottom: 20px;"><b>1.Room Booking</b></h3>
<table class="table table-hover" >
                                            <thead>
                                                <tr> 
                                                    <th style="font-size:11px;text-align:center"> S.No
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th style="font-size:11px;text-align:center"> Booking ID
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center"> Officer's Name
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <!-- <th style="font-size:11px;text-align:center">  Tansport Type<span style="float: right;">
</span>
</th> -->
                                                    <th style="font-size:11px;text-align:center"> Check-in 
                                                        <span style="float: right;"> </span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center"> check-out
                                                        <span style="float: right;"></span>
                                                    </th>
                                                  
                                                    
                                                    <th style="font-size:11px;text-align:center"> Payment Status
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center"> Price
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    

                                                </tr>
                                            </thead>
                                       
<tbody>
 
@if(count($value['data']) > 0)
@foreach($value['data'] as $key=>$v)
<tr>
<td style="font-size:11px;text-align:center">{{$key+1}} </td>
<td style="font-size:11px;text-align:center"> {{$v->booking_id}}</td> 
<td style="font-size:11px;text-align:center"> {{$v->user->name}}</td> 

<td style="font-size:11px;text-align:center"><?php echo date('Y-m-d', strtotime($v->checkin_date)); ?></td>
<td style="font-size:11px;text-align:center"><?php echo date('Y-m-d', strtotime($v->checkout_date)); ?></td>  
  
<td style="font-size:11px;text-align:center"><button class="btn btn-success btn-sm" style="  background: green;color:white;border-color: transparent;
">Paid</button>
</td>
<td style="font-size:11px;text-align:center">₹{{$v->booked_price->total_price}}</td>    
</tr>
@endforeach
@else
<tr>
  <td style="font-size:14px;text-align:center" colspan="7"> No Data Found</td> 
</tr>
@endif
@if($value['month_earnings'][0] > 0)
<tr class="total-row"> 
<td colspan="5" style="border:none"></td>

<td  style="
    text-align: center;
    font-size: 13px;
    font-weight: 700;
">Total Earnings</td>  
   
<td style="
    font-weight: bold;
">  
₹{{$value['month_earnings'][0]}} 
</td>    
</tr>
@endif
</tbody>
</table>
          </td>
        </tr>

        <tr>
          <td colspan="2" style="text-align: left;">
<h3 style="line-height:14px;font-size: 15px;margin-bottom: 20px;"><b>2.Party Hall / Lawn Booking</b></h3>
<table class="table table-hover" >
                                            <thead>
                                                <tr>


                                                    <th style="font-size:11px;text-align:center">  S.No
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th style="font-size:11px;text-align:center">  Booking ID
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center">  Officer's Name
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <!-- <th style="font-size:11px;text-align:center">  Tansport Type<span style="float: right;">
</span>
</th> -->
                                                    <th style="font-size:11px;text-align:center">  Check-in 
                                                        <span style="float: right;"> </span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center">  Guest Type
                                                        <span style="float: right;"></span>
                                                    </th> 
                                                    <th style="font-size:11px;text-align:center">  Payment Status
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <th style="font-size:11px;text-align:center">  Price
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    

                                                </tr>
                                            </thead>
                                       
                                            <tbody>
 
 @if(count($value['party_data']) > 0)
 @foreach($value['party_data'] as $key=>$v)
 <tr>
 <td style="font-size:11px;text-align:center">{{$key+1}} </td>
 <td style="font-size:11px;text-align:center"> {{$v->booking_id}}</td> 
 <td style="font-size:11px;text-align:center"> {{$v->user->name}}</td> 
 
 <td style="font-size:11px;text-align:center"><?php echo date('Y-m-d', strtotime($v->checkin_date)); ?></td>
 <td style="font-size:11px;text-align:center">{{$v->guest_type}}</td>  
   
 <td style="font-size:11px;text-align:center"><button class="btn btn-success btn-sm" style="  background: green;color:white;border-color: transparent;
 ">Paid</button>
 </td>
 <td style="font-size:11px;text-align:center">₹{{$v->tariff}}</td>    
 </tr>
 @endforeach
 @else
 <tr>
   <td style="font-size:14px;text-align:center" colspan="7"> No Data Found</td> 
 </tr>
 @endif
 @if($value['month_earnings'][1] > 0)
 <tr class="total-row"> 
 <td colspan="5" style="border:none"></td>
 
 <td  style="
     text-align: center;
     font-size: 12px;
     font-weight: 700;
 ">Total Earnings</td>  
    
 <td style="
     font-weight: bold;
 ">  
 ₹{{$value['month_earnings'][1]}} 
 </td>    
 </tr>
 @endif
 </tbody>
</table>
          </td>
        </tr><tr>
          <td colspan="2" style="text-align: left;">
<h3 style="line-height:14px;font-size: 15px;margin-bottom: 20px;"><b>3.Sports Booking</b></h3>
<table class="table table-hover">
                                            <thead>
                                            <tr>


<th style="font-size:11px;text-align:center">  S.No
    <span style="float: right;"></span>
</th>

<th style="font-size:11px;text-align:center">  Booking ID
    <span style="float: right;"></span>
</th>
<th style="font-size:11px;text-align:center">  Officer's Name
    <span style="float: right;"></span>
</th>
<!-- <th style="font-size:11px;text-align:center">  Tansport Type<span style="float: right;">
</span>
</th> -->
<th style="font-size:11px;text-align:center">  Check-in 
    <span style="float: right;"> </span>
</th>
<th style="font-size:11px;text-align:center">  Guest Type
    <span style="float: right;"></span>
</th> 
<th style="font-size:11px;text-align:center">  Payment Status
    <span style="float: right;"></span>
</th>
<th style="font-size:11px;text-align:center">  Price
    <span style="float: right;"></span>
</th>



</tr>
                                            </thead>
                                       
                                            <tbody>
 
 @if(count($value['sports_data']) > 0)
 @foreach($value['sports_data'] as $key=>$v)
 <tr>
 <td style="font-size:11px;text-align:center">{{$key+1}} </td>
 <td style="font-size:11px;text-align:center"> {{$v->booking_id}}</td> 
 <td style="font-size:11px;text-align:center"> {{$v->user->name}}</td> 
 
 <td style="font-size:11px;text-align:center"><?php echo date('Y-m-d', strtotime($v->checkin_date)); ?></td>
 <td style="font-size:11px;text-align:center">{{$v->guest_type}}</td>  
   
 <td style="font-size:11px;text-align:center"><button class="btn btn-success btn-sm" style="  background: green;color:white;border-color: transparent;
 ">Paid</button>
 </td>
 <td style="font-size:11px;text-align:center">₹{{$v->tariff}}</td>    
 </tr>
 @endforeach
 @else
 <tr>
   <td style="font-size:14px;text-align:center" colspan="7"> No Data Found</td> 
 </tr>
 @endif
 @if($value['month_earnings'][2] > 0)
 <tr class="total-row"> 
 <td colspan="5" style="border:none"></td>
 
 <td  style="
     text-align: center;
     font-size: 12px;
     font-weight: 700;
 ">Total Earnings</td>  
    
 <td style="
     font-weight: bold;
 ">  
 ₹{{$value['month_earnings'][2]}} 
 </td>    
 </tr>
 @endif
 </tbody>
</table>
          </td>
        </tr> 
        
              </tbody>
            </table>
          
        
      
    </div>
  </div>
</div>

   



</body></html>