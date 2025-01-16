<?php
// Include database connection
include('../database/connection.php');

// Check if the 'id' is provided in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query to delete the computer record
    $query = "DELETE FROM computers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to the list page after deletion
        header("Location: computer_list.php"); // or wherever your table is displayed
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No ID provided for deletion.";
}

// Close the database connection
$conn->close();
?>
