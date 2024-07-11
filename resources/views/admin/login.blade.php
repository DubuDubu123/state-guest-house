<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8" />
    <title>@lang('view_pages.admin_login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <!-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"> -->
    <link rel="shortcut icon" href="{{ fav_icon() ?? asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ url('assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Bootstrap extend-->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap-extend.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/css/master_style.css') }}">

    <!-- Fab Admin skins -->
    <link rel="stylesheet" href="{{ url('assets/css/skins/_all-skins.css') }}">
    <style>
        .error-style {
            list-style: none;
            color: red;
            text-align: center;
            margin-top: 15%;
            padding: 0;
        }
        /* linear-gradient(90deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)) */
        body {
            background-image: url(assets/images/admin-bg.png) !important;
            background-size: cover !important;
        }
        .login-box-body, .register-box-body, .lockscreen-box-body {
            background: #fff;
            padding:0 20px 25px 20px;
            border-top: 0;
            border:0.5px solid #d4d4d4;
            /* color: #ffffff; */
            border-radius: 20px;
            box-shadow: none;
            -webkit-box-shadow: -13px 16px 15px -8px rgba(173,173,173,1);
            -moz-box-shadow: -13px 16px 15px -8px rgba(173,173,173,1);
            box-shadow: -13px 16px 15px -8px rgba(173,173,173,1); 
        }
        .login-email input {
            height: 35px;
            background: #f4f5ff;
            border: none;
            border-radius: 8px !important;
            padding-left: 25px;
            margin-bottom: 20px;
        }
        .login-btn button {
            font-size: 12px;
            font-weight: 600;
            border-radius: 10px;
        }

        .margin-top-10 {
            margin-top: 10px;
        }
        .btn-info {
            background-color: #fad813;
            border-color: #fad813;
            color: #fff;
        }

        .dubu{
            display:inline-block;
            position:absolute;
            bottom:420px;
            right:250px;

        }
        /* 
        ##Device = Desktops
        ##Screen = 1281px to higher resolution desktops
        */

        @media (min-width: 1281px) { 
            .dubu{
            display:inline-block;
            position:absolute;
            bottom:420px;
            right:250px; 
        }  
        }

/* 
  ##Device = Laptops, Desktops
  ##Screen = B/w 1025px to 1280px
*/

@media (min-width: 1025px) and (max-width: 1280px) {
  
    .dubu{
    display:inline-block;
    position:absolute;
    bottom:420px;
    right:250px;

}
  
}

/* 
  ##Device = Tablets, Ipads (portrait)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) {
  
    .dubu{
    display:inline-block;
    position:absolute;
    bottom:480px;
    right:200px;

}
  
}

/* 
  ##Device = Tablets, Ipads (landscape)
  ##Screen = B/w 768px to 1024px
*/

@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
  
    .dubu{
    display:inline-block;
    position:absolute;
    bottom:350px;
    right:160px;

    label #label{
        margin-left:-100px;
    }

}
  
}

/* 
  ##Device = Low Resolution Tablets, Mobiles (Landscape)
  ##Screen = B/w 481px to 767px
*/

@media (min-width: 481px) and (max-width: 767px) {
  
    .dubu{
    display:inline-block;
    position:absolute;
    bottom:420px;
    right:250px;

}
  
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
  /* CSS */
  
}
/* @media only screen and (min-width: 768px){
#label{
    position: absolute;
    bottom:50px;
    left: 200px;
}
} */

    </style>
</head>

