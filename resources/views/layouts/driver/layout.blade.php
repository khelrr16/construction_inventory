@include('layouts.header')

<!-- Sidebar Toggle Button (Mobile) -->
<button class="btn btn-primary" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<nav id="sidebar">
    @include('layouts.driver.sidebar')
</nav>

<!-- Main Content -->
<div id="content">
    @yield('content')
</div>
    
@stack('scripts')
@include('layouts.scripts')
@include('layouts.footer')