<?php
session_start();
include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($username) || empty($password)) {
        echo "<script>alert('Both username and password are required!'); window.location.href='admin_login.html';</script>";
        exit;
    }

    // Query to check admin login credentials
    $query = "SELECT * FROM teachers WHERE username = ? AND role = 'Admin'";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['role'] = $admin['role'];

                // Redirect to admin dashboard
                header('Location: admin_dashboard.php');
                exit();
            } else {
                echo "<script>alert('Invalid password!'); window.location.href='admin_login.html';</script>";
            }
        } else {
            echo "<script>alert('Invalid username or not an admin user!'); window.location.href='admin_login.html';</script>";
        }

        $stmt->close();
    } else {
        echo "Error preparing query: " . $conn->error;
    }
} else {
    echo "<script>alert('Invalid request method!'); window.location.href='admin_login.html';</script>";
}

$conn->close();
?>
