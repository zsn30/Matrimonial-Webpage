<!-- ✅ 9. save_familyinfo.php -->
<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO family_info (user_id, father_name, father_occupation, father_education, mother_name, mother_occupation, mother_education, brother_name, brother_occupation, brother_education, sister_name, sister_occupation, sister_education) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssssssss",
    $user_id,
    $_POST['father_name'],
    $_POST['father_occupation'],
    $_POST['father_education'],
    $_POST['mother_name'],
    $_POST['mother_occupation'],
    $_POST['mother_education'],
    $_POST['brother_name'],
    $_POST['brother_occupation'],
    $_POST['brother_education'],
    $_POST['sister_name'],
    $_POST['sister_occupation'],
    $_POST['sister_education']
);

if ($stmt->execute()) {
    //echo "✅ Family Info saved! <a href='profile.html'>Back to Profile</a>";
    header("Location: profile.html");
} else {
    echo "❌ Error: " . $stmt->error;
}
?>
