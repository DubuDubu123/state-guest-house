@extends('dispatch-new.layout')

@section('dispatch-content')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('assets/css/dispatcher/requestlist.css') }}">
<style>
.season_tabs {
  position: relative;   
  min-height: 260px; 
  clear: both;
  margin: 25px 0;
}
.season_tab {
  float: left;  
  clear: both;
  width: 200px;
  border-right:1px solid #dcbaff;
}
.season_tab label {
    /* background: #eee; */
    padding: 15px;
    /* border: 1px solid #ccc; */
    margin-left: -1px;
    font-size: 18px;
    vertical-align: middle;
    position: relative;
    left: 1px;
    width: 200px;
    height: 68px;
    display: table-cell;
}
.season_tab [type=radio] {
  display: none;   
}
.season_content {
  position: absolute;
  font-size:15px;
  top: 0;
  left: 210px;
  background: white;
  right: 0;
  bottom: 0;
  padding: 20px;
  /* border: 1px solid #ccc; */
 }
.season_content span {
  animation: 0.5s ease-out 0s 1 slideInFromTop; 
}
[type=radio]:checked ~ label {
  /* background: white; */
  border-left: 5px solid #043c6c;
  z-index: 2;
}
[type=radio]:checked ~ label ~ .season_content {
  z-index: 1;
}
.tom-select .ts-dropdown {
    font-size: 1.5rem;
}
.tom-select .ts-input {
    font-size: 1.5rem;
}
.form-control {
    font-size: 1.5rem;
}
.form-select {
    font-size: 1.5rem;
}
.pagination .page-item .page-link {
    border-radius: 0.375rem;
    box-shadow: none;
    font-weight: 400;
    margin-right: 0.5rem;
    min-width: 40px;
    text-align: center;
    font-size: 18px;
    margin-top: 20px;
}
</style>



<div class="g-col-12 mt-8 p-10">
    <!-- <div class="intro-y d-flex align-items-center h-10 mb-10">
        <h2 class=" me-5 animate__animated animate__backInRight" style="font-size:25px;font-weight:800;color:#043c6c;">
           <i class="far fa-question-circle" style="color:black;"></i> Request List
        </h2>
    </div> -->
    <div class="grid columns-12 gap-6 mt-5">
    <div class="g-col-12 g-col-sm-6 g-col-xl-6">
            <div class="zoom-in" style="box-shadow:  0px 0px 8px 1px rgba(127, 0, 255, 0.15);border-radius:15px;height: 168px;">
                <div class="box" style="border-radius:15px;height: 100%;">
                    
<div style="
    display: inline-block;
    padding-right: 40px;
    padding-left: 30px;
    padding-top: 46px;
    /* position: relative; */
    /* bottom: 5px; */
    height: 100%;
    background-color: #043c6c;
"><div style="font-size:25px;font-weight:800;position: relative;bottom: 14px;" class="mt-6">Completed</div>
<div class="mt-1 p-5" style="font-size:25px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */position: relative;bottom: 15px;">{{$is_completed_count}}</div></div>
<div style="display: inline-block;padding-right: 50px;padding-left: 50px;/* padding-top: 0px; */vertical-align: text-bottom;/* padding-top: 48px; *//* height: 100%; *//* background-color: #043c6c; */border-right: 3px solid black;position: relative;bottom: 10px;height: 80px;width: 235px;"><div style="font-size: 24px;font-weight:800;">Dispatcher</div>
<div class="mt-1 p-5" style="font-size: 19px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */">{{$dispatcher_completed_count}}</div></div><div style="
    display: inline-block;
    padding-right: 40px;
    padding-left: 30px;
    /* padding-top: 40px; */
    /* height: 100%; */
    /* background-color: #043c6c; */
    display: inline-block;
    padding-right: 40px;
    padding-left: 0px;
    /* padding-top: 0px; */
    vertical-align: text-bottom;
    /* padding-top: 48px; */
    /* height: 100%; */
    /* background-color: #043c6c; */
    /* border-right: 3px solid black; */
    position: relative;
    bottom: 10px;
    height: 80px;
    width: 250px;
