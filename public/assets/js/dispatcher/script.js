var html_data = "";
var map;
var markerPositions = [];
var markerarray = [];
markerarray["all"] = []; 
markerarray["online"] = []; 
markerarray["offline"] = []; 
markerarray["onride"] = []; 
var driver_ids = [];
driver_ids["all"] = []; 
driver_ids["online"] = []; 
driver_ids["offline"] = []; 
driver_ids["onride"] = []; 
var markerMap = {};
var marker; 
var type; 
var database; 
var shouldProcessChildAdded = false;
var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");
  if(window.location.hostname == "localhost")
  {
      baseUrl+="/dubu-dubu/public";
  }  

    function removeMarkers() {  
      for (var i = 0; i < markerPositions.length; i++) { 
        markerPositions[i].setMap(null); // Remove the marker from the map
      }
      markerPositions = [];
      markerMap = {};
    }
    function get_html_data(text,driverData){
      var last_seen = '';
      var last_seen_time = new Date() - new Date(driverData.updated_at);
      var seenInMinutes = parseInt(last_seen_time / 60000),
          seenInHours = 0,
          seenInDays = 0,
          seenInWeeks = 0;
      if(seenInMinutes > 59){
        seenInHours = parseInt(seenInMinutes / 60);
        if(seenInHours > 23){
          seenInDays = parseInt(seenInHours / 24);
          if(seenInDays > 6){
            seenInWeeks = parseInt(seenInDays / 7);
          }
        }
      }
      if(seenInMinutes <= 1){
        last_seen = 'just now';
      }
      if(seenInMinutes > 1 && seenInMinutes < 59){
        last_seen = seenInMinutes + ' minutes ago';
      }
      if(seenInHours == 1){last_seen = 'An hour ago'}
      if(seenInHours > 1){
        last_seen = seenInHours + ' hours ago';
      }
      if(seenInDays == 1){last_seen = 'A day ago'}
      if(seenInDays > 1){
        last_seen = seenInDays +' days ago';
      }
      if(seenInWeeks == 1){last_seen = 'A week ago'}
      if(seenInWeeks > 1){
        last_seen = seenInWeeks + ' weeks ago';
      }
      html_data+= `<div class="box p-5 intro-y mt-5 all-tabss" id="${driverData.id}" style="background:#F3F4F4;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);cursor:pointer" data-lat="${driverData.l[0]}" data-lng="${driverData.l[1]}">
                      <div class="d-flex flex-column flex-lg-row pb-5 mx-n5">
                          <div class="d-flex px-5 align-items-start justify-content-center justify-content-lg-start">
                              <div class="d-flex ms-5">
                                  <div class="px-4 ct1">${driverData.name}</div>
                              </div>
                          </div>
                          <div class="mt-6 mt-lg-0 flex-1 px-5 border-start border-end border-gray-200 border-top border-top-lg-0 pt-5 pt-lg-0">
                              <div class="fw-medium text-center text-lg-start ct2">${driverData.rating} <i class="fa fa-star" style="color:yellow;"></i></div>
                          </div>`;
                          if(!driverData.is_available )
                          {
                            html_data+= ` <div class="mt-6 mt-lg-0 flex-1 px-5">
                            <div class="bg-theme-14 text-theme-10 rounded px-5 mt-1.5 w-40 ct3">${text}</div>
                          </div>`;
                          }
                          else{

                              if(driverData.is_active)
                              {
                                
                                html_data+= ` <div class="mt-6 mt-lg-0 flex-1 px-5">
                            <div class="bg-theme-14 text-theme-10 rounded px-5 mt-1.5 w-40 ct3">${text}</div>
                          </div>`;
                              }
                              else{
                                html_data+= ` <div class="mt-6 mt-lg-0 flex-1 px-5">
                                <div class="bg-theme-17 text-theme-6 rounded px-5 mt-1.5 w-40 ct3">${text}</div>
                              </div>`;
                              }
                          }
                         
                          
                          html_data+= `</div>
                      <div class="box p-5 intro-y">
                          <div class="position-relative d-flex align-items-center">
                              <div class="w-24 h-24 flex-none image-fit">
                                  <img alt="" class="rounded-circle" src="${driverData.profile_picture}">
                              </div>
                              <div class="ms-4 me-auto">
                                  <div class="fw-medium cm1">${driverData.vehicle_name}</div>  
                              </div>
                              <div class="fw-medium cm1">${driverData.mobile}</div>
                              <div><a href="javascript:;" data-trigger="click" class="tooltip" title="${driverData.mobile}"><img src="${baseUrl}/assets/img/call.png" class="img-fit w-24 img-fluid" alt=""></a></div>
                          </div>
                      </div>`;
                      if(driverData.is_active == 0){
                        html_data += `<div style="font-size: 14px; padding: 5px; text-align: right; color: rebeccapurple;">${last_seen}</div>`;
                      }
                      html_data += `</div>`;
                  return html_data;
    }

    function setmap(type,driverData,lastkey=false)
    {  
      if(driverData.hasOwnProperty('is_available'))
      {   
          var eligible_status = 0;
          if(type == "all")
          {
            eligible_status = 1;
          if(driverData.is_active == 1 && driverData.is_available === true)
          {
            var text = "Online";
          }
          if(driverData.is_available === false)
          { 
            var text = "Onride";
          }
          if(driverData.is_active == 0)
          {
            var text = "Offline";
          }
          }
          if(type == "online")
          {
          if(driverData.is_active == 1 && driverData.is_available === true)
          {
            eligible_status = 1;
            var text = "Online";
          }
          }
          if(type == "offline")
          {
            if(driverData.is_active == 0)
            {
              eligible_status = 1;
              var text = "Offline";
            }
          }
          if(type == "onride")
          {
            if(driverData.is_available === false)
            {
              eligible_status = 1;
              var text = "Onride";
            }
          }  
          if(eligible_status == 1)
          {
                // alert("eligible_status");
              var latitude = driverData.l[0];
              var longitude = driverData.l[1];
              // Create marker position
              var markerPosition = { lat: latitude, lng: longitude ,driver_id:driverData.id}; 
            
              driver_ids[type].push(driverData.id);
            // markerarray[type].push(markerPosition); 
            // markerarray.push(markerPosition);   
                  
              driver_ids[type] = [...new Set(driver_ids[type])];  
              (markerarray[type] || (markerarray[type] = [])).push(markerPosition);

              // Convert the array of marker positions to a Set to remove duplicates based on driver ID
              const uniqueMarkerPositions = Array.from(new Set(markerarray[type].map(pos => pos.driver_id)))
              .map(driver_id => markerarray[type].find(pos => pos.driver_id === driver_id));

              // Update markerarray[type] with the unique marker positions
              markerarray[type] = uniqueMarkerPositions; 
          
              // Calculate the center of all marker positions
              var centerLat = 0;
              var centerLng = 0;

              markerarray[type].forEach(function(markerPosition) {
                  centerLat += markerPosition.lat;
                  centerLng += markerPosition.lng;
              });

              centerLat /= markerarray[type].length;
              centerLng /= markerarray[type].length; 
              // Set the map center to the calculated center
              map.setCenter({ lat: centerLat, lng: centerLng }); 
              map.setZoom(5); 
              var html_datas = get_html_data(text,driverData);
              $(".driver-side-menu").append(html_datas);
            
        
          }  
          if(lastkey)
          {  
            markerarray[type].forEach(function(markerPosition) {
              addMarker(markerPosition.lat,markerPosition.lng,markerPosition.driver_id);
            });
          }
      } 
    }
    function deleteSingleMarker(id)
    { 
      var markerToRemove = markerMap[id];
      if (markerToRemove) { 
          markerToRemove.setMap(null); 
          delete markerMap[id];
      }
    }
    function addMarker(latitude, longitude,id) {
                marker = new google.maps.Marker({
                  position: { lat: latitude, lng: longitude },
                  map: map, // Assuming 'map' is your initialized map object
                  title: "Marker" // You can set a title if needed
              });

              // Push the marker to the array
              markerPositions.push(marker);
              markerMap[id] = marker;  
    }
    function fetchDataFromFirebase(type = undefined,element=undefined) { 
       database = firebase.database();
       $("li.nav-item").removeClass("actv");
      if(element === undefined || type=="all")
      { 
        $("#all-tab").addClass("actv");
      }
      else{ 
        if (element instanceof jQuery) {
          element.addClass("actv");
        } else { 
          element.classList.add("actv");
        }
      } 
$(".driver-side-menu").html('');


var driverRef = database.ref('drivers').orderByKey().startAt("driver_"); 
if(type == "online")
{
var driverRef = database.ref('drivers').orderByChild("is_active").equalTo(1); 
}
if(type == "offline")
{
var driverRef = database.ref('drivers').orderByChild("is_active").equalTo(0);  
}
if(type == "onride")
{
var driverRef = database.ref('drivers').orderByChild("is_available").equalTo(false); 
}


var driverIdPattern = "driver_"; // The pattern to match  
removeMarkers();  
markerarray = [];
driverRef.once("value", function(snapshot) {


var totalChildren = snapshot.numChildren();
if(totalChildren == 0)
{
    var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");
    if(window.location.hostname == "localhost")
    {
        baseUrl+="/dubu-dubu/public";
    }   
  html_data = "";
 html_data+= `<div class="box p-5 intro-y mt-5" style="height:400px;width:400px"><img src="${baseUrl}/images/no-drivers.png" style="height:100%;width:100%"></div>`;
 
 $(".driver-side-menu").append(html_data);
}else{
var processedChildren = 0;

    snapshot.forEach(function(childSnapshot) {
      html_data = "";
      processedChildren++;
      var lastkey;
      // Check if this is the last child
      var driverData = childSnapshot.val(); 
        var driverKey = childSnapshot.key; 
       
      if(driverKey.startsWith("driver_"))
      { 
        if (processedChildren === totalChildren) 
        { 

          if(driverData.hasOwnProperty('is_available'))
          {
            setmap(type,driverData,true); 
          }
          else{ 
              markerarray[type].forEach(function(markerPosition) {
                addMarker(markerPosition.lat,markerPosition.lng,markerPosition.driver_id);
              });
             
          }
              
        }
        else{
              setmap(type,driverData,false); 
        }
      }
      else{
        if (processedChildren === totalChildren) {
          if(markerarray.length > 0){
            markerarray[type].forEach(function(markerPosition) {
              addMarker(markerPosition.lat,markerPosition.lng,markerPosition.driver_id);
            });
          }else{
            var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");
            if(window.location.hostname == "localhost")
            {
                baseUrl+="/dubu-dubu/public";
            }
            html_data = `<div class="box p-5 intro-y mt-5" style="height:400px;width:400px"><img src="${baseUrl}/images/no-drivers.png" style="height:100%;width:100%"></div>`;
            $(".driver-side-menu").append(html_data);
          }
        } 
      } 
    });
  }
});
} 
document.querySelector(".hamburger").addEventListener("click", function () { 
      document.querySelector("nav").classList.toggle("toggle-menu") 
  });

  document.querySelector(".close").addEventListener("click", function () { 
      document.querySelector("nav").classList.toggle("toggle-menu") 
  });
  // window.onload = fetchDataFromFirebase;

  $(document).ready(function() {
    setTimeout(function() {
      shouldProcessChildAdded = true;
      shouldProcessSosChildAdded = true;
      }, 3000);
            // setInterval(function(){ 
              
            // var data_val = $("li.nav-item.actv").attr("data-val");
            // // alert(data_val);
            // fetchDataFromFirebase(data_val,$("li.nav-item.actv")); 
            // }, 60000); 
            fetchDataFromFirebase('all');
            const dbRef = firebase.database().ref();
            dbRef.child("drivers").on("child_changed", (snapshot) => {
              if (snapshot.exists()) {
               
                driverData = "";
                 driverData = snapshot.val();
                 const driverId = snapshot.key;
                 if (driverId.startsWith("driver_")) { 
                 var data_val = $("li.nav-item.actv").attr("data-val");
                 
                 if(data_val == "online")
                 { 
                  var append_status = 0;
                 
                  if(driverData.is_active == 1 && driverData.is_available == true)
                  {
                    var text = "Online";  
                   
                    if (!driver_ids[data_val].includes(driverData.id)) {
                       if(driver_ids[data_val].length == 0)  
                       {
                        $(".driver-side-menu").html('');
                       } 
                        append_status = 1;
                        driver_ids[data_val].push(driverData.id); 
                        var latitude = driverData.l[0];
                        var longitude = driverData.l[1];
                        addMarker(latitude,longitude,driverData.id);
                    }
                  }
                  else{  
                    if(driver_ids[data_val].length == 1)  
                    {
                      html_data = "";
 html_data+= `<div class="box p-5 intro-y mt-5" style="height:400px;width:400px"><img src="${baseUrl}/images/no-drivers.png" style="height:100%;width:100%"></div>`;
 
 $(".driver-side-menu").append(html_data);
                    } 
                     $("#"+driverData.id).remove(); 
                     deleteSingleMarker(driverData.id);
                     const index = driver_ids[data_val].indexOf(driverData.id); 
                      if (index !== -1) {
                        driver_ids[data_val].splice(index, 1);
                      } 
                  }
                 }
                 if(data_val == "offline")
                 {
                   
                  var append_status = 0;
                  if(driverData.is_active == 0 && driverData.is_available == true)
                  {
                    if(driver_ids[data_val].length == 0)  
                    {
                     $(".driver-side-menu").html('');
                    } 
                    var text = "Offline"; 
                    if (!driver_ids[data_val].includes(driverData.id)) {
                     append_status = 1;
                     driver_ids[data_val].push(driverData.id);
                     addMarker(driverData.l[0],driverData.l[1],driverData.id);
                    }
                  }
                  else{
                    if(driver_ids[data_val].length == 1)  
                    {
                      html_data = "";
                      html_data+= `<div class="box p-5 intro-y mt-5" style="height:400px;width:400px"><img src="${baseUrl}/images/no-drivers.png" style="height:100%;width:100%"></div>`;
                      
                      $(".driver-side-menu").append(html_data);
                    } 
                    deleteSingleMarker(driverData.id);
                    $("#"+driverData.id).remove();
                  }
                 }
                 if(data_val == "onride")
                 {
                  var append_status = 0;
                  if(driverData.is_available == true)
                  {
                    if(driver_ids[data_val].length == 1)  
                    {
                      html_data = "";
                      html_data+= `<div class="box p-5 intro-y mt-5" style="height:400px;width:400px"><img src="${baseUrl}/images/no-drivers.png" style="height:100%;width:100%"></div>`;
                      
                      $(".driver-side-menu").append(html_data);
                    } 
                    deleteSingleMarker(driverData.id);
                    $("#"+driverData.id).remove();
                  } 
                  else{
                    if(driver_ids[data_val].length == 0)  
                    {
                     $(".driver-side-menu").html('');
                    } 
                    var text = "Onride";
                    if (!driver_ids[data_val].includes(driverData.id)) {
                        append_status = 1;
                        driver_ids[data_val].push(driverData.id);
                        addMarker(driverData.l[0],driverData.l[1],driverData.id);
                    }
                  }
                 } 
                 if(append_status == 1)
                 { 
                  console.log("sdfdsf");
                  html_data = "";
                  var html_datas = get_html_data(text,driverData);
                  $(".driver-side-menu").prepend(html_datas);
                 }
                }
                
              } else {
                console.log("No data available");
              }
            });
            dbRef.child("drivers").on("child_added", (childSnapshot) => {
              if (shouldProcessChildAdded)
              {
              const driverId = childSnapshot.key;
              const driverData = childSnapshot.val(); 
                 if (driverId.startsWith("driver_")) { 
                  
                 var data_val = $("li.nav-item.actv").attr("data-val"); 
                 if(data_val == "all")
                 { 
                  var append_status = 0;  
                   
                    if (!driver_ids[data_val].includes(driverData.id)) {
                     append_status = 1;
                     driver_ids[data_val].push(driverData.id);
                     var text = "Online"; 
                    } 
                 }
                 if(data_val == "online")
                 { 
                  var append_status = 0;
                  console.log(driver_ids[data_val].length);
                    console.log("online length");
                  if(driverData.is_active == 1 && driverData.is_available == true)
                  {
                    var text = "Online";  
                    if (!driver_ids[data_val].includes(driverData.id)) {
                     append_status = 1;
                     driver_ids[data_val].push(driverData.id);
                   
                    }
                  }
                  else{ 
                    console.log(driver_ids[data_val].length);
                     $("#"+driverData.id).remove(); 
                     const index = driver_ids[data_val].indexOf(driverData.id); 
                      if (index !== -1) {
                        driver_ids[data_val].splice(index, 1);
                      } 
                  }
                }
                
                
                 if(append_status == 1)
                 { 
                  console.log("driver_ids[data_val].length");
                  html_data = "";
                  var html_datas = get_html_data(text,driverData);
                  $(".driver-side-menu").prepend(html_datas);
                 }
                } 
                } 
              }, (error) => {
              console.error("Error listening for new drivers:", error);
              }); 
            
            $(document).on("click", ".all-tabss", function(event) { 
              if(event.type == "click")
              {
                removeMarkers();
                var lat = parseFloat($(this).attr("data-lat"));
                var lng = parseFloat($(this).attr("data-lng"));
                var id = parseFloat($(this).attr("id"));  
                setTimeout(function() {
                  addMarker(lat,lng,id); 
                }, 100); 
                var zoomLevel = 12; // Adjust as needed 
                var animationDuration = 1000; // Adjust the duration of the animation in milliseconds

                // Pan to the specified location with animation
                map.panTo({ lat: lat, lng: lng });

                // Start the zoom animation
                var startZoom = map.getZoom();
                var zoomDifference = zoomLevel - startZoom;
                var increment = zoomDifference > 0 ? 1 : -1;
                var stepDuration = animationDuration / Math.abs(zoomDifference);
                
                function zoomStep() {
                    if ((increment > 0 && map.getZoom() < zoomLevel) || (increment < 0 && map.getZoom() > zoomLevel)) {
                        map.setZoom(map.getZoom() + increment);
                        setTimeout(zoomStep, stepDuration);
                    }
                } 
                zoomStep();
              } 
        }); 
        $(document).on("mouseenter mouseleave", ".all-tabss", function(event) {  
          if(event.type == "mouseenter")
          {
            removeMarkers();
            var lat = parseFloat($(this).attr("data-lat"));
            var lng = parseFloat($(this).attr("data-lng"));
            var id = parseFloat($(this).attr("id"));  
            setTimeout(function() {
              addMarker(lat,lng,id); 
            }, 100); 
            var zoomLevel = 12; // Adjust as needed 
            var animationDuration = 1000; // Adjust the duration of the animation in milliseconds

            // Pan to the specified location with animation
            map.panTo({ lat: lat, lng: lng });

            // Start the zoom animation
            var startZoom = map.getZoom();
            var zoomDifference = zoomLevel - startZoom;
            var increment = zoomDifference > 0 ? 1 : -1;
            var stepDuration = animationDuration / Math.abs(zoomDifference);
            
            function zoomStep() {
                if ((increment > 0 && map.getZoom() < zoomLevel) || (increment < 0 && map.getZoom() > zoomLevel)) {
                    map.setZoom(map.getZoom() + increment);
                    setTimeout(zoomStep, stepDuration);
                }
            } 
            zoomStep();
          } 
    }); 

}); 

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
  // fetchDataFromFirebase(tabValue, clickedTab);
}