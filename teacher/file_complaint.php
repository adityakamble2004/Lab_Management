<?php
session_start();
include('../database/connection.php');

// Check if the user is logged in and is a Teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Teacher') {
    header("Location: ../login.php");
    exit();
}

// Get the teacher's assigned lab
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

// Fetch computers from the assigned lab
$stmt = $conn->prepare("SELECT id, computer_name FROM computers WHERE Lab = ?");
$stmt->bind_param("s", $lab_assigned);
$stmt->execute();
$computers = $stmt->get_result();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $computer_id = $_POST['computer_id'];
    $issue_description = trim($_POST['issue_description']);

    if (empty($computer_id) || empty($issue_description)) {
        $error_message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO complaints (teacher_id, computer_id, issue_description, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())");
        $stmt->bind_param("iis", $teacher_id, $computer_id, $issue_description);

        if ($stmt->execute()) {
            $success_message = "Complaint filed successfully!";
        } else {
            $error_message = "Error filing the complaint.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Complaint</title>
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

        select, textarea {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
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

        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include('header.php'); // Include the header ?>


    <div class="container">
        <h2>File a Complaint</h2>

        <?php if (isset($error_message)) : ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)) : ?>
            <p class="success"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Computer:</label>
            <select name="computer_id" required>
                <option value="">Select a Computer</option>
                <?php while ($row = $computers->fetch_assoc()) : ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['computer_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Issue Description:</label>
            <textarea name="issue_description" required></textarea>

            <button type="submit">Submit Complaint</button>
        </form>
    </div>
</body>
</html>
