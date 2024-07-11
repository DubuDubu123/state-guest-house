@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{!! asset('assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}">

    <style>
        .form-horizontal {
            padding: 2em;
        }
        span.select2.select2-container.select2-container--default {
            width: 505px !important;
    }

    .datepicker td, .datepicker th{
        text-align: center;
    width: 36px !important;
    height: 20px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    border: none;
    }
    .datepicker table tr td.active.active, .datepicker table tr td.active.disabled, .datepicker table tr td.active.disabled.active, .datepicker table tr td.active.disabled.disabled, .datepicker table tr td.active.disabled:active, .datepicker table tr td.active.disabled:hover, .datepicker table tr td.active.disabled:hover.active, .datepicker table tr td.active.disabled:hover.disabled, .datepicker table tr td.active.disabled:hover:active, .datepicker table tr td.active.disabled:hover:hover, .datepicker table tr td.active.disabled:hover[disabled], .datepicker table tr td.active.disabled[disabled], .datepicker table tr td.active:active, .datepicker table tr td.active:hover, .datepicker table tr td.active:hover.active, .datepicker table tr td.active:hover.disabled, .datepicker table tr td.active:hover:active, .datepicker table tr td.active:hover:hover, .datepicker table tr td.active:hover[disabled], .datepicker table tr td.active[disabled] {
    background-color: #0a7e8c !important;
}
.datepicker.datepicker-dropdown.dropdown-menu {
    background: #fafafa;
    border: 1px solid gainsboro;
}
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    background: 0 0;
    color: #e6e3e3 !important;
    cursor: default;
}
span.select2.select2-container.select2-container--default {
            width: 520px !important;
            }
            input.select2-search__field {
            padding-left: 10px !important;
            }
            .loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  display:none;
}

/* Transparent Overlay */
.loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 89px;
    left: 270px;
    width: 100%;
    height: 100%;
    background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
    background: #e0dfdf;
    opacity: 0.9;
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: 2.5em;
  margin-left: 80px;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: #0A7E8C 1.5em 0 0 0, #0A7E8C 1.1em 1.1em 0 0, #0A7E8C 0 1.5em 0 0, #0A7E8C -1.1em 1.1em 0 0, #0A7E8C -1.5em 0 0 0, #0A7E8C -1.1em -1.1em 0 0, #0A7E8C 0 -1.5em 0 0, #0A7E8C 1.1em -1.1em 0 0;
