@extends('admin.layouts.app')

<style>
    .timeline .timeline-item>.timeline-point {
        color: yellow !important;
        padding: 3px;
    }

    .dropdown.user.user-menu a.dropdown-toggle {
        display: inherit;
    }

</style>

@section('content')


<section class="content">
    <div class="row">
        <div class="col-12">

            <a href="{{ url()->previous() }}">
                <button class="btn btn-danger btn-sm pull-right mb-3" type="submit">
                    <i class="mdi mdi-keyboard-backspace mr-2"></i>
                    @lang('view_pages.back')
                </button>
            </a>
            <div class="col-lg-12">

                <div class="nav-tabs-custom box-profile">

                    <div class="tab-content">

                        <div class="active tab-pane" id="timeline">

                            <div class="box p-15">
                                <div class="timeline timeline-single-column" style="max-width: max-content;">
                                    @foreach ($trackRequests as $trackRequest)

                                        <div class="timeline-item">
                                            <div class="timeline-point">
                                                <i class="fa fa-star text-yellow"></i>
                                            </div>
                                            
                                            <div class="timeline-event p-10">
                                                <div class="post">
                                                    <div class="user-block">

                                                        <img class="img-bordered-sm rounded-circle"
                                                            src="{{ $trackRequest->userDetail->profile_picture ?: asset('/assets/img/user-dummy.svg') }}"
                                                            alt="user image">

                                                        <span class="username">
                                                            <a href="#">{{ $trackRequest->driver->name }}</a>
                                                            {{ $trackRequest->request->request_number }}
                                                        </span>
                                                        <span
                                                            class="description">{{ $trackRequest->created_at->diffForHumans() ?? '' }}</span>
                                                        <p style="position: absolute;right: 15px;top: 15px;">
                                                            {{ $trackRequest->created_at->format('d-M-Y') }}</p>
                                                    </div>

                                                    <div class="activitytimeline">
                                                        <p>
                                                            <b>  @lang('view_pages.pickup_address'):</b>
                                                            
                                                            <span class="text-gray">
                                                                {{ $trackRequest->request->requestPlace->pick_address }}
                                                            </span>
                                                        </p>
                                                        <p class="mar0">{{ $trackRequest->comment }}</p>                                                
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                    <span class="timeline-label">
                                        <button class="btn btn-danger"><i class="fa fa-clock-o"></i></button>
                                    </span>

                                    <div class="text-right">
                                        <span  style="float:right">
                                        {{$trackRequests->links()}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </section>

@endsection
