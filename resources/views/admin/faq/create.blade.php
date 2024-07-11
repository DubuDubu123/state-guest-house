@extends('admin.layouts.app')
@section('title', 'Main page')

@section('content')
{{-- {{session()->get('errors')}} --}}

    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="box">

                        <div class="box-header with-border">
                            <a href="{{ url('faq') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('faq/store') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_type">@lang('view_pages.user_type') <span class="text-danger">*</span></label>
                                            <select name="user_type" id="user_type" class="form-control" required>
                                                <option value="" selected disabled>@lang('view_pages.select')</option>
                                                <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }} >@lang('view_pages.user')</option>
                                                <option value="driver" {{ old('user_type') == 'driver' ? 'selected' : '' }} >@lang('view_pages.driver')</option>
                                                <option value="owner" {{ old('user_type') == 'owner' ? 'selected' : '' }} >@lang('view_pages.owner')</option>
                                                <option value="all" {{ old('user_type') == 'all' ? 'selected' : '' }} >@lang('view_pages.all')</option>
                                            </select>
                                            <span class="text-danger">{{ $errors->first('user_type') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="question">@lang('view_pages.question') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="question" name="question"
                                                value="{{ old('question') }}" required
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.question')">
                                            <span class="text-danger">{{ $errors->first('question') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="answer">@lang('view_pages.answer') <span class="text-danger">*</span></label>
                                            <!-- <textarea class="ckeditor form-control" name="answer" value="{{ old('answer') }}" required></textarea> -->
                                            <input class="form-control" type="text" id="answer" name="answer"
                                                value="{{ old('answer') }}" required=""
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.answer')">
                                            <span class="text-danger">{{ $errors->first('answer') }}</span>

                                        </div>
                                    </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.hyper_link')</label>
                                                <input type="text"  class="form-control"  name="hyper_link" value="{{old('hyper_link')}}"
                                                placeholder=" @lang('view_pages.enter_hyper_link')">
                                            <span class="text-danger">{{ $errors->first('hyper_link') }}</span>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-sm pull-right m-5" type="submit">
                                            @lang('view_pages.save')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</div>
    <!-- content -->

    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
       $('.ckeditor').ckeditor();
    });

</script>
@endsection
