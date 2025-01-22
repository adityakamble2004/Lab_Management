<?php
session_start();
include('../database/connection.php');

$query = "SELECT c.id, c.issue_description, c.status, c.created_at, u.name, comp.lab_name, comp.computer_no 
          FROM complaints c
          JOIN users u ON c.user_id = u.id
          JOIN computers comp ON c.computer_id = comp.id";
$result = $conn->query($query);

echo "<h2>All Complaints</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<p>User: {$row['name']}</p>";
    echo "<p>Lab: {$row['lab_name']}, Computer: {$row['computer_no']}</p>";
    echo "<p>Issue: {$row['issue_description']}</p>";
    echo "<p>Status: {$row['status']}</p>";
    echo "<form action='update_complaint_status.php' method='POST'>
            <input type='hidden' name='complaint_id' value='{$row['id']}'>
            <select name='status'>
                <option value='Pending' " . ($row['status'] === 'Pending' ? 'selected' : '') . ">Pending</option>
                <option value='Resolved' " . ($row['status'] === 'Resolved' ? 'selected' : '') . ">Resolved</option>
            </select>
            <button type='submit'>Update</button>
          </form>";
    echo "<hr>";
}
?>
