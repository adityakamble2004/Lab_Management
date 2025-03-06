<?php
// session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <style>
        /* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #333;
    padding: 15px 20px;
    color: white;
}

/* Logo */
.logo h2 {
    margin: 0;
}

/* Navigation */
nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    padding: 8px 12px;
    transition: 0.3s;
}

nav ul li a:hover {
    background: #555;
    border-radius: 5px;
}

/* Logout Button */
.logout-btn {
    color: white;
    background: red;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 5px;
}

.logout-btn:hover {
    background: darkred;
}

/* Content Container */
.container {
    padding: 20px;
    margin-top: 20px;
}

    </style>
</head>
<body>

<!-- Navigation Bar -->
<header>
    <div class="logo">
        <h2>Dashboard</h2>
    </div>
    <nav>
        <ul>
            <li><a href="teacher_dashboard.php">Home</a></li>
            <li><a href="manage_computers.php">Manage Computers</a></li>
            <li><a href="file_complaint.php">File Complaint</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="logout">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<div class="container">
