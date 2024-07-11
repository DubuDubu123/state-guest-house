<style>
    table.table.table-hover{
        text-align:center;
    }
    </style>
<div class="box-body" style="    padding: 1.25rem 0rem !important;">
    <div class="table-responsive">
      <table class="table table-hover">
      <thead style="  background-color: #454545; color: white;">
<tr>


<th> @lang('view_pages.s_no')
<span style="float: right;">

</span>
</th>

<th style="padding-left:36px;text-align:left">Driver Name  
</th>

<th> Mobile No.
<span style="float: right;">
</span>
</th>

<th> Installation Date
<span style="float: right;">
</span>
</th>
<th style="text-align:center">  Assigned To
<span style="float: right;">
</span>
</th>
<th style="text-align:center"> Status
<span style="float: right;">
</span>
</th>
<th style="text-align:center"> Action 
<span style="float: right;">
</span>
</th>
</tr>
</thead>
<tbody>
 @if(count($results)<1)
    <tr>
        <td colspan="11">
        <p id="no_data" class="lead no-data text-center">
        <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
     <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
 </p>
    </tr>
    @else

@php  $i= $results->firstItem(); @endphp

@foreach($results as $key => $result)
@php  $employee_status = 0; @endphp
@if($role == "employee") 
@if($result->assign_to != NULL)
@if(auth()->user()->id == $result->assign_to)
@php  $employee_status = 1; @endphp
@endif
@endif
@endif
@if($role == "admin") 
@php  $employee_status = 1; @endphp

@endif 
@if($employee_status == 1)
<tr>
<td>{{ $key+1 }} </td>

<td style="text-align:left">
<img src="https://ddatab.com/images/onboarding.png" alt="" style=" width: 60px; height: 60px;">  {{$result->name}}
</td>

@if(env('APP_FOR')=='demo')
<td>**********</td>
@else
<td>{{$result->mobile}}</td>
@endif
<td>{{$result->getConvertedCreatedAtAttribute()}}</td>
<td>
    @if($role == "admin") 
    <select name="dispatcher_driver_list_acess" class="form-control" data-val="{{$result->id}}" id="assign_to">
<option style="text-align: left;" value="" selected disabled>Select</option>
    @foreach($employee_details as $k=>$value)
    @if($result->assign_to == $value->id)
    <option style="text-align: left;" value="{{$value->id}}" selected>{{$value->name}}</option>
    @else
    <option style="text-align: left;" value="{{$value->id}}">{{$value->name}}</option>
    @endif 
    @endforeach
</select> 
@endif
@if($role == "employee") 
@if(auth()->user()->id == $result->assign_to)
    <select class="form-control" data-val="{{$result->id}}" id="assign_to">
        <option style="text-align: left;" value="" selected disabled>{{auth()->user()->name}}</option>
    </select> 
@endif
@endif

</td>
<td>
<div style="
    display: inline-block;
    width: 90%;
    margin-right: 5px;
">
<select name="dispatcher_driver_list_acess" class="form-control" data-val="{{$result->id}}" id="decomposition">
    <option value="" selected disabled>Select</option>
    <option value="not_reachable" @if($result->decomposition == "not_reachable") selected @endif>Not Reachable</option>
    <option value="rnr" @if($result->decomposition == "rnr") selected @endif>RNR</option> 
    <option value="call_back" @if($result->decomposition == "call_back") selected @endif>Call Back</option> 
    <option value="pending_docs" @if($result->decomposition == "pending_docs") selected @endif>Pending Docs</option> 
    <option value="Others" @if($result->decomposition == "Others") selected @endif>Others</option>  
</select>

</div>



</td>
<td>

<button type="button" class="btn btn-info btn-sm dropdown-toggle" style="background-color: #043c6c !important;border-color: #043c6c;color:black" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('view_pages.action')
</button>
@php
$drivers = DB::table('drivers')->where('mobile',$result->mobile)->first();
if($drivers)
{
    $url = url('/drivers')."/".$drivers->id;
}
else{
    $url = url('/drivers/create')."?value=".$result->id;
}
@endphp
<a href="{{$url}}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-plus-circle mr-2"></i>Onboard Driver</a>
                                    <div class="data" style="position: absolute;/* right: 10px; */background: #454545;display: inline-block;height: 35px;width: 40px;cursor: pointer;border-radius: 3px;margin-left: 8px;padding-left: 42pxx;">
<img src="https://ddatab.com/images/Notes Icon.png" style="width: 100%;/* margin-top:25px; *//* margin-bottom:25px; */height: 100%;" alt="" id="notes" data-val="{{$result->id}}">
</div>
     <div class="dropdown-menu w-48 ">
        @if($drivers)
        <a class="dropdown-item" href="{{url('drivers/SendForapproval',$drivers->id)}}">
        <i class="fa fa-dot-circle-o"></i>Send For Approval</a> 
        @endif
   
    @if(auth()->user()->can('delete-drivers'))         
        <a class="dropdown-item sweet-delete" href="#" data-url="{{url('drivers/registered/delete',$result->id)}}">
        <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a> 
    @endif 
            
      
    
    </div>

</td>   
</a>
</tr>
@endif 
@endforeach
@endif
</tbody>
</table>
<div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div>
</div>
</div>