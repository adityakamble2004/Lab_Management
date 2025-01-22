<?php
// Include database connection
include('../database/connection.php');

// Initialize variables
$selected_lab = '';
$computer_count = 0;

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_lab = $_POST['lab_name'];

    // Prepare query to count computers in the selected lab
    $query = "SELECT COUNT(*) AS count FROM computers WHERE Lab = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selected_lab);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $computer_count = $row['count'];
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Computer Count</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <h1>Check Computers in Specific Lab</h1>
    <form method="POST" action="">
        <label for="lab_name">Select a Lab:</label>
        <select name="lab_name" id="lab_name" required>
            <option value="" disabled selected>--Select Lab--</option>
            <option value="lab1" <?= $selected_lab === 'lab1' ? 'selected' : '' ?>>Lab 1</option>
            <option value="lab2" <?= $selected_lab === 'lab2' ? 'selected' : '' ?>>Lab 2</option>
            <option value="lab3" <?= $selected_lab === 'lab3' ? 'selected' : '' ?>>Lab 3</option>
            <option value="lab4" <?= $selected_lab === 'lab4' ? 'selected' : '' ?>>Lab 4</option>
            <option value="lab5" <?= $selected_lab === 'lab5' ? 'selected' : '' ?>>Lab 5</option>
        </select>
        <button type="submit">Check</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2>Results for <?= htmlspecialchars($selected_lab) ?>:</h2>
        <p>Total Computers: <?= $computer_count ?></p>
    <?php endif; ?>
</body>
</html>
