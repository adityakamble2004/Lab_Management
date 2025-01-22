<?php
include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    $query = "UPDATE complaints SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $status, $complaint_id);
        if ($stmt->execute()) {
            echo "<script>alert('Complaint status updated successfully!'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating complaint status!'); window.location.href='admin_dashboard.php';</script>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
