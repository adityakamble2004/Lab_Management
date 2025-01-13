<?php
session_start();
require 'vendor/autoload.php'; // Ensure you have installed PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection details
$host = "localhost";
$db_user = "root"; // Default XAMPP username
$db_password = ""; // Default XAMPP password
$dbname = "college"; // Change to your database name

// Connect to the MySQL database
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate user input
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
            // Start session and store user data
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['roll_no'] = $user['roll_no'];



            


            // Redirect to the homepage
            // header('Location: ../home_page_complaint_site.php');
            // exit;
            
            $sql = "SELECT email FROM users WHERE roll_no = '$roll_no'";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                echo $email;
            } else {
                $email = null; // Set email to null if no result is found or query fails
                echo "Error: " . $conn->error; // Display the error message
            }

            $otp = rand(100000, 999999);

        // Store OTP in the session
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // Configure SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'droptechnologyes@gmail.com'; // Your Gmail address
            $mail->Password = 'bqqg txyj cevp ogzg'; // Your Gmail password or App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
            $mail->Port = 587;

            // Specify sender and recipient
            $mail->setFrom('droptechnologyes@gmail.com', 'Drop Technology');
            $mail->addAddress($email); // Recipient's email

            // Email content
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP is: $otp";

            // Send the email
            if ($mail->send()) {
                echo "OTP sent successfully to $email! Redirecting to OTP verification page...";
                // Redirect to OTP verification page after 2 seconds
                header("refresh:2; url=otp_verification.html");
                exit();
            } else {
                echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            // Catch PHPMailer exceptions and display errors
            echo "Message could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
        } catch (\Throwable $e) {
            // Handle any unexpected errors
            echo "An unexpected error occurred: " . $e->getMessage();
        }



        } else {
            echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
