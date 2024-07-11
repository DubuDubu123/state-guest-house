@extends('admin.layouts.app')

<style>
    :root{
  --primary-color:#043c6c;
  --accent-color:#043c6c;
  --danger-color:#EC3582;
  --fore-color:rgba(0,0,0,0.65);
  --main-cast-shadow: 0px 3px 12px rgba(0, 0, 0, 0.08), 0px 3px 6px rgba(0, 0, 0, 0.12);
}
*{
  box-sizing:border-box;
}
body, html{
  margin:0;
  color: var(--fore-color);
}
body{
  font-family: "Roboto";
  font-size:14px;
  background-color: var(--accent-color);
}
button,a{
  cursor: pointer;
}
.sc-box{
  position:relative;
  width:1200px;
  margin:36px auto;
  
  background-color: #F6F8FA;
  border-radius:35px;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.08), 
    0px 6px 16px rgba(0,0,0,0.12);
  
  overflow:hidden;
}
@media (min-width: 768px) and (max-width: 1024px) {
  
  .sc-box{
  position:relative;
  width:700px;
  margin:36px auto;
  
  background-color: #F6F8FA;
  border-radius:35px;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.08), 
    0px 6px 16px rgba(0,0,0,0.12);
  
  overflow:hidden;
}
  
}
@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
  
  .sc-box{
  position:relative;
  width:700px;
  margin:36px auto;
  
  background-color: #F6F8FA;
  border-radius:35px;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.08), 
    0px 6px 16px rgba(0,0,0,0.12);
  
  overflow:hidden;
}
  
}

/* 
  ##Device = Low Resolution Tablets, Mobiles (Landscape)
  ##Screen = B/w 481px to 767px
*/

@media (min-width: 481px) and (max-width: 767px) {
  
  .sc-box{
  position:relative;
  width:400px;
  margin:36px auto;
  
  background-color: #F6F8FA;
  border-radius:35px;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.08), 
    0px 6px 16px rgba(0,0,0,0.12);
  
  overflow:hidden;
}

.sc-timeline-time {
    line-height: 1.2;
    font-size: 12px;
    font-weight: 800;
}
  
}

/* 
  ##Device = Most of the Smartphones Mobiles (Portrait)
  ##Screen = B/w 320px to 479px
*/

@media (min-width: 320px) and (max-width: 480px) {
  
  .sc-box{
  position:relative;
  width:300px;
  margin:36px auto;
  
  background-color: #F6F8FA;
  border-radius:15px;
  box-shadow: 0px 3px 6px rgba(0,0,0,0.08), 
    0px 6px 16px rgba(0,0,0,0.12);
  
  overflow:hidden;
}

.sc-timeline-time {
    line-height: 1.2;
    font-size: 12px;
    font-weight: 800;
}

.sc-timeline-item {
    /* display: flex;
    width: 100%;
    align-items: flex-start; */
    margin-bottom: 10px;
    cursor: pointer;
}
  
}
.sc-container{
  padding:36px;
}

.sc-main-title{
  --fore-color: #000000;
  
  margin-bottom:42px;
  
  color:var(--fore-color);
  text-align:center;
}


.sc-timeline{
  padding-top:0;
  padding-bottom:64px;
}
.sc-timeline-item{
  display:flex;
  
  width:100%;
  align-items:flex-start;
  margin-bottom: 30px;
  
  cursor:pointer;
}
/* .sc-timeline-item:after{
  content:url("data:image/svg+xml,%3Csvg width='15' height='26' viewBox='0 0 15 26' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath opacity='0.2' d='M1 1L13 13L1 25' stroke='black' stroke-width='2'/%3E%3C/svg%3E%0A");
  align-self:center;
  margin-left:16px;
} */
.sc-timeline-item:last-child{
  margin-bottom:0;
}
.sc-timeline-icon{
  display:flex;
  position:relative;
  
  align-items:center;
  justify-content:center;
  width:60px;
  height:60px;
  
  font-size: 24px;
  color:#ffffff;
  background-color:var(--primary-color);
  border-radius:50%;
  box-shadow: var(--main-cast-shadow);
  
  z-index:2;
}
.sc-timeline .sc-timeline-icon{
  margin-right:16px;
  flex:none;
}
.sc-timeline .sc-timeline-icon:after{
  content:'';
  position:absolute;
  
  top:100%;
  height:100%;
  width:2px;
  
  background-color:#DBE0E8;
  
  z-index:-1;
}
.sc-timeline-item:last-child .sc-timeline-icon:after{
  display:none;
}
.sc-timeline-item[event*="launch"] .sc-timeline-icon{
  background-color: var(--accent-color);
}
.sc-timeline-info{
  padding-top:8px;
  flex-grow:1;
}
.sc-timeline-title{
  --fore-color:#000000;
  
  margin:0;
  
  color:var(--fore-color);
  font-weight:600;
}
.sc-timeline-details{
  display:flex;
  
  justify-content:space-between;
  margin-top:10px;
}
.sc-timeline-time{
  line-height:1.6;
  font-size: 16px;
  font-weight: 800;
}