"><div style="font-size: 24px;font-weight:800;text-align: center;">App</div>
<div class="mt-1 p-5" style="font-size: 19px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */">{{$app_completed_count}}</div></div>
                    
                </div>
            </div>
        </div>
        <div class="g-col-12 g-col-sm-6 g-col-xl-6">
            <div class="zoom-in" style="box-shadow:  0px 0px 8px 1px rgba(127, 0, 255, 0.15);border-radius:15px;height: 168px;">
                <div class="box" style="border-radius:15px;height: 100%;">
                    
<div style="
    display: inline-block;
    padding-right: 40px;
    padding-left: 30px;
    padding-top: 46px;
    /* position: relative; */
    /* bottom: 5px; */
    height: 100%;
    background-color: #043c6c;
"><div style="font-size:25px;font-weight:800;position: relative;bottom: 14px;" class="mt-6">Cancelled</div>
<div class="mt-1 p-5" style="font-size:25px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */position: relative;bottom: 15px;">{{$cancelled_count}}</div></div>
<div style=" display: inline-block;padding-right: 50px;padding-left: 30px;/* padding-top: 0px; */vertical-align: text-bottom;/* padding-top: 48px; *//* height: 100%; *//* background-color: #043c6c; */border-right: 3px solid black;position: relative;bottom: 10px;height: 80px;
"><div style="font-size: 24px;font-weight:800;">Dispatcher</div>
<div class="mt-1 p-5" style="font-size: 19px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */">{{$dispatcher_cancelled_count}}</div></div> 
<div style="
    display: inline-block;
    padding-right: 40px;
    padding-left: 30px;
    /* padding-top: 40px; */
    /* height: 100%; */
    /* background-color: #043c6c; */
    display: inline-block;
    padding-right: 50px;
    padding-left: 32px;
    /* padding-top: 0px; */
    vertical-align: text-bottom;
    /* padding-top: 48px; */
    /* height: 100%; */
    /* background-color: #043c6c; */
    /* border-right: 3px solid black; */
    position: relative;
    bottom: 10px;
    height: 80px;
    width: 150px;
    border-right: 3px solid black;
    "><div style="font-size: 24px;font-weight:800;text-align: center;">Driver</div>
<div class="mt-1 p-5" style="font-size: 19px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */">{{$driver_cancelled_count}}</div></div><div style="
    display: inline-block;
    padding-right: 40px;
    padding-left: 30px;
    /* padding-top: 40px; */*
    height: 100%; */
    /* background-color: #043c6c; */
    display: inline-block;
    padding-right: 50px;
    padding-left: 50px;
    /* padding-top: 0px; */
    vertical-align: text-bottom;
    /* padding-top: 48px; */
    /* height: 100%; */
    /* background-color: #043c6c; */
    /* border-right: 3px solid black; */
    position: relative;
    bottom: 10px;
    height: 80px;
    width: 145px;
"><div style="font-size: 24px;font-weight:800;text-align: center;">User</div>
<div class="mt-1 p-5" style="font-size: 19px;font-weight:800;color: black;/* height: 100%; */text-align: center;/* background: yellow; */">{{$user_cancelled_count}}</div></div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="g-col-12 g-col-lg-4 mt-10 p-10" style="position:relative">
<div class="active" style="
    font-size: 27px;
    font-weight: bold;
