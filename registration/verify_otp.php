<?php
session_start();

if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        echo "OTP verified successfully! You can now log in.";
        unset($_SESSION['otp']);
        unset($_SESSION['email']);
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .verify-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .verify-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .verify-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .verify-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .verify-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <h2>Verify OTP</h2>
        <form action="verify_otp.php" method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit" name="verify_otp">Verify</button>
        </form>
    </div>
</body>
</html>
