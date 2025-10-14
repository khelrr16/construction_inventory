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
                @if(session('retryAfter'))
                    <div style="color:red;" id="lockoutAlert">
                        Too many attempts. Please wait 
                        <span id="countdown">{{ session('retryAfter') }}</span> seconds.
                    </div>

                    <script>
                    (function(){
                        let timeLeft = {{ session('retryAfter') }};
                        const countdownEl = document.getElementById("countdown");
                        const loginBtn = document.querySelector("button[type=submit]");

                        if(loginBtn) loginBtn.disabled = true;

                        const timer = setInterval(() => {
                            timeLeft--;
                            countdownEl.textContent = timeLeft;

                            if (timeLeft <= 0) {
                                clearInterval(timer);
                                const alert = document.getElementById('lockoutAlert');
                                if (alert) alert.remove();
                                if(loginBtn) loginBtn.disabled = false;
                            }
                        }, 1000);
                    })();
                    </script>
                @else
                    @foreach ($errors->all() as $error)
                        <li style="color:red;">{{ $error }}</li>
                    @endforeach
                @endif
                
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