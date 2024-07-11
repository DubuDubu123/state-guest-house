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
</style>
</head> 
<body>
<div id="invoiceholder">
  <div id="invoice" class="effect2">
   
    
    <div id="invoice1" class="effect3">
      <table style="width: 100%;">
        <tr>
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
              <p style="line-height: 14px;">{{$user_details['name']}}<br>{{$user_details['address']}}<br>{{$user_details['mobile']}}<br></p>
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
                Payment Due: <?php echo date('Y-m-d', strtotime($booking['checkin_date'])); ?><br><br>
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
                  <td class="text-end px-0" style="text-align: right;"><?php echo date('Y-m-d', strtotime($booking['checkin_date'])); ?></td>
                </tr>
                
                 
                @if($booking['is_lawn'])
                <tr>
                
                <td class="px-0" style="padding-top:10px">Lawn availability</td>
                <td class="text-end px-0" style="text-align: right;font-size:12px">Yes</td>
              </tr>
                <tr>
                
                  <td class="px-0" style="padding-top:10px">Lawn Price</td>
                  <td class="text-end px-0" style="text-align: right;color:#86bebd !important;font-size:12px"> + ₹{{$booking['lawn_amount']}}</td>
                </tr>
                @else
                <tr>
                
                <td class="px-0" style="padding-top:10px">Lawn availability</td>
                <td class="text-end px-0" style="text-align: right;font-size:12px">No</td>
              </tr>
                @endif 
                 @if($booking['status'] == 2 && $invoice['additional_charge'] > 0)
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
                @if($booking['status'] == 2 && $invoice['initial_price'] > 0)
                <tr>
                  <td class="px-0">Advance Amount</td>
                  <td class="text-end px-0" style="text-align: right;color:red !important;font-size:12px"> - ₹{{$invoice['initial_price']}}</td>
                </tr>
                <tr style="border-top:1px solid #d9d9d9;padding-top:10px">
                  <td class="px-0" >Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice['amount_need_to_paid']}}</b></td>
                </tr>
                @endif
                @if($booking['status'] == 1)
                @if($invoice['initial_price_status'])
                <tr>
                  <td class="px-0">Advance Amount</td>
                  <td class="text-end px-0" style="text-align: right;color:red !important;font-size:12px"> - ₹{{$invoice['initial_price']}}</td>
                </tr>
                <tr>
                  <td class="px-0">Amount to be Paid</td>
                  <td class="text-end px-0" style="text-align: right; font-weight: bold !important;">
                    <b style="font-weight: bold; font-size: 17px; color: black;">₹{{$invoice['amount_need_to_paid']}}</b></td>
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