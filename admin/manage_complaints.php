<?php
session_start();
include '../database/connection.php'; // Ensure this contains $conn for DB connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch all complaints
$query = "SELECT c.id, c.roll_no, c.asset_id, c.issue_description, c.status, c.created_at, c.resolved_at, c.selected_problems, c.email, c.computer_id, 
                 c.technician_id, t.name AS technician_name, c.resolution_note, u.name AS student_name
          FROM complaints c
          LEFT JOIN users u ON c.roll_no = u.roll_no
          LEFT JOIN technicians t ON c.technician_id = t.id
          ORDER BY c.created_at DESC";

$result = $conn->query($query);
if (!$result) {
    die("Error fetching complaints: " . $conn->error);
}

// Fetch available technicians
$technicians = $conn->query("SELECT id, name FROM technicians");

// Handle complaint updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_status'])) {
        $complaint_id = intval($_POST['complaint_id']);
        $new_status = $_POST['status'];
        $resolution_note = trim($_POST['resolution_note']);

        // Update complaint status
        $stmt = $conn->prepare("UPDATE complaints SET status = ?, resolution_note = ?, resolved_at = NOW() WHERE id = ?");
        $stmt->bind_param("ssi", $new_status, $resolution_note, $complaint_id);

        if ($stmt->execute()) {
            $success_message = "Complaint updated successfully!";
        } else {
            $error_message = "Error updating complaint: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['assign_technician'])) {
        $complaint_id = intval($_POST['complaint_id']);
        $technician_id = intval($_POST['technician_id']);

        // Assign technician to complaint
        $stmt = $conn->prepare("UPDATE complaints SET technician_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $technician_id, $complaint_id);

        if ($stmt->execute()) {
            $success_message = "Technician assigned successfully!";
        } else {
            $error_message = "Error assigning technician: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['delete_complaint'])) {
        $complaint_id = intval($_POST['complaint_id']);

        // Delete complaint
        $stmt = $conn->prepare("DELETE FROM complaints WHERE id = ?");
        $stmt->bind_param("i", $complaint_id);

        if ($stmt->execute()) {
            $success_message = "Complaint deleted successfully!";
        } else {
            $error_message = "Error deleting complaint: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <link rel="stylesheet" href="../styles/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 90%;
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
        .error { background: #ffdddd; color: #a00; }
        .success { background: #ddffdd; color: #0a0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 12px; text-align: center; }
        th { background: #007bff; color: white; }
        td { background: #f9f9f9; }
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
        button:hover { background: #0056b3; }

        
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Complaints</h2>

        <?php if (!empty($error_message)): ?>
            <p class="message error"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <p class="message success"><?= htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Asset ID</th>
                <th>Description</th>
                <th>Status</th>
                <th>Technician</th>
                <th>Resolution Note</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['student_name']); ?></td>
                    <td><?= htmlspecialchars($row['asset_id']); ?></td>
                    <td><?= htmlspecialchars($row['issue_description']); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td><?= htmlspecialchars($row['technician_name'] ?? "Not Assigned"); ?></td>
                    <td><?= htmlspecialchars($row['resolution_note'] ?? "No Notes"); ?></td>
                    <td>
                        <!-- Update Complaint Status -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                            <select name="status">
                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?= $row['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                            </select>
                            <input type="text" name="resolution_note" placeholder="Resolution Note">
                            <button type="submit" name="update_status">Update</button>
                        </form>

                        <!-- Assign Technician -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                            <select name="technician_id">
                                <?php while ($tech = $technicians->fetch_assoc()) { ?>
                                    <option value="<?= $tech['id']; ?>"><?= $tech['name']; ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" name="assign_technician">Assign</button>
                        </form>

                        <!-- Delete Complaint -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="delete_complaint" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
