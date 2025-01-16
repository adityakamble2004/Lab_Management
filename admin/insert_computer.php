<?php
// Start the session
session_start();

// Include database connection file
include('../database/connection.php');

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $asset_id = $_POST['asset_id'];
    $computer_name = $_POST['computer_name'];
    $computer_type = $_POST['computer_type'];
    $operating_system = $_POST['operating_system'];
    $processor_details = $_POST['processor_details'] ?? null;
    $ram_size = $_POST['ram_size'] ?? null;
    $storage_details = $_POST['storage_details'] ?? null;
    $graphics_card = $_POST['graphics_card'] ?? null;
    $monitor_details = $_POST['monitor_details'] ?? null;
    $peripherals = $_POST['peripherals'] ?? null;
    $ip_address = $_POST['ip_address'] ?? null;
    $mac_address = $_POST['mac_address'] ?? null;
    $network_name = $_POST['network_name'] ?? null;
    $installed_applications = $_POST['installed_applications'] ?? null;
    $antivirus_details = $_POST['antivirus_details'] ?? null;
    $warranty_expiry_date = $_POST['warranty_expiry_date'] ?? null;
    $last_checked_date = $_POST['last_checked_date'] ?? null;
    $location = $_POST['location'] ?? null;
    $assigned_user = $_POST['assigned_user'] ?? null;
    $department = $_POST['department'] ?? null;
    $service_history = $_POST['service_history'] ?? null;
    $issue_description = $_POST['issue_description'] ?? null;

    // Insert query
    $query = "INSERT INTO computers (
        asset_id, computer_name, computer_type, operating_system, 
        processor_details, ram_size, storage_details, graphics_card, 
        monitor_details, peripherals, ip_address, mac_address, 
        network_name, installed_applications, antivirus_details, 
        warranty_expiry_date, last_checked_date, location, 
        assigned_user, department, service_history, issue_description
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the query
    $stmt = $conn->prepare($query);

    // Error handling for query preparation
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    // Bind parameters to the query
    $stmt->bind_param(
        "ssssssssssssssssssssss",
        $asset_id,
        $computer_name,
        $computer_type,
        $operating_system,
        $processor_details,
        $ram_size,
        $storage_details,
        $graphics_card,
        $monitor_details,
        $peripherals,
        $ip_address,
        $mac_address,
        $network_name,
        $installed_applications,
        $antivirus_details,
        $warranty_expiry_date,
        $last_checked_date,
        $location,
        $assigned_user,
        $department,
        $service_history,
        $issue_description
    );

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Computer information added successfully!'); window.location.href='computer_list.php';</script>";
    } else {
        echo "<script>alert('Error adding computer information: " . $stmt->error . "'); window.location.href='add_computer_form.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method!'); window.location.href='add_computer_form.php';</script>";
}
?>
