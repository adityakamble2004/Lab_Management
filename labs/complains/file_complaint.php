<?php
session_start();
include('../../database/connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_name'], $_SESSION['email'], $_SESSION['roll_no'])) {
    die("User not logged in. Please log in and try again.");
}

$user_name = $_SESSION['user_name'];
$email = $_SESSION['email'];
$roll_no = $_SESSION['roll_no'];


// Get asset_id from query parameter
if (isset($_GET['asset_id'])) {
    $asset_id = $_GET['asset_id'];

    // Fetch computer details
    try {
        $query = "SELECT * FROM computers WHERE asset_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare SQL statement: " . $conn->error);
        }

        $stmt->bind_param("s", $asset_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Computer with the specified asset ID not found.");
        }

        $computer = $result->fetch_assoc();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Asset ID not specified.");
}

// Handle complaint submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data when the form is submitted
    $selected_problems = isset($_POST['problems']) ? implode(", ", $_POST['problems']) : '';
    $other_problem = isset($_POST['other_problem']) ? $_POST['other_problem'] : '';

    // Validate input
    if (empty($selected_problems) && empty($other_problem)) {
        echo "<p>Error: Please select at least one problem or describe another problem.</p>";
    } else {
        // Prepare SQL query to insert data
        try {
            // Prepare the INSERT statement
            $stmt = $conn->prepare("INSERT INTO complaints (roll_no, asset_id, issue_description, status, created_at, selected_problems, email) VALUES (?, ?, ?, 'Pending', now(), ?, ?)");
            
            // Check if statement was prepared successfully
            if (!$stmt) {
                throw new Exception("Failed to prepare SQL statement: " . $conn->error);
            }

            // Bind parameters to the SQL query
            $stmt->bind_param("issss", $roll_no, $asset_id, $other_problem, $selected_problems, $email);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p>Thank you for submitting your problems! We have saved your data.</p>";
                header("Location: track_complaints.php");

            } else {
                throw new Exception("Error executing query: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Complaint - <?php echo htmlspecialchars($computer['computer_name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: #555;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #ecf0f1;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .problem-description {
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
<form action="" method="POST">
    <h2>Check the Computer Problems You've Experienced</h2>

    <div class="form-section">
        <label><input type="checkbox" name="problems[]" value="Slow Performance"> Slow Performance</label>
        <label><input type="checkbox" name="problems[]" value="Software Crashes"> Software Crashes</label>
        <label><input type="checkbox" name="problems[]" value="Blue Screen of Death (BSOD)"> Blue Screen of Death (BSOD)</label>
        <label><input type="checkbox" name="problems[]" value="Internet Connectivity Issues"> Internet Connectivity Issues</label>
        <label><input type="checkbox" name="problems[]" value="Virus or Malware Infections"> Virus or Malware Infections</label>
        <label><input type="checkbox" name="problems[]" value="Driver Issues"> Driver Issues</label>
        <label><input type="checkbox" name="problems[]" value="Hardware Failures"> Hardware Failures</label>
        <label><input type="checkbox" name="problems[]" value="Operating System Errors"> Operating System Errors</label>
        <label><input type="checkbox" name="problems[]" value="Peripheral Issues"> Peripheral Issues</label>
        <label><input type="checkbox" name="problems[]" value="Disk Space Running Out"> Disk Space Running Out</label>
        <label><input type="checkbox" name="problems[]" value="Overheating"> Overheating</label>
        <label><input type="checkbox" name="problems[]" value="Password or Login Issues"> Password or Login Issues</label>
        <label><input type="checkbox" name="problems[]" value="Display Problems"> Display Problems</label>
        <label><input type="checkbox" name="problems[]" value="File Corruption"> File Corruption</label>
        <label><input type="checkbox" name="problems[]" value="Compatibility Issues"> Compatibility Issues</label>
    </div>

    <div class="form-section">
        <label for="other_problem"><input type="checkbox" id="other_problem_checkbox" name="problems[]" value="Other"> Another Big Problem (Describe below):</label><br>
        <textarea id="other_problem" name="other_problem" rows="4" cols="50" placeholder="If 'Other' is selected, please describe the problem here..."></textarea>
        <p class="problem-description">You can describe any other problems that are not listed above.</p>
    </div>

    <input type="submit" value="Submit">
</form>

</body>
</html>
