<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    Admin
    <ul>
        <a href="{{route('admin')}}">
            <li>Dashboard</li>
        </a>
        <a href="">
            <li>User Management</li>
        </a>
        <a href="{{route('admin.inventory')}}">
            <li>Inventory</li>
        </a>
        {{-- <a href="{{route('admin.stocks')}}">
            <li>Stocks</li>
        </a> --}}
    </ul>
    <form action="/logout" method="POST">
        @csrf
        <button>Log out</button>
    </form>
</body>
</html>