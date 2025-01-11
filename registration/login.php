<?php
session_start();

// Database connection details
$host = "localhost";
$db_user = "root"; // Default XAMPP username
$db_password = ""; // Default XAMPP password
$dbname = "college"; // Change to your database name

// Connect to the MySQL database
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate user input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = trim($_POST['roll_no']);
    $password = trim($_POST['password']);

    if (empty($roll_no) || empty($password)) {
        echo "<script>alert('Both fields are required!'); window.location.href='login.html';</script>";
        exit;
    }

    // Query to check user details
    $query = "SELECT * FROM users WHERE roll_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Start session and store user data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['roll_no'] = $user['roll_no'];


            // Redirect to the homepage
            header('Location: ../home_page_complaint_site.php');
            exit;
        } else {
            echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid roll number or password!'); window.location.href='login.html';</script>";
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
