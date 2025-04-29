<?php
session_start();
require 'db.php';

// Simulated user login
$user_id = $_SESSION['user_id'] ?? 1; // Replace with actual session user ID logic

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $file = $_FILES['profile_pic'];
    $fileName = basename($file['name']);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array(strtolower($ext), $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'Only JPG, PNG, or GIF files allowed']);
        exit;
    }

    $newName = 'user_' . $user_id . '_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $newName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Save to database
        $stmt = $conn->prepare("UPDATE users SET profile_pic=? WHERE id=?");
        $stmt->bind_param("si", $newName, $user_id);
        $stmt->execute();
        echo json_encode(['status' => 'success', 'path' => $targetPath]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Upload failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>

