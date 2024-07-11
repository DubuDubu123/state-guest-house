<!-- Toastr css -->


<!-- Top Bar Start -->


<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/dashboard')}}" class="logo">
        <!-- mini logo -->
        <b class="logo-mini" style="width:80px;padding-top:10px">
             <span class="light-logo" style="/* display: flex; *//* align-items: end; */"><img src="http://iasmess.dubudubutechnologies.com/assets/img/logo.png" style="width: 67px;padding-right: 5px;" alt="logo"></span> 
         </b> 
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">@lang('view_pages.toggle_navigation')</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <li style="
    padding-right: 20px;cursor:pointer
">
                    
                 </li>
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="name">{{ucfirst(auth()->user()->name)}}</span>
                        <img src="{{ auth()->user()->profile_picture ?: asset('/assets/img/user-dummy.svg') }}"
                             class="user-image rounded-circle" alt="User Image">
                             <i class="fa fa-angle-down pull-right" style="
    position: relative;
    top: 20px;
"></i>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header d-flex">
                            <img src="{{ auth()->user()->profile_picture ?: asset('/assets/img/user-dummy.svg') }}"
                                 class="float-left rounded-circle" alt="User Image">

                            <p class="pt-1 pl-2">
                                <span>{{ auth()->user()->name }}</span>
                                <small class="mb-5">{{ auth()->user()->email }}</small>

                            </p>

                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row no-gutters">
                                <div class="col-12 text-left">
                                    <a href="{{ url('admins/profile', auth()->user()->id) }}"><i
                                            class="ion ion-person"></i> @lang('pages_names.my_profile')</a>
                                </div>
                                <div role="separator" class="divider col-12"></div>
                                <div class="col-12 text-left">
                                    <a href="{{ url('api/spa/logout') }}" class="logout"><i
                                            class="fa fa-power-off"></i> @lang('pages_names.logout')</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
<!-- Top Bar End -->
<!-- Control Sidebar -->

<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<!-- <div class="control-sidebar-bg"></div> -->
