@php
    use Illuminate\Support\Facades\URL;
    $route = \Request::route()->getName();
    $current_url = URL::current();
    $base_url = URL::to('/');
@endphp
<div class="slim-navbar">
    <div class="container">
      <ul class="nav">
        @if(Auth::user()->can('admin_notification')) 
          <li class="nav-item with-sub {{ (strpos($route, 'admin.notification.') !== false) ? 'active' : '' }}">
            <a class="nav-link cursor-pointer" href="#">
              <i class="icon ion-ios-bell-outline"></i>
              <span>Notification</span>
            </a>
            <div class="sub-item">
              <ul>
                  <li><a href="{{route('admin.notification')}}">Notification</a></li>
              </ul>
            </div><!-- sub-item -->
          </li>
        @endif  
        @if(Auth::user()->can(['admin_category','admin_failure','admin_failure_detail']) && Auth::user()->hasRole('admin'))
          <li class="nav-item with-sub {{ (strpos($route, 'admin.failure.') !== false) ? 'active' : '' }}">
            <a class="nav-link cursor-pointer" href="#">
              <i class="icon ion-android-apps"></i>
              <span>Failure mode</span>
            </a>
            <div class="sub-item">
              <ul>
                @if(Auth::user()->can('admin_category') && Auth::user()->hasRole('admin')) 
                  <li><a href="{{route('admin.failure.category')}}">Failure categories</a></li>
                @endif
                @if(Auth::user()->can('admin_failure') && Auth::user()->hasRole('admin')) 
                  <li><a href="{{route('admin.failure.mode')}}">Failure mode</a></li>
                @endif
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        @endif
        @if(Auth::user()->can(['admin_line','admin_area','admin_machine']))
          <li class="nav-item with-sub {{ (strpos($route, 'admin.school.') !== false) ? 'active' : '' }}">
            <a class="nav-link cursor-pointer" href="#">
              <i class="icon ion-android-pin"></i>
              <span>Major</span>
            </a>
            <div class="sub-item">
              <ul>
                @if(Auth::user()->can('admin_line')) 
                  <li><a href="{{route('admin.line')}}">Line</a></li>
                @endif
                @if(Auth::user()->can('admin_area')) 
                  <li><a href="{{route('admin.area')}}">Area</a></li>
                @endif
                @if(Auth::user()->can('admin_machine')) 
                  <li><a href="{{route('admin.device')}}">Machine</a></li>
                @endif
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        @endif
        @if(Auth::user()->can(['admin_user', 'admin_role']))
          <li class="nav-item with-sub {{ (strpos($route, 'admin.user.') !== false) ? 'active' : '' }}">
            <a class="nav-link cursor-pointer" href="#">
              <i class="icon ion-android-people"></i>
              <span>User</span>
            </a>
            <div class="sub-item">
              <ul>
                @if(Auth::user()->can('admin_user')) 
                  <li><a href="{{route('admin.user')}}">User</a></li>
                @endif
                @if(Auth::user()->can('admin_role') && Auth::user()->hasRole('admin')) 
                  <li><a href="{{route('admin.role')}}">Role</a></li>
                @endif
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        @if(Auth::user()->can('admin_report'))
            <li class="nav-item {{ (strpos($route, 'admin.page.') !== false || strcmp($route, 'home.index') == 0) ? 'active' : '' }}">
                <a class="nav-link cursor-pointer" href="{{route('admin.page.report')}}">
                    <i class="icon ion-podium"></i>
                    <span>Report</span>
                </a>
            </li>
        @endif
        
        @endif  
        @if(Auth::user()->can(['admin_setting','admin_qr','admin_news']))
          <li class="nav-item with-sub {{ (strpos($route, 'admin.setting.') !== false) ? 'active' : '' }}">
            <a class="nav-link cursor-pointer" href="#">
              <i class="icon ion-ios-gear-outline"></i>
              <span>Setting</span>
            </a>
            <div class="sub-item">
              <ul>
                @if(Auth::user()->can('admin_setting') && Auth::user()->hasRole('admin'))
                  <li><a href="{{route('admin.setting')}}">Setting</a></li>
                @endif
              </ul>
            </div><!-- dropdown-menu -->
          </li>
        @endif
      </ul>
    </div><!-- container -->
  </div><!-- slim-navbar -->