<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>@yield('title')</title>
    @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="navbar-brand">
                        {{ ucwords(str_replace('_', ' ', Auth::user()->employeeCode())) }}
                    </a>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    {{------------------------------------------ USER ------------------------------------------}}
                    @if(Auth::user()->role == 'user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('request') }}">Request</a>
                    </li>
                    {{------------------------------------------ CLERK ------------------------------------------}}
                    @elseif(Auth::user()->role == 'receiving_clerk') 
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clerk.preparation') }}">Preparation</a>
                    </li>
                    {{------------------------------------------ DRIVER ------------------------------------------}}
                    @elseif(Auth::user()->role == 'driver')
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('request') }}">Request</a>
                    </li> --}}
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <span class="nav-link text-white fw-bold">{{ Auth::user()->name }}
                        [ {{Auth::user()->role}} ]
                        </span>
                    </li>
                    <li class="nav-item">
                        <form class="m-0 p-0" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link fw-bold text-danger">Log out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>