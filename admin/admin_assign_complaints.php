<?php
session_start();
include '../database/connection.php'; // Ensure this file contains $conn for DB connection

// Error message variable
$error_message = "";
$success_message = "";

// Fetch complaints that are not yet assigned
$query = "SELECT c.id, c.issue_description, u.name AS student_name 
          FROM complaints c
          JOIN users u ON c.roll_no = u.roll_no
          WHERE c.technician_id IS NULL";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching complaints: " . $conn->error);
}

// Fetch all approved technicians
$techQuery = "SELECT 	id , name FROM  technicians WHERE 	id IN (SELECT id FROM technicians WHERE status = 'approved')";
$techResult = $conn->query($techQuery);

if (!$techResult) {
    die("Error fetching technicians: " . $conn->error);
}

// Assign a complaint to a technician
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign'])) {
    $complaint_id = isset($_POST['complaint_id']) ? intval($_POST['complaint_id']) : null;
    $technician_id = isset($_POST['technician_id']) ? intval($_POST['technician_id']) : null;

    if (!$complaint_id || !$technician_id) {
        $error_message = "Invalid complaint or technician selection.";
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("UPDATE complaints SET technician_id = ?, status = 'In Progress' WHERE id = ?");
        
        if (!$stmt) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("ii", $technician_id, $complaint_id);
        if ($stmt->execute()) {
            $success_message = "Complaint assigned successfully!";
        } else {
            $error_message = "Error assigning complaint: " . $stmt->error;
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
    <title>Admin - Assign Complaints</title>
    <link rel="stylesheet" href="../styles/admin.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
    text-align: center;
}

/* Page Header */
h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Success and Error Messages */
p {
    padding: 10px;
    font-weight: bold;
}

p[style*="color: red"] {
    background-color: #ffdddd;
    border: 1px solid #ff6666;
    color: #a33;
    display: inline-block;
    border-radius: 5px;
}

p[style*="color: green"] {
    background-color: #ddffdd;
    border: 1px solid #66cc66;
    color: #3a873a;
    display: inline-block;
    border-radius: 5px;
}

/* Table Styling */
table {
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Form Elements */
select {
    padding: 8px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
}

/* Button Styling */
button {
    padding: 8px 12px;
    font-size: 14px;
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: 0.3s;
}

button:hover {
    background-color: #218838;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    table {
        width: 100%;
    }
    th, td {
        padding: 8px;
    }
}

    </style>
</head>
<body>
    <h2>Assign Complaints to Technicians</h2>

    <?php if (!empty($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message); ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Complaint ID</th>
            <th>Description</th>
            <th>Student</th>
            <th>Assign Technician</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['issue_description']); ?></td>
                <td><?= htmlspecialchars($row['student_name']); ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="complaint_id" value="<?= $row['id']; ?>">
                        <select name="technician_id" required>
                            <?php while ($tech = $techResult->fetch_assoc()) { ?>
                                <option value="<?= $tech['id']; ?>"><?= htmlspecialchars($tech['name']); ?></option>
                            <?php } ?>
                        </select>
                </td>
                <td>
                        <button type="submit" name="assign">Assign</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
