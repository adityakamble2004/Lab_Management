<?php
session_start();
include('../database/connection.php');

// Check if the user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
//     header("Location: ../index.php");
//     exit();
// }

// Fetch users from the database
$sql = "SELECT teacher_id, name, email, phone_number, lab_in_charge, username, role FROM teachers";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .container {
    width: 90%;
    margin: 20px auto;
}

h2 {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #007BFF;
    color: white;
}

.edit-btn, .delete-btn {
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 4px;
    margin-right: 5px;
}

.edit-btn {
    background-color: #28a745;
    color: white;
}

.delete-btn {
    background-color: #dc3545;
    color: white;
}

    </style>
</head>
<body>


    <div class="container">
        <h2>Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Lab In-Charge</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['teacher_id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone_number'] ?></td>
                        <td><?= $row['lab_in_charge'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['role'] ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['teacher_id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete_user.php?id=<?= $row['teacher_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
