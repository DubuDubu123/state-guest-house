<style>
.btn{
  font-size:12px;
}
</style>
<div class="grid columns-12 gap-5 mt-5">
<div class="g-col-12 g-col-xl-12 g-col-xxl-12">
<div class="box" style="background:#FBFBFB;box-shadow:  0px 0px 8px 1px rgba(0,0,0,0.3);">
<div class="">
<div class="overflow-x-auto">
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
    <tbody>
    @forelse ($results as $key => $result)
    <tr>
        <th scope="row" style="    text-align: center;">{{ $result->request_number }}</th>
        <td>{{ $result->converted_created_at }}</td>
        <td>{{ $result->pickaddress }}</td>
        <td>{{ $result->dropaddress }}</td>
        <?php 
        $status='<button class="btn btn-warning"> Upoming </button>';
        if($result->is_cancelled){
          $status = '<button class="btn btn-danger"> Cancelled </button>';
        }
        if($result->is_completed){
          $status = '<button class="btn btn-success"> Completed </button>';
        }
        ?>
        <td style="padding-left:66px;">{!! $status !!}</td>
        <td>
          <a href="{{ url('/').'/dispatch/detailed-view/'.$result->id }}" class="btn btn-primary" type="button">
         View</a>
        </td>
      </tr>
    @empty
    <tr><td colspan="12" style = "display: flex; text-align: center; justify-content:center;">No Requests Yet</td></tr>
    @endforelse
    </tbody>
</table>


</div>
</div>
</div>
</div>
</div>
<div class="intro-y g-col-12 d-flex flex-wrap flex-sm-row flex-sm-nowrap align-items-center">
    <nav class="w-full w-sm-auto me-sm-auto">
        <ul class="pagination">
            {{ $results->links('pagination::bootstrap-4') }}
        </ul>
    </nav>
</div>