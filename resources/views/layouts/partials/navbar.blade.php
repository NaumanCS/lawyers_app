<!-- Header -->
<div class="header">
    <div class="header-left">
        <a href="index.html" class="logo logo-small">
            <img src="{{ asset('admin') }}/assets/img/logo-icon.png" alt="Logo" width="30" height="30">
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-align-left"></i>
    </a>
    <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
        <i class="fas fa-align-left"></i>
    </a>
   
    <ul class="nav user-menu">
        <li class="nav-item logged-item">
            <a href="{{route('chat')}}" class="nav-link">
                <i class="fa fa-comments" aria-hidden="true"></i>
            </a>
        </li>
        <!-- Notifications -->
        <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="far fa-bell"></i>
                @if (auth()->user()->unreadnotifications->count() > 0)
                    <span class="badge badge-pill"></span>
                @else
                    <span class="badge badge-pill d-none"></span>
                @endif
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @if (auth()->user()->notifications)
                            @foreach (auth()->user()->unreadnotifications as $notification)
                                <li class="notification-message">
                                    <a href="admin-notification.html">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt=""
                                                    src="{{ asset('admin') }}/assets/img/provider/provider-01.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details">
                                                    <span class="noti-title">{{ $notification->data['name'] }} documents
                                                        are verified.</span>
                                                </p>
                                                <p class="noti-time">
                                                    <span
                                                        class="notification-time">{{ $notification->created_at }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="admin-notification.html">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        <!-- User Menu -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="{{ asset('admin') }}/assets/img/user.jpg" width="40"
                        alt="Admin">
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="admin-profile.html">Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        <!-- /User Menu -->
    </ul>
</div>
<!-- /Header -->
