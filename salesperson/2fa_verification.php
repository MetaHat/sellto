<?php
include '../config/_config.php';
require '../config/smtp_settings.php';

if (!isset($_SESSION['temp_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['otp'] == $_SESSION['otp']) {
        $_SESSION['salesperson_id'] = $_SESSION['temp_user'];
        unset($_SESSION['temp_user'], $_SESSION['otp']);
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid OTP!";
    }
} else {
    $_SESSION['otp'] = rand(100000, 999999);
    sendEmail($_SESSION['temp_email'], "Your OTP", "Your OTP is " . $_SESSION['otp']);
}
?>
