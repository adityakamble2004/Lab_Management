<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = trim($_POST['otp']);

    if (isset($_SESSION['otp']) && $enteredOtp == $_SESSION['otp']) {
        echo "Login successful! Welcome, " . $_SESSION['email'];
        unset($_SESSION['otp']);
        header('Location: ../home_page_complaint_site.php');
        
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
