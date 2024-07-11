@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')


<style type="text/css">
        .make-approve.active {
        font-size: 0px;
        width: 40px;
        height: 40px;
        padding: 0px !important;
        background: none !important;
        border-radius: 50% !important;
        border-left-color: transparent !important;
        animation: rotate 0.5s ease 0.5s infinite;
        border: 3px solid blue;
    }
    @keyframes rotate{
    0%{
        transform: rotate(360deg);
    }
    }
    .make-confirm.active {
        font-size: 0px;
        width: 40px;
        height: 40px;
        padding: 0px !important;
        background: none !important;
        border-radius: 50% !important;
        border-left-color: transparent !important;
        animation: rotate 0.5s ease 0.5s infinite;
        border: 3px solid blue;
    }
    @keyframes rotate{
    0%{
        transform: rotate(360deg);
    }
    }
    
    .make-offline.active {
        font-size: 0px;
        width: 40px;
        height: 40px;
        padding: 0px !important;
        background: none !important;
        border-radius: 50% !important;
        border-left-color: transparent !important;
        animation: rotate 0.5s ease 0.5s infinite;
        border: 3px solid blue;
    }
    @keyframes rotate{
    0%{
        transform: rotate(360deg);
    }
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

/*#import{
    border: 1px solid #F2F3F4 ;
    width: 250px;
    padding: 5px;
    margin-left: 980px;
    background: #F2F3F4 ;
}*/
/* Style the Image Used to Trigger the Modal */
img {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

img:hover {opacity: 0.7;}

/* The Modal (background) */
#image-viewer {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}
.modal-content { 
    animation-name: zoom;
    animation-duration: 0.6s;
}
@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}
#image-viewer .close {
    position: absolute;
    top: 100px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}
#image-viewer .close:hover,
#image-viewer .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}


 

.profile-nav .user-heading {
    background: #fbc02d;
    color: #fff;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    padding: 30px;
    text-align: center;
}

.profile-nav .user-heading.round a  {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    border: 10px solid rgba(255,255,255,0.3);
    display: inline-block;
}

.profile-nav .user-heading a img {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
}

.profile-nav .user-heading h1 {
    font-size: 22px;
    font-weight: 300;
    margin-bottom: 5px;
}

.profile-nav .user-heading p {
    font-size: 12px;
}

.profile-nav ul {
    margin-top: 1px;
}

.profile-nav ul > li {
    border-bottom: 1px solid #ebeae6;
    margin-top: 0;
    line-height: 30px;
}

.profile-nav ul > li:last-child {
    border-bottom: none;
}

.profile-nav ul > li > a {
    border-radius: 0;
    -webkit-border-radius: 0;
    color: #89817f;
    border-left: 5px solid #fff;
}

.profile-nav ul > li > a:hover, .profile-nav ul > li > a:focus, .profile-nav ul li.active  a {
    background: #f8f7f5 !important;
    border-left: 5px solid #fbc02d;
    color: #89817f !important;
}

.profile-nav ul > li:last-child > a:last-child {
    border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
}

.profile-nav ul > li > a > i{
    font-size: 16px;
    padding-right: 10px;
    color: #bcb3aa;
}

.r-activity {
    margin: 6px 0 0;
    font-size: 12px;
}


.p-text-area, .p-text-area:focus {
    border: none;
    font-weight: 300;
    box-shadow: none;
    color: #c3c3c3;
    font-size: 16px;
}

.profile-info .panel-footer {
    background-color:#f8f7f5 ;
    border-top: 1px solid #e7ebee;
}

.profile-info .panel-footer ul li a {
    color: #7a7a7a;
}

.bio-graph-heading {
    background: #fbc02d;
    color: #fff;
    text-align: center;
    font-style: italic;
    padding: 40px 110px;
    border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    font-size: 16px;
    font-weight: 300;
}

.bio-graph-info {
    color: #89817e;
}

.bio-graph-info h1 {
    font-size: 22px;
    font-weight: 300;
    margin: 0 0 20px;
}

.bio-row {
    width: 50%;
    float: left;
    margin-bottom: 10px;
    padding:0 15px;
}

.bio-row p span {
    width: 200px;
    display: inline-block;
}

.bio-chart, .bio-desk {
    float: left;
}

.bio-chart {
    width: 40%;
}

.bio-desk {
    width: 60%;
}

.bio-desk h4 {
    font-size: 15px;
    font-weight:400;
}

.bio-desk h4.terques {
    color: #4CC5CD;
}

.bio-desk h4.red {
    color: #e26b7f;
}

