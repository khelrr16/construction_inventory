<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Sign in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{  asset('css/authentication.css') }}">
</head>

<body>
    <div class="container @if($errors->register->any()) sign-up-mode @endif">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{ route('login') }}" method="POST" class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    @if($errors->login->any())
                    <div class="note">
                        @if(session('retryAfter'))
                            Too many attempts. Please wait 
                            <span id="countdown">{{ session('retryAfter') }}</span> seconds.
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
                            @foreach ($errors->login->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                    @endif
                </form>

                <form action="{{ route('register') }}" method="POST" class="sign-up-form">
                    @csrf
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Full Name" name="name" required 
                            value="{{ old('name') }}" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" required 
                            value="{{ old('email') }}" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-phone"></i>
                        <input type="tel" placeholder="Phone Number" name="contact_number" maxlength="11" required 
                            value="{{ old('contact_number') }}" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" required />
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                    <div class="note">
                        @if($errors->register->any())
                            @foreach($errors->register->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>
                        <b>CONTRUCKTOR</b>
                    </h3>
                    <p>
                        CONSTRUCTION INVENTORY MANAGEMENT SYSTEM
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>

            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>ALREADY HAVE AN ACCOUNT?</h3><br>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");

    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
    });

    sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign-up-mode");
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>