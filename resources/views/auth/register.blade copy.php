<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container">
    <h2>Create Account</h2>
    <form action="/register" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Full Name" value="{{old('name')}}" required>
        <input type="email" name="email" placeholder="Email" value="{{old('email')}}" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red;">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
        <input type="submit" value="Sign Up">
    </form>
        <div class="option">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>