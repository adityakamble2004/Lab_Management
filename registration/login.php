<?php
session_start();
include('connection.php')

// Connect to SQLite database
try {
    $pdo = new PDO('sqlite:complaints.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Validate user input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Both fields are required!'); window.location.href='login.html';</script>";
        exit;
    }

    // Query to check user details
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // User authenticated, redirect to the homepage
        $_SESSION['user'] = $user;
        header('Location: home_page_complaint_site.html');
        exit;
    } else {
        echo "<script>alert('Invalid username or password!'); window.location.href='login.html';</script>";
        exit;
    }
}
?>
