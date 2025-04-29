<!-- ✅ 6. save_myinfo.php -->
<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO user_info (user_id, full_name, gender, age, religion, country, height, weight, skin_tone, education, occupation, salary, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississddsssis",
    $user_id,
    $_POST['full_name'],
    $_POST['gender'],
    $_POST['age'],
    $_POST['religion'],
    $_POST['country'],
    $_POST['height'],
    $_POST['weight'],
    $_POST['skin_tone'],
    $_POST['education'],
    $_POST['occupation'],
    $_POST['salary'],
    $_POST['bio']
);

if ($stmt->execute()) {
    //echo "✅ Info saved! <a href='profile.html'>Back to Profile</a>";
    header("Location: profile.html");
} else {
    echo "❌ Error: " . $stmt->error;
}
?>
