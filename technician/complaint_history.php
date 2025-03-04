<?php
session_start();
if (!isset($_SESSION['technician_id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

include '../database/connection.php';

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$tech_id = $_SESSION['technician_id'];

// Fetch resolved complaints assigned to the technician
$query = "SELECT id, roll_no, asset_id, computer_id, issue_description, resolution_note, resolved_at 
          FROM complaints 
          WHERE technician_id = ? AND status = 'Resolved' 
          ORDER BY resolved_at DESC";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $tech_id);

if (!$stmt->execute()) {
    die("Query execution failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Error fetching results: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint History</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>

    
    <?php include 'asset/header.php'; ?> <!-- Include navigation header -->
    <?php include 'all_done_worksphp.php'; ?> <!-- Include navigation header -->

</body>
</html>
