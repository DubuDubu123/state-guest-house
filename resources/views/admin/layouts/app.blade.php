<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">


<head>
    <meta charset="utf-8" />

    <meta dir="rtl" lang="ar">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="x-pjax-version" content="{{ mix('/css/app.css') }}">
    <title>IAS Mess - Admin App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="Tag your taxi Admin portal, helps to manage your fleets and trip requests" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="theme-color" content="#0B4DD8">


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/img/logo.png')}}">
     
    <style>

 /* Modal Styling */
 .modal-wrapper {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgb(0 0 0 / 67%);
  z-index: 9999;
  display: flex;
  justify-content: center; 
  animation: fadeIn 0.5s ease-in-out;
  outline: 0;
    overflow-x: hidden;
    overflow-y: auto;
    position: fixed;
}

.modal-content {
  min-width: 500px;
  max-width: 700px;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.5s ease-in-out;
}

.modal-close {
    position: absolute;
    top: 0px;
    right: 10px;
    cursor: pointer;
    font-size: 26px;
}

/* Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    transform: translateY(-50px);
  }
  to {
    transform: translateY(0);
  }
}

    .modal.fade.top.show{
top:0px !important
    }
    .page-item.active .page-link{
      z-index: 3;
    background-color: #86BEBD !important;
    border-color: #86BEBD !important;
    }
    .pagination li a:hover {
    color: #fff;
    border: 1px solid #86BEBD;
    background-color: #86BEBD !important;
}
/* For Chrome, Safari, Edge, Opera */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* For Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}

        </style>
    @include('admin.layouts.common_styles')
    @yield('extra-css')
</head>

<body class="hold-transition skin-blue sidebar-mini fixed" dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">

    <!-- Begin page -->
    <div class="wrapper skin-blue-light">
        <!-- Navigation -->
        @include('admin.layouts.topnavbar')

        @include('admin.layouts.navigation')

        <div class="content-wrapper">
            <!-- Page wrapper -->
            @include('admin.layouts.common_scripts')

            <!-- Main view  -->
            @yield('content')

        </div>
        <!-- Footer -->

    </div>
    <!-- <audio id="audioPlayer">
<source src="{{ asset('audio/order_alert.mp3') }}">    
</audio> 
<audio id="sosplayer">
<source src="{{ asset('audio/sos_alert.mp3') }}">    
</audio>  -->
    <div class="modal-wrapper" id="modal1" style="display:none">
<div class="modal-dialog"> 
<div class="modal-content ">
    <span class="modal-close" onclick="popup_close()">&times;</span> 
    <div class="model-content-wrapping">
  </div> 
  </div> 
</div>
</div>
<script>
      var audio = document.getElementById("audioPlayer"); 
     var sos_audio = document.getElementById("sosplayer"); 
    function playAudio(type=undefined) {
      if(type == 1)
      {
        sos_audio.play();
      }
      else{
        audio.play();
      }
      
    }

    function pauseAudio(type=undefined) {
      if(type == 1)
      {
        sos_audio.pause();
      }
      else{
        audio.pause();
      } 
    }
    var modal;
    function popup_init(){
    modal = document.getElementById("modal1");
    modal.style.display = "flex";
  }
  function popup_data(model_content){
    $(".model-content-wrapping").html(model_content);
    modal.style.display = "flex"; 

  }
  function popup_close()
  {
    var modal = document.getElementById("modal1");
    modal.style.display = "none";
  }
 
  // popup_init();
</script>
    @yield('extra-js')
   
</body>

</html>