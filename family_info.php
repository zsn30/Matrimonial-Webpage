<!-- ✅ 8. family_info.php -->
<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM family_info WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Family Info</h2><form action='update_familyinfo.php' method='POST'>";
    foreach ($row as $key => $value) {
        if ($key !== "user_id") {
            echo ucfirst(str_replace("_", " ", $key)) . ": ";
            echo "<input type='text' name='$key' value='" . htmlspecialchars($value) . "'><br><br>";
        }
    }
    echo "<input type='submit' value='Update Family Info'></form>";
} else {
    echo '<h2>Enter Family Info</h2><form action="save_familyinfo.php" method="POST">';
    echo 'Father Name: <input type="text" name="father_name"><br><br>';
    echo 'Father Occupation: <input type="text" name="father_occupation"><br><br>';
    echo 'Father Education: <input type="text" name="father_education"><br><br>';
    echo 'Mother Name: <input type="text" name="mother_name"><br><br>';
    echo 'Mother Occupation: <input type="text" name="mother_occupation"><br><br>';
    echo 'Mother Education: <input type="text" name="mother_education"><br><br>';
    echo 'Brother Name: <input type="text" name="brother_name"><br><br>';
    echo 'Brother Occupation: <input type="text" name="brother_occupation"><br><br>';
    echo 'Brother Education: <input type="text" name="brother_education"><br><br>';
    echo 'Sister Name: <input type="text" name="sister_name"><br><br>';
    echo 'Sister Occupation: <input type="text" name="sister_occupation"><br><br>';
    echo 'Sister Education: <input type="text" name="sister_education"><br><br>';
    echo '<input type="submit" value="Save Family Info"></form>';
}
?>