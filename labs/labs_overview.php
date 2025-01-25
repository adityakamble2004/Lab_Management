<?php
include('../database/connection.php');

// Fetch lab details from the database
$query = "SELECT DISTINCT Lab FROM computers";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching labs: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labs Overview</title>
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
        .lab-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .lab-card {
            background: #fff;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .lab-card:hover {
            transform: scale(1.05);
        }
        .lab-card h3 {
            margin: 10px 0;
        }
        .lab-card a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .lab-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Labs Overview</h1>
    <div class="lab-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="lab-card">
                <h3><?php echo htmlspecialchars($row['Lab']); ?></h3>
                <a href="lab_details.php?Lab=<?php echo urlencode($row['Lab']); ?>">View Details</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
