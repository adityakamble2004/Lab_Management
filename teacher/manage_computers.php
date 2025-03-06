<?php
session_start();
include('../database/connection.php');

// Check if the user is logged in and is a Teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit();
}

// Fetch the teacher's assigned lab
$teacher_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT lab_in_charge FROM teachers WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if (!$teacher || empty($teacher['lab_in_charge'])) {
    die("Error: You are not assigned to any lab.");
}

$lab_assigned = $teacher['lab_in_charge'];

// Fetch computers assigned to the teacher's lab
$stmt = $conn->prepare("SELECT * FROM computers WHERE Lab = ?");
$stmt->bind_param("s", $lab_assigned);
$stmt->execute();
$computers = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Computers</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .actions a {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px;
        }

        .edit-btn {
            background: #28a745;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .actions a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h2>Manage Computers - <?= htmlspecialchars($lab_assigned) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Asset ID</th>
                    <th>Computer Name</th>
                    <th>Type</th>
                    <th>OS</th>
                    <th>Processor</th>
                    <th>RAM</th>
                    <th>Storage</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($computer = $computers->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($computer['asset_id']) ?></td>
                        <td><?= htmlspecialchars($computer['computer_name']) ?></td>
                        <td><?= htmlspecialchars($computer['computer_type']) ?></td>
                        <td><?= htmlspecialchars($computer['operating_system']) ?></td>
                        <td><?= htmlspecialchars($computer['processor_details']) ?></td>
                        <td><?= htmlspecialchars($computer['ram_size']) ?></td>
                        <td><?= htmlspecialchars($computer['storage_details']) ?></td>
                        <td><?= htmlspecialchars($computer['status']) ?></td>
                        <td class="actions">
                            <a href="edit_computer.php?id=<?= $computer['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete_computer.php?id=<?= $computer['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
