<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = trim($_POST['roll_no']);
    $password = trim($_POST['password']);

    if (empty($roll_no) || empty($password)) {
        echo "<script>alert('Both fields are required!'); window.location.href='login.html';</script>";
        exit;
    }

    // Query to check user details
    $query = "SELECT * FROM users WHERE roll_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['roll_no'] = $user['roll_no'];
            $email = $user['email'];

            // Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Send OTP
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'droptechnologyes@gmail.com';
                $mail->Password = 'bqqg txyj cevp ogzg';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('droptechnologyes@gmail.com', 'Drop Technology');
                $mail->addAddress($email);

                $mail->Subject = 'Your OTP Code';
                $mail->Body = "Your OTP is: $otp";

                if ($mail->send()) {
                    echo "OTP sent successfully to $email! Redirecting to OTP verification page...";
                    header("refresh:2; url=otp_verification.html");
                    exit();
                } else {
                    echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
