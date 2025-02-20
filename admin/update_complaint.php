<?php
include('../database/connection.php');



$id = $_GET['id'];
$status = $_GET['status'];

if ($status == 'Resolved') {
    $sql = "UPDATE complaints SET status = 'Resolved', resolved_at = NOW() WHERE id = ?";
} else {
    $sql = "UPDATE complaints SET status = ? WHERE id = ?";
}

$stmt = $conn->prepare($sql);
if ($status == 'Resolved') {
    $stmt->bind_param('i', $id);
} else {
    $stmt->bind_param('si', $status, $id);
}

if ($stmt->execute()) {
    echo "Complaint updated successfully.";
} else {
    echo "Error updating complaint: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: admin_complaints.php");
?>
