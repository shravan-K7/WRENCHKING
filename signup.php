<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WrenchKing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="favicon_io/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F5F5F5;
            margin: 0;
            padding: 20px 15px;
        }

        .register-container {
            display: flex;
            width: 100%;
            max-width: 950px;
            min-height: 600px;
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
            max-width: 380px;
        }

        @media (max-width: 768px) {
            .register-container {
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

            .right-panel {
                width: 100%;
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="left-panel">
            <div>
                <a href="index.php">
                    <img src="img/wrenchkinglogo.png" alt="Logo">
                </a>
                <h1>Join Us!</h1>
                <p>Create an account to enjoy our services.</p>
            </div>
        </div>
        <div class="right-panel">
            <h2 class="mb-4">Sign Up</h2>
            <form method="POST" action="./controllers/auth.php" id="signupForm">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full Name"
                        pattern="[A-Za-z\s]{3,50}"
                        title="Name should be 3-50 characters long and only contain letters and spaces" required>
                </div>

                <div class="mb-3">
                    <input type="tel" name="phone" class="form-control" pattern="\d{10}" maxlength="10" minlength="10"
                        placeholder="Phone" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <select name="sp_id" class="form-control" required>
                        <option value="" hidden disabled selected>Select Branch</option>
                        <option value="1">WK Adkathbail</option>
                        <option value="2">Wk Kumbla</option>
                        <option value="3">Wk Nileshwar</option>
                    </select>
                </div>

                <!-- Password Field with Eye Icon -->
                <div class="mb-3 position-relative">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                    <span id="togglePassword1" class="eye-icon"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>
                <!-- Confirm Password -->
                <div class="mb-3 position-relative">
                    <input type="password" id="cpassword" name="cpassword" class="form-control"
                        placeholder="Confirm Password" required>
                    <span id="togglePassword2" class="eye-icon"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>

                <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="signin.php">Sign In</a></p>
        </div>
    </div>

    <!-- Bootstrap Icons (Make sure Bootstrap is included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let passwordField = document.getElementById("password");
            let cpasswordField = document.getElementById("cpassword");
            let togglePassword1 = document.getElementById("togglePassword1");
            let togglePassword2 = document.getElementById("togglePassword2");
            let icon1 = togglePassword1.querySelector("i");
            let icon2 = togglePassword2.querySelector("i");

            // Initially hide the eye icon when password field is empty
            togglePassword1.style.display = "none";
            togglePassword2.style.display = "none";

            // Show the eye icon when user starts typing
            passwordField.addEventListener("input", function () {
                togglePassword1.style.display = passwordField.value.length > 0 ? "block" : "none";
            });

            cpasswordField.addEventListener("input", function () {
                togglePassword2.style.display = cpasswordField.value.length > 0 ? "block" : "none";
            });

            // Toggle Password Visibility on Click for Password Field
            togglePassword1.addEventListener("click", function () {
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    icon1.classList.remove("bi-eye-slash-fill");
                    icon1.classList.add("bi-eye-fill");
                } else {
                    passwordField.type = "password";
                    icon1.classList.add("bi-eye-slash-fill");
                    icon1.classList.remove("bi-eye-fill");
                }
            });

            // Toggle Password Visibility on Click for Confirm Password Field
            togglePassword2.addEventListener("click", function () {
                if (cpasswordField.type === "password") {
                    cpasswordField.type = "text";
                    icon2.classList.remove("bi-eye-slash-fill");
                    icon2.classList.add("bi-eye-fill");
                } else {
                    cpasswordField.type = "password";
                    icon2.classList.add("bi-eye-slash-fill");
                    icon2.classList.remove("bi-eye-fill");
                }
            });

            // Password Validation on Submit
            document.getElementById("signupForm").addEventListener("submit", function (event) {
                let password = passwordField.value;
                let passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

                if (!passwordPattern.test(password)) {
                    alert(
                        "Password must be at least 8 characters long and include at least one number, one uppercase letter, and one lowercase letter."
                    );
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
</body>

</html>