<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="{{ route('lawyer.dashboard') }}" class="navbar-brand logo">
                {{-- <img src="{{asset('front')}}/assets/img/logo.png" class="img-fluid" alt="Logo"> --}}
                <h2 class="text-white">Dashboard</h2>
            </a>
            <a href="{{ route('lawyer.dashboard') }}" class="navbar-brand logo-small">
                {{-- <img src="{{asset('front')}}/assets/img/logo-icon.png" class="img-fluid" alt="Logo"> --}}
                <h2 class="text-white">Dashboard</h2>
            </a>
        </div>

        <ul class="nav header-navbar-rht">

            <li class="nav-item desc-list">
                <a href="{{ route('lawyer.service.create', 0) }}" class="nav-link header-login">
                    <i class="fas fa-plus-circle me-1"></i> <span>Post a Service</span>
                </a>
            </li>

            <!-- Notifications -->
            <li class="nav-item dropdown logged-item">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i> <span
                        class="badge badge-pill bg-yellow">{{ auth()->user()->unreadnotifications->count() }}</span>
                </a>
                <div class="dropdown-menu notify-blk dropdown-menu-end notifications">
                    <div class="topnav-dropdown-header">
                        <span class="notification-title">Notifications</span>
                        <a href="javascript:void(0)" class="clear-noti">Clear All</a>
                    </div>
                    <div class="noti-content">
                        <ul class="notification-list">
                            {{-- {{dd(auth()->user()->notification)}} --}}
                            @if (auth()->user()->notifications->isEmpty())
                                @foreach (auth()->user()->unreadnotifications as $notification)
                                    {{-- <div id="flash-message" class="mb-3"> --}}
                                    <li class="notification-message">
                                        <a href="notifications.html">
                                            <div class="media d-flex">
                                                <span class="avatar avatar-sm flex-shrink-0">
                                                    <img class="avatar-img rounded-circle" alt="User Image"
                                                        src="{{ asset('front') }}/assets/img/customer/user-01.jpg">
                                                </span>
                                                <div class="media-body flex-grow-1">
                                                    <p class="noti-details"> <span class="noti-title">{{$notification->data['message']}}</span></p>
                                                    <p class="noti-time"><span class="notification-time">{{$notification->created_at}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    {{-- </div> --}}
                                @endforeach
                            @else
                                <li class="notification-message">
                                    <div class="media d-flex">
                                        <h4 class="text-dark">Nothing to show yet!</h4>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="notifications.html">View all Notifications</a>
                    </div>
                </div>
            </li>
            <!-- /Notifications -->

            <!-- chat -->
            <li class="nav-item logged-item">
                <a href="{{route('chat')}}" class="nav-link">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                </a>
            </li>
            <!-- /chat -->

            <!-- User Menu -->
            <li class="nav-item dropdown has-arrow logged-item">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="user-img">
                        <img class="rounded-circle" src="{{ $user->image }}" alt="Profile Picture" width="31">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="user-header">
                        <div class="user-text">
                            <h6 class="text-truncate">{{ $user->name }}</h6>
                            <p class="text-muted mb-0">Lawyer</p>
                        </div>
                    </div>
                    {{-- <a class="dropdown-item" href="provider-dashboard.html">Dashboard</a>
                    <a class="dropdown-item" href="my-services.html">My Services</a>
                    <a class="dropdown-item" href="provider-bookings.html">Booking List</a>
                    <a class="dropdown-item" href="provider-settings.html">Profile Settings</a>
                    <a class="dropdown-item" href="provider-wallet.html">Wallet</a>
                    <a class="dropdown-item" href="provider-subscription.html">Subscription</a>
                    <a class="dropdown-item" href="provider-availability.html">Availability</a>
                    <a class="dropdown-item" href="chat.html">Chat</a>
                    <a class="dropdown-item" href="index.html">Logout</a> --}}
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
    </nav>
</header>
