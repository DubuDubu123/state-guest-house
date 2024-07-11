<table class="table table-hover">
    <thead>
        <tr>
            <th> @lang('view_pages.s_no')</th>
            <th> @lang('view_pages.date')</th>
            <th> @lang('view_pages.name')</th>
            <th> @lang('view_pages.mobile')</th>
        </tr>
    </thead>

    <tbody>
        @php $i= 1; @endphp

        @forelse($drivers as $key => $result)
            <tr>
                <td>{{ $i++ }} </td>
                <td>{{ $result->created_at->format("m/d/Y") }} </td>
                <td> {{ $result->name }}</td>
                <td>{{ $result->mobile }}</td>
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
