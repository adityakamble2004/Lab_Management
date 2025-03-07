<?php
// Start session and include database connection
session_start();
include('../database/connection.php');

// Dynamic Greeting Message
$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}

// Dummy admin name (Replace with session value if available)
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';

// Fetch Data from Database
$complaints = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM complaints"))['count'];
$technicians = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM technicians"))['count'];
$teachers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM teachers"))['count'];
$users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$computers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM computers"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
        }

        /* Header Styling */
        .header {
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        /* Sidebar Styling */
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
            font-size: 16px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #007bff;
            padding-left: 20px;
        }

        /* Main Content */
        .content {
            margin-left: 260px;
            margin-top: 60px;
            padding: 20px;
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            flex: 1;
            min-width: 250px;
            text-align: center;
        }
        .card h3 {
            margin: 10px 0;
            color: #007bff;
        }
        .card p {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .card a {
            display: block;
            margin-top: 10px;
            padding: 8px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .card a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="manage_complaints.php">📌 Complaints</a>
        <a href="manage_technicians.php">👷 Technicians</a>
        <a href="manage_teachers.php">👨‍🏫 Teachers</a>
        <a href="manage_users.php">👩‍🎓 Users</a>
        <a href="computer_list.php">💻 Computers</a>
        <a href="computer_list.php">📊 Reports</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <!-- Header -->
    <div class="header">
        <?php echo "$greeting, $admin_name!"; ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Manage system operations efficiently from this panel.</p>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <h3>📌 Total Complaints</h3>
                <p><?php echo $complaints; ?></p>
                <a href="complaints.php">View Complaints</a>
            </div>
            <div class="card">
                <h3>👷 Active Technicians</h3>
                <p><?php echo $technicians; ?></p>
                <a href="manage_technicians.php">View Technicians</a>
            </div>
            <div class="card">
                <h3>👨‍🏫 Registered Teachers</h3>
                <p><?php echo $teachers; ?></p>
                <a href="manage_teachers.php">View Teachers</a>
            </div>
            <div class="card">
                <h3>👩‍🎓 Registered Users</h3>
                <p><?php echo $users; ?></p>
                <a href="manage_users.php">View Users</a>
            </div>
            <div class="card">
                <h3>💻 Registered Computers</h3>
                <p><?php echo $computers; ?></p>
                <a href="computer_list.php">View Computers</a>
            </div>
        </div>
    </div>

</body>
</html>
