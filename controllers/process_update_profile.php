<?php
// session_start();
include '../config.php';

$admin = new Admin();

if (isset($_POST['c_name'], $_POST['c_email'], $_POST['c_phone']) && isset($_SESSION['c_id'])) {
    $id = $_SESSION['c_id'];
    $name = $_POST['c_name'];
    $email = $_POST['c_email'];
    $phone = $_POST['c_phone'];
    $address = $_POST['c_address'];

    $admin->cud("UPDATE customer SET c_name='$name', c_email='$email', c_phone='$phone', c_address='$address' WHERE c_id='$id'", "updated");
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Updating Profile...</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            html,
            body {
                margin: 0;
                padding: 0;
                height: 100%;
                background: transparent;
            }

            .spinner {
                width: 40px;
                height: 40px;
                border: 4px solid rgba(0, 0, 0, 0.1);
                border-top-color: #333;
                border-radius: 50%;
                animation: spin 0.6s linear infinite;
                margin: 20px auto;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>

    <body>
        <script>
            // Trigger animation immediately once page loads
            window.onload = function () {
                Swal.fire({
                    html: '<div class="spinner"></div><div style="margin-top:10px;">Updating your profile...</div>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    width: 220,
                    padding: '1.5em',
                    background: 'rgba(255,255,255,0.95)',
                    color: '#000',
                    backdrop: 'rgba(0,0,0,0.3)', // semi-transparent dark overlay
                    position: 'center'
                });

                // Smooth redirect after delay
                setTimeout(() => {
                    window.location.href = "../profile.php";
                }, 1200); // Slightly longer delay to feel natural
            }
        </script>
    </body>

    </html>
    <?php
    exit;
} else {
    echo "Invalid access.";
}