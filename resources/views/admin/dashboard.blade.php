@extends('admin.layouts.app')

@section('content')
    <!-- Morris charts -->
    <link rel="stylesheet" href="{!! asset('assets/vendor_components/morris.js/morris.css') !!}">
    <style>
        .text-red {
            color: red;
        }

        .demo-radio-button label {
            font-size: 15px;
            font-weight: 600 !important;
            margin-bottom: 5px !important;
        }

        .box-title {
            font-size: 15px;
            margin: 0 0 7px 0;
            margin-bottom: 7px;
            font-weight: 600;
        }

        .total-earnings-text {
            font-size: 15px;
        }

        .total-earnings {
            font-size: 30px;
            margin-bottom: 60px;
        }

        #map {
            height: 50vh;
            margin: 10px;
        }

        #legend {
            font-family: Arial, sans-serif;
            background: #fff;
            padding: 10px;
            margin: 10px;
            border: 3px solid #000;
        }

        #legend h3 {
            margin-top: 0;
        }

        #legend img {
            vertical-align: middle;
        }

        .g-3 h6 {
            font-weight: 600;
        }

        .g-3 a {
            font-weight: 600;
        }

        .g-3 .bg-holder {
            position: absolute;
            width: 100%;
            min-height: 100%;
            top: 0;
            left: 0;
            background-size: cover;
            background-position: center;
            overflow: hidden;
            will-change: transform, opacity, filter;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            background-repeat: no-repeat;
            z-index: 0;
        }

        .g-3 .bg-card {
            background-size: contain;
            background-position: right;
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .g-3 .display-4 {
            font-size: 2.5rem;
            font-weight: 300;
            line-height: 1.2;
        }

        .badge {
            display: inline-block;
            padding: .35556em .71111em;
            font-size: .75em;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            background-image: var(--bs-gradient);
        }

        .badge-soft-warning {
            color: #9d5228;
            background-color: #fde6d8;
        }

        .badge-soft-success {
            color: #00864e;
            background-color: #ccf6e4;
        }

        .g-3 .dropdown-menu,
        .dropdown-grid {
            width: -webkit-fill-available;
            border: 1px solid #c5c5c5;
        }

    </style>

    <!-- Start Page content -->
    <section class="content">

@if(auth()->user()->can('access-dashboard'))         

        <div class="row g-3">
    @if(!auth()->user()->hasRole('owner'))            
            
            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#4368c4;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white">@lang('view_pages.drivers_registered')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $regitered_drivers }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white" href="{{url('drivers/registered')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>
            <!-- style="background-image:url({{ asset('assets/images/corner-2.png') }});" -->
            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#3995ef;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white">@lang('view_pages.drivers_approved')<span class="badge badge-soft-success rounded-pill ml-2">{{number_format($total_drivers[0]['approve_percentage'],2)}}%</span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $total_drivers[0]['approved'] }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white" href="{{url('drivers')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#1ca53d;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white">@lang('view_pages.drivers_waiting_for_approval')<span class="badge badge-soft-success rounded-pill ml-2">{{number_format($total_drivers[0]['decline_percentage'],2)}}%</span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $total_drivers[0]['declined'] }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white"
                            href="{{url('drivers/waiting-for-approval')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#4368c4;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white"> @lang('view_pages.users_registered')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $active_users }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white" href="{{url('users')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#eeb100;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white">@lang('view_pages.drivers_onlline')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $drivers_online }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#f76701;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white">@lang('view_pages.drivers_offline')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $drivers_offline }}</div>
                    </div>
                </div>
            </div>

           <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#4368c4;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white"> @lang('view_pages.users_deleted')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $deleted_users }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white" href="{{url('users')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>
           <div class="col-sm-6 col-md-3">
                <div class="card overflow-hidden" style="width: 16rem;height:10rem;">
                    <div class="bg-holder bg-card" style="background:#eeb100;">
                    </div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6 class="text-white"> @lang('view_pages.drivers_deleted')
                        </h6>
                        <div class="display-4 fs-4 mb-2 font-weight-normal font-sans-serif text-white"
                            data-countup="{&quot;endValue&quot;:58.386,&quot;decimalPlaces&quot;:2,&quot;suffix&quot;:&quot;k&quot;}">
                            {{ $deleted_drivers }}</div><a class="font-weight-semi-bold fs--1 text-nowrap text-white" href="{{url('drivers/deleted-drivers')}}">@lang('view_pages.see_all')<span class="fa fa-angle-right ml-1" data-fa-transform="down-1"></span></a>
                    </div>
                </div>
            </div>  
          </div>          
<!-- new designs -->
<div class="row">
 <div class="col-sm-6 col-md-3">
    <div class="card" style="border: 1px solid #606061;margin-bottom: 10px;padding: 5px;">
        <h6>@lang('view_pages.driver_details')</h6>
    </div>
                <div class="card overflow-hidden" style="min-width: 12rem;border: 1px solid #606061 ;margin-bottom: 10px;padding: 5px;">
    
                    <ul class="list-group">
                        <li class="list-group-item">@lang('view_pages.reg_today') : {{ $today_drivers }}</li>
                        <li class="list-group-item">@lang('view_pages.reg_this_month') : {{ $current_month_drivers }}</li>
                        <li class="list-group-item">@lang('view_pages.reg_last_month') : {{ $last_month_drivers }}</li>
                    </ul>

                </div>
            </div>

     <div class="col-sm-6 col-md-3">
                 <div class="card" style="border: 1px solid #606061;margin-bottom: 10px;padding: 5px;">
        <h6>@lang('view_pages.user_details')</h6>
    </div>
                <div class="card overflow-hidden" style="min-width: 12rem;border: 1px solid #606061 ;margin-bottom: 10px;padding: 5px;">
                    <ul class="list-group">
                        <li class="list-group-item">@lang('view_pages.reg_today') : {{ $today_users }}</li>
                        <li class="list-group-item">@lang('view_pages.reg_this_month') : {{ $current_month_users }}</li>
                        <li class="list-group-item">@lang('view_pages.reg_last_month') : {{ $last_month_users }}</li>
                    </ul>
                </div>
            </div>

      

      <div class="col-sm-6 col-md-3">
                <div class="card" style="border: 1px solid #606061;margin-bottom: 10px;padding: 5px;">
        <h6>@lang('view_pages.driver_complaints')</h6>
    </div>
                <div class="card overflow-hidden" style="min-width: 12rem;border: 1px solid #606061 ;margin-bottom: 10px;padding: 5px;">
                   
                    <ul class="list-group">
                        <li class="list-group-item">@lang('view_pages.new') : {{ $complaint->whereNotNull('driver_id')->where('status', 'new')->count(); }}</li>
                        <li class="list-group-item">@lang('view_pages.taken') : {{ $complaint->whereNotNull('driver_id')->where('status', 'taken')->count(); }}</li>
                        <li class="list-group-item">@lang('view_pages.solved') : {{ $complaint->whereNotNull('driver_id')->where('status', 'solved')->count(); }}</li>
                    </ul>

                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                 <div class="card" style="border: 1px solid #606061;margin-bottom: 10px;padding: 5px;">
        <h6>@lang('view_pages.user_complaints')</h6>
    </div>
                <div class="card overflow-hidden" style="min-width: 12rem;border: 1px solid #606061 ;margin-bottom: 10px;padding: 5px;">
    
                    <ul class="list-group">
                        <li class="list-group-item">@lang('view_pages.new') : {{ $complaint->whereNotNull('user_id')->where('status', 'new')->count(); }}</li>
                        <li class="list-group-item">@lang('view_pages.taken') : {{ $complaint->whereNotNull('user_id')->where('status', 'taken')->count(); }}</li>
                        <li class="list-group-item">@lang('view_pages.solved') : {{ $complaint->whereNotNull('user_id')->where('status', 'solved')->count(); }}</li>
                    </ul>

                </div>
            </div>
    <!-- new designs -->
    <!-- users_registerd -->

    <div class="col-sm-6 col-md-6">
        <div class="box">   
                  <div class="box-header with-border pb-0 mb-20">
                     <h5>@lang('view_pages.registrations')</h5>
                  </div>
    
            <div class="box-body chart-responsive">
                <canvas id="reg-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="box">   
                  <div class="box-header with-border pb-0 mb-20">
                     <h5>@lang('view_pages.complaints')</h5>
                  </div>
    
            <div class="box-body chart-responsive">
                <canvas id="complaint-chart"></canvas>
            </div>
        </div>
    </div>
    <!-- users_registerd -->
    @endif
       
        </div>

        @if(!auth()->user()->hasRole('owner'))
        <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="font-weight-600">@lang('view_pages.notified_sos')</h3>
                                <ul class="box-controls pull-right">
                                    <li><a class="box-btn-close" href="#"></a></li>
                                    <li><a class="box-btn-slide" href="#"></a></li>
                                    <li><a class="box-btn-fullscreen" href="#"></a></li>
                                </ul>
                            </div>

                            <div class="box-body row">
                                <div id="js-request-partial-target" class="table-responsive">
                                    <include-fragment>
                                        <p id="no_data" class="lead no-data text-center">
                                            <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                                            <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                                        </p>
                                    </include-fragment>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
@if (auth()->user()->hasRole('super-admin'))

        <div class="row g-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="font-weight-600">@lang('view_pages.todays_trips')</h3>
                                <ul class="box-controls pull-right">
                                    <li><a class="box-btn-close" href="#"></a></li>
                                    <li><a class="box-btn-slide" href="#"></a></li>
                                    <li><a class="box-btn-fullscreen" href="#"></a></li>
                                </ul>
                            </div>

                            <div class="box-body row">
                                <div class="col-md-6">
                                    <canvas id="trips" height="200"></canvas>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="info-box">
                                                <span class="info-box-icon rounded" style="background-color:#7460ee"><i
                                                        class="ion ion-stats-bars text-white"></i></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">
                                                        {{$currency}} {{$todayEarnings[0]['total']}}
                                                        <br>
                                                        @lang('view_pages.today_earnings')
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box">
                                                <span class="info-box-icon rounded" style="background-color:#26C6DA"><i
                                                        class="ion ion-stats-bars text-white"></i></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">
                                                        {{$currency}} {{$todayEarnings[0]['driver_commision']}}
                                                        <br>
                                                        @lang('view_pages.driver_earnings')
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box">
                                                <span class="info-box-icon rounded" style="background-color:#26C6DA"><i
                                                        class="ion ion-stats-bars text-white"></i></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">

                                                        {{$currency}} {{$todayEarnings[0]['wallet']}}

                                                        <br>
                                                        @lang('view_pages.by_wallet')
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box">
                                                <span class="info-box-icon rounded" style="background-color:#FC4B6C"><i
                                                        class="ion ion-stats-bars text-white"></i></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">

                                                        {{$currency}} {{$todayEarnings[0]['upi']}}

                                                        <br>
                                                        @lang('view_pages.by_upi')

                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-box">
                                                <span class="info-box-icon rounded" style="background-color:#FC4B6C"><i
                                                        class="ion ion-stats-bars text-white"></i></span>
                                                <div class="info-box-content" style="color: #455a80">
                                                    <h4 class="font-weight-600">

                                                        {{$currency}} {{$todayEarnings[0]['cash']}}

                                                        <br>
                                                        @lang('view_pages.by_cash')

                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <!-- DONUT CHART -->
                <div class="box">
                    <div class="box-header with-border pb-0 mb-20">

                        <h3 class="font-weight-600">@lang('view_pages.overall_earnings')</h3>
                        <ul class="box-controls pull-right">
                            <li><a class="box-btn-close" href="#"></a></li>
                            <li><a class="box-btn-slide" href="#"></a></li>
                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="box-body chart-responsive">
                                <canvas id="chart_1" height="200"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6 m-auto pr-25">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <span class="info-box-icon rounded" style="background-color:#7460ee"><i
                                                class="ion ion-stats-bars text-white"></i></span>
                                        <div class="info-box-content" style="color: #455a80">
                                            <h4 class="font-weight-600">

                                                {{$currency}} {{$overallEarnings[0]['total']}}
                                                <br>
                                                @lang('view_pages.overall_earnings')
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <span class="info-box-icon rounded" style="background-color:#26c6da"><i
                                                class="ion ion-stats-bars text-white"></i></span>
                                        <div class="info-box-content" style="color: #26c6da">
                                            <h4 class="font-weight-600">

                                                {{$currency}} {{$overallEarnings[0]['driver_commision']}}
                                                <br>
                                                @lang('view_pages.driver_earnings')
                                            </h4>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-6">
                                    <div class="box box-body">
                                        <div class="font-size-18 flexbox align-items-center" style="color: #7460ee">
                                            <span style="color: #455a80"> @lang('view_pages.by_cash')</span>
                                            <span>{{$currency}} {{$overallEarnings[0]['cash']}}</span>

                                        </div>
                                        <div class="progress progress-xxs mt-10 mb-0">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ number_format($overallEarnings[0]['cash_percentage'], 2) }}%; height: 4px;background-color: #7460ee;"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>                         
                                <div class="col-md-6">
                                    <div class="box box-body">
                                        <div class="font-size-18 flexbox align-items-center" style="color: #7460ee">
                                            <span style="color: #455a80"> @lang('view_pages.by_upi')</span>
                                            <span>{{$currency}} {{$overallEarnings[0]['upi']}}</span>

                                        </div>
                                        <div class="progress progress-xxs mt-10 mb-0">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ number_format($overallEarnings[0]['upi_percentage'], 2) }}%; height: 4px;background-color: #7460ee;"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-body">
                                        <div class="font-size-18 flexbox align-items-center" style="color: #7460ee">
                                            <span style="color: #455a80"> @lang('view_pages.by_wallet')</span>
                                            <span>{{$currency}} {{$overallEarnings[0]['wallet']}}</span>
                                        </div>
                                        <div class="progress progress-xxs mt-10 mb-0">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ number_format($overallEarnings[0]['wallet_percentage'], 2) }}%; height: 4px;background-color: #7460ee"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.box -->

            </div>
           <div class="col-12 col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="font-weight-600">@lang('view_pages.cancellation_chart')</h3>
                        <ul class="box-controls pull-right">
                            <li><a class="box-btn-close" href="#"></a></li>
                            <li><a class="box-btn-slide" href="#"></a></li>
                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                        </ul>
                    </div>
                    @php
                    $automatic = $cancelled_trip_array[0]->total_cancelled;
                    $user = $cancelled_trip_array[1]->total_cancelled;
                    $driver = $cancelled_trip_array[2]->total_cancelled;
                    $dispatcher = $cancelled_trip_array[3]->total_cancelled;

                    $over_all_cancelled = $automatic+$user+$driver+$dispatcher;
                    @endphp

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart" id="bar-chart" style="height: 300px;"></div>
                            </div>
                            <div class="col-md-6 m-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="box box-body bg-primary">
                                            <div class="flexbox">
                                                <span class="ion ion-ios-person-outline font-size-50"></span>
                                                <span class="font-size-40 font-weight-200">{{$over_all_cancelled ?? 0}}</span>
                                            </div>
                                            <div class="text-right">@lang('view_pages.total_request_cancelled')</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box box-body bg-primary" style="background-color: #1e88e5 !important">
                                            <div class="flexbox">
                                                <span class="ion ion-ios-person-outline font-size-50"></span>
                                                <span class="font-size-40 font-weight-200">{{$automatic ?? 0}}</span>
                                            </div>
                                            <div class="text-right">@lang('view_pages.cancelled_due_to_no_drivers')</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box box-body bg-primary" style="background-color: #26c6da !important">
                                            <div class="flexbox">
                                                <span class="ion ion-ios-person-outline font-size-50"></span>
                                                <span class="font-size-40 font-weight-200">{{$user ?? 0}}</span>
                                            </div>
                                            <div class="text-right">@lang('view_pages.cancelled_by_user')</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box box-body bg-primary" style="background-color: #fc4b6c !important">
                                            <div class="flexbox">
                                                <span class="ion ion-ios-person-outline font-size-50"></span>
                                                <span class="font-size-40 font-weight-200">{{$driver ?? 0}}</span>
                                            </div>
                                            <div class="text-right">@lang('view_pages.cancelled_by_driver')</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  @endif
