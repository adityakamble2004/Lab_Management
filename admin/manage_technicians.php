<?php
// Include database connection
include('../database/connection.php');


// Handle Add Technician
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_technician'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $verification_token = bin2hex(random_bytes(16));

    if (!empty($name) && !empty($email) && !empty($_POST['password'])) {
        $query = "INSERT INTO technicians (name, email, password, phone, specialization, verification_token) 
                  VALUES ('$name', '$email', '$password', '$phone', '$specialization', '$verification_token')";
        mysqli_query($conn, $query);
    }
}

// Handle Update Technician
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_technician'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $status = $_POST['status'];
    $verified = isset($_POST['verified']) ? 1 : 0;

    if (!empty($id) && !empty($name) && !empty($email)) {
        $query = "UPDATE technicians 
                  SET name='$name', email='$email', phone='$phone', specialization='$specialization', status='$status', verified=$verified 
                  WHERE id=$id";
        mysqli_query($conn, $query);
    }
}

// Handle Delete Technician
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM technicians WHERE id=$id";
    mysqli_query($conn, $query);
}

// Fetch Technicians
$technicians = mysqli_query($conn, "SELECT * FROM technicians");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Technicians</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        form {
            margin-bottom: 20px;
        }
        input, select {
            padding: 8px;
            margin: 5px;
        }
        button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            color: white;
        }
        .add-btn { background-color: #28a745; }
        .update-btn { background-color: #007bff; }
        .delete-btn { background-color: #dc3545; }
    </style>
</head>
<body>
<?php include('header.php'); ?>
<h2>Manage Technicians</h2>

<!-- Add Technician Form -->
<form method="POST">
    <input type="text" name="name" placeholder="Technician Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="specialization" placeholder="Specialization">
    <button type="submit" name="add_technician" class="add-btn">Add Technician</button>
</form>

<!-- Display Technicians -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Specialization</th>
            <th>Status</th>
            <th>Verified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($technicians)) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?? 'N/A' ?></td>
                <td><?= $row['specialization'] ?? 'N/A' ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['verified'] ? 'Yes' : 'No' ?></td>
                <td>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="name" value="<?= $row['name'] ?>" required>
                        <input type="email" name="email" value="<?= $row['email'] ?>" required>
                        <input type="text" name="phone" value="<?= $row['phone'] ?>">
                        <input type="text" name="specialization" value="<?= $row['specialization'] ?>">
                        <select name="status">
                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                        <label><input type="checkbox" name="verified" <?= $row['verified'] ? 'checked' : '' ?>> Verified</label>
                        <button type="submit" name="update_technician" class="update-btn">Update</button>
                    </form>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">
                        <button class="delete-btn">Delete</button>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
