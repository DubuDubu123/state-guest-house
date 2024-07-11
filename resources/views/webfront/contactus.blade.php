@extends('admin.layouts.web_header')

@section('title', 'Admin')

<style>
    .nav-link.contact {
        background: var(--logo-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .nav-link.contact::before {
        content: "";
        position: absolute;
        left: .75rem;
        right: .75rem;
        bottom: .25rem;
        border-top: 2px solid #01f0ff;
    }
</style>


@if($data)
<section class="py-15 mt-10" id="welcome"  data-jarallax data-speed=".8" style="background-image: url('{{ asset($p.$data->contactbanner) }}');">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 col-lg-5 text-white">
                <br><br><br><br><br>
            </div>
        </div>
    </div>
</section>
<section class="pt-12 pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4">

                <!-- Card -->
                <div class="card card-xl h-md-0 minh-md-100 mb-10 mb-md-0 shadow" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="">
                            <div class="simplebar-offset">
                                <div class="simplebar-content-wrapper">
                                    <div class="simplebar-content">
                                        <div class="card-body bg-light wow fadeInLeft" data-wow-delay="0.3s">

                                             {!! $data->contacttext !!}

                                           
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: auto; height: 520px;"></div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-md-7 col-lg-8 wow fadeInLeft" data-wow-delay="0.3s">
                <!-- <iframe style="width:100%; height:500px; border:0" src="{{ url($data->contactmap) }}" width="600" height="450"></iframe> -->
                <iframe width="600" height="400" src="https://maps.google.com/maps?hl=en&amp;q=192 Marai Malai Adigal Salai Raja Nagar Puducherry 605013+(undefined)&amp;ie=UTF8&amp;t=&amp;z=16&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
            <div class="col-12 pt-3">

                <form class="row" class="Contact-form" action="{{ route('contactussendmail') }}" method="POST">
                    @csrf
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="contactName">
                            First Name
                        </label>
                        <input class="form-control form-control-sm" id="name" name="first_name" type="text" placeholder="First Name" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="contactName">
                            Last Name
                        </label>
                        <input class="form-control form-control-sm" id="name" name="last_name" type="text" placeholder="Last Name" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="contactEmail">
                            Email Address
                        </label>
                        <input class="form-control form-control-sm" id="email" name="emailaddress" type="email" placeholder="Email Address" required="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="sr-only" for="contactTitle">
                            Phone Number
                        </label>
                        <input class="form-control form-control-sm" id="mobile" name="mobile" type="text" placeholder="Phone Number" required="">
                    </div>
                    <div class="form-group col-md-12 mb-7">
                        <label class="sr-only" for="contactMessage">
                            Message
                        </label>
                        <textarea class="form-control form-control-sm" id="message" name="message" rows="5" placeholder="Message" required=""></textarea>
                    </div>
                    <button class="btn btn-dark m-auto" style="display: flex" type="submit">
                        Send Message
                    </button>
                </form>

            </div>
        </div>
    </div>
</section>
@endif

@extends('admin.layouts.web_footer')
