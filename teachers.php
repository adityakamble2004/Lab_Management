<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Selection</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        button {
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .teacher {
            background-color: #3498db;
            color: white;
        }
        .technician {
            background-color: #2ecc71;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Your Role</h2>
        <button class="teacher" onclick="location.href='teacher_login.html'">I am Teacher</button>
        <button class="technician" onclick="location.href='technician/login_technician.php'">I am Technician</button>
    </div>
</body>
</html>
