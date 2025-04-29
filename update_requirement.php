<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$fields = ["gender", "country", "religion", "occupation", "min_salary", "min_height", "skin_tone"];

$sql = "UPDATE partner_requirement SET ";
$params = [];
$types = "";

foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $sql .= "$field = ?, ";
        $params[] = $_POST[$field];
        $types .= ($field == 'min_salary') ? "i" : "s"; // min_salary is integer, others are string
    }
}

$sql = rtrim($sql, ", ") . " WHERE user_id = ?";
$params[] = $user_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo "✅ Requirement updated! <a href='profile.html'>Back to Profile</a>";
} else {
    echo "❌ Update failed: " . $stmt->error;
}
?>
