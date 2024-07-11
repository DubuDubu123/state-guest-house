@extends('dispatch-new.layout')
<style>
  ul {
    display: flex;
    flex-direction: column;
    align-items: start;
    padding: 1em;
    gap: 2em;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
  </style>
@section('dispatch-content')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('assets/css/dispatcher/requestlist.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dispatcher/ongoing.css') }}">

<style>
.btn{
  font-size:12px;
}
</style>



<!-- <div class="g-col-12 mt-8 p-10">
    <div class=" d-flex align-items-center h-10 mb-10">
        <h2 class=" me-5 animate__animated animate__backInRight" style="font-size:25px;font-weight:800;color:#043c6c;">
           <i class="fa fa-car" style="color:black;"></i> Ongoing Trip
        </h2>
    </div>
</div> -->

<div class="g-col-12 g-col-lg-4 mt-10 p-10" style="position:relative">
<div class="active" style="
    font-size: 27px;
    font-weight: bold;
">Ongoing List</div>
<div style="padding: 10px;background-color: #f5f5ff;background: 0px 0px 8px 1px rgba(0,0,0,0.3);border-radius: 3px;display: inline-block;position: absolute;right: 30px;top: 16px;">
<div class="d-flex">
        <div class="box" style="background:#EAF0FB;">
            <ul role="tablist" class="pos__tabs nav1 nav-pills rounded-2" style="width:650px">
                <li id="all-tab" onclick="toggleActiveTab('all-tab')" class="nav-item flex-1 actv-tab actv" data-val="all" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5 active">All</button>
                </li>
                <li id="assigned-tab" onclick="toggleActiveTab('assigned-tab')"  class="nav-item flex-1" data-val="assigned" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5">Assigned</button>
                </li>
                <li data-val="unassigned" id="unassigned-tab" onclick="toggleActiveTab('unassigned-tab')" class="nav-item flex-1">
                    <button class="nav-link w-full1 pt-2 pb-2.5">Unassigned</button>
                </li>
                
            </ul>
        </div>
        
        <!-- <a href="" data-toggle="modal" data-target="#basicModal" class="btn ms-auto d-flex align-items-center text-theme-1 p-2" style="background:white;border-radius:10px;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);"><i data-feather="sliders" style="rotate:90deg;"></i></a> -->
    </div></div>

 
<div class="tab-content mt-5" style="padding:20px">
 <!-- all drivers tab -->
 <div class="tab-pane fade active show" id="all" role="tabpanel" aria-labelledby="all-tab">
          <!-- <div class="grid columns-12 gap-5 mt-5"> -->
<div class="table-responsive  tb"> 
<table class="table caption-top tb">
<thead style="text-align:center;height:53px;background-color: #454545;color: white;vertical-align: middle;">
      <tr>  
        <th scope="col" style="width:200px">Request No</th>
        <th scope="col" style="width:200px">Date</th>
        <th scope="col" style="width:450px">Pickup Location</th>
        <th scope="col" style="width:450px">Drop Location</th>
        <th scope="col" style="width:200px">Trip Status</th>
        <th scope="col" style="width:200px"> View</th>
      </tr>
    </thead>
    <tbody id="append-rows">
    <tr class="no-data-found" id="row"><td colspan="6" style = " text-align: center; justify-content:center;">No Requests Yet</td></tr>
    </tbody>
</table>
</div>
</div>
</div> 
<!-- offline drivers tab -->
       
</div>

          </div>
      </div> 
