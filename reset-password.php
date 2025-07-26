<?php
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Set New Password</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="min-width: 350px;">
            <h4 class="text-center mb-4">🔒 Set a New Password</h4>

            <form action="update-password.php" method="POST" id="passwordResetForm">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <!-- New Password -->
                <div class="mb-3 position-relative">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control pe-5"
                        placeholder="Enter new password" required>
                    <span id="togglePassword1" class="mt-3 position-absolute top-50 translate-middle-y"
                        style="right: 15px; cursor: pointer; display: none;">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3 position-relative">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control pe-5"
                        placeholder="Confirm password" required>
                    <span id="togglePassword2" class="mt-3 position-absolute top-50 translate-middle-y"
                        style="right: 15px;  cursor: pointer; display: none;">
                        <i class="bi bi-eye-slash-fill"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-danger w-100">Update Password</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let passwordField = document.getElementById("new_password");
            let cpasswordField = document.getElementById("confirm_password");
            let togglePassword1 = document.getElementById("togglePassword1");
            let togglePassword2 = document.getElementById("togglePassword2");
            let icon1 = togglePassword1.querySelector("i");
            let icon2 = togglePassword2.querySelector("i");

            // Initially hide the eye icons
            togglePassword1.style.display = "none";
            togglePassword2.style.display = "none";

            // Show the icon when typing
            passwordField.addEventListener("input", function () {
                togglePassword1.style.display = passwordField.value.length > 0 ? "block" : "none";
            });

            cpasswordField.addEventListener("input", function () {
                togglePassword2.style.display = cpasswordField.value.length > 0 ? "block" : "none";
            });

            // Toggle password visibility
            togglePassword1.addEventListener("click", function () {
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    icon1.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
                } else {
                    passwordField.type = "password";
                    icon1.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
                }
            });

            togglePassword2.addEventListener("click", function () {
                if (cpasswordField.type === "password") {
                    cpasswordField.type = "text";
                    icon2.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
                } else {
                    cpasswordField.type = "password";
                    icon2.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
                }
            });

            // Password validation on submit
            document.getElementById("passwordResetForm").addEventListener("submit", function (event) {
                let password = passwordField.value;
                let confirmPassword = cpasswordField.value;
                let passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

                if (!passwordPattern.test(password)) {
                    alert(
                        "Password must be at least 8 characters long and include at least one number, one uppercase letter, and one lowercase letter."
                    );
                    event.preventDefault();
                    return;
                }

                if (password !== confirmPassword) {
                    alert("Passwords do not match.");
                    event.preventDefault();
                }
            });
        });
    </script>


</body>

</html>