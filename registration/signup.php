<?php
   include('../database/connection.php');
   echo realpath('../database/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($name) && !empty($email) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

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

