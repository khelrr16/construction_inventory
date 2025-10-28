@include('layouts.header')

<!-- Main Content -->
<div id="content">
    @yield('content')
</div>

@stack('scripts')
@include('layouts.scripts')
@include('layouts.footer')