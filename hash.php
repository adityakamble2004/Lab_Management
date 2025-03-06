<?php
echo password_hash('adi', PASSWORD_DEFAULT);
?>

<!-- INSERT INTO teachers (name, email, phone_number, lab_in_charge, username, password_hash, role, created_at, updated_at) 
VALUES ('Test Teacher', 'test.teacher@example.com', '9876543210', 'Lab 1', 'test_teacher', 
        '$2y$10$gNFyStR8.FUUPULqOusNMOQ1rDWHfyWZo7j5M9BCwTL3T0ypUKhEu', 'Teacher', NOW(), NOW()); -->
