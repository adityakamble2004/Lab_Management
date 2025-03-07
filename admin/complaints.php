<?php
// Start session and include database connection
session_start();
include('../database/connection.php');

// Fetch complaints data from database
$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
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

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-resolved {
            color: green;
            font-weight: bold;
        }

        .status-in-progress {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header with Go Back Button -->
    <div class="header">
        <a href="admin_dashboard.php" class="btn-back">⬅ Go Back</a>
        📌 Manage Complaints
        <div></div> <!-- Placeholder for flex alignment -->
    </div>

    <!-- Main Container -->
    <div class="container">
        <h2>All Complaints</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Roll No</th>
                <th>Asset ID</th>
                <th>Issue</th>
                <th>Selected Problems</th>
                <th>Status</th>
                <th>Email</th>
                <th>Computer ID</th>
                <th>Technician ID</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Apply status-specific styling
                    $status_class = '';
                    if ($row['status'] == 'Pending') {
                        $status_class = 'status-pending';
                    } elseif ($row['status'] == 'Resolved') {
                        $status_class = 'status-resolved';
                    } elseif ($row['status'] == 'In Progress') {
                        $status_class = 'status-in-progress';
                    }

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['roll_no'] . "</td>";
                    echo "<td>" . $row['asset_id'] . "</td>";
                    echo "<td>" . $row['issue_description'] . "</td>";
                    echo "<td>" . $row['selected_problems'] . "</td>";
                    echo "<td class='$status_class'>" . $row['status'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . ($row['computer_id'] ? $row['computer_id'] : 'N/A') . "</td>";
                    echo "<td>" . ($row['technician_id'] ? $row['technician_id'] : 'Unassigned') . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>" . $row['updated_at'] . "</td>";
                    echo "<td>
                        <a href='view_complaint.php?id=" . $row['id'] . "' class='btn btn-view'>View</a>
                        <a href='delete_complaint.php?id=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this complaint?\")'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12' style='text-align:center;'>No complaints found</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
