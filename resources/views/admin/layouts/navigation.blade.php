@php
  

if(str_contains((string)request()->path(),'translations')){
  $main_menu = 'settings';
  $sub_menu = 'translations';
  $sub_menu_1 = '';
}
@endphp 

<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">
    <!-- sidebar menu-->
    <ul class="sidebar-menu" data-widget="tree"> 
    @if(auth()->user()->can('access-dashboard'))
      <li class="{{'dashboard' == $main_menu ? 'active' : '' }}">
        <a href="{{url('/dashboard')}}">
          <i class="fa fa-tachometer"></i> <span>@lang('pages_names.dashboard')</span>
        </a>
      </li> 
      @endif
<!-- Configuration Start -->
       @if(auth()->user()->can('view-settings'))
      <li class="treeview {{ 'settings' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-lock" style="font-size: 22px;"></i> 
          <span> Roles and Permission</span>  
          <span class="pull-right-container">
            <i class="fa-solid fa-user-lock"></i>
          </span>
        </a>

        <ul class="treeview-menu">
        @if(auth()->user()->can('get-all-roles'))
            <li class="{{'admin' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/admins')}}">
                <i class="fa fa-user-circle-o"></i> <span>Users</span>
              </a>
            </li>
            @endif
          @if(auth()->user()->can('get-all-roles'))
          <li class="{{ 'roles' == $sub_menu ? 'active' : '' }}">
            <a href="{{url('/roles')}}"><i class="fa fa-circle-thin"></i>Privileges</a>
          </li>
          @endif
      
         
        </ul>
      </li>
      @endif
<!-- Configuration End -->


@if(auth()->user()->can('view-settings'))
      <li class="treeview {{ 'users' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-users" aria-hidden="true"></i>
          <span> User Management</span>  
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
        <li class="{{'user_details' == $sub_menu ? 'active' : '' }}">
        <a href="{{url('/users')}}">
                <i class="fa fa-user-circle-o"></i> <span>Pending Approval Officer's</span>
              </a>
            </li>  
            <li class="{{'approved' == $sub_menu ? 'active' : '' }}">
            <a href="{{url('/users/approved')}}">
            <i class="fa fa-user-plus" aria-hidden="true"></i>  
            Approved Officer's</a>
          </li> 
          <li class="{{'deceased' == $sub_menu ? 'active' : '' }}">
          <a href="{{url('/users/deceased')}}"><i class="fa fa-user-times" aria-hidden="true"></i>Deceased Officer's</a>
          </li> 
      
         
        </ul>
      </li>
      @endif
 
      
      
      @if(auth()->user()->can('add-Room-booking'))
        <li class="{{'types' == $sub_menu ? 'active' : '' }}">
          <a href="{{url('/types')}}">
          <i class="fa fa-bed" style="font-size: 22px;"></i> 
           <span>Book a Room</span>
          </a>
        </li> 
        @endif
        @if(auth()->user()->can('add-party'))
      <li class="{{'party' == $sub_menu ? 'active' : '' }}">
          <a href="{{url('/party')}}">
          <i class="fa fa-building" aria-hidden="true"></i>  <span>Book a Party Hall</span>
          </a>
        </li> 
        @endif 
        
        @if(auth()->user()->can('add-sports'))
        <li class="{{'sports' == $sub_menu ? 'active' : '' }}">
          <a href="{{url('/sports')}}">
          <i class="fa fa-futbol-o" style="font-size: 22px;"></i>  <span>Book a Sport</span>
          </a>
        </li> 
        @endif
        @if(auth()->user()->can('room-booking-management'))
      <li class="treeview {{ 'room' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
          <i class="fa fa-cogs"></i>
          <span> Booking Management</span>  
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
            <li class="{{'room-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/room-booking')}}">
              <i class="fa fa-bed"></i>
              <span>Room</span>
              </a>
            </li>
            <li class="{{'party-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/party-booking')}}">
              <i class="fa fa-building" aria-hidden="true"></i> <span>Party Hall / Lawn</span>
              </a>
            </li>
            <li class="{{'sports-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/sports-booking')}}">
                <i class="fa fa-futbol-o"></i> <span>Sports</span>
              </a>
            </li> 
        </ul>
      </li>  
      @endif

    
        @if(auth()->user()->can('report-management'))
      <li class="treeview {{ 'report' == $main_menu ? 'active menu-open' : '' }}">
        <a href="javascript: void(0);">
        <i class="fa fa-file-text" aria-hidden="true"></i>
          <span> Report Management</span>  
          <span class="pull-right-container">
          <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>

        <ul class="treeview-menu"> 
        <li class="{{'user' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/reports/user')}}">
                <i class="fa fa-user-circle-o"></i> <span>Officer's Report</span>
              </a>
            </li>
            <li class="{{'room-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/reports/room-booking')}}">
              <i class="fa fa-bed"></i>
              <span>Room</span>
              </a>
            </li>
            <li class="{{'party-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/reports/party-booking')}}">
              <i class="fa fa-building" aria-hidden="true"></i><span>Party Hall / Lawn</span>
              </a>
            </li>
            <li class="{{'sports-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/reports/sports-booking')}}">
                <i class="fa fa-futbol-o"></i> <span>Sports</span>
              </a>
            </li> 
            <!-- <li class="{{'overall-booking' == $sub_menu ? 'active' : '' }}">
              <a href="{{url('/reports/overall-booking')}}">
                <i class="fa fa-user-circle-o"></i> <span>Overall Report </span>
              </a>
            </li> -->
        </ul>
      </li>  
      @endif
       
      @if(auth()->user()->can('room-availability-settings'))
      <li class="{{'availabilty-view' == $main_menu ? 'active' : '' }}">
        <a href="{{url('/types/availability-view')}}">
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        <span>Room Availability</span>
        </a>
      </li>  
      @endif
      @if(auth()->user()->can('view-settings'))
<!-- Master Data End -->
<li class="{{'tariff' == $main_menu ? 'active' : '' }}">
        <a href="{{url('/tariff')}}">
        <i class="fa fa-money" aria-hidden="true"></i>
        <span>Tariff Card</span>
        </a>
      </li>  
      @else
      <!-- Master Data End -->
<li class="{{'tariff' == $main_menu ? 'active' : '' }}">
        <a href="{{url('/tariff')}}">
          <i class="fa fa-money"></i> <span>Tariff Card</span>
        </a>
      </li>  
      @endif
     
  </section>
</aside>
