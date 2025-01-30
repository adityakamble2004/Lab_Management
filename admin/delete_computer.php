<?php
include('../database/connection.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM computers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        header("Location: computer_list.php"); 
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID provided for deletion.";
}

$conn->close();
?>
