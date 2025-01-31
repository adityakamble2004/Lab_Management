<?php
session_start();
include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = trim($_POST['otp']);

    if (isset($_SESSION['otp']) && $enteredOtp == $_SESSION['otp']) {
        echo "Login successful! Welcome, " . $_SESSION['email'];
        unset($_SESSION['otp']);

         $roll_no= $_SESSION['roll_no'] ;
         $name=$_SESSION['name'] ;
         $email=$_SESSION['email'] ;
         $password=$_SESSION['password'];
         $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // header('Location: ../home_page_complaint_site.php');
        $stmt = $conn->prepare("INSERT INTO users (roll_no,name, email, password) VALUES (?,?, ?, ?)");
        $stmt->bind_param("ssss",$roll_no, $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
            sleep(2);
            header("Location:login.html");

        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
        
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
       

    }
}
?>