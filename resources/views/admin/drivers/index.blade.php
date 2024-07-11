@extends('admin.layouts.app')

@section('title', 'Company page')

@section('content')
<!-- Include flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

/* CSS for toggle switch */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
.btn-outline.btn-success{

}


    </style>
    <!-- Start Page content -->
    <section class="content">
        {{-- <div class="container-fluid"> --}}

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
                             

                            <div class="col-5 col-md-1 text-left" style="height: 38px;">
                                <button class="btn btn-success btn-sm" type="button" data-toggle="modal"
                                    data-target="#modal-default" style="color:black;    height: 100%;">
                                         @lang('view_pages.filter_drivers')                                </button>
                            </div>
                        @if(auth()->user()->can('add-drivers'))         
                            <div class="col-7 col-md-7 text-right">
                                <a href="{{ url('drivers/create') }}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-plus-circle mr-2"></i>@lang('view_pages.add_driver')</a>
                                <!--  <a class="btn btn-danger">
                                    Export</a> -->
                            </div>
                        @endif


<!-- Modal for Alert -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Get Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="invoiceForm">
                    <div class="form-group">
                        <label for="driverName">Driver Name</label>
                        <input type="text" class="form-control" id="driverName" readonly>
                    </div>                  
                    <div class="form-group">
                        <label for="driverId">Driver ID</label>
                        <input type="hidden" class="form-control" id="driverNum"  >
                        <input type="text" class="form-control" id="driverId"  readonly>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" value="6384606765" readonly>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" readonly>
                    </div>   
                    <div class="form-group">
                        <label for="no_of_rides">Number Of Rides</label>
                        <input type="no_of_rides" class="form-control" id="no_of_rides" placeholder="Enter Amount" step="0.01">
                    </div>                    
                    <div class="form-group">
                        <label for="fromDateTime">From</label>
                        <input type="text" class="form-control" id="fromDateTime" placeholder="Select date and time">
                    </div>

                    <div class="form-group">
                        <label for="toDateTime">To</label>
                        <input type="text" class="form-control" id="toDateTime" placeholder="Select date and time">
                    </div>                     
                    <div class="form-group">
                        <label for="enterAmount">Enter Amount</label>
                        <input type="number" class="form-control" id="enterAmount" placeholder="Enter Amount" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="gstAmount">GST Amount</label>
                        <input type="text" class="form-control" id="gstAmount" value="0" readonly>
                    </div>                    
                    <div class="form-group">
                        <label for="totalAmount">Total Amount</label>
                        <input type="text" class="form-control" id="totalAmount" value="0" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="calculateTotal">Calculate Total</button>
                <button type="button" class="btn btn-success" id="sendInvoice">Send Invoice</button>
            </div>
        </div>
    </div>
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
                                            <h4>@lang('view_pages.select_area')</h4>
                                            <div class="form-group">
                                                <select name="service_location_id" id="service_location_id" class="form-control">
                                                    <option value="all" selected>@lang('view_pages.all')</option>
                                                    @foreach($services as $key=>$service)
                                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                                    @endforeach
                                                </select>
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

                    <div id="js-drivers-partial-target">
                        <include-fragment src="drivers/fetch/approved">
                            <span style="text-align: center;font-weight: bold;"> @lang('view_pages.loading')</span>
                        </include-fragment>
                    </div>
                </div>
            </div>
        </div>

        <!-- container -->
