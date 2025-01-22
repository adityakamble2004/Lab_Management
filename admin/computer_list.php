<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Information</title>
    <style>
        /* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7f6;
    color: #333;
    padding: 20px;
}

/* Header styles */
h1 {
    text-align: center;
    font-size: 30px;
    margin-bottom: 20px;
    color: #4CAF50; /* Green color for heading */
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    background-color: white;
}

/* Table header */
th {
    background-color: #4CAF50;
    color: white;
    padding: 12px 15px;
    text-align: left;
    font-size: 16px;
    font-weight: bold;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

/* Table body */
td {
    padding: 12px 15px;
    text-align: left;
    font-size: 14px;
    border: 1px solid #ddd;
    color: #555;
}

/* Zebra striping for table rows */
tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover effect for table rows */
tr:hover {
    background-color: #f1f1f1;
}

/* Border styling */
table, th, td {
    border: 1px solid #ddd;
    border-radius: 8px;
}

/* Table container for responsiveness */
.container {
    overflow-x: auto;
    margin: 0 auto;
    max-width: 1200px;
}

/* Style for the empty state message */
p {
    font-size: 16px;
    color: #555;
    text-align: center;
    margin-top: 30px;
}

/* Styling for each table row */
td {
    font-size: 14px;
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

/* Style for the Edit button */
.edit-button {
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
}

.edit-button:hover {
    background-color: #45a049;
}

/* Style for the Delete button */
.delete-button {
    background-color: #f44336;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

.delete-button:hover {
    background-color: #e53935;
}

/* Style for the PDF button */
.pdf-button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
}

.pdf-button:hover {
    background-color: #45a049;
}

/* Responsive design for small screens */
@media screen and (max-width: 768px) {
    th, td {
        padding: 10px;
    }
    h1 {
        font-size: 24px;
    }
    table {
        font-size: 12px;
    }
}

    </style>
</head>
<body>
<?php
// Start the session
session_start();
echo"";

// Include database connection file
include('../database/connection.php');

// Query to fetch all computer records
$query = "SELECT * FROM computers";

$result = $conn->query($query);

// Error handling for query execution
if (!$result) {
    die("<p>Error retrieving computer records: " . $conn->error . "</p>");
}

// Check if there are any records in the table
if ($result->num_rows > 0) {
    // Display the records in a table
    echo "<h1>Computer Information List</h1>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Asset ID</th>
            <th>Computer Name</th>
            <th>Type</th>
            <th>Operating System</th>
            <th>Processor</th>
            <th>RAM</th>
            <th>Storage</th>
            <th>Graphics</th>
            <th>Monitor</th>
            <th>Peripherals</th>
            <th>IP Address</th>
            <th>MAC Address</th>
            <th>Network</th>
            <th>Installed Applications</th>
            <th>Antivirus</th>
            <th>Warranty Expiry</th>
            <th>Last Checked</th>
            <th>Lab</th>
            <th>Assigned User</th>
            <th>Department</th>
            <th>Service History</th>
            <th>Issue Description</th>
          </tr>";

    // Fetch and display each record
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['asset_id']}</td>
                <td>{$row['computer_name']}</td>
                <td>{$row['computer_type']}</td>
                <td>{$row['operating_system']}</td>
                <td>{$row['processor_details']}</td>
                <td>{$row['ram_size']}</td>
                <td>{$row['storage_details']}</td>
                <td>{$row['graphics_card']}</td>
                <td>{$row['monitor_details']}</td>
                <td>{$row['peripherals']}</td>
                <td>{$row['ip_address']}</td>
                <td>{$row['mac_address']}</td>
                <td>{$row['network_name']}</td>
                <td>{$row['installed_applications']}</td>
                <td>{$row['antivirus_details']}</td>
                <td>{$row['warranty_expiry_date']}</td>
                <td>{$row['last_checked_date']}</td>
                <td>{$row['Lab']}</td>
                <td>{$row['assigned_user']}</td>
                <td>{$row['department']}</td>
                <td>{$row['service_history']}</td>
                <td>{$row['issue_description']}</td>
                <td>{$row['issue_description']}</td>
                
               <td>
                <!-- Edit Button -->
                <a href='edit_computer.php?id={$row['id']}' class='edit-button'>Edit</a>

                <!-- Delete Button -->
                <form action='delete_computer.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}' />
                    <button type='submit' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</button>
                </form>
            </td>

              </tr>";
    }
    echo "</table>";
} else {
    // No records found
    echo "<p>No computer records found in the database.</p>";
}

// Close the database connection
$conn->close();
?>
<!-- Button to Generate PDF -->
<form action="generate_pdf.php" method="get">
    <button type="submit" class="pdf-button">Generate PDF Report</button>
</form>

</body>
</html>
