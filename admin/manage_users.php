<?php
// Start session and include database connection
session_start();
include('../database/connection.php');

// Fetch users data from the database
$sql = "SELECT * FROM users ORDER BY user_id ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Header Styling */
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            margin-left: 15px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        /* Table Styling */
        .container {
            width: 95%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Header with Go Back Button -->
    <div class="header">
        <a href="admin_dashboard.php" class="btn-back">⬅ Go Back</a>
        📌 Manage Users
        <div></div> <!-- Placeholder for flex alignment -->
    </div>

    <!-- Main Container -->
    <div class="container">
        <h2>All Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Roll No</th>
                <th>Class</th>
                <th>Subjects</th>
                <th>Email</th>
                <th>Verified</th>
                <th>Actions</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>";
                    if (!empty($row['photo'])) {
                        echo "<img src='" . $row['photo'] . "' class='profile-img'>";
                    } else {
                        echo "<img src='default_profile.png' class='profile-img'>";
                    }
                    echo "</td>";
                    echo "<td>" . ($row['name'] ? $row['name'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['roll_no'] ? $row['roll_no'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['class'] ? $row['class'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['subjects'] ? $row['subjects'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['email'] ? $row['email'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['is_verified'] ? '✅ Yes' : '❌ No') . "</td>";
                    echo "<td>
                        <a href='view_user.php?user_id=" . $row['user_id'] . "' class='btn btn-view'>View</a>
                        <a href='delete_user.php?user_id=" . $row['user_id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' style='text-align:center;'>No users found</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
