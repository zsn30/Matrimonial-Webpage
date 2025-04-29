<!-- ✅ 5. myinfo.php -->
<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM user_info WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>My Info</h2>";
    echo "<form action='update_myinfo.php' method='POST'>";
    foreach ($row as $key => $value) {
        if ($key !== "user_id" && $key !== "profile_pic") {
            echo ucfirst(str_replace("_", " ", $key)) . ": ";
            echo "<input type='text' name='$key' value='" . htmlspecialchars($value) . "'><br><br>";
        }
    }
    echo "<input type='submit' value='Update Info'>";
    echo "</form>";
} else {
    echo '<h2>Enter Your Information</h2>';
    echo '<form action="save_myinfo.php" method="POST">';
    echo 'Full Name: <input type="text" name="full_name"><br><br>';
    echo 'Gender: <select name="gender"><option>Male</option><option>Female</option><option>Other</option></select><br><br>';
    echo 'Age: <input type="number" name="age"><br><br>';
    echo 'Religion: <input type="text" name="religion"><br><br>';
    echo 'Country: <input type="text" name="country"><br><br>';
    echo 'Height: <input type="text" name="height"><br><br>';
    echo 'Weight: <input type="text" name="weight"><br><br>';
    echo 'Skin Tone: <select name="skin_tone"><option>Fair</option><option>Brown</option><option>Black</option></select><br><br>';
    echo 'Education: <input type="text" name="education"><br><br>';
    echo 'Occupation: <input type="text" name="occupation"><br><br>';
    echo 'Salary: <input type="number" name="salary"><br><br>';
    echo 'Bio: <textarea name="bio" maxlength="250"></textarea><br><br>';
    echo '<input type="submit" value="Save Info">';
    echo '</form>';
}
?>