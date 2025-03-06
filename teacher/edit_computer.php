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

// Check if the computer ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: No computer selected.");
}

$computer_id = $_GET['id'];

// Fetch computer details
$stmt = $conn->prepare("SELECT * FROM computers WHERE id = ? AND Lab = ?");
$stmt->bind_param("is", $computer_id, $lab_assigned);
$stmt->execute();
$computer = $stmt->get_result()->fetch_assoc();

if (!$computer) {
    die("Error: Computer not found or you are not authorized to edit this.");
}

// Update computer details on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $computer_name = $_POST['computer_name'];
    $computer_type = $_POST['computer_type'];
    $operating_system = $_POST['operating_system'];
    $processor_details = $_POST['processor_details'];
    $ram_size = $_POST['ram_size'];
    $storage_details = $_POST['storage_details'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE computers SET computer_name=?, computer_type=?, operating_system=?, processor_details=?, ram_size=?, storage_details=?, status=? WHERE id=? AND Lab=?");
    $stmt->bind_param("sssssssis", $computer_name, $computer_type, $operating_system, $processor_details, $ram_size, $storage_details, $status, $computer_id, $lab_assigned);
    
    if ($stmt->execute()) {
        header("Location: manage_computers.php?success=Computer updated successfully");
        exit();
    } else {
        $error_message = "Error updating the computer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Computer</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 50%;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input, select {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Computer - <?= htmlspecialchars($computer['computer_name']) ?></h2>
        
        <?php if (isset($error_message)) : ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Computer Name:</label>
            <input type="text" name="computer_name" value="<?= htmlspecialchars($computer['computer_name']) ?>" required>

            <label>Computer Type:</label>
            <select name="computer_type">
                <option value="Desktop" <?= ($computer['computer_type'] == 'Desktop') ? 'selected' : '' ?>>Desktop</option>
                <option value="Laptop" <?= ($computer['computer_type'] == 'Laptop') ? 'selected' : '' ?>>Laptop</option>
                <option value="Server" <?= ($computer['computer_type'] == 'Server') ? 'selected' : '' ?>>Server</option>
            </select>

            <label>Operating System:</label>
            <input type="text" name="operating_system" value="<?= htmlspecialchars($computer['operating_system']) ?>" required>

            <label>Processor Details:</label>
            <input type="text" name="processor_details" value="<?= htmlspecialchars($computer['processor_details']) ?>">

            <label>RAM Size:</label>
            <input type="text" name="ram_size" value="<?= htmlspecialchars($computer['ram_size']) ?>">

            <label>Storage Details:</label>
            <input type="text" name="storage_details" value="<?= htmlspecialchars($computer['storage_details']) ?>">

            <label>Status:</label>
            <select name="status">
                <option value="Working" <?= ($computer['status'] == 'Working') ? 'selected' : '' ?>>Working</option>
                <option value="Not Working" <?= ($computer['status'] == 'Not Working') ? 'selected' : '' ?>>Not Working</option>
            </select>

            <button type="submit">Update Computer</button>
        </form>
    </div>
</body>
</html>
