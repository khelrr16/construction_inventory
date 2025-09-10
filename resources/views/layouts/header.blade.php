<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <h2>[{{ Auth::user()->role }}]</h1>

    <ul>
        <a href="{{route('/')}}">
            <li>Home</li>
        </a>
    </ul>
    <form action="/logout" method="POST">
        @csrf
        <button>Log out</button>
    </form>
</body>
</html>