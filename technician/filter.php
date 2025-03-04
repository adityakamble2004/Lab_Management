<?php
session_start();
include '../database/connection.php'; // Ensure this file contains $conn for DB connection

// Check if the technician is logged in
if (!isset($_SESSION['technician_id'])) {
    header("Location: ../login.php");
    exit();
}

$technician_id = $_SESSION['technician_id'];
$filters = [];
$params = [];
$query = "SELECT c.id, c.issue_description, u.name AS student_name, c.status, c.resolution_note, c.asset_id, c.computer_id 
          FROM complaints c 
          JOIN users u ON c.roll_no = u.roll_no 
          WHERE c.technician_id = ?";
$params[] = $technician_id;

// Filtering logic
if (!empty($_GET['status'])) {
    $filters[] = "c.status = ?";
    $params[] = $_GET['status'];
}
if (!empty($_GET['asset_id'])) {
    $filters[] = "c.asset_id = ?";
    $params[] = $_GET['asset_id'];
}
if (!empty($_GET['computer_id'])) {
    $filters[] = "c.computer_id = ?";
    $params[] = $_GET['computer_id'];
}

// Append filters if any exist
if (!empty($filters)) {
    $query .= " AND " . implode(" AND ", $filters);
}

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat("s", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Complaints</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <div class="container">
        <h2>Filter Complaints</h2>
        <form method="GET">
            <label for="status">Status:</label>
            <select name="status">
                <option value="">All</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
                <option value="Pending">Pending</option>
            </select>
            <label for="asset_id">Asset ID:</label>
            <input type="text" name="asset_id" placeholder="Enter Asset ID">
            <label for="computer_id">Computer ID:</label>
            <input type="text" name="computer_id" placeholder="Enter Computer ID">
            <button type="submit">Filter</button>
        </form>

        <table>
            <tr>
                <th>Complaint ID</th>
                <th>Description</th>
                <th>Student</th>
                <th>Status</th>
                <th>Resolution Note</th>
                <th>Asset ID</th>
                <th>Computer ID</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['issue_description']); ?></td>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= htmlspecialchars($row['resolution_note'] ?? "No notes added"); ?></td>
                    <td><?= htmlspecialchars($row['asset_id'] ?? "N/A"); ?></td>
                    <td><?= htmlspecialchars($row['computer_id'] ?? "N/A"); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
