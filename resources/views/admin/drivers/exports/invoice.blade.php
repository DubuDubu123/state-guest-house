<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        #wrap{
            display:flex;
            flex-wrap:nowrap;
        }
    </style>
</head>
<body>

@php $driverInvoice; @endphp
<!-- Modal for Alert -->
<div class="box" style="border:1px solid black;width:500px;margin-left:100px;">

<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<div class="container text-center" style="background:#043c6c;text-align:center;margin-top:-21px;">
<h1>Tax Invoice</h1>
</div> 
</div>
<div class="modal-body">
<div class="container">
<div class="row" id="wrap">
<div class="col-2">
<!-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/dd.png'))) }}" style="width:60px;" class="img-fluid" alt=""> -->
</div>
<div class="col-8" style="padding:5px;">
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Invoice-logo.png'))) }}" style="width:260px;" class="img-fluid" alt="">

</div>
<div class="col-2">
</div>
</div>
</div> 

<div class="container-fluid">
    @if($driverInvoice->is_subscription_invoice==true)
    <h5 class="bg-dark p-5 text-center" style="background:#465161;text-align:center;padding:10px 5px;color:white;font-size:16px;margin-top:20px;">Subscription Invoice</h5>        
    @else
    <h5 class="bg-dark p-5 text-center" style="background:#465161;text-align:center;padding:10px 5px;color:white;font-size:16px;margin-top:20px;">Invoice Details</h5>    
    @endif
<div class="container bg-gray p-3" style="display:flex;background:gray;padding:7px;margin-top:-31px;color:white;">
<div class="form-group mt-5" style="margin-top:5px;">
<label for="gst" style="margin-left:10px">Invoice # : {{ $driverInvoice->invoice_number }} </label>
<span style="margin-left:100px">Invoice Date :{{ $driverInvoice->getConvertedCreatedAtAttribute() }} </span> 
</div>
<!-- <h6 class="p-2" style="padding:6px 10px;font-size:14px;color:white;margin:5px 0 0 0;">Invoice # : {{ $driverInvoice->invoice_number }} </h6>
<h6 class="p-2" style="padding:6px 10px;font-size:14px;color:white;margin:0px 0 0 0;">Invoice Date :{{ $driverInvoice->getConvertedCreatedAtAttribute() }} </h6> -->
</div> 
<form id="invoiceForm" style="padding:10px;">

<div class="form-group mt-5" style="margin-top:0px;">
<label for="driverId"><span style="font-weight:800;">Driver Name</span> <span style="margin-left:20px">:</span> {{ $driverInvoice->driver->name }} </label>
</div>
<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">Driver ID</span> <span style="margin-left:43px">:</span> {{ $driverInvoice->driver->user->username }} </label>
</div>
<div class="form-group mt-5" style="margin-top:25px;">
<label for="phoneNumber"><span style="font-weight:800;">Phone Number</span> <span style="margin-left:8px">:</span> {{ $driverInvoice->driver->mobile }} </label>
</div>
{{--    @if($driverInvoice->is_subscription_invoice==true)
    <div class="form-group mt-5" style="margin-top:25px;">
    <label for="order_amount">Subscription Amount <span style="margin-left:5px">:</span> {{ $driverInvoice->invoice_amount }} </label>
    </div>    
    @else
    <div class="form-group mt-5" style="margin-top:25px;">
    <label for="order_amount">Order Amount <span style="margin-left:10px">:</span> {{ $driverInvoice->invoice_amount }} </label>
    </div>
    @endif --}}
<!-- <div class="form-group mt-5" style="margin-top:25px;">
<label for="gst">GST 18% <span style="margin-left:40px">:</span> {{ $driverInvoice->gst }}</label>
</div> -->

<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">Location</span> <span style="margin-left:53px">:</span> {{ $driverInvoice->driver->serviceLocation->name }} </label>
</div>
@if($driverInvoice->is_subscription_invoice==false)
<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">No.of Rides</span> <span style="margin-left:35px">:</span> {{ $driverInvoice->no_of_rides }} </label>
</div>
<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">From</span> <span style="margin-left:75px">:</span> {{ $driverInvoice->from }} </label>
</div>
<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">To</span> <span style="margin-left:95px">:</span> {{ $driverInvoice->to }} </label>
</div>
@else
<div class="form-group mt-5" style="margin-top:25px;">
<label for="driverId"><span style="font-weight:800;">Subscription</span> <span style="margin-left:32px">:</span> {{ $driverInvoice->driverSubscription->subscription_type }} </label>
</div>
@endif
<div class="form-group mt-5" style="margin-top:25px;border-top:1px solid black">

</div>


    @if($driverInvoice->is_subscription_invoice==true)
    <div class="form-group mt-5" style="margin-top:25px;">
    <label for="order_amount" style="font-weight:800;">Subscription Amount   </label>
    <span style="margin-left:280px"> <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $driverInvoice->invoice_amount }} </span> 
    </div>   
    @else
    <div class="form-group mt-5" style="margin-top:25px;">
    <label for="order_amount" style="font-weight:800;">Order Amount  </label>
    <span style="margin-left:320px"> <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $driverInvoice->invoice_amount }} </span> 
    </div>
    @endif 
     
<div class="form-group mt-5" style="margin-top:25px;">
<label for="gst" style="font-weight:800;">GST (18%) </label>
<span style="margin-left:346px"> <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $driverInvoice->gst }} </span> 
</div>

<div class="container-fluid form-group mt-5" style="margin-top:25px;background:#465161;padding:10px;color:white;">
<label for="total" style="font-weight:800;">Total Amount  </label>
<span style="margin-left:295px"> <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>
{{ $driverInvoice->amount }} </span> 
</div>

</form>
</div>
</div>
</div>
</div>
</div>
<!-- modal end -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

