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
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 20px;
}

.container {
    width: 80%;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Header */
h2 {
    text-align: center;
    color: #333;
}

/* Messages */
.message {
    text-align: center;
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
}

.error {
    background: #ffdddd;
    color: #a00;
}

.success {
    background: #ddffdd;
    color: #0a0;
}

/* Filter Form */
.filter-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.filter-form select, .filter-form input {
    padding: 8px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    min-width: 150px;
}

.filter-form button {
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 14px;
}

.filter-form button:hover {
    background: #0056b3;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: #007bff;
    color: white;
}

td {
    background: #f9f9f9;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
        padding: 15px;
    }
    .filter-form {
        flex-direction: column;
        align-items: center;
    }
    .filter-form select, .filter-form input, .filter-form button {
        width: 100%;
    }
}

    </style>
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
        <button onclick="window.history.back();" style="margin-top: 20px; padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Go Back</button>
        <button onclick="window.location.href='dashboard_technician.php';" style="margin: 10px; padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Go to Dashboard</button>

    </body>
    </div>
</body>
</html>
