<!-- Header -->
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
            <a href="{{ route('front') }}" class="navbar-brand logo" style="max-height: 80px !important"> 
                <img src="{{asset('admin/assets/img/al-wakeel-logo.png')}}" class="img-fluid" style="max-height: 80px !important" alt="Logo">
                {{-- <h4 style="color: #fff;">App Logo</h4> --}}
            </a>
            {{-- <a href="index.html" class="navbar-brand logo-small">
                <img src="{{asset('front')}}/assets/img/logo-icon.png" class="img-fluid" alt="Logo">
            </a> --}}
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{ route('front') }}" class="menu-logo">
                    {{-- <img src="{{asset('front')}}/assets/img/logo.png" class="img-fluid" alt="Logo"> --}}
                    <h4 style="color: #fff;">App Logo</h4>
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
            </div>
            <ul class="main-nav">
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('front') }}">Home</a>
                </li>
                <li class="has-submenu {{ request()->is('categories*') ? 'active' : '' }}">

                    <a href="{{ route('categories', ['filter' => 'all']) }}">Categories<i
                            class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        @foreach ($categories as $category)
                            <li><a href="{{ route('lawyers.services', $category->id) }}">{{ $category->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="has-submenu {{ request()->is('lawyers/online*') ? 'active' : '' }}">
                    <a href="{{ route('lawyers.services', ['filter' => 'all']) }}">Consult Online<i
                            class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        {{-- <li><a href="{{route('chat')}}">Chat</a></li> --}}
                        <li><a href="{{ route('lawyers.services', ['filter' => 'online']) }}">Find Online Lawyers</a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('lawyer/signup*') ? 'active' : '' }}">
                    {{-- <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#provider-register">Become a
                        Professional</a> --}}
                        <a href="{{ route('lawyer.register.page') }}" >Become a
                            Professional</a>
                </li>
                <li class="{{ request()->is('customer/signup*') ? 'active' : '' }}">
                    {{-- <a href="javascript:void(0);" type="button" data-bs-toggle="modal"
                        data-bs-target="#user-register">Become a
                        Customer</a> --}}

                        <a href="{{ route('customer.register.page') }}" >Become a
                        Customer</a>
                </li>
            </ul>
        </div>
        @if (auth()->check() && auth()->user()->role == 'lawyer')
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('lawyer.dashboard') }}">Dashboard</a>
                </li>
            </ul>
        @elseif (auth()->check() && auth()->user()->role == 'user')
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('customer.dashboard') }}">Dashboard</a>
                </li>
            </ul>
        @else
            <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ route('login.page') }}" >Login</a>
                </li>
            </ul>
        @endif
    </nav>
</header>
<!-- /Header -->
