<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WrenchKing</title>

    <!-- Bootstrap and Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="favicon_io/favicon.ico">

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F5F5F5;
            margin: 0;
        }

        .login-container {
            display: flex;
            width: 1000px;
            height: 600px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .left-panel {
            background-color: #d81324;
            color: white;
            width: 50%;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .left-panel img {
            position: absolute;
            top: 10px;
            left: 22%;
            transform: translateX(-50%);
            max-width: 160px;
            height: auto;
            max-height: 100px;
        }

        .profile-icon {
            font-size: 80px;
            margin-top: 100px;
            margin-bottom: 20px;
        }

        .right-panel {
            width: 65%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .form-control {
            border-radius: 25px;
            font-size: 1.1rem;
            padding: 12px;
        }

        .btn-primary {
            border-radius: 25px;
            background-color: #d81324;
            border: none;
            font-size: 1.1rem;
            padding: 12px;
        }

        .btn-primary:hover {
            background-color: rgb(251, 0, 21);
        }

        a {
            text-decoration: none;
        }

        .right-panel form {
            width: 100%;
            max-width: 350px;
        }

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="left-panel">
            <div>
                <a href="index.php">
                    <img src="img/wrenchkinglogo.png" alt="Logo">
                </a>
                <i class="bi bi-person-circle profile-icon"></i>
                <h2>Welcome back!</h2>
                <p>You can sign in to access your existing account.</p>
            </div>
        </div>
        <div class="right-panel">
            <h3 class="mb-4">Sign In</h3>
            <form method="POST" action="./controllers/auth.php">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <!-- Password Field with Eye Icon -->
                <div class="mb-3 position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                    <span id="togglePassword" class="eye-icon">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>

                <div class="form-check mb-3 text-start">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100">Sign In</button>

                <!-- forgot password -->
                <div class=" mt-1 text-center">
                    <a href="./forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                </div>

            </form>
            <p class="text-center mt-1">New here? <a href="./signup.php">Create an Account</a></p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let passwordField = document.getElementById("password");
            let togglePassword = document.getElementById("togglePassword");
            let icon = togglePassword.querySelector("i");

            // Initially hide the eye icon
            togglePassword.style.display = "none";

            // Show the eye icon when user starts typing
            passwordField.addEventListener("input", function () {
                if (passwordField.value.length > 0) {
                    togglePassword.style.display = "block";
                } else {
                    togglePassword.style.display = "none";
                }
            });

            // Toggle Password Visibility on Click
            togglePassword.addEventListener("click", function () {
                if (passwordField.type === "password") {
                    passwordField.type = "text"; // Show password
                    icon.classList.remove("bi-eye-slash-fill");
                    icon.classList.add("bi-eye-fill");
                } else {
                    passwordField.type = "password"; // Hide password
                    icon.classList.add("bi-eye-slash-fill");
                    icon.classList.remove("bi-eye-fill");
                }
            });
        });
    </script>

    <script src="finisher-header.es5.min.js" type="text/javascript"></script>

</body>

</html>