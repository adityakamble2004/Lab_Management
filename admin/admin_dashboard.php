<?php
// Dynamic Greeting Message
session_start();
include('../database/connection.php');

$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #007bff;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php echo "$greeting ";?>
    </div>
    
    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="manage_complaints.php">📌 Complaints</a>
        <a href="manage_technicians.php">👷 Technicians</a>
        <a href="manage_computer.php">💻computers</a>
        <a href="computer_list.php">📊 Reports</a>
        <a href="manage_users.php">👩‍🎓 Users</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
    
    <div class="content">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Manage system operations efficiently from this panel.</p>
    </div>
</body>
</html>
