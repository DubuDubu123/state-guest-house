<div class="box-body no-padding">
                            <div class="table-responsive">
<table class="table table-hover">
                                    <thead>
                                        <tr>


                                            <th> @lang('view_pages.s_no')
                                                <span style="float: right;">

                                                </span>
                                            </th>
                                            <th> @lang('view_pages.slug')
                                                <span style="float: right;">
                                                </span>
                                            </th>
                                            <th> @lang('view_pages.name')
                                                <span style="float: right;">
                                                </span>
                                            </th>
                                            <th> @lang('view_pages.description')
                                                <span style="float: right;">
                                                </span>
                                            </th>
                                            <th> @lang('view_pages.updated_by')
                                            <span style="float: right;">
                                            </span>
                                            </th> 

                                        @if(auth()->user()->can('edit-roles'))
                                            <th> @lang('view_pages.action')
                                                <span style="float: right;">
                                                </span>
                                            </th>
                                        @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($results) < 1)
                                            <tr>
                                                <td colspan="11">
                                                    <p id="no_data" class="lead no-data text-center">
                                                        <img src="{{ asset('assets/img/dark-data.svg') }}"
                                                            style="width:150px;margin-top:25px;margin-bottom:25px;" alt="">
                                                    <h4 class="text-center" style="color:#333;font-size:25px;">
                                                        @lang('view_pages.no_data_found')</h4>
                                                    </p>
                                                </td>
                                            </tr>
                                        @else
                                            @php  $i= $results->firstItem(); @endphp
                                            @foreach ($results as $key => $result)

                                                <tr>
                                                    <td>{{ $i++ }} </td>
                                                    <td> {{ $result->slug }}</td>
                                                    <td>{{ $result->name }}</td>
                                                    <td>{{ $result->description }} </td>
                                                    <td>{{$result->updatedUser->name ?? "-"}}</td>   

                                                    @if($result->slug != 'dispatcher')
                                                    @if($result->slug != 'super-admin')
                                                    <td>
                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ url('roles/assign/permissions', $result->id) }}">
                                                            <i class="fa fa-pencil" id="edit_session" data-toggle="tooltip"
                                                                data-placement="top" title="Assign Permissions"></i>
                                                        </a>

                                                    </td>
                                                    @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

    <ul class="pagination pagination-sm pull-right">
        <li>
            <a href="#">{{$results->links()}}</a>
        </li>
    </ul>

    </div></div>