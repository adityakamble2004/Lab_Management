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
          WHERE c.technician_id = ? AND c.status != 'Resolved'"; // Hides resolved complaints

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $technician_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching complaints: " . $conn->error);
}

// Update complaint status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $complaint_id = intval($_POST['complaint_id']);
    $new_status = $_POST['status'];
    $resolution_note = $_POST['resolution_note'] ?? ""; // Get resolution note if provided

    // Validate status input
    $valid_statuses = ["In Progress", "Resolved", "Pending"];
    if (!in_array($new_status, $valid_statuses)) {
        $error_message = "Invalid status selected.";
    } else {
        // Prepare SQL statement with resolution_note
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
            background: #f4f4f4;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007BFF;
            color: white;
        }
        td {
            background: #fff;
        }
        select, textarea, button {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
        button {
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .message {
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
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
                <td><?= htmlspecialchars($row['resolution_note']); ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                        <select name="status" required>
                            <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                            <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        </select>
                        <textarea name="resolution_note" placeholder="Enter resolution note (required for Resolved)"></textarea>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
