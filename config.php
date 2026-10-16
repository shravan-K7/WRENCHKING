<?php
/**
 * WrenchKing Configuration & Environment Loader
 */

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==========================================
// Load Environment Variables (.env)
// ==========================================
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($envKey, $envVal) = explode('=', $line, 2);
            $envKey = trim($envKey);
            $envVal = trim($envVal);
            // Strip matching surrounding quotes if present
            if ((str_starts_with($envVal, '"') && str_ends_with($envVal, '"')) ||
                (str_starts_with($envVal, "'") && str_ends_with($envVal, "'"))) {
                $envVal = substr($envVal, 1, -1);
            }
            putenv("$envKey=$envVal");
            $_ENV[$envKey] = $envVal;
            $_SERVER[$envKey] = $envVal;
        }
    }
}

if (!function_exists('env')) {
    function env($key, $default = '') {
        $val = getenv($key);
        if ($val !== false) {
            return $val;
        }
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
        return $default;
    }
}

// ==========================================
// Database Configuration
// ==========================================
define('DB_SERVER', env('DB_SERVER', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_DATABASE', env('DB_DATABASE', 'wrenchking'));
define('DB_PASSWORD', env('DB_PASSWORD', ''));
define('DB_TYPE', env('DB_TYPE', 'mysql'));

// ==========================================
// Razorpay Credentials
// ==========================================
define('RAZORPAY_KEY_ID', env('RAZORPAY_KEY_ID', ''));
define('RAZORPAY_KEY_SECRET', env('RAZORPAY_KEY_SECRET', ''));

// ==========================================
// SMTP / PHPMailer Credentials
// ==========================================
define('SMTP_HOST', env('SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_PORT', (int) env('SMTP_PORT', 587));
define('SMTP_SECURE', env('SMTP_SECURE', 'tls'));
define('SMTP_USERNAME', env('SMTP_USERNAME', ''));
define('SMTP_PASSWORD', env('SMTP_PASSWORD', ''));
define('SMTP_FROM_EMAIL', env('SMTP_FROM_EMAIL', ''));
define('SMTP_FROM_NAME', env('SMTP_FROM_NAME', 'WrenchKing'));

// ==========================================
// Site Details
// ==========================================
define('SITE_TITLE', 'WrenchKing');
define('SITE_TAG_LINE', 'Auto Repair & Service Center');
define('SITE_CONTACT', '9876543210');
define('SITE_EMAIL_INFO', SMTP_FROM_EMAIL);
define('BASE_URL', 'http://localhost/WRENCHKING/');

// Included main classes
require_once __DIR__ . '/app/Main.php';
require_once __DIR__ . '/app/Controller.php';
require_once __DIR__ . '/app/Admin.php';

$admin = new Admin();

$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}