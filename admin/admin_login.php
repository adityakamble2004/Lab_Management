<?php
session_start();
include('../database/connection.php');


if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($password)) {
        $error = "Both username and password are required!";
    } else {
       
        $sql = "SELECT * FROM teachers WHERE username = ? AND role = 'Admin'";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['admin_id'] = $user['teacher_id'];
                    $_SESSION['admin_username'] = $user['username'];
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "User not found or not an admin!";
            }

            $stmt->close();
        } else {
            $error = "Failed to prepare the database query!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input, .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
