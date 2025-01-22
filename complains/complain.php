<form action="register_complaint.php" method="POST">
    <label for="computer_id">Select Computer:</label>
    <select name="computer_id" id="computer_id" required>
        <?php
        include('../database/connection.php');
        $query = "SELECT id, lab_name, computer_no FROM computers";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>Lab: {$row['lab_name']}, Computer: {$row['computer_no']}</option>";
        }
        ?>
    </select>

    <label for="issue_description">Describe the Issue:</label>
    <textarea name="issue_description" id="issue_description" required></textarea>

    <button type="submit">Submit Complaint</button>
</form>
