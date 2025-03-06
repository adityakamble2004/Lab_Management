<?php
session_start();

include('../database/connection.php');

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    $location = $_POST['lab'] ?? null;
    $assigned_user = $_POST['assigned_user'] ?? null;
    $department = $_POST['department'] ?? null;
    $service_history = $_POST['service_history'] ?? null;
    $issue_description = $_POST['issue_description'] ?? null;

    $query = "INSERT INTO computers (
        asset_id, computer_name, computer_type, operating_system, 
        processor_details, ram_size, storage_details, graphics_card, 
        monitor_details, peripherals, ip_address, mac_address, 
        network_name, installed_applications, antivirus_details, 
        warranty_expiry_date, last_checked_date, lab, 
        assigned_user, department, service_history, issue_description
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

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
        $lab_assigned,
        $assigned_user,
        $department,
        $service_history,
        $issue_description
    );

    if ($stmt->execute()) {
        echo "<script>alert('Computer information added successfully!'); window.location.href='manage_computers';</script>";
    } else {
        echo "<script>alert('Error adding computer information: " . $stmt->error . "'); window.location.href='add_computer_form.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method!'); window.location.href='add_computer_form.php';</script>";
}
?>
