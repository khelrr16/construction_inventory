<div class="sidebar-header">
    <span class="menu-text">
        <h2><i class="fa solid fa-truck sidebar-logo"></i></h2>
        <h3>CONSTRUCKTOR</h3>
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
            <a href="{{ route('driver.pending') }}"
                class="{{ request()->routeIs('driver.pending') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="menu-text">Pending</span>
            </a>
        </li>
        <li>
            <a href="{{ route('driver.deliveries') }}"
                class="{{ request()->routeIs('driver.deliveries') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i>
                <span class="menu-text">Deliveries</span>
            </a>
        </li>
        <li>
            <a href="{{ route('driver.vehicles') }}" 
                class="{{ request()->routeIs('driver.vehicles') ? 'active' : '' }}">
                <i class="bi bi-truck-front"></i>
                <span class="menu-text">Vehicles</span>
            </a>
        </li>
    </ul>
</div>

<div class="sidebar-footer">
    <div class="user-info">
        <div class="user-avatar"><h1><i class="bi bi-truck" title="Driver"></i></h1></div>
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