<!-- JavaScript -->
<!-- Include flatpickr JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
            // Handle the "Send Invoice" button click event
            $('#sendInvoice').on('click', function() {
                // Submit the form
                $('#invoiceForm').submit();
            });

        </script>        
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

                    fetch('drivers/search?search=' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-drivers-partial-target').innerHTML = html
                        });
                });

                $('.filter,.resetfilter').on('click', function() {
                    let filterColumn = ['area'];

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

                    fetch('drivers/fetch/approved?' + query)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-drivers-partial-target').innerHTML = html
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

                                fetch('drivers/fetch/approved?search=' + search_keyword + '&' + query)
                                    .then(response => response.text())
                                    .then(html => {
                                        document.querySelector('#js-drivers-partial-target')
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
    $(document).on('click', '.get-invoice', function (e) {
        e.preventDefault();

        // Initialize flatpickr for "from" and "to" fields
        flatpickr('#fromDateTime', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Add any additional options or configurations as needed
        });

        flatpickr('#toDateTime', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Add any additional options or configurations as needed
        });
        // Get driver_id and Phone Number from the data attributes
        var driverId = $(this).data('driver-id');
        var phoneNumber = $(this).data('phone-number');
        var driverNum = $(this).data('driver-num');
        var driverName = $(this).data('driver-name');
        var location = $(this).data('driver-location');
        // var no_of_rides = $(this).data('no_of_rides');


// driver-location
        // Populate the modal fields with the retrieved values
        $('#driverId').val(driverId);
        $('#phoneNumber').val(phoneNumber);
        $('#driverNum').val(driverNum);
        $('#driverName').val(driverName);
        $('#location').val(location);
        // $('#no_of_rides').val(no_of_rides);


// alert(driverNum);

        // Clear the input fields before opening the modal
        $('#enterAmount').val('');
        $('#totalAmount').val('0');

        $('#alertModal').modal('show');
    });

    $('#alertModal').on('hidden.bs.modal', function (e) {
        // Refresh the page when the modal is closed
        location.reload();
    });
window.csrfToken = "{{ csrf_token() }}";

$(document).on('click', '#calculateTotal', function() {
    var enterAmount = parseFloat($('#enterAmount').val()) || 0;
    var gstAmount = enterAmount * 0.18; // Calculate GST amount (assuming a GST rate of 18%)
    var totalAmount = enterAmount + gstAmount; // Calculate total amount including GST
    var driverId = $('#driverId').val(); // Retrieve the driverId value correctly

    // Ensure that the driverId is not empty before making the AJAX call
    if (driverId.trim() === '') {
        alert('Please provide a driver ID.'); // Display an alert if driverId is empty
        return; // Exit the function to prevent the AJAX call
    }

    /*ajax*/
    $.ajax({
        type: "POST",
        url: "{{ route('CheckInvoiceExists') }}", // Replace with your Laravel route name or endpoint
        data: { driverId: driverId }, // Pass driverId as part of the data object
        success: function(response) {
            // alert(response); // Show a success message or handle the response from the server
            if(response==0)
            {
            // Update the total and GST amount only if the AJAX call is successful
            $('#totalAmount').val(totalAmount.toFixed(2)); // Display total with 2 decimal places
            $('#gstAmount').val(gstAmount.toFixed(2)); // Display GST amount with 2 decimal places          
            }else{
                alert("Driver Already have Unpaid Invoice");
            }

        },
        error: function(error) {
            // console.log(error);
        }
    });
    /*ajax*/
});

$('#sendInvoice').on('click', function() {
    var driverId = $('#driverId').val();
    var phoneNumber = $('#phoneNumber').val();
    var enterAmount = $('#enterAmount').val();
    var totalAmount = $('#totalAmount').val();
    var gstAmount = $('#gstAmount').val(); // Get the calculated GST amount
    var driverNum = $('#driverNum').val();
    var fromDateTime = $('#fromDateTime').val(); // Get value of 'from' datetime input
    var toDateTime = $('#toDateTime').val(); // Get value of 'to' datetime input
    var no_of_rides = $('#no_of_rides').val(); // Get value of 'to' datetime input


    var formData = {
        driverId: driverId,
        phoneNumber: phoneNumber,
        enterAmount: enterAmount,
        totalAmount: totalAmount,
        gstAmount: gstAmount, // Include the GST amount in the form data
        driverNum: driverNum,
        fromDateTime: fromDateTime, // Include 'from' datetime in form data
        toDateTime: toDateTime, // Include 'to' datetime in form data      
        no_of_rides: no_of_rides, // Include 'to' datetime in form data        
        _token: window.csrfToken
    };

    $.ajax({
        type: "POST",
        url: "{{ route('get_invoice') }}", // Replace with your Laravel route name or endpoint
        data: formData,
        success: function(response) {
            alert(response); // Show a success message or handle the response from the server
        },
        error: function(error) {
            console.log(error);
        }
    });
});
 </script>
<script type="text/javascript">
    
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
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
});

$(document).on("click","#notes",function(){
        popup_init();
        var data_id = $(this).attr("data-val"); 
        $.ajax({
                    url: "{{url('/')}}/drivers/list-note",
                    method: "GET",
                    data: {data_id:data_id},
                    dataType:'json',
                    success: function(response) { 

                        popup_data(response.message); 
                    }
        });
    });
    $(document).on("change", "#decomposition", function(){
    var value = $(this).val(); 
    var data_value = $(this).attr("data-val"); 
    console.log(data_value); // Check if data_value is retrieved correctly
    $.ajax({
        url: "{{url('/')}}/drivers/add-decomposition1",
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
                    url: "{{url('/')}}/drivers/add-note",
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
