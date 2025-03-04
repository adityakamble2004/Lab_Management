<?php
session_start();
if (!isset($_SESSION['technician_id'])) {
    header("Location: ../login.php"); // Redirect if not logged in
    exit();
}

include '../database/connection.php';

$tech_id = $_SESSION['technician_id'];

// Fetch Technician Details
$query = "SELECT name, email FROM technicians WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tech_id);
$stmt->execute();
$result = $stmt->get_result();
$technician = $result->fetch_assoc();
$stmt->close();

// Fetch Assigned Complaints Count
$complaintQuery = "SELECT COUNT(*) AS assigned_complaints FROM complaints WHERE technician_id = ?";
$stmt2 = $conn->prepare($complaintQuery);
$stmt2->bind_param("i", $tech_id);
$stmt2->execute();
$complaintResult = $stmt2->get_result();
$complaintData = $complaintResult->fetch_assoc();
$assigned_complaints = $complaintData['assigned_complaints'];
$stmt2->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Profile</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <style>
        /* Profile Container */
.profile-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
}

/* Profile Card */
.profile-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 600px;
    text-align: justify;
}

.profile-card h2 {
    margin-bottom: 10px;

}

.profile-card p {
    font-size: 1.1rem;
    margin: 8px 0;
}

.logout-btn {
    display: inline-block;
    background: #dc3545;
    color: white;
    padding: 10px 15px;
    margin-top: 15px;
    text-decoration: none;
    border-radius: 5px;
}

.logout-btn:hover {
    background: #c82333;
}

    </style>
</head>
<body>

<?php include 'asset/header.php'; ?> <!-- Include header for navigation -->

<div class="profile-container">
    <div class="profile-card">
        <h2>👨‍🔧 Technician Profile</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($technician['name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($technician['email']); ?></p>
        <p><strong>Assigned Complaints:</strong> <?= $assigned_complaints; ?></p>
        <a href="../logout.php" class="logout-btn">🚪 Logout</a>
    </div>
</div>

</body>
</html>
