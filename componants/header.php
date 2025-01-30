<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page Header</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 70px;
            width: 70px;
            margin-right: 10px;
        }

        .header .logo span {
            font-size: 20px;
            font-weight: bold;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu li {
            margin: 0 10px;
        }

        .nav-menu a {
            text-decoration: none;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .nav-menu a:hover {
            background-color: #575757;
        }

        .user-info {
            position: relative;
        }

        .user-avatar {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            cursor: pointer;
        }

        .user-popup {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            padding: 10px;
            width: 200px;
            z-index: 10;
        }

        .user-popup p {
            margin: 0 0 10px;
            font-size: 14px;
        }

        .user-popup button {
            display: block;
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .user-popup button:hover {
            background-color: #0056b3;
        }
    </style>
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
            window.location.href = 'login.html';
        }
    </script>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="collage web/componants/assets/logo.png" alt="Logo"> 
            <span>Complaint Portal</span>
        </div>

        <ul class="nav-menu">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="labs.html">Labs</a></li>
            <li class="user-info">
                <img src="user.png" alt="User Avatar" class="user-avatar" onclick="toggleUserPopup()">
                <div class="user-popup" id="userPopup">
                    <p><strong>Welcome, [User Name]</strong></p>
                    <p>Email: user@example.com</p>
                    <button onclick="window.location.href='profile.html';">View Profile</button>
                    <button onclick="window.location.href=' ../registration/login.html'">Logout</button>
                </div>
            </li>
        </ul>
    </header>
</body>
</html>
