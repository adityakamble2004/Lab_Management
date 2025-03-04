<?php
session_start();
include '../database/connection.php'; // Database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Basic validation
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        die("Invalid name. Only alphabets and spaces allowed.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if (strlen($password) < 6) {
        die("Password must be at least 6 characters.");
    }

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM technicians WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Error: Email already registered.");
    }
    $check_stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert technician into database (Pending Admin Approval)
    $stmt = $conn->prepare("INSERT INTO technicians (name, email, password, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful! Waiting for admin approval.";
    } else {
        echo "Error registering technician: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>