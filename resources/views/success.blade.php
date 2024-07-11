	<!-- <style type="text/css">
		.container{
			display: inline-block;
			position: relative;
			top: 300px;
			left: 600px;
			align-content: center;
			align-items: center;
		}
		h3{
			text-align: center;
		}
	</style>


	<div class="container">
		<div class="row" style="align-items: center;align-content: center;">
			<div class="col-md-12">
				<img src="{{asset('assets/img/tick.png')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
				<h3 class="text-center text-success">Success</h3>
			</div>
		</div>
	</div> -->
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 150px auto;
        width:700px;
        height:850px;
      }
      .card1{
        display: grid;
        position: absolute;
        left:25%;
        top:30%;
      }
    </style>
    <body>
      <div class="card">
      <div style="margin:0 0 30px 0;display:grid;place-items:center;">
        <!-- <i class="checkmark">✓</i> -->
        <img src="{{asset('assets/img/dd.png')}}" width="200px" class="img-fluid" alt="">
      </div>
      <div class="card1" style="margin-top:150px;border:1px solid #646464;border-radius:20px; height:300px; width:500px;padding:0px; background: white; margin:0 0 30px 0;display:grid;place-items:center;-webkit-box-shadow: 10px 10px 9px -7px rgba(0,0,0,0.45);
-moz-box-shadow: 10px 10px 9px -7px rgba(0,0,0,0.45);
box-shadow: 10px 10px 9px -7px rgba(0,0,0,0.45);">
      <img src="{{asset('assets/img/check.png')}}" width="100px" style="margin-top:20px;" class="img-fluid" alt="">
        <h5 style="margin-bottom:100px;font-size:40px">Payment Successful</h5> 
        <!-- <p>We received your purchase request;<br/> we'll be in touch shortly!</p> -->
        <!-- <button style="padding:6px 40px;background:#454545;color:#ffe001;font-size:16px;border-radius:10px">close</button> -->
    </div>
      </div>
    </body>
</html>