<body class="hold-transition login-page">

    <div class="container h-p100">
        <div class="row align-items-center justify-content-md-center h-p100" style="margin-top:185px;">

            <div class="col col-lg-2 col-md-6 d-none d-md-block">
                 <h4 class="dubu"><a href="https://www.dubudubu.in/" target="_blank" style="color:#fad813;font-size:25px;">www.dubudubu.in</a></h4>
                
                <!-- <img src="http://localhost/tagyourtaxi/future/public/assets/images/left.svg" alt=""> -->
            </div>

            <div class="col col-lg-3 col-md-6 col-12">
                <div class="login-box">
                    <div class="login-box-body text-center">
                        <!-- <img src="{{ fav_icon() ?? asset('images/favicon.png') }}" alt=""> -->
                        <!-- /.col -->
                                <div class="col-12 text-center">
                                    <!-- <h5>Dubu Dubu India Pvt. Ltd.,</h5> -->
                                    <!-- <a href="https://www.dubudubu.in/" target="_blank" style="color:#fad813;">www.dubudubu.in</a> -->
                                </div>
                                <!-- /.col -->
                        <!-- <h3 class="text-center">@lang('view_pages.admin_panel')</h3> -->
                        <p class="login-box-msg"></p>
                        <!-- action="{{ url('api/spa/login') }}" method="post" -->
                        <form class="login_form" id="form" enctype="multipart/form-data">
                            <div class="col-12 form-group has-feedback"
                                style="display:flex;margin-bottom:15px;background: #fff;padding: 0px;">
                                <!-- <div class="col-md-2 float-left text-center"> -->
                                <!-- <span class="ion ion-email form-control-feedback"></span>
                        </div> -->
                        <div class="print-error-msg" style="position: absolute;right: 0;left: 0;">
                            <ul class="error-style"></ul>
                        </div>

                                <div class="col-md-11 mx-auto p-0 login-email">
                                <label id="label" for="email" style="margin-left:-200px">Username</label>
                                    <input type="email" style="border-radius:none;" class="form-control rounded"
                                        name="email" id="emailaddress" required="" placeholder="Email" maxlength="74"
                                        data-validation="required length email" data-validation-length="8-74"
                                        data-validation-error-msg-email="Please enter valid email address">
                                </div>
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>

                            <div class="col-12 form-group has-feedback"
                                style="display:flex;margin-bottom:10px;background: #fff;padding: 0px;">
                                <!-- <div class="col-md-2 float-left text-center">
                           <span class="ion ion-locked form-control-feedback"></span>
                      </div> -->
                                <div class="col-md-11 mx-auto text-center p-0 login-email">
                                    <label id="label" for="password" style="margin-left:-200px">Password</label>
                                    <input type="password" name="password" style="border-radius:none;" required=""
                                        id="password" class="form-control rounded" placeholder="Password" maxlength="30"
                                        data-validation="required length" data-validation-length="8-30"
                                        data-validation-error-msg-length="Password should have atleast 8 characters.">
                                </div>
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="checkbox">
                                        <input type="checkbox" id="basic_checkbox_1">
                                        <label for="basic_checkbox_1">@lang('view_pages.remember_me')</label>                                    
                                    </div>
                                </div>
                                <div class="col-6">
                                   <span> <a href="{{ url('forgot_password')}}">@lang('view_pages.forgot_password')</a></span>
                                </div>

                            
                                <!-- /.col -->
                                <div class="col-3 text-center login-btn">
                                </div>
                                <div class="col-6 text-center login-btn">
                                    <button class="btn btn-info btn-block margin-top-10 submit_button text-dark"
                                        type="submit">@lang('view_pages.sign_in')</button>
                                </div>
                                <!-- /.col -->
                                <div class="col-lg-3 col-md-8 col-12">
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /.login-box-body -->
                </div>
                <!-- /.login-box -->

            </div>


        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ url('assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>


    <!-- Bootstrap 4.0-->
    <script src="{{ url('assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/jquery.form-validator.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <?php if (session()->has('success')) {
    $alertMessage = session()->get('success'); ?>
    <script>
        var alertMessage = "<?php echo $alertMessage; ?>";

        //alert(alertMessage);
        $.toast({
            heading: '',
            text: alertMessage,
            position: 'top-right',
            loaderBg: '#5ba035',
            icon: 'success',
            hideAfter: 5000,
            stack: 1
        });

    </script>
    <?php
    } ?>

</body>

</html>
