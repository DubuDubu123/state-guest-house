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
    padding: 15px !important;
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
            <th> S.No</th>
            <th> Booking ID</th>
            <th>Officer's ID</th>
            <th>Officer's Name</th>
            <th>Check-in</th>
            <th>Guest Type</th>
            <th>Sports Type</th>
            <th>Booked By</th>
            <th>Payment Status</th>
            <th>Price</th> 
        </tr>
    </thead>
    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)
            <tr>
                <td>{{ $i++ }} </td>
                <td>{{$result->booking_id}} </td>
                <td>{{$result->user->userid}} </td>
                <td>{{$result->user->name}} </td>
                <td><?php echo date('Y-m-d', strtotime($result->checkin_date));?></td>
                <td>{{ucfirst($result->guest_type)}}</td>
                <td>@foreach($result->details as $k=>$v)
                    {{$v->tariff->name}}@if($k != (count($result->details)-1)),@endif
                @endforeach
                </td>
                <td>{{$result->booked_user->userid}} </td>
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
                <td>₹{{$result->tariff}}</td> 
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