.bio-desk h4.green {
    color: #97be4b;
}

.bio-desk h4.purple {
    color: #caa3da;
}

.file-pos {
    margin: 6px 0 10px 0;
}

.profile-activity h5 {
    font-weight: 300;
    margin-top: 0;
    color: #c3c3c3;
}

.summary-head {
    background: #ee7272;
    color: #fff;
    text-align: center;
    border-bottom: 1px solid #ee7272;
}

.summary-head h4 {
    font-weight: 300;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.summary-head p {
    color: rgba(255,255,255,0.6);
}

ul.summary-list {
    display: inline-block;
    padding-left:0 ;
    width: 100%;
    margin-bottom: 0;
}

ul.summary-list > li {
    display: inline-block;
    width: 19.5%;
    text-align: center;
}

ul.summary-list > li > a > i {
    display:block;
    font-size: 18px;
    padding-bottom: 5px;
}

ul.summary-list > li > a {
    padding: 10px 0;
    display: inline-block;
    color: #818181;
}

ul.summary-list > li  {
    border-right: 1px solid #eaeaea;
}

ul.summary-list > li:last-child  {
    border-right: none;
}

.activity {
    width: 100%;
    float: left;
    margin-bottom: 10px;
}

.activity.alt {
    width: 100%;
    float: right;
    margin-bottom: 10px;
}

.activity span {
    float: left;
}

.activity.alt span {
    float: right;
}
.activity span, .activity.alt span {
    width: 45px;
    height: 45px;
    line-height: 45px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    background: #eee;
    text-align: center;
    color: #fff;
    font-size: 16px;
}

.activity.terques span {
    background: #8dd7d6;
}

.activity.terques h4 {
    color: #8dd7d6;
}
.activity.purple span {
    background: #b984dc;
}

.activity.purple h4 {
    color: #b984dc;
}
.activity.blue span {
    background: #90b4e6;
}

.activity.blue h4 {
    color: #90b4e6;
}
.activity.green span {
    background: #aec785;
}

.activity.green h4 {
    color: #aec785;
}

.activity h4 {
    margin-top:0 ;
    font-size: 16px;
}

.activity p {
    margin-bottom: 0;
    font-size: 13px;
}

.activity .activity-desk i, .activity.alt .activity-desk i {
    float: left;
    font-size: 18px;
    margin-right: 10px;
    color: #bebebe;
}

.activity .activity-desk {
    margin-left: 70px;
    position: relative;
}

.activity.alt .activity-desk {
    margin-right: 70px;
    position: relative;
}

.activity.alt .activity-desk .panel {
    float: right;
    position: relative;
}

.activity-desk .panel {
    background: #F4F4F4 ;
    display: inline-block;
}


.activity .activity-desk .arrow {
    border-right: 8px solid #F4F4F4 !important;
}
.activity .activity-desk .arrow {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    left: -7px;
    position: absolute;
    top: 13px;
    width: 0;
}

.activity-desk .arrow-alt {
    border-left: 8px solid #F4F4F4 !important;
}

.activity-desk .arrow-alt {
    border-bottom: 8px solid transparent;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    right: -7px;
    position: absolute;
    top: 13px;
    width: 0;
}

.activity-desk .album {
    display: inline-block;
    margin-top: 10px;
}

.activity-desk .album a{
    margin-right: 10px;
}

.activity-desk .album a:last-child{
    margin-right: 0px;
}
/* Style the Image Used to Trigger the Modal */
img {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

img:hover {opacity: 0.7;}

/* The Modal (background) */
#image-viewer {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
}
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}
.modal-content { 
    animation-name: zoom;
    animation-duration: 0.6s;
}
@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}
#image-viewer .close {
    position: absolute;
    top: 100px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}
#image-viewer .close:hover,
#image-viewer .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>


    <!-- Start Page content -->
    <section class="content">
    <div class="box-header with-border" style="
    float: right;
    /* justify-content: right; */
    text-align: right;
    width: 100%;
">@if($user->is_approve == 1 && $user->is_deleted == false)
<a href="http://iasmess.dubudubutechnologies.com/users/approved">
@elseif($user->is_approve == 1 && $user->is_deleted == true)
<a href="http://iasmess.dubudubutechnologies.com/users/deceased">
@elseif($user->is_approve == 0)
<a href="http://iasmess.dubudubutechnologies.com/users">
@endif
 <button class="btn btn-danger btn-sm pull-right" type="submit">
    <i class="mdi mdi-keyboard-backspace mr-2"></i>
        back
