<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        .menu {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .menu a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .menu a:hover, .menu a.active {
            background-color: #007bff;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <h3>System Management</h3>
        <a href="#" class="menu-item" data-page="AddComputer.html">Add Computer</a>
        <a href="#" class="menu-item" data-page="computer_list.php">computer list.php</a>
        <a href="#" class="menu-item" data-page="manage_technicians.php">Manage Technicians</a>
        <a href="#" class="menu-item" data-page="system_settings.php">System Settings</a>
        <a href="#" class="menu-item" data-page="reports.php">Reports</a>
        <a href="#" class="menu-item" data-page="logout.php">Logout</a>
    </div>
    
    <div class="content" id="content">
        <h2>Welcome to System Management</h2>
        <p>Select an option from the menu.</p>
    </div>

    <script>
        $(document).ready(function() {
            $(".menu-item").click(function(e) {
                e.preventDefault();
                let page = $(this).data("page");
                $(".menu-item").removeClass("active");
                $(this).addClass("active");
                
                $.ajax({
                    url: page,
                    type: "GET",
                    success: function(response) {
                        $("#content").html(response);
                    },
                    error: function() {
                        $("#content").html("<p>Error loading page.</p>");
                    }
                });
            });
        });
    </script>
</body>
</html>
