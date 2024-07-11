@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <style>
        .demo-radio-button label {
            min-width: 100px;
            margin: 0 0 5px 50px;
        }

        .modal-header {
            border-bottom: 2px solid #1e88e5;
        }

        .modal-title {
            color: #9c9cdc;
            font-weight: 700;
        }

        .request-status h4 {
            background: blue;
            padding: 5px 5px 5px 5px;
            border-radius: 5px;
            width: 35%;
            color: white;
            font-weight: 600;
        }

    </style>

    <!-- Start Page content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">

                    <div class="box-header with-border">
                        <div class="row text-right">

                            <div class="col-8 col-md-3">
                                <div class="form-group">
                                    <input type="text" id="search_keyword" name="search" class="form-control"
                                        placeholder="@lang('view_pages.enter_keyword')">
                                </div>
                            </div>

                            <div class="col-4 col-md-2 text-left">
                                <button id="search" class="btn btn-success btn-outline btn-sm py-2" type="submit">
                                    @lang('view_pages.search')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="js-rental_request-partial-target">
                        <include-fragment src="pondicherry/fetch">
                            <span style="text-align: center;font-weight: bold;">@lang('view_pages.loading')</span>
                        </include-fragment>
                    </div>

                </div>
            </div>
        </div>

        {{-- </div> --}}
        <!-- container -->


<script src="{{ asset('assets/js/fetchdata.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let search_keyword = '';

        $('body').on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.get(url, $('#search').serialize(), function (data) {
                $('#js-rental_request-partial-target').html(data);
            });
        });

        $('#search').on('click', function (e) {
            e.preventDefault();
            search_keyword = $('#search_keyword').val();
            fetchDataWithKeyword(search_keyword);
        });

        $('.filter, .resetfilter').on('click', function () {
            const filterColumn = ['trip_status', 'is_paid', 'payment_opt'];
            let queryObject = {};

            $.each(filterColumn, function (index, value) {
                if ($(this).hasClass('resetfilter')) {
                    $('input[name="' + value + '"]').prop('checked', false);
                } else if ($('input[name="' + value + '"]:checked').attr('id') !== undefined) {
                    let activeVal = $('input[name="' + value + '"]:checked').attr('data-val');
                    queryObject[value] = activeVal;
                }
            });

            fetchDataWithQuery(queryObject);
        });

        function fetchDataWithKeyword(keyword) {
            fetch('rental_requests/pondicherry/fetch?search=' + keyword)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('#js-rental_request-partial-target').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        function fetchDataWithQuery(queryObject) {
            const queryString = new URLSearchParams(queryObject).toString();
            fetch('rental_requests/pondicherry/fetch?' + queryString)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('#js-rental_request-partial-target').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    });
</script>

    @endsection