</button>
                            </a>
                        </div>
        {{-- <div class="container-fluid"> --}}

        
        <div class="row" style="margin: 20px 20px 20px 20px;background: white;padding-top: 30px;border-radius:3px">
        <div class="container bootstrap snippets bootdey">
            <div class="row">
                <div class="profile-info col-md-12">
                    <div class="panel">
                        <div class="panel-body bio-graph-info">
                            <h1><strong>User Details</strong></h1>
                            <div class="row">
                                <div class="bio-row">
                                    <p><span>Full Name </span>: {{$user->salutation}} {{$user->name}}</p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Date of Birth </span>: {{$user->dob}}</p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Batch </span>: {{$user->batch}}</p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Email ID</span>: {{$user->email}}</p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Mobile No </span>: {{$user->mobile}}</p>
                                </div>
                                <div class="bio-row">
                                    <p><span>Date of Retirement </span>: {{$user->retired_date}}</p>
                                </div>
                                <div class="bio-row">
                                    <p> <span style=" vertical-align: top;">Address </span>
                                        <span>: {{$user->address}}</span>
                                    </p>
                                </div>
                                <div class="bio-row">
                                <p><span>Membership Type </span>: 
                                    @if($user->membership_type == 1)
                                    Life Time Member
                                    @else
                                    Associate Member
                                    @endif
                                </p>
                                </div>
                                @if($user->is_approve == 1 && $user->is_deleted == false)
                                <div class="bio-row">
                                <p><span>Payment Mode </span>:  
                                   @if($user->payment_mode == 1)
                                   Cash
                                   @elseif ($user->payment_mode == 2)
                                   Cheque
                                   @else
                                   Bank Transfer
                                   @endif
                                </p>
                                </div>
                                @endif
                                <div class="bio-row images">
                                    <p><span>Profile Picture </span>: <img src="{{$user->profile_picture}}" width="100px" height="100px"> </p>
                                    <div id="image-viewer">
                                    <span class="close">&times;</span>
                                    <img class="modal-content" id="full-image">
                                    </div>
                                </div>
                                <div class="bio-row images">
                                    <p><span>Proof ID </span>: <img src="{{$user->proof}}" width="100px" height="100px"></p>
                                </div>
                                @if($user->is_deleted == true)
                                <div class="bio-row images">
                                    <p><span>Legal Heir proof of family </span>: <img src="{{$user->proof}}" width="100px" height="100px"></p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group" style="
    width: 100%;
    text-align: center;
    align-items: center;
    display: flex;
    justify-content: center !im;
