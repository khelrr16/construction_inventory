<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://plus.unsplash.com/premium_photo-1701090939615-1794bbac5c06?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Z3JheSUyMGJhY2tncm91bmR8ZW58MHx8MHx8fDA%3D') no-repeat center center fixed;
            background-size: cover;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            max-width: 400px;
            width: 100%;
            color: black;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: black;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.25);
            box-shadow: none;
            color: black;
        }

        .btn-custom {
            background-color: rgba(255, 255, 255, 0.3);
            color: black;
            border: none;
        }

        .btn-custom:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .error {
            color: red;
            display: none;
            font-size: 14px;
        }
    </style>
</head>

<body>


    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="glass-card text-center">
            <h2>Create Account</h2>
            <form>
                <div class="mb-3 text-start">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="number" class="form-label">Phone Number</label>
                    <input type="number" class="form-control" id="number" required="">
                </div>
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3  text-start">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" required>
                </div>
                <div class="error" id="password-error">Passwords do not Match</div>
                <button type="submit" class="btn btn-custom w-100 mt-3">Create Account</button>
                <p class="mt-3 mb-0">Already have an account? <a href="#" class="text-light">Login</a></p>
            </form>
        </div>
    </div>

    <script>
        function checkPasswords() {
            const password = document.getElementById("password").value;
            const confirm-password = document.getElementById("confirm-password").value;
            const errorMessage = document.getElementById("password-error");

            if (password !== confirm - password) {
                errorMessage.style.display = "block"
                return false;
            } else {
                errorMessage.style.display = "none";
                return true;

            }
        }
    </script>
</body>

</html>