@extends('admin.layouts.app')

@section('title', 'Company page')

@section('content')
    <style>
        .demo-radio-button label {
            min-width: 100px;
            margin: 0 0 5px 50px;
        }
        input[type=file]::file-selector-button {
  margin-right: 10px;
  border: none;
  background: #084cdf;
  padding: 10px 10px;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
  font-size: 10px;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}

    </style>
    <!-- Start Page content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="box">

                    <div class="box-header with-border">
                        <div class="row text-right">
                            <div class="col-8 col-md-3">
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="text" id="search_keyword" name="search" class="form-control"
                                            placeholder="@lang('view_pages.enter_keyword')">
                                    </div>
                                </div>
                            </div>

                            <div style="height: 38px;"> <button id="search" class="btn btn-primary btn-sm" type="submit" style="  height: 100%;">
                                    Search                                </button>
                            </div>
                             <div class="col-7 col-md-7 text-right">
                                <a href="{{ url('drivers/reports/download') }}" class="btn btn-primary btn-sm">
                                   @lang('view_pages.download')</a>
                                <!--  <a class="btn btn-danger">
                                    Export</a> -->
                            </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('view_pages.filter_drivers')</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <div class="driver-status">
                                            <h4>@lang('view_pages.active_status')</h4>
                                            <div class="demo-radio-button">
                                                <input name="active" type="radio" id="active" data-val="1"
                                                    class="with-gap radio-col-green">
                                                <label for="active">@lang('view_pages.active')</label>
                                                <input name="active" type="radio" id="inactive" data-val="0"
                                                    class="with-gap radio-col-grey">
                                                <label for="inactive">@lang('view_pages.Inactive')</label>
                                            </div>
                                            <h4>@lang('view_pages.approve_status')</h4>
                                            <div class="demo-radio-button">
                                                <input name="approve" type="radio" id="approved" data-val="1"
                                                    class="with-gap radio-col-green">
                                                <label for="approved">@lang('view_pages.approved')</label>
                                                <input name="approve" type="radio" id="disapproved" data-val="0"
                                                    class="with-gap radio-col-grey">
                                                <label for="disapproved">@lang('view_pages.disapproved')</label>
                                            </div>
                                            <h4>@lang('view_pages.online_status')</h4>
                                            <div class="demo-radio-button">
                                                <input name="available" type="radio" id="online" data-val="1"
                                                    class="with-gap radio-col-green">
                                                <label for="online">@lang('view_pages.online')</label>
                                                <input name="available" type="radio" id="offline" data-val="0"
                                                    class="with-gap radio-col-grey">
                                                <label for="offline">@lang('view_pages.offline')</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-success btn-sm float-right filter">@lang('view_pages.apply_filters')</button>

                                        <button type="button" data-dismiss="modal"
                                            class="btn btn-danger btn-sm resetfilter float-right mr-2">@lang('view_pages.reset_filters')</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>

                    <div id="js-registered-drivers-partial-target">
                        <include-fragment src="fetch/registered">
                            <span style="text-align: center;font-weight: bold;"> @lang('view_pages.loading')</span>
                        </include-fragment>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->


        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
            var search_keyword = '';
            var query = '';

            $(function() {
                $('body').on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, $('#search').serialize(), function(data) {
                        $('#js-drivers-partial-target').html(data);
                    });
                });

                $('#search').on('click', function(e) {
                    e.preventDefault();
                    search_keyword = $('#search_keyword').val();

                    fetch('search?search=' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-registered-drivers-partial-target').innerHTML = html
                        });
                });

                $('.filter,.resetfilter').on('click', function() {
                    let filterColumn = ['active', 'approve', 'available','area'];

                    let className = $(this);
                    query = '';
                    $.each(filterColumn, function(index, value) {
                        if (className.hasClass('resetfilter')) {
                            $('input[name="' + value + '"]').prop('checked', false);
                            if(value == 'area') $('#service_location_id').val('all')
                            query = '';
                        } else {
                            if ($('input[name="' + value + '"]:checked').attr('id') != undefined) {
                                var activeVal = $('input[name="' + value + '"]:checked').attr(
                                    'data-val');

                                query += value + '=' + activeVal + '&';
                            }else if (value == 'area') {
                                var area = $('#service_location_id').val()

                                query += 'area=' + area + '&';
                            }
                        }
                    });

                    fetch('fetch/registered?' + query)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-registered-drivers-partial-target').innerHTML = html
                        });
                });
            });

            $(document).on('click', '.sweet-delete', function(e) {
                e.preventDefault();

                let url = $(this).attr('data-url');

                swal({
                    title: "Are you sure to delete ?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Delete",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        swal.close();

                        $.ajax({
                            url: url,
                            cache: false,
                            success: function(res) {

                                fetch('fetch/registered?search=' + search_keyword + '&' + query)
                                    .then(response => response.text())
                                    .then(html => {
                                        document.querySelector('#js-registered-drivers-partial-target')
                                            .innerHTML = html
                                    });

                                $.toast({
                                    heading: '',
                                    text: res,
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 5000,
                                    stack: 1
                                });
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.decline', function(e) {
                e.preventDefault();
                var button = $(this);
                var inpVal = button.attr('data-reason');
                var driver_id = button.attr('data-id');
                var redirect = button.attr('href')

                if (inpVal == '-') {
                    inpVal = '';
                }

                swal({
                        title: "",
                        text: "Reason for Decline",
                        type: "input",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        confirmButtonText: 'Decline',
                        cancelButtonText: 'Close',
                        confirmButtonColor: '#fc4b6c',
                        confirmButtonBorderColor: '#fc4b6c',
                        animation: "slide-from-top",
                        inputPlaceholder: "Enter Reason for Decline",
                        inputValue: inpVal
                    },
                    function(inputValue) {
                        if (inputValue === false) return false;

                        if (inputValue === "") {
                            swal.showInputError("Reason is required!");
                            return false
                        }

                        $.ajax({
                            url: '{{ route('UpdateDriverDeclineReason') }}',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'reason': inputValue,
                                'id': driver_id
                            },
                            method: 'post',
                            success: function(res) {
                                if (res == 'success') {
                                    window.location.href = redirect;

                                    swal.close();
                                }
                            }
                        });
                    });
            });

            $(function() {
              $('table.container').on("click", "tr.table-tr", function() {
                window.location = $(this).data("url");
                //alert($(this).data("url"));
              });
            });

        </script>

<script>
    $(document).on('change', '.online-toggle', function() {
        var userId = $(this).data('user-id');
        var isChecked = $(this).is(':checked');

        // console.log("User ID:", userId);
        // console.log("Status:", isChecked ? "ON" : "OFF");

        // Perform an AJAX request here to update the status in the backend
        // Example AJAX call structure:
        
        $.ajax({
            url: "{{ route('free_trail') }}", // Replace with your Laravel route name or endpoint
            method: 'POST',
            data: {
                driver_id: userId,
                status: isChecked ? '1' : '0'
            },
            success: function(response) {
                // Handle success response

                if (response == "failure")
                 {
                    alert("Driver Has Active Subscription");
                    $('.online-toggle[data-user-id="' + userId + '"]').prop('checked', !isChecked);                    

                }

            },
            error: function(error) {
                // Handle error response
            }
        });
        
    });
    $(document).on('change', '.online-toggle1', function() {
        var userId = $(this).data('user-id');
        var isChecked = $(this).is(':checked');

        // console.log("User ID:", userId);
        // console.log("Status:", isChecked ? "ON" : "OFF");

        // Perform an AJAX request here to update the status in the backend
        // Example AJAX call structure:
        
        $.ajax({
            url: "{{ route('welcome_call') }}", // Replace with your Laravel route name or endpoint
            method: 'POST',
            data: {
                driver_id: userId,
                status: isChecked ? '1' : '0'
            },
            success: function(response) {
                // Handle success response

                if (response == "failure")
                 {
                    alert("Driver Has Active Subscription");
                    $('.online-toggle[data-user-id="' + userId + '"]').prop('checked', !isChecked);                    

                }

            },
            error: function(error) {
                // Handle error response
            }
        });
        
    });
    $(document).on("click","#notes",function(){
        popup_init();
        var data_id = $(this).attr("data-val"); 
        $.ajax({
                    url: "{{url('/')}}/drivers/list-notes",
                    method: "GET",
                    data: {data_id:data_id},
                    dataType:'json',
                    success: function(response) { 

                        popup_data(response.message); 
                    }
        });
    });
    $(document).on("change","#assign_to",function(){
        var data_id = $(this).val(); 
        var data_value = $(this).attr("data-val"); 
        $.ajax({
                    url: "{{url('/')}}/drivers/assign-employees",
                    method: "GET",
                    data: {data_id:data_id,data_value:data_value},
                    dataType:'json',
                    success: function(response) {  
                    }
        });
    });
    $(document).on("change", "#decomposition", function(){
    var value = $(this).val(); 
    var data_value = $(this).attr("data-val"); 
    console.log(data_value); // Check if data_value is retrieved correctly
    $.ajax({
        url: "{{url('/')}}/drivers/add-decomposition",
        method: "GET",
        data: {data_value: data_value, value: value},
        dataType: 'json',
        success: function(response) {  
            // Handle success response
        }
    });
});

    $(document).on("click",".save_notes",function(){ 
        var data_value = $(this).attr("data-val"); 
        var value = $("#textbox2").val(); 
        
        $.ajax({
                    url: "{{url('/')}}/drivers/add-notes",
                    method: "GET",
                    data: {data_value:data_value,value:value},
                    dataType:'json',
                    success: function(response) {  
                        $.toast({
                            heading: '',
                            text: "Notes added successfully",
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 5000,
                            stack: 1
                        });
                        popup_close();
                    }
        });
    });
    $(document).on("click",".close1",function(){
        popup_close();
    });
    </script>
@endsection
