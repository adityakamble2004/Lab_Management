<?Php
session_start();
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
            <img src="componants/assets/logo.png" alt="Logo"> <!-- Replace 'logo.png' with the actual logo file -->
            <span>Complaint Portal</span>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav-menu">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="labs.html">Labs</a></li>
            <li class="user-info">
                <img src="componants\assets\user.png" alt="User Avatar" class="user-avatar" onclick="toggleUserPopup()"> <!-- Replace 'user.png' with the actual path to user avatar -->
                <div class="user-popup" id="userPopup">
                    <p><strong>Welcome, <?php echo $_SESSION['user_name'] ?></strong></p>
                    <p>Email: user@example.com</p>
                    <button onclick="window.location.href='user_profile.php';">View Profile</button>
                    <button onclick="window.location.href='\index.html'">Logout</button>
                </div>
            </li>
        </ul>
    </header>
</body>
</html>
