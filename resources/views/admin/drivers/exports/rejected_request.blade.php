<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.request_number')</th>
            <th> @lang('view_pages.pickup_address')</th>
            <th> @lang('view_pages.drop_address')</th>
            <th> @lang('view_pages.date')</th>

        </tr>
    </thead>

    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)
            <tr>
                <td>{{ $i++ }} </td>
                <td>{{$result->driver ? $result->driver->name : '-'}}</td>
                <td>{{$result->request ? $result->request->request_number : '-'}}</td>
                <td>{{$result->request ? $result->request->requestPlace->pick_address : '-'}}</td>
                <td>{{$result->request ? $result->request->requestPlace->drop_address : '-'}}</td>
                <td>{{ $result->created_at->format("d/m/Y") }} </td>

             </tr>
        @empty
            <tr>
                <td colspan="11">
                    <h4 class="text-center" style="color:#333;font-size:25px;">@lang('view_pages.no_data_found')</h4>
                </td>
            </tr>
        @endforelse

    </tbody>
</table>
