<?php
session_start();

// Database connection details
$host = "localhost";
$db_user = "root"; // Default XAMPP username
$db_password = ""; // Default XAMPP password
$dbname = "college"; // Database name

// Connect to the database
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$su= $_SESSION['user_name'];

// Retrieve user details
$query = "SELECT * FROM users WHERE roll_no =  ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Handle form submission to update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $class = trim($_POST['class']);
    $subjects = trim($_POST['subjects']);
    $email = trim($_POST['email']);

    // Handle profile image upload
    $photo = $user['photo']; // Default to existing photo
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $upload_dir = "uploads/";
        $photo = $upload_dir . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $photo);
    }

    // Update user details in the database
    $update_query = "UPDATE users SET name = ?, class = ?, subjects = ?, email = ?, photo = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssi", $name, $class, $subjects, $email, $photo, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
}

$stmt->close();
$conn->close();
?>
