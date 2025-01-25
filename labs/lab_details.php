<?php
include('../database/connection.php');

// Get lab name from query parameter
if (isset($_GET['Lab'])) {
    $Lab = $_GET['Lab'];
} else {
    die("Lab name not specified.");
}

// Fetch computers in the specified lab
$query = "SELECT * FROM computers WHERE Lab = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $Lab);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching computer details: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($Lab); ?> - Lab Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .computer-table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .computer-table th, .computer-table td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: center;
        }
        .computer-table th {
            background-color: #007bff;
            color: #fff;
        }
        .computer-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .computer-table tr:hover {
            background-color: #f1f1f1;
        }
        .complaint-button {
            text-decoration: none;
            color: white;
            background-color: #5cb85c;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        .complaint-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($Lab); ?> - Computer Details</h1>
    <table class="computer-table">
        <thead>
            <tr>
                <th>Computer ID</th>
                <th>Computer Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['asset_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['computer_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <a href="complains/file_complaint.php?asset_id=<?php echo urlencode($row['asset_id']); ?>" class="complaint-button">File Complaint</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
