<?php
session_start();
include('../database/connection.php');

$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session.

$query = "SELECT c.id, c.issue_description, c.status, c.created_at, comp.lab_name, comp.computer_no 
          FROM complaints c
          JOIN computers comp ON c.computer_id = comp.id
          WHERE c.user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Your Complaints</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<p>Lab: {$row['lab_name']}, Computer: {$row['computer_no']}</p>";
        echo "<p>Issue: {$row['issue_description']}</p>";
        echo "<p>Status: {$row['status']}</p>";
        echo "<p>Date: {$row['created_at']}</p>";
        echo "<hr>";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
