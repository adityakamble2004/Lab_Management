<?php
session_start();
include '../database/connection.php'; // Database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is logged in (Replace with actual admin authentication)
// if (!isset($_SESSION['admin_id'])) {
//     die("Access Denied. Please login as admin.");
// }

// Approve technician
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $stmt = $conn->prepare("UPDATE technicians SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_technicians.php");
    exit();
}

// Reject technician
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $stmt = $conn->prepare("DELETE FROM technicians WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_technicians.php");
    exit();
}

// Fetch pending technicians
$stmt = $conn->prepare("SELECT id, name, email FROM technicians WHERE status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Technicians</title>
    <link rel="stylesheet" href="../styles/admin.css">

    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 500px;
}

h2 {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

.approve-btn {
    background-color: green;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
}

.reject-btn {
    background-color: red;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Technician Approval</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="?approve=<?= $row['id']; ?>" class="approve-btn">Approve</a>
                        <a href="?reject=<?= $row['id']; ?>" class="reject-btn">Reject</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
