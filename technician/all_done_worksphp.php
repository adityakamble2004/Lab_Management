<?php
session_start();
include '../database/connection.php'; // Ensure this file contains $conn for DB connection

// Error message variable
$error_message = "";
$success_message = "";

// Check if the technician is logged in
if (!isset($_SESSION['technician_id'])) {
    header("Location: ../login.php");
    exit();
}

$technician_id = $_SESSION['technician_id'];

// Fetch complaints assigned to the logged-in technician
$query = "SELECT c.id, c.issue_description, u.name AS student_name, c.status, c.resolution_note
          FROM complaints c
          JOIN users u ON c.roll_no = u.roll_no
          WHERE c.technician_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $technician_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching complaints: " . $conn->error);
}

// Update complaint status with resolution note
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $complaint_id = intval($_POST['complaint_id']);
    $new_status = $_POST['status'];
    $resolution_note = trim($_POST['resolution_note']);

    // Validate status input
    $valid_statuses = ["In Progress", "Resolved", "Pending"];
    if (!in_array($new_status, $valid_statuses)) {
        $error_message = "Invalid status selected.";
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("UPDATE complaints SET status = ?, resolution_note = ? WHERE id = ? AND technician_id = ?");
        
        if (!$stmt) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("ssii", $new_status, $resolution_note, $complaint_id, $technician_id);
        if ($stmt->execute()) {
            $success_message = "Complaint status updated successfully!";
        } else {
            $error_message = "Error updating status: " . $stmt->error;
        }

        $stmt->close();
        
        // Refresh the page to reflect updates
        header("Location: dashboard_technician.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Dashboard</title>
    <link rel="stylesheet" href="../styles/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .message {
            text-align: center;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
        .error {
            background: #ffdddd;
            color: #a00;
        }
        .success {
            background: #ddffdd;
            color: #0a0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        td {
            background: #f9f9f9;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }
        select, input, button {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
        }
        button:hover {
            background: #0056b3;
        }
        .note-box {
            width: 100%;
            min-height: 50px;
            resize: vertical;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Technician Dashboard</h2>

        <?php if (!empty($error_message)): ?>
            <p class="message error"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <p class="message success"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Complaint ID</th>
                <th>Description</th>
                <th>Student</th>
                <th>Status</th>
                <th>Resolution Note</th>
                <th>Update Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['issue_description']); ?></td>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= htmlspecialchars($row['resolution_note'] ?? "No notes added"); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                            <select name="status" required>
                                <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            </select>
                            <textarea name="resolution_note" class="note-box" placeholder="Add resolution note"><?= htmlspecialchars($row['resolution_note'] ?? ""); ?></textarea>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
