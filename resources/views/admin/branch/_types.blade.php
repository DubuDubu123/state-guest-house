<div class="box-body no-padding">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>


                                                    <th> S.No
                                                        <span style="float: right;"></span>
                                                    </th>
                                                     
                                                    <th> Name
                                                        <span style="float: right;"></span>
                                                    </th>

                                                    <th> Address
                                                        <span style="float: right;"></span>
                                                    </th> 
                                                  
                                                    <th> Status
                                                        <span style="float: right;"></span>
                                                    </th> 
                                                    <th> Action<span style="float: right;">
</span>
                                                    </th>

                                                </tr>
                                            </thead>
                                       
<tbody>
 @if(count($results) < 1)
    <tr>
        <td colspan="6">
        <p id="no_data" class="lead no-data text-center">
        <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
     <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
 </p>
    </tr>
    @else

@php  $i= $results->firstItem(); @endphp

@foreach($results as $key => $result)

<tr>
<td>{{ $i++ }} </td>
<td> {{$result->title}}</td> 
<td> {{$result->location}}</td>  
<td>
@if($result->status == 0) 
    <button class="btn btn-success btn-sm" style="  background: red;   border-color: transparent;">Inactive</button>
@else
    <button class="btn btn-success btn-sm" style="  background: #ff9900;   border-color: transparent;">Active</button>
@endif  
</td>   

    
<td>
            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> @lang('view_pages.action')
                    
                    </button>
                    <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{url('requests',$result->id)}}">
                            <i class="fa fa-eye"></i>Edit</a>                      
                            <a class="dropdown-item" href="{{url('requests/track_reqest',$result->id)}}">
                            <i class="fa fa-eye"></i>Active</a>
                            <a class="dropdown-item" target="_blank" href="{{url('requests/delete',$result->id)}}">
                            <i class="fa fa-trash-o"></i>@lang('view_pages.delete')</a>
                            
                    </div>
                </div>
</td>
@endforeach
@endif
            </tr>
</tbody>
</table>
<div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div></div></div>
