@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{!! asset('assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}">

    <style>
        .form-horizontal {
            padding: 2em;
        }
        /* Absolute Center Spinner */
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
                        <h3>Officer's Report</h3>
                    </div>

                    <form method="post" class="form-horizontal" action="{{ url('reports/download') }}" style=" background: #fff; border-radius: 3px; padding: 30px;">
                        @csrf
                        <input type="hidden" name="model" value="User">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">@lang('view_pages.select_status')</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="" selected disabled>@lang('view_pages.select_status')</option>
                                        <option value="1" selected>Pending Officer's</option>
                                        <option value="2">Approved Officer's</option>
                                        <option value="3">Deceased Officer's</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                               <div class="form-group"> 
                               <label for="format">@lang('view_pages.select_format') <span
                                            class="text-danger">*</span></label>
                                    <select name="format" id="format" class="form-control" required> 
                                        @foreach($formats as $k=>$format)
                                        @if($k==0)
                                        <option value="{{ $format }}"  selected>{{ $format }}</option>
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
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: 'today'
        });

        $(document).on('change', '#date_option', function() {
            dateOption();
        });

        $(document).on('click', '.submit', function(e) {

            var validate = validateForm();

            if (validate) {
                let filterColumn = ['status', 'date_option'];
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
                        url:'{{url("/")}}/reports/export_pdf',
                        data:{type:'user',status:$("#status").val()}, 
                        type: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success:function(response)
                        {  
                            $(".loading").removeClass("actv");
                            var blob = new Blob([response], { type: 'application/pdf' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob); 
                            link.download = "overall_earinings_"+Date.now()+".pdf";
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
                    url: searchUrl,
                    data: $('form').serialize(),
                    method: 'post',
                    success: function(res) {
                        $(".loading").removeClass("actv");
                        // $('form').trigger("reset");
                        dateOption();
                        console.log(res);
                        window.location = res;
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