@endif

    </section>

    <script src="{{ asset('assets/vendor_components/jquery.peity/jquery.peity.js') }}"></script>

    <script>
        $(function() {
            'use strict';

            // pie chart
            $("span.piee").peity("pie", {
                height: 220,
                width: 300,
            });

        }); // End of use strict

    </script>

    <!-- Morris.js charts -->
    <script src="{{ asset('assets/vendor_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/morris.js/morris.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";

            var barData = JSON.parse('<?php echo json_encode($data); ?>');
            var tripData = JSON.parse('<?php echo json_encode($trips); ?>');

            var barChartData = barData?.cancel;
            var overallEarning = barData?.earnings;
            let cancelValues = [];
            for(var value in barChartData){
                // console.log(barChartData[value]);
            }

            var bar = new Morris.Bar({
                element: 'bar-chart',
                resize: true,
                data: barChartData,
                barColors: ['#1e88e5', '#fc4b6c', '#26c6da'],
                barSizeRatio: 0.5,
                barGap: 5,
                xkey: 'y',
                ykeys: ['a', 'd','u'],
                labels: ['Cancelled due to no Drivers', 'Cancelled by Driver','Cancelled by User'],
                hideHover: 'auto',
                color: '#666666'
            });
            console.log(barChartData,bar);

            if ($('#chart_1').length > 0) {
                var ctx1 = document.getElementById("chart_1").getContext("2d");
                var data1 = {
                    labels: overallEarning['months'],
                    datasets: [{
                            label: "Overall Earnings",
                            backgroundColor: "#bdb5ed",
                            borderColor: "#9080f1",
                            pointBorderColor: "#ffffff",
                            pointHighlightStroke: "#26c6da",
                            data: overallEarning['values']
                        },


                    ]
                };

                var areaChart = new Chart(ctx1, {
                    type: "line",
                    data: data1,

                    options: {
                        tooltips: {
                            mode: "label"
                        },
                        elements: {
                            point: {
                                hitRadius: 90
                            }
                        },

                        scales: {
                            yAxes: [{
                                stacked: true,
                                gridLines: {
                                    color: "rgba(135,135,135,0)",
                                },
                                ticks: {
                                    fontFamily: "Poppins",
                                    fontColor: "#878787"
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                gridLines: {
                                    color: "rgba(135,135,135,0)",
                                },
                                ticks: {
                                    fontFamily: "Poppins",
                                    fontColor: "#878787"
                                }
                            }]
                        },
                        animation: {
                            duration: 3000
                        },
                        responsive: true,
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: 'rgba(33,33,33,1)',
                            cornerRadius: 0,
                            footerFontFamily: "'Poppins'"
                        }

                    }
                });
            }

            tripData = Object.values(tripData);

            if ($('#trips').length > 0) {
                var ctx7 = document.getElementById("trips").getContext("2d");
                var data7 = {
                    labels: [
                        "Completed",
                        "Cancelled",
                        "Scheduled"
                    ],
                    datasets: [{
                        data: [tripData[0].today_completed,tripData[0].today_cancelled,tripData[0].today_scheduled],
                        backgroundColor: [
                            "#7460ee",
                            "#fc4b6c",
                            "#26c6da"
                        ],
                        hoverBackgroundColor: [
                            "#7460ee",
                            "#fc4b6c",
                            "#26c6da"
                        ]
                    }]
                };
                var doughnutChart = new Chart(ctx7, {
                    type: 'doughnut',
                    data: data7,
                    options: {
                        animation: {
                            duration: 4000
                        },
                        responsive: true,
                        legend: {
                            labels: {
                                fontFamily: "Poppins",
                                fontColor: "#878787"
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(33,33,33,1)',
                            cornerRadius: 0,
                            footerFontFamily: "'Poppins'"
                        },
                        elements: {
                            arc: {
                                borderWidth: 0
                            }
                        }
                    }
                });
            }
        });

    </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
