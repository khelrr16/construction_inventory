@include('layouts.header')

<!-- Sidebar Toggle Button (Mobile) -->
    <button class="btn btn-primary" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav id="sidebar">
        @include('layouts.worker.sidebar')
    </nav>

    <!-- Main Content -->
    <div id="content">
        @yield('content')
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>

@include('layouts.footer')