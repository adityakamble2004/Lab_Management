<?php
if (!isset($_SESSION['technician_id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

// Fetch technician details (Assuming you have a DB connection)
include '../database/connection.php';
$tech_id = $_SESSION['technician_id'];
$query = "SELECT name, email FROM technicians WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tech_id);
$stmt->execute();
$result = $stmt->get_result();
$technician = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css"> <!-- External CSS -->
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    margin: 0;
    padding-top: 60px; /* To prevent content from being hidden under header */
}

/* Header */
header {
    background: #343a40;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

/* Logo */
.logo {
    font-size: 1.5rem;
    font-weight: bold;
}

/* Navigation Menu */
nav ul {
    list-style: none;
    display: flex;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-size: 1rem;
    padding: 8px 15px;
    transition: background 0.3s ease;
}

nav ul li a:hover {
    background: #007bff;
    border-radius: 5px;
}

/* Logout Button */
.logout-btn {
    background: #dc3545;
    padding: 8px 15px;
    border-radius: 5px;
}

.logout-btn:hover {
    background: #c82333;
}

    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="logo">Technician Dashboard</div>
    <nav>
        <ul>
            <li><a href="profile.php">👤 Profile</a></li>
            <li><a href="filter_complaints.php"> Filter Complaints</a></li>
            <li><a href="complaint_history.php"> Complaint History</a></li>
            <li><a href="reports.php"> Reports</a></li>
            <li><a href="../logout.php" class="logout-btn"> Logout</a></li>
        </ul>
    </nav>
</header>
