<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-box">
        <h2>Log In</h2>    
        <form action="/login" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" value="{{old('email')}}" required>
            <input type="password" name="password" placeholder="Password" required>
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <button>Login</button>
        </form>
        <div class="option">
            <a href="">Forgot Password</a> | <a href="{{ route('register') }}">Create Account</a>
        </div>
    </div>
</body>
</html>