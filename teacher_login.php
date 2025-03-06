<?php
session_start();
include('database/connection.php');

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Please enter both email and password.";
    } else {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try {
            // Fetch user from database using email
            $stmt = $conn->prepare("SELECT teacher_id, email, password_hash, role FROM teachers WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }
            
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                throw new Exception("Query execution failed.");
            }

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                // Verify password
                if (password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['teacher_id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect based on role
                    if ($user['role'] == 'Admin') {
                        header("Location: admin/admin_dashboard.php");
                    } else {
                        header("Location: teacher/teacher_dashboard.php");
                    }
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "No user found with that email!";
            }
        } catch (Exception $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Login Container */
        .login-container {
            background: #ffffff;
            padding: 20px;
            width: 350px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        /* Heading */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Error Message */
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        /* Labels */
        label {
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Input Fields */
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit Button */
        button {
            background: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)) { echo "<p class='error-message'>$error</p>"; } ?>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