.sc-timeline-duration{
  line-height:1.6;
}

.sc-bottom-bar{
  display:flex;
  
  padding: 16px 36px;
  justify-content:space-between;
  
  font-size:26px;
  background-image:radial-gradient(circle at center 6px,transparent 36px, #ffffff 36px);
  filter: drop-shadow(0px -1px 6px  rgba(0, 0, 0, 0.08)) drop-shadow(0px -2px 12px  rgba(0, 0, 0, 0.12));
}

.sc-fab{
  position:absolute;
  display:flex;
  
  justify-content:center;
  align-items:center;
  width: 56px;
  height: 56px;
  bottom:28px;
  margin:auto;
  left:0;
  right:0;
  
  color:#ffffff;
  background-color: #000000;
  box-shadow: var(--main-cast-shadow);
  border-radius:50%;
}
.sc-menu-item{
  opacity:0.6;
}
.sc-current{
  opacity:1;
}
.sc-actionsheet-container{
  position:absolute;
  
  width:100%;
  height:100%;
  top:0;
  left:0;
  
  z-index:9;
    pointer-events:none;
}
.sc-actionsheet{
  position:absolute;

  width:100%;
  bottom:0;
  
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(20px);
  border-radius: 40px 40px 0px 0px;
  
  transition:ease-in-out .3s;
  transform:translate3d(0px, 100%, 0px);
  
  z-index:9;

}
.sc-actionsheet-container.sc-show .sc-overlay{
  opacity:1;
  pointer-events: all;
}
.sc-actionsheet-container.sc-show .sc-actionsheet{
  transform:translate3d(0px,0px,0px);
  pointer-events: all;
}
.sc-overlay{
  position:absolute;
  
  width:100%;
  height:100%;
  top:0;
  left:0;
  
  background-color:rgba(0,0,0,0.25);
  opacity:0;
  
  transition:ease-in-out .3s;
  pointer-events:none;
}

.sc-actionsheet-title{
  display:grid;
  
  padding:16px 36px;
  margin-top:24px;
  grid-template-columns: 1fr 2fr 1fr;
  grid-template-areas: '. title close';
  align-items:center;
}
.sc-actionsheet[type*="event"] .sc-actionsheet-title{
  grid-template-areas: 'duration title close';
  
}
.sc-actionsheet-info{
  grid-area:duration;
}
.sc-actionsheet-title-text{
  display:flex;
  
  width:100%;
  justify-content:center;
  grid-area:title;
  margin:0;
}
.sc-actionsheet-close{
  display:inline-flex;
  
  justify-content:center;
  align-items:center;
  grid-area: close;
  width:34px;
  height:34px;
  
  color:var(--fore-color);
  text-decoration:none;
  justify-self:end;
  border-radius:50%;
  background: rgba(0,0,0,0.1);
}
.sc-event-details{
  display:flex;
  
  justify-content:center;
  margin-top:24px;
}
.sc-event-details-items{
  display:inline-flex;
  flex-direction:column;
}
.sc-event-details-items > span{
  margin-bottom:8px;
}


.sc-flex-row{
  display:flex;
  flex-wrap:wrap;
}
.sc-justify-center{
  justify-content:center;
}

button{
  padding:12px 16px;
  
  text-align:center;
  border-radius:40px;
}
button[sc-style*="secondary"]{
  background-color:transparent;
  border: 1px solid var(--primary-color);
  color: var(--primary-color);
}
button[sc-style*="flat"]{
  padding:8px 16px;
  
  background-color:transparent;
  color:var(--fore-color);
  border:none;
}
button[sc-style*="danger"]{
  --fore-color: var(--danger-color);
}
button[sc-style*="block"]{
  width:100%;
}
</style>

@section('content')


<section class="content">

  <div class="sc-box" style="padding:20px">
    <h4>REQUEST NUMBER: <strong>{{ $request->request_number }}</strong> </h4> <hr>
      <div class="form-group mt-5">
         <label for="driverName">User Name : <strong>{{ $request->userDetail ? $request->userDetail->name : $request->adHocuserDetail->name }}</strong> </label>
      </div>  
  <div class="row">
     <div class="col-sm-6">
        <div class="form-group mt-5">
            <h6>
              <strong>Pickup Address :</strong>
            </h6>   
        </div>
          <div class="form-group mt-5">
             {{ $request->requestPlace->pick_address }}
          </div>
      </div>

      <div class="col-sm-6" style="border-left:1px grey solid;padding-left:40px;">
          <div class="form-group mt-5">
              <h6><strong>Drop Address :</strong></h6>   
          </div>
          <div class="form-group mt-5">
               {{ $request->requestPlace->drop_address ?? "-" }}
          </div>
      </div>

     </div>
  </div>

<!-- timeline -->
<div class="sc-box">
  <div class="sc-container">
    
  </div>
    <div class="sc-container sc-timeline">
  <!-- if track request is empty -->

    @if($trackRequests->isempty())
      @if($request->if_dispatch==1)
      <div class="sc-timeline-item" event="launch">
        <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
        <div class="sc-timeline-info">
          <div class="sc-timeline-details">
            <span class="sc-timeline-time">Ride Requested</span>
            <span class="sc-timeline-duration">
              <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                        <span class="strong">{{ $request->userDetail ? $request->userDetail->name : $request->adHocuserDetail->name }}</span> {{  $request->converted_created_at }}</span>
          </div>
              <div style="margin-top:40px;border-bottom:1px dashed;"></div>
        </div>
      </div>
      @else
      <div class="sc-timeline-item" event="launch">
        <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
        <div class="sc-timeline-info">
          <div class="sc-timeline-details">
            <span class="sc-timeline-time">Ride Requested</span>
            <span class="sc-timeline-duration">
              <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                        <span class="strong">{{ $request->userDetail ? $request->userDetail->name : $request->adHocuserDetail->name }}</span> {{  $request->converted_created_at }}</span>
          </div>
              <div style="margin-top:40px;border-bottom:1px dashed;"></div>
        </div>
      </div>      
      @endif
      @if($request->is_completed==1)      
      <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Completed</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                          <span class="strong">{{ $request->driverDetail->name ?? "-"}} {{ $request->driverDetail->user->username ?? "-" }}</span> {{  $request->converted_completed_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
        @else
       <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Cancelled</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/cross.png')}}" width="20px" style="margin-right:5px;" alt="">
                  <span class="strong">{{ $request->driverDetail->name ?? "Automatic"}}{{ $request->driverDetail->user->username ?? "-" }}</span> {{  $request->converted_updated_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
      @endif
    @else
    <!-- track request not empty -->
      <div class="sc-timeline-item" event="launch">
        <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
        <div class="sc-timeline-info">
          <div class="sc-timeline-details">
            <span class="sc-timeline-time">Ride Requested</span>
            <span class="sc-timeline-duration">
              <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                        <span class="strong">{{  $request->userDetail ? $request->userDetail->name : $request->adHocuserDetail->name }}</span> {{  $request->converted_created_at }}</span>
          </div>
              <div style="margin-top:40px;border-bottom:1px dashed;"></div>
        </div>
      </div>
     @foreach($trackRequests as $trackRequest)
      @if($trackRequest->is_after_accept==1)
      <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Cancelled</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/cross.png')}}" width="20px" style="margin-right:5px;" alt="">
                          <span class="strong">{{ $trackRequest->driver->name ?? "-"}} {{ $trackRequest->driver->user->username ?? "-" }}</span> {{  $trackRequest->converted_updated_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
      @else
      <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Denied</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/cross.png')}}" width="20px" style="margin-right:5px;" alt="">
                          <span class="strong">{{ $trackRequest->driver->name ?? "-"}} {{ $trackRequest->driver->user->username ?? "-" }}</span> {{  $trackRequest->converted_created_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
      @endif
     @endforeach
      @if($request->is_completed==1)
      <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Completed</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                          <span class="strong">{{ $request->driverDetail->name ?? "-"}} {{ $request->driverDetail->user->username ?? "-" }}</span> {{  $request->converted_completed_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
      @endif
      @if(($request->is_cancelled==1) && ($request->cancel_method==1))
      <div class="sc-timeline-item" event="launch">
          <i class="sc-timeline-icon"><img src="{{asset('assets/images/route.png')}}" width="30px" alt=""></i> 
          <div class="sc-timeline-info">
            <div class="sc-timeline-details">
              <span class="sc-timeline-time">Ride Cancelled</span>
              <span class="sc-timeline-duration">
                <img src="{{asset('assets/images/tick.png')}}" width="20px" style="margin-right:5px;" alt="">
                          <span class="strong">{{ $request->userDetail->name ?? "-"}}</span> {{  $request->converted_cancelled_at }}</span>
            </div>
            <div style="margin-top:40px;border-bottom:1px dashed;"></div>
          </div>
        </div>
      @endif
    @endif
  </div>
</div>
       


<!-- timeline end -->
    </section>
@endsection
