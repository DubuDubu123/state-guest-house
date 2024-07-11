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
  padding: 6px 0px 11px 0px !important;
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
    padding: 15px !important;
}
.table .total-row td {
  font-weight: bold;
}

.table .total-row td:first-child {
    text-align: right;
}
table.table-hover th,
    table.table-hover td {
        /* Example widths; adjust as needed */
        min-width: 50px !important; /* Minimum width */
        max-width: 150px !important; /* Maximum width */
        word-wrap: break-word; /* Wrap long text */
    }
    table.table-hover td {
        white-space: nowrap; /* Prevent text wrapping */
        overflow: hidden; /* Hide overflow if necessary */
        text-overflow: ellipsis; /* Show ellipsis for overflow */
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
              <h2 style="line-height:14px;font-size: 20px;margin-bottom: 10px;"><b>Room Booking Report </b></h2>


              
              
            </div>
          </td>
        </tr>
        

 

        <tr>
          <td colspan="2" style="text-align: left;"> 
          <table class="table table-hover">
    <thead>
        <tr>
            <th style="font-size:11px"> S.No</th>
            <th style="font-size:11px"> Booking ID</th> 
            <th style="font-size:11px">Officer's ID</th>
            <th style="font-size:11px">Officer's Name</th>
            <th style="font-size:11px"> Check-in</th>
            <th style="font-size:11px"> Check-out</th>
            <th style="font-size:11px"> Actual Check-in</th>
            <th style="font-size:11px"> Actual Check-out</th> 
            <th style="font-size:11px"> Payment Status</th>
            <th style="font-size:11px"> Price</th> 
        </tr>
    </thead>
    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)
            <tr>
                <td style="font-size:11px">{{ $i++ }} </td>
                <td style="font-size:11px">{{$result->booking_id}} </td>
                <td style="font-size:11px">{{$result->user->userid}} </td>
                <td style="font-size:11px">{{$result->user->name}} </td>
                <td style="font-size:11px"><?php echo date('Y-m-d', strtotime($result->checkin_date));?></td>
                <td style="font-size:11px"><?php echo date('Y-m-d', strtotime($result->checkout_date));?></td>
                @if($result->status == 1 && $result->status == 3)
                <td style="font-size:11px;max-width:50px"><?php echo date('Y-m-d H:i:s', strtotime($result->actual_checkin_date));?></td>
                @else
                <td style="font-size:11px;max-width:50px">--------</td>
                @endif
                @if($result->status == 3)
                <td style="font-size:11px;max-width:50px"><?php echo date('Y-m-d H:i:s', strtotime($result->actual_checkout_date));?></td>
                @else
                <td style="font-size:11px;max-width:50px">--------</td>
                @endif   
                <td style="font-size:11px;text-align:center"> 
                    @if($result->is_paid == 1)
                    <button class="btn btn-success btn-sm" style="background: green;color:white;border-color: transparent;">
                    Paid
                    </button>
                    @else
                    <button class="btn btn-danger btn-sm" style="background: green;color:white;border-color: transparent;">
                    Unpaid
                    </button>
                    @endif 
                </td>
                <td style="font-size:11px">₹{{$result->booked_price->total_price}}</td> 
            </tr>
        @empty
            <tr>
                <td colspan="11">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </td>
            </tr>
        @endforelse

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