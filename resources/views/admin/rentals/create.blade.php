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
                            <a href="{{ url('rentals') }}">
                                <button class="btn btn-danger btn-sm pull-right" type="submit">
                                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                                    @lang('view_pages.back')
                                </button>
                            </a>
                        </div>

                        <div class="col-sm-12">

                            <form method="post" class="form-horizontal" action="{{ url('rentals/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="city">@lang('view_pages.city')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="city" id="city" class="form-control" required>
                                            <option value="" >@lang('view_pages.select_city')</option>
                                            <option value= 'pondicherry' {{ old('city') == 'pondicherry' ? 'selected' : '' }}>@lang('view_pages.pondicherry')</option>
                                            <option value= 'goa' {{ old('city') == 'goa' ? 'selected' : '' }}>@lang('view_pages.goa')</option>
                                           </select>
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                     </div>
                                </div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">@lang('view_pages.category_name') <span class="text-danger">*</span></label>
                                        <select name="name" id="name" class="form-control" required>
                                                <option value="" >@lang('view_pages.select_category')</option>
                                                <option value= 'scooter' {{ old('name') == 'scooter' ? 'selected' : '' }}>@lang('view_pages.scooter')</option>
                                                <option value= 'bike' {{ old('name') == 'bike' ? 'selected' : '' }}>@lang('view_pages.bike')</option>
                                                <option value= 'royal_enfield' {{ old('name') == 'royal_enfield' ? 'selected' : '' }}>@lang('view_pages.royal_enfield')</option>
                                                <option value= 'maruthi_800' {{ old('name') == 'maruthi_800' ? 'selected' : '' }}>@lang('view_pages.maruthi_800')</option> 
                                                <option value= 'vintage_cars' {{ old('name') == 'vintage_car' ? 'selected' : '' }}>@lang('view_pages.vintage_car')</option>                                                
                                           </select>


                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="price_per_day">@lang('view_pages.price_per_day') <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="price_per_day" name="price_per_day"
                                                value="{{ old('price_per_day') }}" required=""
                                                placeholder="@lang('view_pages.enter') @lang('view_pages.price_per_day')">
                                            <span class="text-danger">{{ $errors->first('price_per_day') }}</span>

                                        </div>
                                    </div>
                     <div class="form-group">
                            <div class="col-6">
                                <label for="icon">@lang('view_pages.icon')</label><br>
                                <img id="blah" src="#" alt=""><br>
                                <input type="file" id="icon" onchange="readURL(this)" name="icon" style="display:none">
                                <button class="btn btn-primary btn-sm" type="button" onclick="$('#icon').click()" id="upload">@lang('view_pages.browse')</button>
                                <button class="btn btn-danger btn-sm" type="button" id="remove_img" style="display: none;">@lang('view_pages.remove')</button><br>
                                <span class="text-danger">{{ $errors->first('icon') }}</span>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                            <div class="col-12">
                                <button class="btn btn-primary btn-sm m-5 pull-right" type="submit">
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
@endsection
