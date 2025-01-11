<?php
session_start();
// Start session
$conn = new mysqli("localhost", "root", "", "college");

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Check if the user is logged in
if (!isset($_SESSION['roll_no'])) {
    die("User not logged in!");
}

// Retrieve the logged-in user's ID
$user_id = $_SESSION['roll_no'];

// Check if form data has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form inputs
    $name = trim($_POST['name']);
    $class = trim($_POST['class']);
    $subjects = trim($_POST['subjects']);
    $email = trim($_POST['email']);
    $profile_image = $_FILES['profile_image'];

    // Validate input fields
    if (empty($name) || empty($class) || empty($subjects) || empty($email)) {
        die("Please fill in all required fields!");
    }

    // Handle file upload if a new profile image is provided
    $profile_image_path = null;
    if (!empty($profile_image['name'])) {
        $upload_dir = 'uploads/';
        $profile_image_path = $upload_dir . basename($profile_image['name']);

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($profile_image['tmp_name'], $profile_image_path)) {
            die("Error uploading profile image.");
        }
    }

    // Update the user's details in the database
    $query = "UPDATE users SET name = ?, class = ?, subjects = ?, email = ?";
    if ($profile_image_path) {
        $query .= ", photo = ?";
    }
    $query .= " WHERE roll_no = ?";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Debug: Check if prepare() failed
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    if ($profile_image_path) {
        $stmt->bind_param("sssssi", $name, $class, $subjects, $email, $profile_image_path, $user_id);
    } else {
        $stmt->bind_param("ssssi", $name, $class, $subjects, $email, $user_id);
    }

    // Execute the query
    if ($stmt->execute()) {
        echo "User details updated successfully!";
        // Redirect to the profile page or display a success message
        header("Location: user_profile.php");
        exit;
    } else {
        echo "Error updating user details: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
