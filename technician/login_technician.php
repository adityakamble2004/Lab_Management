<?php
session_start();
include '../database/connection.php'; // Ensure this file contains $conn for DB connection

// Error and success message variables
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if technician exists and is approved
        $stmt = $conn->prepare("SELECT id, password, status FROM technicians WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password, $status);
            $stmt->fetch();
            
            if ($status !== 'approved') {
                $error_message = "Your account is not approved by the admin yet.";
            } elseif (password_verify($password, $hashed_password)) {
                $_SESSION['technician_id'] = $id;
                header("Location: dashboard_technician.php");
                exit();
            } else {
                $error_message = "Invalid password.";
            }
        } else {
            $error_message = "No account found with this email.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Login</title>
    <link rel="stylesheet" href="../styles/technician.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background: white;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

input {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    width: 100%;
    border-radius: 5px;
}

button:hover {
    background-color: #218838;
}

.error {
    color: red;
    font-size: 14px;
    margin-bottom: 10px;
}

.success {
    color: green;
    font-size: 14px;
    margin-bottom: 10px;
}

</style>
<body>
    <div class="container">
        <h2>Technician Login</h2>

        <?php if (!empty($error_message)): ?>
            <p class="error"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <p class="success"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <form action="login_technician.php" method="POST">
            <input type="email" name="email" placeholder="Enter Your Email" required>
            <input type="password" name="password" placeholder="Enter Your Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
