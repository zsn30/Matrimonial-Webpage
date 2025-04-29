<?php
session_start(); // ✅ Start session at the top
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // ✅ Select id and password from DB
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // ✅ Bind both id and password
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // ✅ Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id; // ✅ Set user_id
            header("Location: profile.html");
            exit();
        } else {
            echo "❌ Incorrect Password!";
        }
    } else {
        echo "❌ Email not registered!";
    }

    $stmt->close();
    $conn->close();
}
?>