">
@if($user->is_approve == 0 && $user->is_deleted == false)
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-md m-5 make-approve" type="button">
                                            Send Payment Link                                        </button>
                                            <button class="btn btn-primary btn-md m-5 make-offline" type="button" style=" margin-left: 30px !important;">Make Offline Payment</button>
                                    </div>
                                    @endif
                                    @if($user->is_approve == 1 && $user->is_deleted == false)
                                    <div class="col-12">
                                        <button class="btn btn-success btn-md m-5" type="button" style="background-color:green;">
                                            Approved                                        </button>
                                    </div>
                                    @endif
                                    @if($user->is_deleted == true)
                                    <div class="col-12">
                                        <button class="btn btn-danger btn-md m-5" type="button">
                                           Marked as Deceased                                     </button>
                                    </div>
                                    @endif
                                </div>
        </div>
        <!-- container -->

        {{-- </div> --}}
        <!-- content -->

        <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
        <script>
            var search_keyword = '';
            var query = '';

            $(function() {
                $('body').on('click', '.pagination a', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    $.get(url, $('#search').serialize(), function(data) {
                        $('#js-user-partial-target').html(data);
                    });
                });

                $('#search').on('click', function(e) {
                    e.preventDefault();
                    search_keyword = $('#search_keyword').val();

                    fetch('users/search?search=' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-user-partial-target').innerHTML = html
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

                    fetch('users/fetch?' + search_keyword)
                        .then(response => response.text())
                        .then(html => {
                            document.querySelector('#js-user-partial-target').innerHTML = html
                        });
                });
            });

            // var search_keyword = '';
            // $(function() {
            //     $('body').on('click', '.pagination a', function(e) {
            //         e.preventDefault();
            //         var url = $(this).attr('href');
            //         $.get(url, $('#search').serialize(), function(data) {
            //             $('#js-user-partial-target').html(data);
            //         });
            //     });

            //     $('#search').on('click', function(e) {
            //         e.preventDefault();
            //         search_keyword = $('#search_keyword').val();

            //         fetch('users/fetch?search=' + search_keyword)
            //             .then(response => response.text())
            //             .then(html => {
            //                 document.querySelector('#js-user-partial-target').innerHTML = html
            //             });
            //     });


            // });
            
            $(document).on('click', '.make-offline', function(e) { 
                e.preventDefault();
                

                swal({
                    title: "Are you sure to Confirm Make Offline Payment?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#0A7E8C",
                    confirmButtonText: "Make Offline Payment",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        $(this).addClass("active");
                        swal.close(); 
                      
                        popup_init();
                        var content = `<div class="popup_deceased">
                        <div class="form-group">
                        <label for="image" style="font-size: 16px;">
                        MemberShip Type
                        </label> 
                        <select id="membership_type" name="membership_type" style=" width: 95%; padding: 10px; border-radius: 3px; border: 1px solid #c6c6c6; cursor: pointer;" required="">`;
                        var selected = "";
                        var price = 0;
                        @foreach($membership_tariff as $key=>$value)
                            @if($value->id == $user->membership_type)
                            content += `<option value="{{$value->id}}" data-price="{{$value->price}}" selected>{{$value->name}}</option>`;
                            price = "{{$value->price}}"
                            @else
                            content += `<option value="{{$value->id}}" data-price="{{$value->price}}" >{{$value->name}}</option>`;
                            @endif
                            
                        @endforeach 
                            content += `</select></div>
                            <div class="form-group">
                        <label for="image" style="font-size: 16px;">
                        Payment Mode
                        </label> 
                        <select id="payment_mode" name="payment_mode" style=" width: 95%; padding: 10px; border-radius: 3px; border: 1px solid #c6c6c6; cursor: pointer;" required="">
                            <option value="1" selected="">Cash</option>
                            <option value="2">Cheque</option>
                            <option value="3">Bank Transter</option>
                        </select>
                        </div>
                            <div class="form-group">
                                        <label for="image" style="
                                        font-size: 16px;
                                        ">Price
                                        </label> 
                                        <br><span class="membership-price" style="
                                            font-size: 26px;
                                        ">₹${price}</span> 
                                        <br>
                                        <div class="text-center m-b-0" style="/* background: #0A7E8C; */">
                                        <button class="btn btn-custom waves-effect waves-light make-confirm" data-url="{{url('users/confirm',$user->id)}}" type="button" style="background: #0A7E8C;
                                                padding-left: 30px;padding-right: 30px;">Confirm</button>
                                        </div>
                                    <br> 
                                                    </div>
                                        </div>`;
                        popup_data(content);
                        $("#membership_type").change(function() {
                            var selectedOption = $(this).find('option:selected');
                            var price = selectedOption.data('price');
                            $(".membership-price").html(`₹${price}`);
                        });
                      
                    }
                });
            });
            $(document).on('click', '.make-confirm', function(e) {
                let url = $(this).attr('data-url');
                var data = $("#membership_type").val();
                var payment_mode = $("#payment_mode").val();
                $(".make-confirm").addClass("active");
                $.ajax({
            url: url,
            data: {data:data,payment_mode:payment_mode},
            cache: false,
            success: function(res) { 
                console.log(res);
                $(".make-confirm").removeClass("active");
                $(".cancel").hide();
                $.toast({
                    heading: '',
                    text: "Confirmed Successfully",
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 1
                });
                window.location.reload();
            }
        });
            });
            
            $(document).on('click', '.make-approve', function(e) {
                e.preventDefault();
                

                swal({
                    title: "Are you sure to Send Payment Link ?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#0A7E8C",
                    confirmButtonText: "Send Payment Link",
                    cancelButtonText: "No! Keep it",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        $(this).addClass("active");
                        swal.close();

                        $.ajax({
                            url: "{{url('/')}}/users/approve/{{$user->id}}",
                            cache: false,
                            success: function(res) { 
                                $(this).removeClass("active");
                                $.toast({
                                    heading: '',
                                    text: "Payment Link Sent Successfully",
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'success',
                                    hideAfter: 5000,
                                    stack: 1
                                });
                                window.location.reload();
                            }
                        });
                    }
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

                                fetch('users/fetch?search=' + search_keyword)
                                    .then(response => response.text())
                                    .then(html => {
                                        document.querySelector('#js-user-partial-target')
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
            $(".images img").click(function(){
  $("#full-image").attr("src", $(this).attr("src"));
  $('#image-viewer').show();
});

$("#image-viewer .close").click(function(){
  $('#image-viewer').hide();
});

        </script>
    @endsection
