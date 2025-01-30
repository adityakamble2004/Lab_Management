<?php
session_start();
include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $lab_in_charge = trim($_POST['lab_in_charge']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'Admin'; 

    $errors = [];

    
    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email is required.";
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT); 

        // Check  the username or email already exists or not
        $check_sql = "SELECT * FROM teachers WHERE username = ? OR email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $errors[] = "Username or email is already in use.";
        } else {
            // Insert qoery admin details into the database
            $sql = "INSERT INTO teachers (name, email, phone_number, lab_in_charge, username, password_hash, role) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $name, $email, $phone_number, $lab_in_charge, $username, $password_hash, $role);

            if ($stmt->execute()) {
                echo "<script>alert('Admin registered successfully!'); window.location.href='admin_login.php';</script>";
                exit;
            } else {
                $errors[] = "Database error: Unable to register.";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
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
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Signup</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            <input type="text" name="phone_number" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone_number ?? ''); ?>">
            <input type="text" name="lab_in_charge" placeholder="Lab In-Charge" value="<?php echo htmlspecialchars($lab_in_charge ?? ''); ?>">
            <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
