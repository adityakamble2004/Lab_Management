<?php
session_start();
include('../database/connection.php');

// Check if roll_no is set in session
if (isset($_SESSION['roll_no'])) {
    $roll_no = $_SESSION['roll_no'];

    // Prepare the SQL query
    $sql = "SELECT name, email, class, subjects, photo FROM users WHERE roll_no = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and store user details
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        $class = $user['class'];
        $subjects = $user['subjects'];
        $photo = $user['photo'];
    } else {
        echo "No user found with the given roll number.";
    }

    // Free result and close statement
    $stmt->close();
} else {
    echo "Roll number not set in session.";
}

// Close database connection
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
            display: flex;
            justify-content: space-between;
        }
        .btn {
            padding: 10px 20px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-dashboard {
            background: #28a745;
        }
        .btn-dashboard:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <!-- User Image -->
    <img src="<?= htmlspecialchars($user['photo'] ?? 'default.png') ?>" alt="Profile Image" class="profile-img" id="profileImage">
   
    <!-- Profile Details -->
    <div class="profile-details">
        <form action="updateuserinfo.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label for="roll_no">Roll No</label>
            <input type="text" id="roll_no" name="roll_no" value="<?= htmlspecialchars($roll_no) ?>" readonly>

            <label for="class">Class</label>
            <input type="text" id="class" name="class" value="<?= htmlspecialchars($user['class']) ?>" required>

            <label for="subjects">Subjects</label>
            <input type="text" id="subjects" name="subjects" value="<?= htmlspecialchars($user['subjects']) ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="profile_image">Profile Image</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">

            <!-- Buttons -->
            <div class="btn-container">
                <button type="submit" class="btn">Save Changes</button>
                <a href="home_page_complaint_site.php" class="btn btn-dashboard">Go to Dashboard</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
