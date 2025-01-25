<?Php
session_start();
// Define the path to the requested image and fallback image
function imgload(){

    $imagePath = "";
    $fallbackImagePath = "componants\assets\user.png";
    
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
            <img src="componants/assets/student_logo.png" alt="student Logo" height="160px">
            
            <span>Complaint Portal</span>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav-menu">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="labs/labs_overview.php">Labs</a></li>
            <li class="user-info">
                <img src="componants\assets\user.png" alt="User Avatar" class="user-avatar" onclick="toggleUserPopup()"> <!-- Replace 'user.png' with the actual path to user avatar -->
                <div class="user-popup" id="userPopup">
                    <p><strong>Welcome, <?php echo $_SESSION['user_name'] ?></strong></p>
                    <p><?php echo $_SESSION['email']?></p>
                    <button onclick="window.location.href='user_profile.php';">View Profile</button>
                    <button onclick="window.location.href='\index.html'">Logout</button>
                    
                </div>
            </li>
        </ul>
    </header>
    <h1><?php echo $_SESSION['roll_no'] ?></h1>
</body>
</html>
