<?php
$host = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password
$dbname = "college"; // Change to your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (roll_no,name, email, password) VALUES (?,?, ?, ?)");
        $stmt->bind_param("ssss",$roll_no, $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
            sleep(2);
            header("Location:login.html");

        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}
$conn->close();
?>

