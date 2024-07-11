@extends('dispatch-new.layout') @section('dispatch-content') 
<link rel="stylesheet" href="{{ asset('assets/css/dispatcher/style.css') }}" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
.show {
    display: block;
    z-index: 0;
}

.modal-backdrop.show {
    opacity: 0;
}
.modal-backdrop.fade {
    opacity: 0;
}
.show {
    display: block;
    z-index: 0;
}
.show {
    display: block;
    z-index: 60;
}
.modal-backdrop {
    background-color: #000;
    height: 100vh;
    left: 0;
    position: fixed;
    top: 0;
    width: 100vw;
    z-index: 0;
}
.fs{
  font-size:16px;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.form-check-input[type=checkbox] {
    border-radius: 0.25em;
    border: 1px solid #b4b1b1;
}
</style>
<div class="g-col-12 g-col-lg-4 mt-10 p-10">
  
    <div class="tab-content mt-5">
        <!-- all drivers tab -->
        <div class="tab-pane fade active show" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="grid columns-12 gap-5 mt-5 no-data-fouds">
                <!-- BEGIN: Driver Side Menu -->
                <div class="g-col-12 g-col-xl-4 g-col-xxl-4 all-driver-side-menu overflow-y-auto p-5" style="height:600px;">
                <div style="padding: 10px; background-color: #f5f5ff; background: 0px 0px 8px 1px rgba(0,0,0,0.3); border-radius: 3px;">
<div class="d-flex">
        <div class="box" style="background:#EAF0FB;">
            <ul role="tablist" class="pos__tabs nav1 nav-pills rounded-2">
                <li id="all-tab" onclick="fetchDataFromFirebase('all',this),toggleActiveTab('all-tab')" class="nav-item flex-1 actv-tab actv" data-val="all" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5 active">All</button>
                </li>
                <li id="online-tab" onclick="fetchDataFromFirebase('online',this),toggleActiveTab('online-tab')" class="nav-item flex-1" data-val="online" role="presentation">
                    <button class="nav-link w-full1 pt-2 pb-2.5">Online</button>
                </li>
                <li data-val="offline" id="offline-tab" onclick="fetchDataFromFirebase('offline',this),toggleActiveTab('offline-tab')" class="nav-item flex-1">
                    <button class="nav-link pt-2 pb-2.5">Offline</button>
                </li>
                <li data-val="onride" id="onride-tab" onclick="fetchDataFromFirebase('onride',this),toggleActiveTab('onride-tab')" class="nav-item flex-1">
                    <button class="nav-link pt-2 pb-2.5">On-Ride</button>
                </li>
            </ul>
        </div>
        <!-- <div class="d-flex align-items-center " style="font-size:22px;margin-left: 10px;/* background-color: grey; */"><button class="w-full1" onclick="all_drivers()" style="
    background-color: grey;
    color: white;
    border-radius: 5px !important;
">All Drivers</button></div> -->
        <!-- <a href="" data-toggle="modal" data-target="#basicModal" class="btn ms-auto d-flex align-items-center text-theme-1 p-2" style="background:white;border-radius:10px;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);"><i data-feather="sliders" style="rotate:90deg;"></i></a> -->
    </div></div>
                    <div class="driver-side-menu">
                    </div>
                    <div class="driver-side-menu1">
                    </div>
                </div>
                <!-- END: Home Side card Menu -->
                <!-- BEGIN: Map Content -->
                <div class="g-col-12 g-col-xl-8 g-col-xxl-8">
                    <div class="box p-5">
                        <div id="map" style=" height: 600px;width: 100%;"></div>
                    </div>
                </div>
                <!-- END: Map Content -->
            </div>
        </div> 
    </div>
</div>

<!-- filter modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title fs" id="myModalLabel">Filter</h4>
        <div type="button" class="btn btn-default tb" data-dismiss="modal"><i data-feather="x"></i></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="season_tabs">
            
            <div class="season_tab">
              <div class="d-flex align-items-center">
                <div>
                <input type="radio" id="tab-1" name="tab-group-1" checked>
                <label for="tab-1">Vehicle Type</label>
                </div>
                <div>
                <input id="vehicleCheckbox"  class="form-check-input" type="checkbox" value="" disabled style="font-size:14px;">
                </div>
              </div>
                
                <div class="season_content">
                    <div>
                      <select id="vehicleSelect" data-placeholder="Select" class="tom-select w-full" multiple >
                          <option value="1" style="dont-size:14px;">Sedan</option>
                          <option value="2">SUV</option>
                          <option value="3">Mini</option>
                          <option value="4">Bike</option>
                      </select>
                          
                      
                    </div>
                </div> 
            </div>
            
            <div class="season_tab d-flex align-items-center">
                <input type="radio" id="tab-2" name="tab-group-1">
                <label for="tab-2">Mobile Number</label>
                <div style="margin-bottom:15px;">
                <input id="searchCheckbox" class="form-check-input" type="checkbox" value="" disabled  style="font-size:14px;">
                </div>
                
                <div class="season_content">
                    <div>
                    <input id="search" type="number" class="form-control" placeholder="Search">
                    </div>
                </div> 
            </div>
            
            <div class="season_tab d-flex align-items-center">
                <input type="radio" id="tab-3" name="tab-group-1">
                <label for="tab-3">Location</label>
                <div style="margin-bottom:15px;">
                <input id="locationCheckbox" class="form-check-input" type="checkbox" disabled value="" style="font-size:14px;">
                </div>
              
                <div class="season_content">
                    <div>
                    <select id="locationSelect" class="form-select mt-2 me-sm-2" aria-label="">
                        <option>India</option>
                        <option>Nepal</option>
                        <option>Pakistan</option>
                    </select>
                    </div>
                </div> 
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button id="resetButton" type="button" class="btn btn-default fs" >reset</button>
        <button type="button" class="btn btn-primary fs">Filter</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.querySelector(".hamburger").addEventListener("click", function () { 
            document.querySelector("nav").classList.toggle("toggle-menu") 
        });

        document.querySelector(".close").addEventListener("click", function () { 
            document.querySelector("nav").classList.toggle("toggle-menu") 
        });
</script>
<script>
  $(document).ready(
  function(){
    $("li.d-flex").removeClass("active");
    $('li.driver-list').addClass('active');
  }
)
  </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/dispatcher/script.js') }}"></script>
<script>
   function initMap() { 
   map = new google.maps.Map(document.getElementById("map"), {
      zoom: 5,
      center: { lat: 27.7172, lng: 85.3240 },
      mapTypeId: 'roadmap'
       
  }); 
}
</script> 
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDQGdKdsj9esPLI8DPDp5DO055ud53OgYI&callback=initMap" async defer></script> 
<script>
    // vehicle select
  document.getElementById("vehicleSelect").addEventListener("change", function() {
  // Check if any option is selected
  var selectedOptions = this.selectedOptions;
  
  if (selectedOptions.length > 0) {
    // Check the checkbox if at least one option is selected
    document.getElementById("vehicleCheckbox").checked = true;
    document.getElementById("vehicleCheckbox").disabled = false;
  } else {
    // Uncheck the checkbox if no option is selected
    document.getElementById("vehicleCheckbox").checked = false;
    document.getElementById("vehicleCheckbox").disabled = true;

  }
});
function all_drivers(){
  var element = $('.nav-link.active').closest('.nav-item');
  var type = element.attr('data-val');
  fetchDataFromFirebase(type,element);
}
// location select
document.getElementById("locationSelect").addEventListener("change", function() {
  // Check if any option is selected
  var selectedOptions = this.selectedOptions;
  
  if (selectedOptions.length > 0) {
    // Check the checkbox if at least one option is selected
    document.getElementById("locationCheckbox").checked = true;
    document.getElementById("locationCheckbox").disabled = false;
  } else {
    // Uncheck the checkbox if no option is selected
    document.getElementById("locationCheckbox").checked = false;
    document.getElementById("vehicleCheckbox").disabled = true;
  }
});
// number search
document.getElementById('search').addEventListener('keyup', function(event) {
    // Check if the Enter key was pressed
    if (event.key === 'Enter') {
        // Get the input value
        var inputValue = this.value.trim();

        // Check if the input is not empty
        if (inputValue) {
            // Check the checkbox
            document.getElementById('searchCheckbox').checked = true;
            document.getElementById('searchCheckbox').disabled = false;
        } else {
            // Uncheck the checkbox if the input is empty
            document.getElementById('searchCheckbox').checked = false;
            document.getElementById('searchCheckbox').disabled = true;

        }
    }
});

// reset
document.getElementById("resetButton").addEventListener("click", function() {
    // Uncheck all checkboxes within the modal
    var checkboxes = document.querySelectorAll('#basicModal .form-check-input');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
        checkbox.disabled = true;
    });

    // Additionally, if you want to clear the selections of the multi-select dropdown
    var multiSelect = document.getElementById("vehicleSelect");
    if (multiSelect) {
        // This will work for a standard <select> element. 
        // If you're using a plugin like Select2 or Tom Select, you may need to use the plugin's API to clear the selection.
        multiSelect.selectedIndex = -1; // Deselect all options
    }
});
</script>
@endsection @push('scripts-js') @endpush
<!-- END: Form Layout -->