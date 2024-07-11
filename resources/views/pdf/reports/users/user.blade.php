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
table.table-hover {
        width: 100%;
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
">    </div>
          </td>
        </tr> 
        <tr>
          <td colspan="2" style="text-align: left;">
<h3 style="line-height:14px;font-size: 15px;margin-bottom: 20px;"><b>Officer's List</b></h3>
<table class="table table-hover">
                                            <thead>
                                                <tr>


                                                    <th style="font-size:10px;text-align:center">  S.No
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th style="font-size:10px;text-align:center">  User ID
                                                        <span style="float: right;"></span>
                                                    </th>
                                                    <th style="font-size:10px;text-align:center">  Officer's Name
                                                        <span style="float: right;"></span>
                                                    </th>
                                                   
                                                    <th style="font-size:10px;text-align:center">  Email address
                                                        <span style="float: right;"> </span>
                                                    </th>
                                                    <th style="font-size:10px;text-align:center">  Mobile Number
                                                        <span style="float: right;"></span>
                                                    </th>  
                                                    <th style="font-size:10px;text-align:center">  Address
                                                        <span style="float: right;"></span>
                                                    </th>  
                                                    <th style="font-size:10px;text-align:center">  Status
                                                        <span style="float: right;"></span>
                                                    </th> 
                                                </tr>
                                            </thead>
                                       
<tbody>
 

@foreach($value['data'] as $k=>$val)
<tr>
<td style="font-size:10px;text-align:center">{{$k+1}} </td>
<td style="font-size:10px;text-align:center"> {{$val->userid}}</td> 
<td style="font-size:10px;text-align:center"> {{$val->name}}</td> 

<td style="font-size:10px;text-align:center">{{$val->email}}</td>
<td style="font-size:10px;text-align:center">{{$val->mobile}}</td>  
<td style="font-size:10px;text-align:center">{{$val->address}}</td>  
   
@if ($val->is_approve == 0 && $val->is_deleted == false)
    <td style="font-size:10px;text-align:center"><span class="label label-success">Pending</span></td>
    @elseif ($val->is_approve == 1 && $val->is_deleted == false)
    <td style="font-size:10px;text-align:center"><span class="label label-success">Approved</span></td>
    @elseif($val->is_deleted == true)  
    <td style="font-size:10px;text-align:center"><span class="label label-success">Deceased</span></td>
    @endif    
</tr>
  @endforeach
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