
    <!-- jQuery 3 -->
    <script src="{{asset('assets/vendor_components/jquery/dist/jquery.js')}}"></script>


    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('assets/vendor_components/jquery-ui/jquery-ui.js')}}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- popper -->
    <script src="{{asset('assets/vendor_components/popper/dist/popper.min.js') }}"></script>

    <!-- Bootstrap 4.0-->
    <script src="{{asset('assets/vendor_components/bootstrap/dist/js/bootstrap.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>

    <!-- ChartJS -->
    <script src="{{asset('assets/vendor_components/chart.js-master/Chart.min.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{asset('assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- FastClick -->
    <script src="{{asset('assets/vendor_components/fastclick/lib/fastclick.js') }}"></script>

    <!-- peity -->
    <script src="{{asset('assets/vendor_components/jquery.peity/jquery.peity.js') }}"></script>

    <!-- Fab Admin App -->
    <script src="{{asset('assets/js/template.js')}}"></script>
    <!-- Fab Admin for demo purposes -->
    <script src="{{asset('assets/js/demo.js')}}"></script>

    <!-- Vector map JavaScript -->
    <script src="{{asset('assets/vendor_components/jvectormap/lib2/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('assets/vendor_components/jvectormap/lib2/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('assets/vendor_components/jvectormap/lib2/jquery-jvectormap-us-aea-en.js')}}"></script>

    <!-- Sweet-Alert  -->
    <script src="{{asset('assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/vendor_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

    <!-- toast -->
    <script src="{{asset('assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js')}}"></script>
    <script src="{{asset('assets/js/pages/toastr.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/vendor_plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
        <!-- bootstrap time picker -->
    <script src="{{asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
        <!-- date-range-picker -->
    <script src="{{asset('assets/vendor_components/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <!-- bootstrap color picker -->
    <script src="{{asset('assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>

        <!-- iCheck 1.0.1 -->
    <script src="{{asset('assets/vendor_plugins/iCheck/icheck.min.js')}}"></script> 

  
    {{-- mapbox script --}}
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>





    @yield('extra-scripts')

    {{-- @stack('sos-script') --}}
    <!-- Fab Admin for advanced form element -->
    <script src="{{asset('assets/js/pages/advanced-form-element.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    <script src="https://code.highcharts.com/6.0.6/highcharts-more.js"></script> --}}

<!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-messaging.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->

<script> 
//    var shouldProcessChildAdded = false;
//    var shouldProcessSosChildAdded = false;
//     var firebaseConfig = {
//     apiKey: "{{get_settings('firebase-api-key')}}",
//     authDomain: "{{get_settings('firebase-auth-domain')}}",
//     databaseURL: "{{get_settings('firebase-db-url')}}",
//     projectId: "{{get_settings('firebase-project-id')}}",
//     storageBucket: "{{get_settings('firebase-storage-bucket')}}",
//     messagingSenderId: "{{get_settings('firebase-messaging-sender-id')}}",
//     appId: "{{get_settings('firebase-app-id')}}",
//     measurementId: "{{get_settings('firebase-measurement-id')}}"
//   };



//         // Initialize Firebase
//         firebase.initializeApp(firebaseConfig);
//         firebase.analytics();
//         const messaging = firebase.messaging();
        

//         var database = firebase.database();
//         var statusRef = database.ref('food-delivery');
//         statusRef.on('child_changed', function(snapshot) {
//         var changedId = snapshot.key;
//         var updatedData = snapshot.val();
//         @if(isset($order)) 
//         var order_id = '{{$order->id}}';

//         if(changedId == order_id)
//         {
//             $("#line-progress").removeClass("cancelled_request");
//             if(updatedData.status == 3)
//             {
//                 $("#line-progress").css("width", "25%");
//                 $(".step01").addClass("active");
//                 $(".step02").addClass("active");
//             }
//             if(updatedData.status == 4)
//             {
//                 $("#line-progress").css("width", "50%");
//                 $(".step01").addClass("active");
//                 $(".step02").addClass("active");
//                 $(".step03").addClass("active");
//             }
//             if(updatedData.status == 5)
//             {
//                 $("#line-progress").css("width", "75%");
//                 $(".step01").addClass("active");
//                 $(".step02").addClass("active");
//                 $(".step03").addClass("active");
//                 $(".step04").addClass("active");
//             }
            
//             if(updatedData.status == 6)
//             {
//                 $("#line-progress").css("width", "25%");
//                 $(".step01").addClass("active"); 
//                 $(".step02").addClass("cancelled");
//                 $("#line-progress").addClass("cancelled_request");
//                 $(".step-inner.cancelled_by_user").html('Cancelled By User');
//                 $("img.cancelled-user").attr("src", "{{url('assets/img/3.png')}}");

//             }
//             if(updatedData.status == 7)
//             {
//                 $("#line-progress").css("width", "100%");
//                 $(".step01").addClass("active");
//                 $(".step02").addClass("active");
//                 $(".step03").addClass("active");
//                 $(".step04").addClass("active");
//                 $(".step05").addClass("active");
//             }
//         }
//         @endif
//    // The snapshot represents the child node that was changed
       
//         if(updatedData.pending_count > 0)
//         {
//             $(".count_badge").show();
//             $(".count_badge").html(updatedData.pending_count);
//         }
//         else{
//              $(".count_badge").hide();
//             $(".count_badge").html('');
//         }
//          if(updatedData.refund_pending_count > 0)
//         {
//             $(".refund_count_badge").show();
//             if(!$(".refund_count_badge").hasClass("actv"))
//             {
//                 $(".refund_count_badge").addClass("actv");
//             }

