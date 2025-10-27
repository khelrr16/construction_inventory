<div class="sidebar-header">
    <span class="menu-text">
        <img src="{{ asset('img/logo/full-logo.png') }}" 
            class="mx-auto d-block w-75" alt="img-logo">
    </span>
</div>

<div class="sidebar-menu glass-scrollbar">
    <ul>
        @can('access-admin')
        <li>
            <a href="{{ route('admin') }}"
                class="{{ request()->routeIs('admin') ? 'active' : '' }}">
                <i class="bi bi-key-fill"></i>
                <span class="menu-text">Admin</span>
            </a>
        </li>
        @endcan
        <li>
            <a href="{{ route('worker.projects') }}" 
                class="{{ request()->routeIs('worker.projects') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span class="menu-text">Projects</span>
            </a>
        </li>
    </ul>
</div>

<div class="sidebar-footer">
    <div class="user-info">
        <div class="user-avatar"><h1><i class="bi bi-buildings" title="Site Worker"></i></h1></div>
        <div class="user-details">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</div>
            <div class="user-name">ID: {{ auth()->user()->employeeCode() }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="user-logout">
            @csrf
            <button type="submit" class="bg-transparent p-0 m-0 border-0 text-current">
                <h3><i class="bi bi-box-arrow-left"></i></h3>
            </button>
        </form>
    </div>
</div>