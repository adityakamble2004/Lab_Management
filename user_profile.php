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

// Retrieve user details
$user_id = $_SESSION['user_name']['user_id']; // Assuming user_id is stored in the session after login
$query = "SELECT * FROM user_name WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .profile-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
        }
        .profile-details {
            margin-top: 20px;
            text-align: left;
        }
        .profile-details label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        .profile-details input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-container {
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <!-- User Image -->
    <img src="<?= htmlspecialchars($user['photo']) ?>" alt="Profile Image" class="profile-img" id="profileImage">

    <!-- Profile Details -->
    <div class="profile-details">
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label for="roll_no">Roll No</label>
            <input type="text" id="roll_no" name="roll_no" value="<?= htmlspecialchars($user['roll_no']) ?>" readonly>

            <label for="class">Class</label>
            <input type="text" id="class" name="class" value="<?= htmlspecialchars($user['class']) ?>" required>

            <label for="subjects">Subjects</label>
            <input type="text" id="subjects" name="subjects" value="<?= htmlspecialchars($user['subjects']) ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="profile_image">Profile Image</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">

            <!-- Submit Button -->
            <div class="btn-container">
                <button type="submit" class="btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
