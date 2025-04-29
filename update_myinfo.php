<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

// Update all fields except salary
$stmt = $conn->prepare("UPDATE user_info SET 
    full_name = ?, 
    gender = ?, 
    age = ?, 
    religion = ?, 
    country = ?, 
    height = ?, 
    weight = ?, 
    skin_tone = ?, 
    education = ?, 
    occupation = ?, 
    bio = ?
    WHERE user_id = ?");

$stmt->bind_param("ssissddsssss", 
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
    $_POST['bio'],
    $user_id
);

// Execute the update
if ($stmt->execute()) {
    // Now call the stored procedure to update salary
    $salary_stmt = $conn->prepare("CALL UpdateSalary(?, ?)");
    $salary_stmt->bind_param("ii", $user_id, $_POST['salary']);
    
    if ($salary_stmt->execute()) {
        echo "✅ Info updated successfully! <a href='profile.html'>Back to Profile</a>";
    } else {
        echo "❌ Error updating salary: " . $salary_stmt->error;
    }
} else {
    echo "❌ Error updating info: " . $stmt->error;
}
?>
