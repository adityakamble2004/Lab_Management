<?php
    session_start();

   include('../database/connection.php');
   //php mailer
  
   require 'vendor/autoload.php';

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($name) && !empty($email) && !empty($password)) {

        $_SESSION['roll_no']=$roll_no ;
        $_SESSION['name']= $name ;
        $_SESSION['email']=$email ;
        $_SESSION['password']= $password;

        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo "user had all ready registerd ";
            header("refresh:2; url=login.html");

        } else {
            
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

                $mail->Subject = 'Ragistration related ';
                $mail->Body = " well come dear $name on our website Your OTP is: $otp";

                if ($mail->send()) {
                    echo "OTP sent successfully to $email! Redirecting to OTP verification page...";
                    header("refresh:2; url=sendotp.html");
                    exit();
                } else {
                    echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. PHPMailer Error: {$mail->ErrorInfo}";
            }



        }
        
    } else {
        echo "All fields are required!";
    }
}
$conn->close();
?>

