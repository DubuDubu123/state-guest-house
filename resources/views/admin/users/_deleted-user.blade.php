<div class="box-body no-padding">
    <div class="table-responsive">
      <table class="table table-hover">
    <thead>
    <tr> 

    <th> @lang('view_pages.s_no')
    <span style="float: right;">

    </span>
    </th>

    <th> @lang('view_pages.name')
    <span style="float: right;">
    </span>
    </th>
 
    <th> @lang('view_pages.mobile')
    <span style="float: right;">
    </span>
    </th>
    <th>Image
    <span style="float: right;">
    </span>
    </th>
    <th>Membership Type
    <span style="float: right;">
    </span>
    </th> 
    </th>     <th>View
    <span style="float: right;">
    </span>
    </th>
  
    </tr>
    </thead>
    <tbody>


    @php  $i= $results->firstItem(); @endphp

    @forelse($results as $key => $result)

    <tr>
    <td>{{ $i++ }} </td>
    <td>  {{$result->salutation}} {{$result->name}}</td>
<!--     @if(env('APP_FOR')=='demo')
    <td>**********</td>
    @else
    <td>{{$result->email}}</td>
    @endif -->
    @if(env('APP_FOR')=='demo')
    <td>**********</td>
    @else
    <td>+91 {{$result->mobile}}</td>
    <!-- <td>{{$result->gender}}</td> -->
    @endif
    <td><img src="{{$result->profile_picture}}" width="100px" height="100px"></td>
    <td><a class="dropdown-item"><span class="">
    @if($result->membership_type == 1)
                                    Life Time Member
                                    @else
                                    Associate Member
                                    @endif
    
    </span></a> </td> 
    <!-- <td>{{$result->createdUser->name ?? "-"}}</td>
    <td>{{$result->updatedUser->name ?? "-"}}</td>    -->
    <!-- <td>{{$result->userDetails ? $result->userDetails->address : '-'}}</td> --> 
    <td><a class="dropdown-item" href="{{url('users/view',$result->id)}}"><span class="label label-success">View   </span></a> </td> 
     
    </tr>
   @empty
        <tr>
            <td colspan="11">
                <p id="no_data" class="lead no-data text-center">
                    <img src="{{asset('assets/img/dark-data.svg')}}" style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </p>
            </td>
        </tr>
    @endforelse

    </tbody>
    </table>


    <div class="text-right">
<span  style="float:right">
{{$results->links()}}
</span>
</div>
</div></div>
