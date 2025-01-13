<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];

    if ($enteredOtp == $_SESSION['otp']) {
        echo "Login successful! Welcome, " . $_SESSION['email'];
        unset($_SESSION['otp']); // Clear OTP after successful login
        header('Location: ../home_page_complaint_site.php');

    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
