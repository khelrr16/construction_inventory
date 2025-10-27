@include('layouts.header')

<!-- Sidebar Toggle Button (Mobile) -->
<button class="btn btn-primary" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<nav id="sidebar">
    @include('layouts.clerk.sidebar')
</nav>

<!-- Main Content -->
<div id="content">
    @yield('content')
</div>
    
@include('layouts.scripts')
@stack('scripts')

@include('layouts.footer')