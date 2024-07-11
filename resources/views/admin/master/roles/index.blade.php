@extends('admin.layouts.app')


@section('title', 'Main page')

@section('content')

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

        <div class="row" style="margin: 20px 20px 20px 20px;background: white;padding-top: 30px;border-radius:3px">
                <div class="col-sm-12">

                    <div class="box">
                        <div class="box-header with-border"> 
                                <div class="row text-right">
                            @if(auth()->user()->can('create-roles'))
                           <!--      <div class="col-sm-12 text-right">
                                 <a href="{{ url('roles/create') }}" class="btn btn-primary btn-sm">
                                    <i class="mdi mdi-plus-circle mr-2"></i>@lang('view_pages.add_role')</a>
                                </div> -->
                            @endif
                                    <div class="col-8 col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="search" id="search_keyword" class="form-control"
                                                placeholder="@lang('view_pages.enter_keyword')">
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-2 text-left">
                                        <button class="btn btn-success btn-outline btn-sm py-2 search_keyword" id="search" type="button">
                                            @lang('view_pages.search')
                                        </button>
                                    </div>
 
                            <!-- <div class="box-controls pull-right">
                            <div class="lookup lookup-circle lookup-right">
                              <input type="text" name="s">
                            </div>
                          </div> -->
                        </div>
                        <!-- /.box-header -->
                         
                                <div id="js-role-partial-target">
            <include-fragment src="roles/fetch">
                <span style="text-align: center;font-weight: bold;">@lang('view_pages.loading')</span>
            </include-fragment>
        </div>
                          
                    </div>
                    <div class="text-right">
                        <span style="float:right">
                            {{ $results->links() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container -->

    </div>
    <!-- content -->

    <script src="{{asset('assets/js/fetchdata.min.js')}}"></script>
<script>
    $(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.get(url, $('#search').serialize(), function(data){
            $('#js-role-partial-target').html(data);
        });
    });

    $('#search').on('click', function(e){
        e.preventDefault();

            var search_keyword = $('#search_keyword').val();
            console.log(search_keyword);
            fetch('roles/fetch?search='+search_keyword)
            .then(response => response.text())
            .then(html=>{
                document.querySelector('#js-role-partial-target').innerHTML = html
            });
    });

});
</script>

@endsection
