<?php
include('../database/connection.php');

// Check if user is logged in
if (!isset($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's roll number
$roll_no = $_SESSION['roll_no'];

// Fetch complaints along with user details
$sql = "SELECT 
            c.id AS complaint_id, 
            c.asset_id, 
            c.issue_description, 
            c.status, 
            c.created_at, 
            u.name, 
            u.class, 
            u.subjects 
        FROM complaints c
        JOIN users u ON c.roll_no = u.roll_no
        WHERE c.roll_no = ?
        ORDER BY c.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $roll_no);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        tr:hover {
            background: #d6e4ff;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .pending { background: #ffc107; color: black; }
        .resolved { background: #28a745; color: white; }
        .in-progress { background: #17a2b8; color: white; }
    </style>
</head>
<body>

    <h2>Complaint Tracking</h2>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Complaint ID</th>
                        <th>Asset ID</th>
                        <th>Issue Description</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['complaint_id']) ?></td>
                            <td><?= htmlspecialchars($row['asset_id']) ?></td>
                            <td><?= htmlspecialchars($row['issue_description']) ?></td>
                            <td>
                                <span class="status 
                                    <?php 
                                        if ($row['status'] == 'Pending') echo 'pending'; 
                                        elseif ($row['status'] == 'Resolved') echo 'resolved'; 
                                        else echo 'in-progress';
                                    ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px; color: #777;">No complaints found.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
