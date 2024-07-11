@extends('admin.layouts.app')

@section('title', 'Company page')

@section('content')
<div class="box-header with-border" style="margin-top:10px;">
<a href="{{ url('/drivers/subscriptions/' . $driverSubscription->driver->id) }}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>
<!-- Modal Data -->
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
<h6 class="p-2">Subscription Type # : {{ $driverSubscription->subscription_type }} </h6>
<h6 class="p-2">subscription Date :{{ $driverSubscription->getConvertedCreatedAtYearAttribute() }} </h6>
</div> 
<div class="container-fluid mt-5">
<h5 class="bg-dark p-5 text-center">Subscription Invoice Details</h5>
<form id="invoiceForm">
<div class="form-group mt-5">
<label for="driverId">Driver ID :{{ $driverSubscription->driver->user->username ?? "-" }} </label>
</div>
<div class="form-group mt-5">
<label for="phoneNumber">Phone Number :{{ $driverSubscription->driver->mobile ?? "-" }} </label>
</div>
<div class="form-group mt-5">
<label for="order_amount">Expiry Date :{{ $driverSubscription->getConvertedExpiredAtYearAttribute() }} </label>
</div>
<div class="form-group mt-5">
<label for="total">subscription Amount : {{ $driverSubscription->paid_amount }}</label>
</div>
</form>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" id="">
<a href="{{ route('generate.pdf', $driverSubscription->id) }}">PDF</a>	
</button>
</div>
</div>
</div>
</div>
<!-- modal end -->

 @endsection