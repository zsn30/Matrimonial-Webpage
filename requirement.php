<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM partner_requirement WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$height_options = ['4ft 5inch', '5ft', '5ft 6inch', '6ft'];
$skin_tone_options = ['Fair', 'Brown', 'Black'];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>My Requirement</h2><form action='update_requirement.php' method='POST'>";
    
    // Gender
    echo "Gender: <select name='gender'>";
    foreach (['Male', 'Female', 'Other'] as $gender) {
        $selected = ($row['gender'] == $gender) ? "selected" : "";
        echo "<option value='$gender' $selected>$gender</option>";
    }
    echo "</select><br><br>";

    // Country
    echo "Country: <input type='text' name='country' value='" . htmlspecialchars($row['country']) . "'><br><br>";

    // Religion
    echo "Religion: <input type='text' name='religion' value='" . htmlspecialchars($row['religion']) . "'><br><br>";

    // Occupation
    echo "Occupation: <input type='text' name='occupation' value='" . htmlspecialchars($row['occupation']) . "'><br><br>";

    // Minimum Salary
    echo "Minimum Salary: <input type='number' name='min_salary' value='" . htmlspecialchars($row['min_salary']) . "'><br><br>";

    // Minimum Height
    echo "Minimum Height: <select name='min_height'>";
    foreach ($height_options as $height) {
        $selected = ($row['min_height'] == $height) ? "selected" : "";
        echo "<option value='$height' $selected>$height</option>";
    }
    echo "</select><br><br>";

    // Skin Tone
    echo "Skin Tone: <select name='skin_tone'>";
    foreach ($skin_tone_options as $tone) {
        $selected = ($row['skin_tone'] == $tone) ? "selected" : "";
        echo "<option value='$tone' $selected>$tone</option>";
    }
    echo "</select><br><br>";

    echo "<input type='submit' value='Update Requirement'></form>";

} else {
    echo '<h2>Enter Partner Requirement</h2><form action="save_requirement.php" method="POST">';
    
    // Gender
    echo "Gender: <select name='gender'>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select><br><br>";

    // Country
    echo 'Country: <input type="text" name="country"><br><br>';

    // Religion
    echo 'Religion: <input type="text" name="religion"><br><br>';

    // Occupation
    echo 'Occupation: <input type="text" name="occupation"><br><br>';

    // Minimum Salary
    echo 'Minimum Salary: <input type="number" name="min_salary"><br><br>';

    // Minimum Height
    echo 'Minimum Height: <select name="min_height">';
    foreach ($height_options as $height) {
        echo "<option value='$height'>$height</option>";
    }
    echo '</select><br><br>';

    // Skin Tone
    echo 'Skin Tone: <select name="skin_tone">';
    foreach ($skin_tone_options as $tone) {
        echo "<option value='$tone'>$tone</option>";
    }
    echo '</select><br><br>';

    echo '<input type="submit" value="Save Requirement"></form>';
}
?>
