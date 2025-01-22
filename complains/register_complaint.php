<?php
session_start();
include('../database/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session.
    $computer_id = $_POST['computer_id'];
    $issue_description = $_POST['issue_description'];

    $query = "INSERT INTO complaints (user_id, computer_id, issue_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("iis", $user_id, $computer_id, $issue_description);
        if ($stmt->execute()) {
            echo "<script>alert('Complaint registered successfully!'); window.location.href='track_complaint.php';</script>";
        } else {
            echo "<script>alert('Error registering complaint!'); window.location.href='register_complaint.php';</script>";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
