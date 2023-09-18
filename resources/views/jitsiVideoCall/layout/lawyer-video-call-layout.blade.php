<!DOCTYPE html>
<html lang="en">

<head>
    @include('front-layouts.partials.head')
    @include('front-layouts.assets.css')
</head>
<body>
    <div class="main-wrapper">
        @include('front-layouts.partials.lawyer-navbar')
        <div class="content">
            <div class="container">
                <div class="row">
                    @include('front-layouts.partials.lawyer-sidebar')
                    <div class="col-xl-9 col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('front-layouts.partials.lawyer-footer')
    </div>
    @include('front-layouts.assets.script')
</body>
</html>