">Request List</div>
<div style="padding: 10px;background-color: #f5f5ff;background: 0px 0px 8px 1px rgba(0,0,0,0.3);border-radius: 3px;display: inline-block;position: absolute;right: 30px;top: 16px;">
<div class="d-flex">
        <div class="box" style="background:#EAF0FB;">
            <ul role="tablist" class="pos__tabs nav1 nav-pills rounded-2" style="width:650px">
                <li id="all-tab" onclick="get_request_list('all'),toggleActiveTab('all-tab')" class="nav-item flex-1 actv-tab actv" data-val="all" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5 active" data-val="all">All</button>
                </li>
                <li id="online-tab" onclick="get_request_list('completed'),toggleActiveTab('online-tab')"  class="nav-item flex-1" data-val="online" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5" data-val="completed" >Completed</button>
                </li>
                <li data-val="offline" id="offline-tab" onclick="get_request_list('cancelled'),toggleActiveTab('offline-tab')" class="nav-item flex-1">
                    <button class="nav-link w-full1 pt-2 pb-2.5" data-val="cancelled">Cancelled</button>
                </li>
                
            </ul>
        </div>
        
        <!-- <a href="" data-toggle="modal" data-target="#basicModal" class="btn ms-auto d-flex align-items-center text-theme-1 p-2" style="background:white;border-radius:10px;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);"><i data-feather="sliders" style="rotate:90deg;"></i></a> -->
    </div></div>
     
          <!-- <a href="" data-toggle="modal" data-target="#basicModal" class="btn ms-auto d-flex align-items-center text-theme-1 p-2" style="background:white;border-radius:10px;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);"><i data-feather="sliders" style="rotate:90deg;"></i></a> -->
 

      </div><input type="hidden" id="page_count" value="">
      <div id="request_list" style="padding:20px">
      </div>
</div>
 
<script>

function get_request_list(type,page=1){
    console.log(type,page);
    var url = '{{url("/")}}/dispatch/request_fetch?type='+type;
    if (page > 1) {
      url += '&page=' + page;
    }
    $.get(url, function(data) {
        $('#request_list').html(data);
    });
    }
  $(document).ready(function(){
    $("li.d-flex").removeClass("active");
    $('li.request').addClass('active');
  });
  $('body').on('click', '.pagination a', function(e){
    e.preventDefault();

    var type = $('.nav-link.active').attr('data-val');
    var href = $(this).attr('href');
    var page = href.split('page=')[1];
    // alert(type);
    get_request_list(type,page);
  })
  function toggleActiveTab(tabId) {
  // Remove "active" class from all tabs
  var tabs = document.querySelectorAll('.nav-link');
  $(".nav-link").removeClass("active");

  // Add "active" class to the clicked tab
  var clickedTab = document.getElementById(tabId);
  clickedTab.querySelector('.nav-link').classList.add('active');

  // Call the fetchDataFromFirebase function with the respective parameter
  var tabValue = clickedTab.getAttribute('data-val');
  // fetchDataFromFirebase(tabValue, clickedTab);
}
  get_request_list('all');
</script>
@endsection
@push('scripts-js')
<script src="{{asset('assets/js/fetchdata.min.js')}}"></script>
<script>
  $(document).ready(function() {
      $('.accordion-btn').click(function() {
		$(this).find('.accordion-icon').toggleClass('rotate');
        var target = $($(this).data('accordion-target'));
        $('.collapse').removeClass('show'); // Remove 'show' class from all accordions
        $(target).collapse('toggle'); // Toggle 'show' class for the clicked accordion
      });
  
    });
</script>
<!-- <script>
  function _class(name){
  return document.getElementsByClassName(name);
}

let tabPanes = _class("tab-header")[0].getElementsByTagName("div");

for(let i=0;i<tabPanes.length;i++){
  tabPanes[i].addEventListener("click",function(){
    _class("tab-header")[0].getElementsByClassName("active")[0].classList.remove("active");
    tabPanes[i].classList.add("active");
    
    _class("tab-indicator")[0].style.top = `calc(80px + ${i*50}px)`;
    
    _class("tab-content")[0].getElementsByClassName("active")[0].classList.remove("active");
    _class("tab-content")[0].getElementsByTagName("div")[i].classList.add("active");
    
  });
}
</script> -->
<script>
  document.getElementById("vehicleSelect").addEventListener("change", function() {
  // Check if any option is selected
  var selectedOptions = this.selectedOptions;
  
  if (selectedOptions.length > 0) {
    // Check the checkbox if at least one option is selected
    document.getElementById("vehicleCheckbox").checked = true;
  } else {
    // Uncheck the checkbox if no option is selected
    document.getElementById("vehicleCheckbox").checked = false;
  }
});

</script>
@endpush
        <!-- END: Form Layout -->


