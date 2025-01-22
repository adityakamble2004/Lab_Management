<?php
// Start the session
session_start();

// Include database connection file
include('../database/connection.php');

// Check if ID is provided in the URL (for editing a specific record)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing record from the database
    $query = "SELECT * FROM computers WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            die("Error executing query: " . $stmt->error);
        }
        $result = $stmt->get_result();

        // Check if the record exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            die("Error: Record not found.");
        }
    } else {
        die("Error preparing the query: " . $conn->error);
    }

    // Update the database with the modified data when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect data from the form and handle blank fields (allow them to be empty)
        $asset_id = !empty($_POST['asset_id']) ? $_POST['asset_id'] : NULL;
        $computer_name = !empty($_POST['computer_name']) ? $_POST['computer_name'] : NULL;
        $computer_type = !empty($_POST['computer_type']) ? $_POST['computer_type'] : NULL;
        $operating_system = !empty($_POST['operating_system']) ? $_POST['operating_system'] : NULL;
        $processor_details = !empty($_POST['processor_details']) ? $_POST['processor_details'] : NULL;
        $ram_size = !empty($_POST['ram_size']) ? $_POST['ram_size'] : NULL;
        $storage_details = !empty($_POST['storage_details']) ? $_POST['storage_details'] : NULL;
        $graphics_card = !empty($_POST['graphics_card']) ? $_POST['graphics_card'] : NULL;
        $monitor_details = !empty($_POST['monitor_details']) ? $_POST['monitor_details'] : NULL;
        $peripherals = !empty($_POST['peripherals']) ? $_POST['peripherals'] : NULL;
        $ip_address = !empty($_POST['ip_address']) ? $_POST['ip_address'] : NULL;
        $mac_address = !empty($_POST['mac_address']) ? $_POST['mac_address'] : NULL;
        $network_name = !empty($_POST['network_name']) ? $_POST['network_name'] : NULL;
        $installed_applications = !empty($_POST['installed_applications']) ? $_POST['installed_applications'] : NULL;
        $antivirus_details = !empty($_POST['antivirus_details']) ? $_POST['antivirus_details'] : NULL;
        $warranty_expiry_date = !empty($_POST['warranty_expiry_date']) ? $_POST['warranty_expiry_date'] : NULL;
        $last_checked_date = !empty($_POST['last_checked_date']) ? $_POST['last_checked_date'] : NULL;
        $Lab = !empty($_POST['Lab']) ? $_POST['Lab'] : NULL;
        $assigned_user = !empty($_POST['assigned_user']) ? $_POST['assigned_user'] : NULL;
        $department = !empty($_POST['department']) ? $_POST['department'] : NULL;
        $service_history = !empty($_POST['service_history']) ? $_POST['service_history'] : NULL;
        $issue_description = !empty($_POST['issue_description']) ? $_POST['issue_description'] : NULL;

        // Prepare the update query
        $update_query = "UPDATE computers SET asset_id = ?, computer_name = ?, computer_type = ?, operating_system = ?, processor_details = ?, ram_size = ?, storage_details = ?, graphics_card = ?, monitor_details = ?, peripherals = ?, ip_address = ?, mac_address = ?, network_name = ?, installed_applications = ?, antivirus_details = ?, warranty_expiry_date = ?, last_checked_date = ?, Lab = ?, assigned_user = ?, department = ?, service_history = ?, issue_description = ? WHERE id = ?";
        
        if ($update_stmt = $conn->prepare($update_query)) {
            // Bind parameters, ensuring NULL values are handled
            $update_stmt->bind_param(
                "ssssssssssssssssssssssi", 
                $asset_id, $computer_name, $computer_type, $operating_system, $processor_details, $ram_size, 
                $storage_details, $graphics_card, $monitor_details, $peripherals, $ip_address, $mac_address, 
                $network_name, $installed_applications, $antivirus_details, $warranty_expiry_date, $last_checked_date, 
                $Lab, $assigned_user, $department, $service_history, $issue_description, $id
            );

            // Execute and handle errors
            if ($update_stmt->execute()) {
                echo "<p>Computer information updated successfully!</p>";
            } else {
                echo "<p>Error updating the record: " . $update_stmt->error . "</p>";
            }
        } else {
            die("Error preparing the update query: " . $conn->error);
        }
    }
} else {
    die("Error: No ID provided.");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Computer Information</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS if needed -->

    <style>
        /* Basic reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fc;
    color: #333;
    padding: 20px;
}

/* Container for form */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Heading styling */
h1 {
    text-align: center;
    color: #4A90E2;
    margin-bottom: 20px;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
}

/* Label styling */
label {
    font-weight: bold;
    margin-bottom: 8px;
    color: #555;
}

/* Input and textarea styling */
input[type="text"],
input[type="date"],
textarea,
select {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
}

/* Styling for textarea for larger input fields */
textarea {
    height: 100px;
    resize: vertical;
}

/* Styling for buttons */
button {
    padding: 12px;
    background-color: #4A90E2;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    margin-top: 10px;
}

/* Button hover effect */
button:hover {
    background-color: #357ABD;
}

/* Styling for select dropdown */
select {
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

/* Responsive design for smaller screens */
@media screen and (max-width: 768px) {
    .container {
        padding: 15px;
    }

    button {
        font-size: 14px;
        padding: 10px;
    }

    input[type="text"],
    input[type="date"],
    textarea,
    select {
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Computer Information</h1>
        <form action="edit_computer.php?id=<?php echo $id; ?>" method="POST">
            <label for="asset_id">Asset ID:</label>
            <input type="text" name="asset_id" value="<?php echo $row['asset_id']; ?>" required><br><br>

            <label for="computer_name">Computer Name:</label>
            <input type="text" name="computer_name" value="<?php echo $row['computer_name']; ?>" required><br><br>

            <label for="computer_type">Computer Type:</label>
            <select name="computer_type">
                <option value="Desktop" <?php echo ($row['computer_type'] == 'Desktop') ? 'selected' : ''; ?>>Desktop</option>
                <option value="Laptop" <?php echo ($row['computer_type'] == 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                <option value="Server" <?php echo ($row['computer_type'] == 'Server') ? 'selected' : ''; ?>>Server</option>
            </select><br><br>

            <label for="operating_system">Operating System:</label>
            <input type="text" name="operating_system" value="<?php echo $row['operating_system']; ?>" required><br><br>

            <label for="processor_details">Processor:</label>
            <input type="text" name="processor_details" value="<?php echo $row['processor_details']; ?>"><br><br>

            <label for="ram_size">RAM:</label>
            <input type="text" name="ram_size" value="<?php echo $row['ram_size']; ?>"><br><br>

            <label for="storage_details">Storage:</label>
            <input type="text" name="storage_details" value="<?php echo $row['storage_details']; ?>"><br><br>

            <label for="graphics_card">Graphics Card:</label>
            <input type="text" name="graphics_card" value="<?php echo $row['graphics_card']; ?>"><br><br>

            <label for="monitor_details">Monitor:</label>
            <input type="text" name="monitor_details" value="<?php echo $row['monitor_details']; ?>"><br><br>

            <label for="peripherals">Peripherals:</label>
            <input type="text" name="peripherals" value="<?php echo $row['peripherals']; ?>"><br><br>

            <label for="ip_address">IP Address:</label>
            <input type="text" name="ip_address" value="<?php echo $row['ip_address']; ?>"><br><br>

            <label for="mac_address">MAC Address:</label>
            <input type="text" name="mac_address" value="<?php echo $row['mac_address']; ?>"><br><br>

            <label for="network_name">Network Name:</label>
            <input type="text" name="network_name" value="<?php echo $row['network_name']; ?>"><br><br>

            <label for="installed_applications">Installed Applications:</label>
            <textarea name="installed_applications"><?php echo $row['installed_applications']; ?></textarea><br><br>

            <label for="antivirus_details">Antivirus:</label>
            <input type="text" name="antivirus_details" value="<?php echo $row['antivirus_details']; ?>"><br><br>

            <label for="warranty_expiry_date">Warranty Expiry:</label>
            <input type="date" name="warranty_expiry_date" value="<?php echo $row['warranty_expiry_date']; ?>"><br><br>

            <label for="last_checked_date">Last Checked:</label>
            <input type="date" name="last_checked_date" value="<?php echo $row['last_checked_date']; ?>"><br><br>

            <label for="lab">lab:</label>
            <input type="text" name="Lab" value="<?php echo $row['Lab']; ?>"><br><br>

            <label for="assigned_user">Assigned User:</label>
            <input type="text" name="assigned_user" value="<?php echo $row['assigned_user']; ?>"><br><br>

            <label for="department">Department:</label>
            <input type="text" name="department" value="<?php echo $row['department']; ?>"><br><br>

            <label for="service_history">Service History:</label>
            <textarea name="service_history"><?php echo $row['service_history']; ?></textarea><br><br>

            <label for="issue_description">Issue Description:</label>
            <textarea name="issue_description"><?php echo $row['issue_description']; ?></textarea><br><br>

            <button type="submit">Save Changes</button>
            <a href="computer_list.php"> Computer List</a>
        </form>
    </div>
</body>
</html>