$(document).ready(function() {


    var registered_users = JSON.parse('<?php echo json_encode($registeredInfo); ?>');
    // console.log(registered_users);

            var dates = [];
            var total = [];

            for (var i in registered_users) {
                var dateParts = registered_users[i].date.split('-');
                var day = dateParts[2];
                dates.push(day);
                total.push(registered_users[i].total);
            }

            var ctx = document.getElementById('reg-chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Registrations',
                        data: total,
                        backgroundColor: 'rgba(144, 238, 144, 1)',
                        borderColor: 'rgba(33,33,33,1)',
                        borderWidth: 0.5
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    }
                }
            });
});
</script>

<script type="text/javascript">
$(document).ready(function() {


    var complaints = JSON.parse('<?php echo json_encode($complaintInfo); ?>');
    // console.log(registered_users);

            var dates = [];
            var total = [];

            for (var i in complaints) {
                var dateParts = complaints[i].date.split('-');
                var day = dateParts[2];
                dates.push(day);
                total.push(complaints[i].total);
            }

            var ctx = document.getElementById('complaint-chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Complaints',
                        data: total,
                        backgroundColor: 'rgba(216, 191, 216, 1)',
                        borderColor: 'rgba(33,33,33,1)',
                        borderWidth: 0.5
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    }
                }
            });
});
</script>


@endsection
