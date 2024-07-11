@extends('admin.layouts.app')

@section('title', 'Company page')

@section('content')
<div class="box-header with-border" style="margin-top:10px;">
            <a href="{{url('/drivers')}}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>
<!-- Modal for Alert -->
<div class="box">

<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<div class="container text-center" style="background:#043c6c;">
<h1>Tax Invoice</h1>
</div> 
</div>
<div class="modal-body">
<div class="container">
<div class="row">
<div class="col-2">
<img src="{{asset('assets/img/dd.png')}}" style="width:60px;" class="img-fluid" alt="">
</div>
<div class="col-8">
<h4>Dubu Dubu India Pvt Ltd.</h4>
<h4>GSTIN: <strong>34AAJCD9326N1Z5</strong> </h4>
</div>
<div class="col-2">
</div>
</div>
</div> 
<div class="container bg-gray p-3">
<h6 class="p-2">Invoice # : {{ $driverInvoice->invoice_number }} </h6>
<h6 class="p-2">Invoice Date :{{ $driverInvoice->getConvertedCreatedAtAttribute() }} </h6>
</div> 
<div class="container-fluid mt-5">
    @if($driverInvoice->is_subscription_invoice==true)
    <h5 class="bg-dark p-5 text-center">Subscription Invoice</h5>        
    @else
    <h5 class="bg-dark p-5 text-center">Invoice Details</h5>    
    @endif
<form id="invoiceForm">
<div class="form-group mt-5">
<label for="driverName">Driver Name :{{ $driverInvoice->driver->name }} </label>
</div>    
<div class="form-group mt-5">
<label for="driverId">Driver ID :{{ $driverInvoice->driver->user->username }} </label>
</div>
<div class="form-group mt-5">
<label for="phoneNumber">Phone Number :{{ $driverInvoice->driver->mobile }} </label>
</div>
<div class="form-group mt-5">
<label for="location">Location :{{ $driverInvoice->driver->serviceLocation->name }} </label>
</div>
@if($driverInvoice->is_subscription_invoice==false)
<div class="form-group mt-5">
<label for="no_of_rides">No Of Rides :{{ $driverInvoice->no_of_rides }} </label>
</div>
<div class="form-group mt-5">
<label for="from">From :{{ $driverInvoice->from }} </label>
</div>
<div class="form-group mt-5">
<label for="to">To :{{ $driverInvoice->to }} </label>
</div>
@else
<div class="form-group mt-5">
<label for="from">From :{{ $driverInvoice->driverSubscription->getConvertedCreatedAtYearAttribute() ?? "-" }} </label>
</div>
<div class="form-group mt-5">
<label for="to">To :{{ $driverInvoice->driverSubscription->getConvertedExpiredAtAttribute() ?? "-" }} </label>
</div>
@endif

    @if($driverInvoice->is_subscription_invoice==true)
    <div class="form-group mt-5">
    <label for="order_amount">Subscription Amount :{{ $driverInvoice->invoice_amount }} </label>
    </div>    
    @else
    <div class="form-group mt-5">
    <label for="order_amount">Order Amount :{{ $driverInvoice->invoice_amount }} </label>
    </div>
    @endif
<div class="form-group mt-5">
<label for="gst">GST 18% : {{ $driverInvoice->gst }}</label>
</div>
<div class="form-group mt-5">
<label for="total">Total Amount : {{ $driverInvoice->amount }}</label>
</div>
</form>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" id="">
<a href="{{ route('generate-invoice.pdf', $driverInvoice->id) }}" target="_blank">PDF</a>	
</button>
</div>
</div>
</div>
</div>
<!-- modal end -->

 @endsection