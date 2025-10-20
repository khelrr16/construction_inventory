<div class="sidebar-header">
    <h3><i class="fa solid fa-truck sidebar-logo"></i> <span class="menu-text">CONSTRUCKTOR</span></h3>
    <small><span class="menu-text">Admin Panel</span></small>
</div>

<div class="sidebar-menu glass-scrollbar">
    <ul>
        <li>
            <a href="{{ route('admin') }}"
                class="{{ request()->routeIs('admin') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.projects') }}" 
                class="{{ request()->routeIs('admin.projects') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                <span class="menu-text">Projects</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.warehouses') }}" 
                class="{{ request()->routeIs('admin.warehouses') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span class="menu-text">Warehouses</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user-management') }}" 
                class="{{ request()->routeIs('admin.user-management') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="menu-text">User Management</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.requests.new-resources') }}" 
                class="{{ request()->routeIs('admin.requests.new-resources') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span class="menu-text">Requests</span>
            </a>
        </li>

        <!-- Site Worker Collapsible Menu -->
        <li class="collapsible-menu">
            <a href="javascript:void(0)" class="menu-toggle">
                <i class="fas fa-clipboard-list"></i>
                <span class="menu-text">Site Worker</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('worker.projects') }}" 
                        class="{{ request()->routeIs('worker.projects') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span class="menu-text">Projects</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Inventory Clerk Collapsible Menu -->
        <li class="collapsible-menu">
            <a href="javascript:void(0)" class="menu-toggle">
                <i class="fas fa-clipboard-list"></i>
                <span class="menu-text">Inventory Clerk</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('clerk.projects') }}" 
                        class="{{ request()->routeIs('clerk.projects') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span class="menu-text">Resources</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('clerk.inventory') }}" 
                        class="{{ request()->routeIs('clerk.inventory') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        <span class="menu-text">Inventory</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Inventory Clerk Collapsible Menu -->
        <li class="collapsible-menu">
            <a href="javascript:void(0)" class="menu-toggle">
                <i class="fas fa-clipboard-list"></i>
                <span class="menu-text">Driver</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="{{ route('driver.projects') }}" 
                        class="{{ request()->routeIs('driver.projects') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span class="menu-text">Resources</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div class="sidebar-footer">
    <div class="user-info">
        <div class="user-avatar">{{ auth()->user()->name[0] }}</div>
        <div class="user-details">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">{{ auth()->user()->role }}</div>
            <div class="user-name">ID: {{ auth()->user()->employeeCode() }}</div>
        </div>
    </div>
</div>