<?php
session_start();
include('../database/connection.php');
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
            background-color: #f4f4f9;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        nav {
            background-color: #444;
            padding: 10px;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        h1 {
            color: rgb(32, 103, 179);;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
    </header>

    <nav>
        <a href="computer_list.php">Manage Computers</a>
        <a href="teacher_list.php">Manage Teachers</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Use the links above to manage the system.</p>
        <h3>Quick Actions:</h3>
        <button onclick="location.href='add_computer_form.php'">Add New Computer</button>
        <button onclick="location.href='add_teacher_form.php'">Add New Teacher</button>
    </div>

    <div class="allwork">
        <ul>
            <li><a href="insert_computer.php">insert computers </a></li>
            <li><a href="computer_list.php">computer list</a></li>
            <li><a href="update_complaint.php">Upate complain</a></li>
            <li><a href=""></a></li>
            <li><a href=""></a></li>
            <li><a href=""></a></li>
            <li><a href=""></a></li>
        </ul>
    </div>
</body>
</html>
