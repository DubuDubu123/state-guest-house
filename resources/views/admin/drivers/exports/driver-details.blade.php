<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
      .container {
  margin: 2%;
  /* border: 2px dashed #333; */
  border-radius: 4%;
  padding: 2%;
}
.header {
  background-color: #464646;
  padding:1px;
  border-radius: 3px;
}
.header h2 {
  color:white;
  text-align: center;
  text-shadow: 1px 3px 8px #0b1544;
}
table {
  width: 100%;
}
table tr td {
  text-align: start;
  padding:8px 10px:
}
 .first {
  background:#ebecee;
}
.dubu{
  display:flex;
  position: absolute;
  top:75px;
}
.width{
  padding:12px;
  background:#ebecee;
}

    </style>
</head>
<body>

@php
 $driver;
 
    $imagePath = public_path('assets/img/dd.png'); // Default image path
    if ($profile_picture) {
        $imagePath = $profile_picture;
    }


 @endphp
<!-- driver details -->
<div style="margin-top:80px; ">
<div class="container" style="display:flex;align-items:center;justify-content:cenetr;">
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/dd.png'))) }}" width="60px" alt="logo" />
<h2 class="dubu">Dubu Dubu India Pvt Ltd.</h2>
</div>
<div class="container" style="margin-top:-30px;">
  <div class="header">
    <h2>Driver Details</h2>
  </div>
  <div class="content">
    <table border="none">
      <!-- <tr>
        <th>Driver's Name</th>
        <th>Registered Phone Number</th>
        <th>Service Location</th>
        <th>Aadhaar Number</th>
        <th>Driving Licence Number</th>
      </tr> -->
      <tr>
        <td class="first">Driver's Name </td>
        <td colspan="2">{{$driver->name}}</td>
         <td rowspan="5" colspan="3" >
          <img style="position:relative;left:30px;" src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" width="100px" class="img-fluid" alt="profile" />
        </td>

      </tr>

      <tr>
        <td class="first">Registered Phone Number </td>
        <td colspan="2">{{$driver->mobile}}</td>
      </tr>

      <tr>
        <td class="first">Service Location</td>
        <td colspan="2">{{$driver->serviceLocation->name}}</td>
     </tr>

      <tr>
        <td class="first">Aadhaar Number</td>
        <td colspan="2">{{$driver->aadhar_number}}</td>  
      </tr>

      <tr>
        <td class="first">Driving Licence Number</td>
        <td colspan="2">{{$driver->driving_license_number}}</td>
      </tr>

    </table>
  </div>

</div>


<!-- vehicle details -->
<div class="container">
  <div class="header">
    <h2>Vehicle Details</h2>
  </div>
  <div class="content" >
    <table border="none" >

      <tr >
        <td class="width" class="first">Vehicle Type </td>
        <td colspan="2">{{$driver->vehicleType->name}}</td>
      </tr>

      <tr >
        <td class="width" class="first">Vehicle Registration Number </td>
        <td colspan="2">{{$driver->car_number}}</td>
      </tr>

      <tr >
        <td class="width" class="first">Vehicle Make</td>
        <td colspan="2">{{$driver->car_make}}</td>
     </tr>

      <tr >
        <td class="width" class="first">Vehicle Color</td>
        <td colspan="2">{{$driver->car_color}}</td>  
      </tr>

      <tr >
        <td class="width" class="first">Year Of Manufacture</td>
        <td colspan="2">{{$driver->vehicle_year}}</td>
      </tr>

      <tr >
        <td class="width" class="first">Vehicle Insurance Number</td>
        <td colspan="2">{{$driver->vehicle_insurence_number}}</td>
      </tr>

      <tr >
        <td class="width" class="first">Registration Certificate No.</td>
        <td colspan="2">{{$driver->rc_number}}</td>
      </tr>

    </table>
  </div>

</div>
</div>
<!-- modal end -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

