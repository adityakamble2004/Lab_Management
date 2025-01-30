<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        .actions a {
            margin-right: 10px;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <?php
    
    include('../database/connection.php');

    // data retrive
    $sql = "SELECT id, roll_no, asset_id, issue_description, status, created_at, resolved_at, selected_problems, email FROM complaints ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Roll No</th>
                    <th>Asset ID</th>
                    <th>Issue Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Resolved At</th>
                    <th>Selected Problems</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['roll_no']}</td>
                    <td>{$row['asset_id']}</td>
                    <td>{$row['issue_description']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                    <td>{$row['resolved_at']}</td>
                    <td>{$row['selected_problems']}</td>
                    <td>{$row['email']}</td>
                    <td class='actions'>
                        <a href='update_complaint.php?id={$row['id']}&status=In Progress'>Mark In Progress</a> |
                        <a href='update_complaint.php?id={$row['id']}&status=Resolved'>Mark Resolved</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='no-data'>No complaints found.</div>";
    }

    $conn->close();
    ?>

</body>
</html>
