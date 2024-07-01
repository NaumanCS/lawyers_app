<!DOCTYPE html>
<html lang="en">

<head>
    @include('front-layouts.partials.head')
    @include('front-layouts.assets.css')
    @livewireStyles
</head>

<body>
    <div class="main-wrapper">
        @include('front-layouts.partials.navbar')
        @yield('content')
        @include('front-layouts.partials.footer')
        @include('front-layouts.partials.modals')
    </div>

    @include('front-layouts.assets.script')
    @livewireScripts
</body>

</html>
