<!-- ✅ 10. update_familyinfo.php -->
<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$fields = ["father_name", "father_occupation", "father_education", "mother_name", "mother_occupation", "mother_education", "brother_name", "brother_occupation", "brother_education", "sister_name", "sister_occupation", "sister_education"];

$sql = "UPDATE family_info SET ";
$params = [];
$types = "";

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $sql .= "$field = ?, ";
        $params[] = $_POST[$field];
        $types .= "s";
    }
}

$sql = rtrim($sql, ", ") . " WHERE user_id = ?";
$params[] = $user_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo "✅ Family Info updated! <a href='profile.html'>Back to Profile</a>";
} else {
    echo "❌ Update failed: " . $stmt->error;
}
?>