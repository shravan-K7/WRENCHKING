<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Service Provider</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="./assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- End layout styles -->

    <!-- Favicon -->
    <link rel="icon" href="favicon_io/favicon.ico">
</head>

<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-12 col-sm-8 col-md-6 col-lg-4 mx-auto" style="border-radius: 15px;">
                        <div class="card-body px-4 px-sm-5 py-5">
                            <h3 class="card-title text-center mb-3">Service Provider Login</h3>
                            <form method="POST" action="./controllers/auth.php">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" class="form-control p_input text-white" required
                                        placeholder="enter your email">
                                </div>
                                <div class="form-group">
                                    <label>Password *</label>
                                    <div class="input-group">
                                        <input type="text" id="password" name="password"
                                            class="form-control p_input text-white" placeholder="enter your password"
                                            required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="togglePassword()"
                                                style="cursor: pointer;">
                                                <i class="mdi mdi-eye-off text-white" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" name="login"
                                        class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="./assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="./assets/js/off-canvas.js"></script>
    <script src="./assets/js/hoverable-collapse.js"></script>
    <script src="./assets/js/misc.js"></script>
    <script src="./assets/js/settings.js"></script>
    <script src="./assets/js/todolist.js"></script>
    <!-- endinject -->

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "text") {
                passwordInput.type = "password";
                toggleIcon.classList.remove("mdi-eye-off");
                toggleIcon.classList.add("mdi-eye");
            } else {
                passwordInput.type = "text";
                toggleIcon.classList.remove("mdi-eye");
                toggleIcon.classList.add("mdi-eye-off");
            }
        }
    </script>


</body>

</html>