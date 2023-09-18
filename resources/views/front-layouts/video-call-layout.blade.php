<!DOCTYPE html>
<html lang="en">

<head>
    @include('front-layouts.partials.head')
    @include('front-layouts.assets.css')
</head>

<body>
    <div class="main-wrapper">
        @include('front-layouts.partials.user-navbar')
        <div class="content">
            <div class="container">
                <div class="row">
                    @include('front-layouts.partials.user-sidebar')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('front-layouts.partials.user-footer')
    </div>


    @include('front-layouts.assets.script')
</body>

</html>
