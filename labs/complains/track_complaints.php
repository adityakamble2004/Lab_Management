<?php
// Start session to identify logged-in user
session_start();
include('../../database/connection.php');



// Check if user is logged in
if (!isset($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$roll_no = $_SESSION['roll_no'];

// Fetch complaints from the database for the logged-in user
$sql = "SELECT * FROM complaints WHERE roll_no = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roll_no);
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
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Track Your Complaints</h1>
    <p>Below is the list of complaints you have registered:</p>

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
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['asset_id']) ?></td>
                        <td><?= htmlspecialchars($row['issue_description']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No complaints found. <a href="file_complaint.php">Register a complaint</a>.</p>
    <?php endif; ?>

    <a href="../../home_page_complaint_site.php">Back to Dashboard</a>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
