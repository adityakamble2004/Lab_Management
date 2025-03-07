<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css"> <!-- Link your existing CSS file -->
    <title>Dashboard</title>
    <style>
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #343a40;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: background 0.3s ease;
        }

        .sidebar a:hover {
            background: #007BFF;
        }

        .sidebar a.active {
            background: #0056b3;
            font-weight: bold;
        }

        /* Content Wrapper */
        .content {
            margin-left: 260px; /* Adjust margin to accommodate sidebar width */
            padding: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 210px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="manage_complaints.php">📌 Complaints</a>
        <a href="manage_technicians.php">👷 Technicians</a>
        <a href="computer_list.php">💻 Computers</a>
        <a href="computer_list.php">📊 Reports</a>
        <a href="manage_users.php">👩‍🎓 Users</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <!-- The main content of the page will be displayed here -->
