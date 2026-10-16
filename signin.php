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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #F5F5F5;
            margin: 0;
            padding: 20px 15px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 950px;
            min-height: 580px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            margin: auto;
        }

        .left-panel {
            background-color: #d81324;
            color: white;
            width: 45%;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .left-panel img {
            max-width: 170px;
            height: auto;
            margin-bottom: 25px;
        }

        .profile-icon {
            font-size: 70px;
            margin-bottom: 15px;
        }

        .right-panel {
            width: 55%;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .form-control {
            border-radius: 25px;
            font-size: 1rem;
            padding: 12px 18px;
        }

        .btn-primary {
            border-radius: 25px;
            background-color: #d81324;
            border: none;
            font-size: 1.05rem;
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
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            display: none;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .left-panel {
                width: 100%;
                padding: 30px 20px;
            }

            .left-panel img {
                margin-bottom: 15px;
            }

            .profile-icon {
                font-size: 50px;
                margin-bottom: 10px;
            }

            .right-panel {
                width: 100%;
                padding: 30px 20px;
            }
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
</body>

</html>