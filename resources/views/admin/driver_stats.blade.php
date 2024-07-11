@extends('admin.layouts.app')

@section('content')

<!-- Start Page content -->
    <section class="content">
       <!-- driver stats  -->
  <div class="row g-3" style="margin-top:30px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box" style="border:2px solid #043c6c;border-radius:15px;">
                            <div class="box-header with-border">
                                <div class="text-center" style="background:black;color:#043c6c;width:200px;border-radius:30px;">
                                <h5 class="font-weight-600 p-5" >Driver Subscription</h5>
                                </div>

                            </div>

                        
<!-- on boarding  -->
<div class="row box-body">
<div class="box-header">
    <div class="text-center" style="background:black;color:#043c6c;width:150px;border-radius:30px;">
    <h5 class="font-weight-600 p-5" >Revenue</h5>
    </div>
    </div>
    <div class="col-12 col-md-12">
    <div class="row">
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#7460ee"><img src="{{asset('assets/img/driver/Today.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                         ₹ {{ $subscriptionCounts->today_subscribed }}
                            <br>                                                         
                        </h4>
                        <p>Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/This Month.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        ₹ {{ $subscriptionCounts->this_month_subscribed }}
                            <br>
                        </h4>
                        <p>This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/Last Month.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt="">></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        ₹ {{ $subscriptionCounts->last_month_subscribed }}
                            <br>
                        </h4>
                        <p>Last Month</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- complaints  -->
<div class="row box-body">
<div class="box-header">
    <div class="text-center" style="background:black;color:#043c6c;width:200px;border-radius:30px;">
    <h5 class="font-weight-600 p-5" >Subscription Status</h5>
    </div>
    </div>
    <div class="col-12 col-md-12">
    <div class="row">
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#7460ee"><img src="{{asset('assets/img/Active.png')}}" style="width:50px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        {{ $active_subscription_count }}
                            <br>                                                         

                        </h4>
                        <p>Active</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/Inactive.png')}}" style="width:50px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                            {{ $in_active_subscription_count }}
                            <br>
                        </h4>
                        <p>Inactive</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

            </div>


<!-- User stats  -->
  <div class="row g-3" style="margin-top:30px;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box" style="border:2px solid #043c6c;border-radius:15px;">
                            <div class="box-header with-border">
                                <div class="text-center" style="background:black;color:#043c6c;width:150px;border-radius:30px;">
                                <h5 class="font-weight-600 p-5" >Ride Invoice</h5>
                                </div>

                            </div>

<!-- on boarding  -->
<div class="row box-body">
<div class="box-header">
    <div class="text-center" style="background:black;color:#043c6c;width:150px;border-radius:30px;">
    <h5 class="font-weight-600 p-5" >Revenue</h5>
    </div>
    </div>
    <div class="col-12 col-md-12">
    <div class="row">
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#7460ee"><img src="{{asset('assets/img/driver/Today.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                       ₹ {{ $paidInvoicesCounts->today_paid_invoices }}
                            <br>                                                         
             
                        </h4>
                        <p>Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/This Month.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                       ₹ {{ $paidInvoicesCounts->this_month_paid_invoices }}
                            <br>
                        </h4>
                        <p>This Month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/Last Month.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt="">></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                       ₹ {{ $paidInvoicesCounts->last_month_paid_invoices }}
                            <br>
                        </h4>
                        <p>Last Month</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- complaints  -->
<div class="row box-body">
<div class="box-header">
    <div class="text-center" style="background:black;color:#043c6c;width:150px;border-radius:30px;">
    <h5 class="font-weight-600 p-5" >Invoice Status</h5>
    </div>
    </div>
    <div class="col-12 col-md-12">
    <div class="row">
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#7460ee"><img src="{{asset('assets/img/driver/Invoice Sent.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        {{ $paidInvoicesCounts->total_invoices_count }}
                            <br>                                                         
                        </h4>
                        <p>Sent</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/Invoice Received.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        {{ $paidInvoicesCounts->received_invoices_count }}
                            <br>
                        </h4>
                        <p>Received</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box" style="border-radius:10px;">
                    <span class="info-box-icon rounded bg-dark" style="background-color:#26C6DA"><img src="{{asset('assets/img/driver/Invoice Pending.png')}}" style="width:60px;margin:auto;" class="img-fluid" alt=""></span>
                    <div class="info-box-content" style="color: #455a80">
                        <h4 class="font-weight-600">
                        {{ $paidInvoicesCounts->pending_invoices_count }}
                            <br>
                        </h4>
                        <p>Pending</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- end -->
            </div>            



</section>



@endsection
