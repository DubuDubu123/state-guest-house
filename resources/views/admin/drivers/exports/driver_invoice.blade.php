<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.mobile')</th>            
            <th> @lang('view_pages.invoice_number')</th>
            <th> @lang('view_pages.invoice_amount')</th>    
            <th> @lang('view_pages.gst')</th>    
            <th> @lang('view_pages.amount')</th>            
            <th> @lang('view_pages.from')</th>            
            <th> @lang('view_pages.to')</th>
            <th> @lang('view_pages.no_of_rides')</th>            
            <th> @lang('view_pages.date')</th>
        </tr>
    </thead>

    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)

            <tr>
                <td>{{ $i++ }} </td>
                <td>{{$result ? $result->driver->name : '-'}}</td>
                <td>{{$result ? $result->driver->mobile : '-'}}</td>
                <td>{{$result ? $result->invoice_number : '-'}}</td>
                <td>{{$result ? $result->invoice_amount : '-'}}</td>
                <td>{{$result ? $result->gst : '-'}}</td>                
                <td>{{$result ? $result->amount : '-'}}</td>
                <td>{{$result ? $result->getConvertedFromAttribute() : '-'}}</td>
                <td>{{$result ? $result->getConvertedToAttribute() : '-'}}</td>
                <td>{{$result ? $result->no_of_rides : '-'}}</td>
                <td>{{$result ? $result->getConvertedCreatedAtAttribute() : '-'}}</td>
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