<?php
session_start();
include('../database/connection.php');


if (!isset($_SESSION['roll_no'])) {
    die("Roll number not set in session.");
}

$roll_no = $_SESSION['roll_no'];

// Fetch user details from database
$sql = "SELECT * FROM users WHERE roll_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $roll_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['class'] = $user['class'];
    $_SESSION['subjects'] = $user['subjects'];
    $_SESSION['photo'] = $user['photo'] ?: 'componants/assets/user.png'; // Default image if not set
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_verified'] = $user['is_verified'];
} else {
    die("User not found.");
}

$stmt->close();
$conn->close();
?>

<?Php
// Define the path to the requested image and fallback image
function imgload(){

    $imagePath = "";
    $fallbackImagePath = "../componants\assets\user.png";
    
    // Check if the requested image exists
    if (file_exists($imagePath)) {
        $imageToLoad = $imagePath; // Load the requested image
    } else {
        $imageToLoad = $fallbackImagePath; // Load the fallback image
    }
    
    // Serve the image
    header("Content-Type: image/jpeg"); // Set the content type (adjust based on image type)
    readfile($imageToLoad); // Output the image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page Header</title>
    <link rel="stylesheet" href="home_page_complaint_site.css">

     <!-- fevicon code -->
     <link rel="apple-touch-icon" sizes="57x57" href="fevicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="fevicon//apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="fevicon//apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="fevicon//apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="fevicon//apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="fevicon//apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="fevicon//apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="fevicon//apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="fevicon//apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="fevicon//android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="fevicon//favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="fevicon//favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="fevicon//favicon-16x16.png">
    <link rel="manifest" href="fevicon//manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <script>
        function toggleUserPopup() {
            const popup = document.getElementById('userPopup');
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
            } else {
                popup.style.display = 'block';
            }
        }

        function logoutUser() {
            alert("You have been logged out.");
            // Redirect to the login page
            window.location.href = 'login.html';
        }
    </script>
</head>
<body>
    <header class="header">
        <!-- Logo Section -->
        <div class="logo">
            <img src="../componants/assets/student_logo.png" alt="student Logo" height="160px">
            
            <span>Complaint Portal</span>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav-menu">
            <li><a href="#">Home</a></li>
            <li><a href="../labs/complains/track_complaints.php">complains</a></li>
            <li><a href="../bot\chatbot.html">Bot</a></li>
            <li><a href="../labs/labs_overview.php">Labs</a></li>
            <li class="user-info">
            <img src="<?php echo $_SESSION['photo']; ?>" alt="User Avatar" class="user-avatar" onclick="toggleUserPopup()"> <!-- Replace 'user.png' with the actual path to user avatar -->
                <div class="user-popup" id="userPopup">
                    <p><strong>Welcome, <?php echo $_SESSION['user_name'] ?></strong></p>
                    <p><?php echo $_SESSION['email']?></p>
                    <button onclick="window.location.href='user_profile.php';">View Profile</button>
                    <button onclick="window.location.href='\logout.php'">Logout</button>
                    
                </div>
            </li>
        </ul>
    </header>
    <div class="mainsection">
    <?php
include('C:/xampp/htdocs/college_web/student/complain.php');
?>

    </div>
</body>
</html>
