<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.driver_name')</th>
            <th> @lang('view_pages.mobile')</th>            
            <th> @lang('view_pages.subscription_type')</th>
            <th> @lang('view_pages.subscription_amount')</th>            
            <th> @lang('view_pages.expiry_date')</th>
        </tr>
    </thead>

    <tbody>
        @php $i= 1; @endphp

        @forelse($results as $key => $result)

        @php 
           $driver_subscription = $result->subscriptions()->orderBy('created_at', 'desc')->first();
        @endphp
            <tr>
                <td>{{ $i++ }} </td>
                <td>{{$result ? $result->name : '-'}}</td>
                <td>{{$result ? $result->mobile : '-'}}</td>
                @if($result->is_free_trial==false)
                <td>{{ $driver_subscription->subscription_type ?? '-'}}</td>
                <td>{{ $driver_subscription->amount ?? '-'}}</td>
                <td>{{ $driver_subscription->getConvertedExpiredAtAttribute() ?? '-'}}</td>
                @else
                <td>{{'-'}}</td>
                <td>{{'-'}}</td>
                <td>{{'-'}}</td>
                @endif
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