<script>
  $(document).ready(
  function(){
    $("li.d-flex").removeClass("active");
    $('li.ongoing').addClass('active');
  }
)
  </script>
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-messaging.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-analytics.js"></script>
<script>  
  var firebaseConfig = {
      apiKey: "{{ get_settings('firebase-api-key') }}",
      authDomain: "{{ get_settings('firebase-auth-domain') }}",
      databaseURL: "{{ get_settings('firebase-db-url') }}",
      projectId: "{{ get_settings('firebase-project-id') }}",
      storageBucket: "{{ get_settings('firebase-storage-bucket') }}",
      messagingSenderId: "{{ get_settings('firebase-messaging-sender-id') }}",
      appId: "{{ get_settings('firebase-app-id') }}",
      measurementId: "{{ get_settings('firebase-measurement-id') }}"
  }; 

  firebase.initializeApp(firebaseConfig);
  var url = "{{ url('/').'/dispatch/detailed-view'}} }}";
  var database = firebase.database();
  var requestRef = database.ref('requests');
  var requestMetaRef = database.ref('request-meta');  
  var shouldProcessChildAdded = false;
   setTimeout(function() {
    shouldProcessChildAdded = true;
    shouldProcessSosChildAdded = true;  
    }, 3000);
    var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");
  if(window.location.hostname == "localhost")
  {
      baseUrl+="/ayo/public";
  }   
  requestRef.on("child_added", (snapshot) => { 
    
    if(shouldProcessChildAdded){
      var dispatch_id = "{{auth()->user()->admin->id}}";
      
      var type = $('.nav-item .active').closest('.nav-item').attr('data-val');
      var key = snapshot.key;
      var snapshot = snapshot.val(); 
      var dispatch_status = false;
      if (snapshot.hasOwnProperty('dispatch_id')) 
      {
      if (snapshot.is_super_dispatcher == 1) 
      {
          dispatch_status = true;
      }
      if(dispatch_id == snapshot.dispatch_id)
      {
        dispatch_status = true;
      }
      }
      if(dispatch_status)
      {
        if(snapshot.cancelled_by_user)
        {
          $("tr#row_"+key).remove();
          var childRef = database.ref('requests/'+key); 
          // Remove the child node
          childRef.remove()
          .then(function() {
            console.log("Child node removed successfully.");
          })
          .catch(function(error) {
            console.error("Error removing child node: ", error);
          });
          var ongoingRowCount = $("tr").length;
          if(ongoingRowCount < 2)
          {
            var html_data = ` <tr class="no-data-found" id="row"><td colspan="6" style = " text-align: center; justify-content:center;">No Requests Yet</td></tr>`;
            $("#append-rows").html(html_data);
          }
        }
        if(snapshot.request_id){
          var html_data = ` <tr class="ongoing" id="row_${snapshot.request_id}"> 
          <td style="    text-align: center;">${snapshot.request_number}</td>
          <td style="width:160px">${snapshot.date}</td>
          <td>${snapshot.pick_address}</td>
          <td>${snapshot.drop_address}</td>
          <td class="trip_status_${snapshot.request_id}" style="padding-left:66px;"><button class="btn btn-warning"> Searching </button></td>
          <td>
              <a href="${baseUrl}/dispatch/detailed-view/${snapshot.request_id}" class="btn btn-primary" type="button">
            View</a></td>
            </tr>
          `;
          if(type !== 'assigned'){
            $("#append-rows").prepend(html_data);
            $("tr.no-data-found").remove();
          }
        }
      }
     
    }
    });
    requestRef.on("child_changed", (snapshot) => {
      if(shouldProcessChildAdded){
        var snapshot = snapshot.val();
        if(snapshot.is_completed == true)
        { 
          $("tr#row_"+snapshot.request_id).remove();
        }
        if(snapshot.cancelled_request == true)
        { 
          $("tr#row_"+snapshot.request_id).remove();
        }
        if(snapshot.cancelled_by_user == true)
        { 
          $("tr#row_"+snapshot.request_id).remove();
        }
        if(snapshot.is_cancelled == true)
        { 
          $("tr#row_"+snapshot.request_id).remove();
        }
        if(snapshot.is_accept == 0)
        { 
          $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-warning"> Searching </button>');
        }
        if(snapshot.is_accept == 1)
        {
          $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-success"> Accepted </button>');
        }
        if(snapshot.cancelled_by_driver == true)
        { 
          
          $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-danger"> Driver Cancelled the trip </button>');
          setTimeout(function() {
            $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-warning"> Searching </button>');
      }, 2000);
      firebase.database().ref('requests').child(snapshot.request_id).update({
            cancelled_by_driver: false,
            trip_arrived: 0,
            trip_start: 0
                                });  
        } 
        if(snapshot.trip_arrived == 1)
        { 
          $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-success"> Trip arrived </button>');
        } 
        if(snapshot.trip_start == 1)
        { 
          $("td.trip_status_"+snapshot.request_id).html('<button class="btn btn-primary"> On the Ride </button>');
        }
      } 
    });
  function getrequestdata(tabValue){
    requestRef.once('value').then(function(snapshot){
      var val = snapshot.val();
      var requests = [[], [],[]];
      var assign_method = $('input[name="assign_method"]:checked').val(); // 0 if auto and 1 if manual
      // if(!assign_method){
      for(var key in val){
        var req = val[key];
        var completed =0;
        var cancelled =0;
        var cancel_by_user = 0;
        if(req.hasOwnProperty('cancelled_by_user') && req.cancelled_by_user == true){
          cancel_by_user = 1;
        }
        if(req.hasOwnProperty('is_completed') && req.is_completed == true){
          completed = 1;
        }
        if(req.hasOwnProperty('is_cancelled') && req.is_cancelled == true){
          cancelled = 1;
        }
        if( !req.hasOwnProperty('is_cancel') && !cancel_by_user && !completed && !cancelled  && req.hasOwnProperty('request_number')){
          if( req.hasOwnProperty('driver_id') ){
            requests[1].push(req);
          }
          if( !req.hasOwnProperty('driver_id') ){
            requests[2].push(req);
          }
          requests[0].push(req);
        }
      }
      // }else{
      // for(var key in val){
      //   var req = val[key];
      //   var completed =0;
      //   var cancelled =0;
      //   if(req.hasOwnProperty('is_completed') && req.is_completed == true){
      //     completed = 1;
      //   }
      //   // if(req.hasOwnProperty('is_cancelled') && req.is_cancelled == true){
      //   //   cancelled = 1;
      //   // }
      //   if( !req.hasOwnProperty('cancelled_by_user') && req.hasOwnProperty('assign_method') && !completed  && req.hasOwnProperty('request_number')){
      //     if( req.hasOwnProperty('driver_id') ){
      //       requests[1].push(req);
      //     }
      //     if( !req.hasOwnProperty('driver_id') ){
      //       requests[2].push(req);
      //     }
      //     requests[0].push(req);
      //   }
      // }
      // }
      var html_data = ``;
      var i = 0 ;
      switch (tabValue) {
        case 'assigned':
          i=1;
          break;
        case 'unassigned':
          i = 2;
          break;
      
      }
    
      console.log(requests[0]);
      console.log(i);
      requests[i].forEach(function (request) {
        var dispatch_id = "{{auth()->user()->admin->id}}";
        var dispatch_status = false; 
        if (request.hasOwnProperty('dispatch_id')) 
        {
        if (request.is_super_dispatcher == 1) 
        {
            dispatch_status = true;
        }
        if(dispatch_id == request.dispatch_id)
        {
          dispatch_status = true;
        }
        } 
       if(dispatch_status)
       {
         
        var drop = "----";
        if(request.hasOwnProperty('drop_address')){
          drop = request.drop_address;
        }
        var status='';
        if(request.is_accept == 0)
        { 
          status ='<button class="btn btn-warning"> Searching </button>';
        }
        if(request.cancelled_by_driver == true)
        {  

          status ='<button class="btn btn-danger"> Driver Cancelled the trip </button>';
          setTimeout(function() {
            status ='<button class="btn btn-warning"> Searching </button>';
          }, 2000);
        }
        if(request.is_accept == 1)
        {
          status ='<button class="btn btn-success"> Accepted </button>';
        }
        if(request.trip_arrived == 1)
        { 
          status ='<button class="btn btn-success"> Trip arrived </button>';
        } 
        if(request.trip_start == 1)
        { 
          status ='<button class="btn btn-primary"> On the Ride </button>';
        }
        html_data += `
        <tr class="ongoing" id="row_${request.request_id}"> 
          <td>${request.request_number}</td>
          <td style="width:160px">${request.date}</td>
          <td>${request.pick_address}</td>
          <td>${drop}</td>
          <td id="trip_status_${request.request_id}">`+status+`</td>
          <td>
              <a href="${baseUrl}/dispatch/detailed-view/${request.request_id}" class="btn btn-primary" type="button">View</a>
          </td>
        </tr>`;
      }
       
      });
      if(requests[i].length !== 0){
        $("tr.no-data-found").remove();

      }else{
        html_data = ` <tr class="no-data-found" id="row"><td colspan="6" style = " text-align: center; justify-content:center;">No Requests Yet</td></tr>`;
      }
      $("#append-rows").html(html_data);
   
    });
  }
  function toggleActiveTab(tabId) {
  // Remove "active" class from all tabs
  var tabs = document.querySelectorAll('.nav-link');
  tabs.forEach(function(tab) {
      tab.classList.remove('active');
  });

  // Add "active" class to the clicked tab
  var clickedTab = document.getElementById(tabId);
  clickedTab.querySelector('.nav-link').classList.add('active');

  // Call the fetchDataFromFirebase function with the respective parameter
  var tabValue = clickedTab.getAttribute('data-val');
 
  getrequestdata(tabValue);
}
getrequestdata('all');
</script>
@endsection
 
        <!-- END: Form Layout -->


