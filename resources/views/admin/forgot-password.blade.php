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
    position:fixed;
    bottom:630px;
    right:1100px

}
.send_email.active {
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
                        <div class="print-error-msg" style="position: absolute;right: 0;left: 0;">
                            <ul class="error-style"></ul>
                        </div>
                        <img src="{{ fav_icon() ?? asset('images/favicon.png') }}" alt="">
                        <h3 class="text-center">Forgot Password</h3>
                        <p class="login-box-msg"></p>
                        @if(Session::has('message'))
                        <p class="text-danger">{{ Session::get('message') }}</p>
                        @endif
                        <form method="post" action="{{ url('/forgot_password') }}" enctype="multipart/form-data">
                        @csrf
                          <div class="col-12 form-group has-feedback"
                                style="display:flex;margin-bottom:15px;background: #fff;padding: 0px;">
                                <div class="col-md-11 mx-auto p-0 login-email">
                                Verify Your Email Address
                                    <input type="email" style="border-radius:none;" class="form-control rounded"
                                        name="email" id="email" required="" placeholder="Email">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>

                            </div>
                               <!-- /.col -->
                               <div class="row">
                               <div class="col-3 text-center login-btn">
                                </div>
                                <div class="col-12 text-center login-btn">
                                    <button class="btn btn-info btn-block margin-top-10 submit_button"
                                        type="submit">@lang('view_pages.send_link')</button>
                                </div>
                                <div class="col-3 text-center login-btn">
                                </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                    </div>
                    <!-- /.login-box-body -->
                </div>
                <!-- /.login-box -->

            </div>


        </div>
    </div>

    

</body>

</html>
