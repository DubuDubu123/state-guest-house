<!DOCTYPE html>
<html>
<head> 
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
  width: 450px;
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
        <tr>
        <td colspan="2" style="text-align: center;padding-top: 15px;width: 100%;">
            <img src="{{url('/')}}/assets/img/logo.png" style="width: 90px;padding-right: 5px;" alt="logo">
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
        </tr>
        <tr>
          <td style="vertical-align: top; margin-top: 10px;">
            <div class="info1">
              <h2><b>Customer Details</b></h2>
              <p style="line-height: 14px;width:230px">{{$user_details['name']}}<br>{{$user_details['address']}}<br>{{$user_details['mobile']}}<br></p>
            </div>
          </td>
          <td style="text-align: right; margin-top: 10px;">
            <div class="info1">
              <h2><b>Invoice Details</b></h2>
              <p style="line-height: 14px;">
                <b style="font-weight: 800;">#{{$invoice['invoice_number']}}</b><br>
                Issue date:  <?php 
                echo $invoice['issue_date'];
                 ?><br>
                Payment Due: <?php echo date('Y-m-d', strtotime($booking['checkout_date'])); ?><br><br>
              </p>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <table class="table border-gray-200 mt-3">
              <tbody>
              <tr>
                  <td class="px-0">Booking ID</td>
                  <td class="text-end px-0" style="text-align: right;">{{$booking['booking_id']}}</td>
                </tr>
                <tr>
                  <td class="px-0">Checkin Date</td>
                  <td class="text-end px-0" style="text-align: right;"><?php echo date('Y-m-d', strtotime($booking['checkin_date'])); ?></td>
                </tr>
                <tr>
                  <td class="px-0">Checkout Date</td>
                  <td class="text-end px-0" style="text-align: right;"><?php echo date('Y-m-d', strtotime($booking['checkout_date'])); ?></td>
                </tr>
                <tr>
                  <td class="px-0">Total Rooms Booked</td>
                  <td class="text-end px-0" style="text-align: right;">{{$booking['no_of_rooms']}}</td>
                </tr>
                <tr>
                  <td class="px-0">No of Guests</td>
                  <td class="text-end px-0" style="text-align: right;">{{$booking['no_of_guests']}}</td>
                </tr>
                <tr>
                <td class="px-0" style="font-weight: 700;padding-bottom:10px;">Room Pricing Details : </td>
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
    border-bottom: 1px solid #c9c9c9;text-align: center;
    /* border-right: 1px solid #c9c9c9; */
">
                                                <td style="
    border-right: 1px solid #c9c9c9;text-align: center;
    border-bottom: 1px solid #c9c9c9;
"> Room</td>
                                    
                                                <td style="
    border-right: 1px solid #c9c9c9;text-align: center;
    border-bottom: 1px solid #c9c9c9;
">Guest Type</td>

<td style="
    /* border-right: 1px solid #c9c9c9; */
    border-bottom: 1px solid #c9c9c9;text-align: center;
">Price</td>
                                    </tr> 
                                        </thead> 
                                        <tbody id="tariff">
                                              <tr>
                                              @foreach($booking_guest_details as $key=>$value)
               
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align: center;
">Room {{$key+1}}</td>
                                                <td style="
    border-right: 1px solid #c9c9c9;
    border-bottom: 1px solid #c9c9c9;text-align: center;
">
                                                {{ucfirst($value['guest_type'])}}
 
                                                </td>

                                                <td style=" 
    border-bottom: 1px solid #c9c9c9;text-align: center;
">
                                                ₹{{$value['per_day_price']}}
 
                                                </td> 
                                                </tr> 
                                                @endforeach
                                               </tbody></table>
                                               </td>
                                               </tr>
                                               
                                        @if($booking['status'] == 3 && $invoice['additional_charge'] > 0)
                <tr>
                
                  <td class="px-0" style="padding-top:10px">Restaurant Fee</td>
                  <td class="text-end px-0" style="text-align: right;color:#86bebd !important;font-size:12px"> + ₹{{$invoice['additional_charge']}}</td>
                </tr>
                @endif
                <tr>
                  <td class="px-0">Total Amount</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice['total_amount']}}</b>
                  </td>
                </tr>
                @if($booking['status'] == 3 && $invoice['initial_price'] > 0)
                <tr>
                  <td class="px-0">Advance Paid</td>
                  <td class="text-end px-0" style="text-align: right;color:red !important;font-size:12px"> - ₹{{$invoice['initial_price']}}</td>
                </tr>

                @if($invoice['amount_need_to_paid'] > 0)
                @if($invoice['additional_charge'] > 0)
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice['amount_need_to_paid'] + $invoice['additional_charge']}}</b></td>
                </tr>
                @else
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice['additional_charge']}}</b></td>
                </tr>
                @endif
                @endif
                @endif
               
                @if($booking['status'] == 1)
                @if($room_booking_price['initial_price_status'])
                <tr>
                  <td class="px-0">Advance Paid</td>
                  <td class="text-end px-0" style="text-align: right;color:#86bebd !important;font-size:12px"> - ₹{{$room_booking_price['initial_price']}}</td>
                </tr>
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$room_booking_price['amount_need_to_paid']}}</b></td>
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
</script>
   


</body>
</html>