box-shadow: #0A7E8C 1.5em 0 0 0, #0A7E8C 1.1em 1.1em 0 0, #0A7E8C 0 1.5em 0 0, #0A7E8C -1.1em 1.1em 0 0, #0A7E8C -1.5em 0 0 0, #0A7E8C -1.1em -1.1em 0 0, #0A7E8C 0 -1.5em 0 0, #0A7E8C 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.loading.actv{
    display:block;
}

    </style>
   <div class="loading">Loading&#8230;</div>
    <!-- Start Page content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">

                    <div class="box-header with-border">
                        <h3>{{ $page }}</h3>
                    </div>

                    <form method="post" class="form-horizontal" action="{{ url('reports/download') }}" style=" background: #fff; border-radius: 3px; padding: 30px;">
                        @csrf
                        <input type="hidden" name="model" value="sports">

                        <div class="row">

                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_opt">Select Officer's</label>
                                    <select name="user[]" id="user" class="form-control select2" multiple="multiple" data-placeholder="Select Officer's" required>
                                        @foreach($user as $k=>$value)
                                        <option value="{{$value->id}}">{{$value->name}} ({{$value->userid}}) - {{$value->mobile}}</option>
                                        @endforeach
                                    
                                     

                                    </select>
                        <span class="text-danger">{{ $errors->first('payment_opt') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Booking Status </label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="" selected >Select Booking Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Checkin</option>
                                        <option value="3">Completed</option>
                                        <option value="2">Cancelled</option> 
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                           

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_option">@lang('view_pages.date_option') </label>
                                    <select name="date_option" id="date_option" class="form-control">
                                        <option value="date">@lang('view_pages.date')</option>
                                        <option value="today">@lang('view_pages.today')</option>
                                        <option value="week">@lang('view_pages.week')</option>
                                        <option value="month">@lang('view_pages.month')</option>
                                        <option value="year">@lang('view_pages.year')</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('date_option') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 dateDiv">
                                <div class="form-group">
                                    <label for="from">@lang('view_pages.from')<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control datepicker" type="text" id="from" name="from" style="cursor:pointer"
                                        value="{{ old('from') }}" required
                                        placeholder="Select From Date" autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('from') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 dateDiv">
                                <div class="form-group">
                                    <label for="to">@lang('view_pages.to')<span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control datepicker1" type="text" id="to" name="to"
                                        value="{{ old('to') }}" style="cursor:pointer" required placeholder="Select To Date"
                                        autocomplete="off">
                                    <span class="text-danger">{{ $errors->first('to') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="format">@lang('view_pages.select_format') <span
                                            class="text-danger">*</span></label>
                                    <select name="format" id="format" class="form-control" required>
                                        <option value="" selected disabled>@lang('view_pages.select_format')</option>
                                        @foreach ($formats as $k=>$format)
                                        @if($k == 0)
                                        <option value="{{ $format }}" selected> {{ $format }}</option>
                                        @else
                                        <option value="{{ $format }}">{{ $format }}</option>
                                        @endif
                                           
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('format') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <button class="btn btn-primary btn-sm pull-right submit" type="button">
                                    @lang('view_pages.download')
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
        //Date picker
        $(document).ready(function() {
            var fromDate = $('#from').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                endDate: 'today'
            }).on('changeDate', function(e) {
                console.log(e.date);
                // Set the start date of the to_date picker to the selected from_date
                $('#to').datepicker('setStartDate', e.date);
            });

            $('#to').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                endDate: 'today'
            });
        });

        $(document).on('change', '#date_option', function() {
            dateOption();
        });

        $(document).on('click', '.submit', function(e) {

            var validate = validateForm();

            if (validate) {
                let filterColumn = ['vehicle_type', 'vehicle_type', 'payment_opt', 'date_option'];
                let query = '?';

                var from = $('#from').val();
                var to = $('#to').val();

                $.each(filterColumn, function(index, value) {
                    var val = $('#' + value).val();

                    if (value == 'date_option') {
                        if (val == 'date') {
                            val = from + '<>' + to;
                        }
                    }

                    if (value == 'trip_status') {
                        value = $('#' + value).find(":selected").attr('data-col');
                    }

                    if (val != null && val != '') {
                        query += value + '=' + val + '&';
                    }
                });

                let url = '{{ url('reports/download') }}';
                let searchUrl = url + query;
                var format = $("#format").val();
                $(".loading").addClass("actv");
                if(format == "pdf")
                { 
                    $.ajax({
                        url:'{{url("/")}}/reports/export_pdf1',
                        data: $('form').serialize(),
                        method: 'post', 
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success:function(response)
                        {  
                            $(".loading").removeClass("actv");
                            console.log("DFgggggggggggggggggggsd");
                            var blob = new Blob([response], { type: 'application/pdf' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob); 
                            link.download = "sports_"+Date.now()+".pdf";
                            link.click(); 
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            // Handle errors if needed
                        }
                    })
                }
                else{
                $.ajax({
                    url:'{{url("/")}}/reports/export_pdf1',
                    data: $('form').serialize(),
                    method: 'post',
                    success: function(res) {
                        $(".loading").removeClass("actv");
                        // $('form').trigger("reset");
                        // dateOption();
                        window.location.href = '{{url("/")}}/storage/'+res;
                    }
                });
            }
            }
        });

        function validateForm() {
            let validateEle = ['date_option', 'format'];
            var returnVar = true;

            $.each(validateEle, function(i, ele) {
                if (ele == 'date_option') {
                    if ($('#' + ele).val() == 'date') {
                        if ($('#from').val() == '' || $('#from').val() == null) {
                            $('#from').next().text('The Field is required');
                            $('#to').next().text('The Field is required');
                            returnVar = false;
                        } else {
                            $('#from').next().text('');
                            $('#to').next().text('');
                        }
                    } else {
                        $('#from').next().text('');
                        $('#to').next().text('');
                    }
                } else {
                    ele = $('#' + ele);

                    if (ele.val() == '' || ele.val() == null) {
                        ele.next().text('The Field is required');
                        returnVar = false;
                    } else {
                        ele.next().text('');
                    }
                }
            });

            return returnVar;
        }

        function dateOption() {
            var option = $('#date_option').val();

            if (option == 'date') {
                $('.dateDiv').show();
                $('#from').attr('required', true);
                $('#to').attr('required', true);
            } else {
                $('.dateDiv').hide();
                $('#from').attr('required', false);
                $('#to').attr('required', false);
            }
        }

    </script>
@endsection
