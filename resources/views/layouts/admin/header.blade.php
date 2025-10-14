<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>@yield('title')</title>
    @livewireStyles
</head>

<body>
    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left side -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.user-management') }}">User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.projects') }}">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.warehouses') }}">Warehouses</a>
                    </li>
                    
                    <!-- Requests -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="siteDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Requests
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="siteDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.requests.new-resources') }}">Pending Resources</a></li>
                            <li><a class="dropdown-item" href="#">Incomplete Resouces</a></li>
                        </ul>
                    </li>

                    <!-- Site Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="siteDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Site
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="siteDropdown">
                            <li><a class="dropdown-item" href="{{ route('worker.projects') }}">Projects</a></li>
                            <li><a class="dropdown-item" href="#">Site 2</a></li>
                        </ul>
                    </li>

                    <!-- Warehouse Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="warehouseDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Clerk
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="warehouseDropdown">
                            <li><a class="dropdown-item" href="{{ route('clerk.projects') }}">Projects</a></li>
                            <li><a class="dropdown-item" href="{{ route('clerk.inventory') }}">Inventory</a></li>
                        </ul>
                    </li>

                    <!-- Driver Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="driverDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Driver
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="driverDropdown">
                            <li><a class="dropdown-item" href="{{ route('driver.projects') }}">Projects</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Right side -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <span class="nav-link text-white fw-bold">
                            {{ Auth::user()->name }} [ {{ Auth::user()->employeeCode() }} ]
                        </span>
                    </li>
                    <li class="nav-item">
                        <form class="m-0 p-0" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link fw-bold text-danger btn btn-link">
                                Log out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @livewireScripts
</body>

</html>