//             $(".refund_count_badge").html(updatedData.refund_pending_count);
//         }
//         else{
//              $(".refund_count_badge").hide();
//              $(".refund_count_badge").removeClass("actv");
//             $(".refund_count_badge").html('');
//         }


//         // Perform actions based on the updated data for the specific ID
//         console.log('Updated data for ID:', changedId, updatedData);

//         // Add your custom logic here based on the updated data
//         // For example, update the UI, trigger some functions, etc.
//     });

//     statusRef.on('child_added', function(snapshot) {
//          if (shouldProcessChildAdded)
//         {
//               var newKey = snapshot.key;
//               var newData = snapshot.val();
//               $(".count_badge").show();
//               $(".count_badge").html(newData.pending_count);
//               if(newData.status == 0)
//               {
//                  playAudio();
//                  $("#order-model").modal('show');
//               }
             
//         // Perform actions based on the new data
//         console.log('New data added with key:', newKey, 'Data:', newData);
//         }

//         // The snapshot represents the new child node that was added


//         // Add your custom logic here based on the new data
//         // For example, update the UI, trigger some functions, etc.
//     });

//     setTimeout(function() {
//     shouldProcessChildAdded = true;
//     shouldProcessSosChildAdded = true;
//     }, 3000);



        // Get a reference to the database service


    //      if ('serviceWorker' in navigator) {
    // navigator.serviceWorker.register('http://localhost/food-delivery/public/firebase-messaging-sw.js')
    //   .then((registration) => {
    //     console.log('Service Worker registered with scope:', registration.scope);
    //   })
    //   .catch((error) => {
    //     console.error('Service Worker registration failed:', error);
    //   });
    // }
        // const vapidKey = 'your-custom-vapid-key';

        // messaging.requestPermission()
        // .then(() => {
        // console.log('Notification permission granted.');
        // console.log(messaging.getToken());
        // return messaging.getToken();
        // })
        // .then((token) => {

        // console.log('Notification permission granted.');
        // console.log('Token:', token);
        // })
        // .catch((error) => {
        // console.error('Error getting notification permission:', error);
        // });

        // messaging.onMessage((payload) => {
        // console.log('Message received:', payload);
        // // Handle the notification here
        // });


    $('.logout').click(function(e) {
        button = $(this);defined
        e.preventDefault();

        swal({
            title: "Are you sure to logout ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Logout",
            cancelButtonText: "Stay in",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                button.unbind();
                button[0].click();
            }
        });
    });
</script>




<script>

$('.logout').click(function(e){
    button=$(this);
    e.preventDefault();

        swal({
            title: "Are you sure to logout ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Logout",
            cancelButtonText: "Stay in",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {
                button.unbind();
                button[0].click();
            }
        });
    });+

    // $(document).on('click','.sweet-delete',function(e){
$('.sweet-delete').click(function(e){
    button=$(this);
    e.preventDefault();

        swal({
            title: "Are you sure to delete ?",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            cancelButtonText: "No! Keep it",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {
                button.unbind();
                button[0].click();
            }
        });
    });

</script>


<?php

if (session()->has('success')) {
    $alertMessage = session()->get('success'); ?>
<script>
    var alertMessage = "<?php echo $alertMessage ?>";

    //alert(alertMessage);
    $.toast({
        heading: '',
        text: alertMessage,
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: 'success',
        hideAfter: 5000,
        stack: 1
    });

</script>
<?php
}?>

<?php
if (session()->has('warning')) {
    $alertMessage = session()->get('warning'); ?>
<script>
    var alertMessage = "<?php echo $alertMessage ?>";

    $.toast({
        heading: '',
        text: alertMessage,
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: 'warning',
        hideAfter: 5000,
        stack: 1
    });

</script>
<?php
}?>

<script>
     function readURL(input) {
         var parentDiv = input.closest('div');

        // if label is present childnodes may differ
         if(parentDiv.childNodes.length == 16){
             $keys = [4,9,11];
         }else{
            // for settings page only
            $keys = [1,7,9];
         }

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    if(e.target.result){
                        parentDiv.childNodes[$keys[1]].innerText = 'Change';
                        parentDiv.childNodes[$keys[2]].style.display = 'inline-block';
                    }else{
                        parentDiv.childNodes[$keys[2]].style.display = 'none';
                        parentDiv.childNodes[$keys[1]].innerText = 'Browse';
                    }
                    parentDiv.childNodes[$keys[0]].setAttribute('src', e.target.result);
                    parentDiv.childNodes[$keys[0]].style.height = '250px';
                }
                reader.readAsDataURL(input.files[0]);
                $(".sendPush").show();
            }
        }

        $("#profile").change(function() {
            console.log(this);
            readURL(this);
        });


    $(document).on('click','#remove_img',function(){
        // $('#remove_img').click(function(){
            $('#blah').removeAttr('src');
            $('#remove_img').hide();
            $('#upload').text('Browse');
            $('#image').val('');
            $('#blah').css('height','0px');
            $(".sendPush").hide();
        });

        // setTimeout(function(){
        //     $('.text-danger').fadeOut('slow');
        // },5000);


$(document).on('click','.chooseLanguage',function(){
    let langValue = $(this).attr('data-value')

    var link = "<?php echo url('/change/lang')?>";
    var finalLink = link+'/'+langValue;

    console.log(finalLink);

    window.location = finalLink;
});
</script>

@if (session('failure'))
<script>
        swal({
            title: '',
            text: "{{ session('failure') }}"
        });
</script>
@endif

{{-- @push('sos-script') --}}

    <!-- <script src="{{ asset('assets/js/fetchdata.min.js') }}"></script> -->
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-database.js"></script> -->
    <!-- TODO: Add SDKs for Firebase products that you want to use https://firebase.google.com/docs/web/setup#available-libraries -->
    <!-- <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script> -->
 
{{-- @endpush --}}
