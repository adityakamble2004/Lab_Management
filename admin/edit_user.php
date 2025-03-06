<?php
session_start();
include('../database/connection.php');

// Check if admin is logged in
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
//     header("Location: ../index.php");
//     exit();
// }

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$user_id = $_GET['id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, phone_number, lab_in_charge, username, role FROM teachers WHERE teacher_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: manage_users.php");
    exit();
}

$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $lab = $_POST['lab_in_charge'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update user details
    $update_stmt = $conn->prepare("UPDATE teachers SET name=?, email=?, phone_number=?, lab_in_charge=?, username=?, role=? WHERE teacher_id=?");
    $update_stmt->bind_param("ssssssi", $name, $email, $phone, $lab, $username, $role, $user_id);

    if ($update_stmt->execute()) {
        header("Location: manage_users.php?success=User updated successfully!");
        exit();
    } else {
        $error = "Failed to update user!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    width: 50%;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Heading */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Error Message */
.error-message {
    color: red;
    font-size: 14px;
    text-align: center;
    margin-bottom: 10px;
}

/* Form Styles */
form {
    display: flex;
    flex-direction: column;
}

/* Labels */
label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

/* Input Fields */
input, select {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    width: 100%;
}

/* Button */
button {
    background: #007BFF;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }
}

    </style>
</head>
<body>


    <div class="container">
        <h2>Edit User</h2>
        <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>

        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Phone Number:</label>
            <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>">

            <label>Lab In-Charge:</label>
            <input type="text" name="lab_in_charge" value="<?= htmlspecialchars($user['lab_in_charge']) ?>">

            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Teacher" <?= $user['role'] == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
            </select>

            <button type="submit">Update</button>
        </form>
    </div>

</body>
</html>
