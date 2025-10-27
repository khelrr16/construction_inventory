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
            <a href="{{ route('clerk.warehouses') }}" 
                class="{{ request()->routeIs('clerk.warehouses') ? 'active' : '' }}">
                <i class="fas fa-warehouse"></i>
                <span class="menu-text">Warehouses</span>
            </a>
        </li>
        <li>
            <a href="{{ route('clerk.requests') }}" 
                class="{{ request()->routeIs('clerk.requests') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span class="menu-text">Requests</span>
            </a>
        </li>
        <li>
            <a href="{{ route('clerk.preparation') }}" 
                class="{{ request()->routeIs('clerk.preparation') ? 'active' : '' }}">
                <i class="bi bi-wrench-adjustable"></i>
                <span class="menu-text">Preparations</span>
            </a>
        </li>
    </ul>
</div>

<div class="sidebar-footer">
    <div class="user-info">
        <div class="user-avatar"><h1><i class="bi bi-box" title="Inventory Clerk"></i></h1></div>
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