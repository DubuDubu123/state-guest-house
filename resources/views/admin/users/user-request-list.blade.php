@extends('admin.layouts.app')

@section('content')

    <!-- Morris charts -->
    <link rel="stylesheet" href{!! asset('assets/vendor_components/morris.js/morris.css') !!}">
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

    </style>
    <!-- Start Page content -->
    <section class="content">
<div class="row">
<div class="col-sm-12">
    <div class="box">

        <div class="box-header with-border">
            <a href="{{ url('users') }}">
                <button class="btn btn-danger btn-sm pull-right" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
        </div>

        <div class="row">
            @foreach ($card as $item)
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="box box-body">
                        <h5 class="text-capitalize">{{ $item['display_name'] }}</h5>
                        <div class="flexbox wid-icons mt-2">
                            <span class="{{ $item['icon'] }} font-size-40"></span>
                            <span class=" font-size-30">{{ $item['count'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
        <div class="box"> 


                    <div class="box-header with-border">
                        <div class="row text-right">
                            <div class="col-8 col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        {{-- <input type="hidden" id="item" value="{{$item}}"> --}}
                                        <input type="text" id="search_keyword" name="search" class="form-control"
                                            placeholder="@lang('view_pages.enter_keyword')">
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 col-md-1 text-left">
                                <button id="search" class="btn btn-success btn-outline btn-sm py-2" type="submit">
                                    @lang('view_pages.search')
                                </button>
                            </div>

                            <div class="col-5 col-md-1 text-left">
                                <button class="btn btn-outline btn-sm btn-danger py-2" type="button" data-toggle="modal"
                                    data-target="#request-modal">
                                     @lang('view_pages.filter')
                                </button>
                            </div>                       
                        </div>

 <!-- Modal -->
                        <div class="modal fade" id="request-modal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('view_pages.filter_request')</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <div class="request-status">
                                            <h4>@lang('view_pages.trip_status')</h4>
                                            <div class="demo-radio-button">

                                                <input name="trip_status" type="radio" id="is_completed" data-val="1"
                                                    class="with-gap radio-col-green">
                                                <label for="is_completed">@lang('view_pages.completed')</label>
                                                <input name="trip_status" type="radio" id="is_cancelled" data-val="1"
                                                    class="with-gap radio-col-red">
                                                <label for="is_cancelled">@lang('view_pages.cancelled')</label>
                                                <input name="trip_status" type="radio" id="is_trip_start" data-val="0"
                                                    class="with-gap radio-col-yellow">
                                                <label for="is_trip_start">@lang('view_pages.not_yet_started')</label>
                                            </div>
                                            <h4>@lang('view_pages.paid_status')</h4>
                                            <div class="demo-radio-button">
                                                <input name="is_paid" type="radio" id="paid" data-val="1"
                                                    class="with-gap radio-col-green">
                                                <label for="paid">@lang('view_pages.paid')</label>
                                                <input name="is_paid" type="radio" id="unpaid" data-val="0"
                                                    class="with-gap radio-col-red">
                                                <label for="unpaid">@lang('view_pages.unpaid')</label>
                                            </div>
                                            <h4>@lang('view_pages.payment_option')</h4>
                                            <div class="demo-radio-button">
                                                <input name="payment_opt" type="radio" id="card" data-val="0"
                                                    class="with-gap radio-col-red">
                                                <label for="card">@lang('view_pages.card')</label>
                                                <input name="payment_opt" type="radio" id="cash" data-val="1"
                                                    class="with-gap radio-col-blue">
                                                <label for="cash">@lang('view_pages.cash')</label>
                                                <input name="payment_opt" type="radio" id="wallet" data-val="2"
                                                    class="with-gap radio-col-yellow">
                                                <label for="wallet">@lang('view_pages.wallet')</label>
                                                <input name="payment_opt" type="radio" id="wallet_cash" data-val="3"
                                                    class="with-gap radio-col-deep-purple">
                                                <label for="wallet_cash">@lang('view_pages.cash_wallet')</label>
                                                <input name="payment_opt" type="radio" id="upi" data-val="4"
                                                    class="with-gap radio-col-deep-purple">
                                                <label for="upi">@lang('view_pages.upi')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-success btn-sm float-right filter">@lang('view_pages.apply_filters')</button>

                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-danger btn-sm resetfilter float-right mr-2">
                                            @lang('view_pages.reset_filters')</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                    </div>

        <div class="row">
            <div class="col-12">
        <div class="box"
>            <table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.request_id')</th>
            <th> @lang('view_pages.date')</th>
            <th> @lang('view_pages.user_name')</th> 
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.trip_status')</th>
            <th> @lang('view_pages.is_paid')</th>
            <th> @lang('view_pages.payment_option')</th>
            <th> @lang('view_pages.action')</th>
        </tr>
    </thead>
    <tbody>


        @php $i= $results->firstItem(); @endphp

        @forelse($results as $key => $result)

        <tr>
            <td>{{ $i++ }} </td>
            <td>{{$result->request_number}}</td>
            <td>{{ $result->trip_start_time }}</td>
          <td>{{$result->userDetail ? $result->userDetail->name : '-'}}</td>
            <td>{{$result->driverDetail ? $result->driverDetail->name : '-'}}</td>

            @if($result->is_cancelled == 1)
            <td><span class="label label-danger">@lang('view_pages.cancelled')</span></td>
            @elseif($result->is_completed == 1)
            <td><span class="label label-success">@lang('view_pages.completed')</span></td>
            @elseif($result->is_trip_start == 0 && $result->is_cancelled == 0)
            <td><span class="label label-warning">@lang('view_pages.not_started')</span></td>
            @else
            <td>-</td>
            @endif

            @if ($result->is_paid)
            <td><span class="label label-success">@lang('view_pages.paid')</span></td>
            @else
            <td><span class="label label-danger">@lang('view_pages.not_paid')</span></td>
            @endif

            @if ($result->payment_opt == 0)
            <td><span class="label label-danger">@lang('view_pages.card')</span></td>
            @elseif($result->payment_opt == 1)
            <td><span class="label label-primary">@lang('view_pages.cash')</span></td>
            @elseif($result->payment_opt == 2)
            <td><span class="label label-warning">@lang('view_pages.wallet')</span></td>
            @else
            <td><span class="label label-info">@lang('view_pages.upi')</span></td>
            @endif

            @if ($result->is_completed)
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{url('requests',$result->id)}}">
                            <i class="fa fa-eye"></i>@lang('view_pages.view')</a>
                    </div>
                </div>
            </td>
            @else
            <td>-</td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="11">
                <p id="no_data" class="lead no-data text-center">
                    <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </p>
            </td>
        </tr>
        @endforelse

    </tbody>
</table>
                <div class="text-right">
                    <span  style="float:right">
                    {{$results->links()}}
                    </span>
                </div>
              </div>
            </div>
          </div>
        
    </div>
</section>


<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{get_settings('google_map_key')}}&libraries=visualization"></script>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-database.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script>

   

@endsection