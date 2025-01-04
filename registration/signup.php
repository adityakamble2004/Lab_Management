<?php
session_start();
vendor/phpmailer/autoload.php; // Include PHPMailer library

$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "college"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password for security

    // Check if email already exists
    $checkEmail = "SELECT * FROM user_login WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email is already registered!";
    } else {
        // Insert user data into database
        $insertUser = "INSERT INTO user_login (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($insertUser) === TRUE) {
            // Generate OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            // Send OTP via email
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'droptechnologyes@gmail.com'; // Replace with your email
            $mail->Password = '@adi2004'; // Replace with your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your-email@gmail.com', 'Computer Lab Complaint Portal');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Signup';
            $mail->Body    = "<p>Your OTP for signup is <b>$otp</b>.</p>";

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                header("Location: verify_otp.php");
            }
        } else {
            echo "Error: " . $insertUser . "<br>" . $conn->error;
        }
    }
}
?>
