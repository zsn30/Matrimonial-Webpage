<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($pic);
$stmt->fetch();
$stmt->close();

if ($pic && file_exists("uploads/" . $pic)) {
    echo json_encode(['status' => 'success', 'path' => 'uploads/' . $pic]);
} else {
    echo json_encode(['status' => 'default', 'path' => 'uploads/default.png']);
}
