<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO partner_requirement (user_id, gender, country, religion, occupation, min_salary, min_height, skin_tone) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssiss",
    $user_id,
    $_POST['gender'],
    $_POST['country'],
    $_POST['religion'],
    $_POST['occupation'],
    $_POST['min_salary'],
    $_POST['min_height'],
    $_POST['skin_tone']
);

if ($stmt->execute()) {
    //echo "✅ Partner Requirement saved! <a href='profile.html'>Back to Profile</a>";
    header("Location: profile.html");
} else {
    echo "❌ Error: " . $stmt->error;
}
?>
