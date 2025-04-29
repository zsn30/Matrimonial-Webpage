<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';


$gender = $_POST['gender'] ?? '';
$age_range = $_POST['age_range'] ?? '';
$salary = $_POST['salary'] ?? '';
$religion = $_POST['religion'] ?? '';
$height = $_POST['height'] ?? '';
$country = $_POST['country'] ?? '';
$skin_tone = $_POST['skin_tone'] ?? '';

$conditions = [];
$params = [];
$types = "";

// Build search conditions
if (!empty($gender)) {
    $conditions[] = "i.gender = ?";
    $params[] = $gender;
    $types .= "s";
}

if (!empty($age_range)) {
    if ($age_range == "45+") {
        $conditions[] = "i.age >= ?";
        $params[] = 45;
        $types .= "i";
    } else {
        list($minAge, $maxAge) = explode("-", $age_range);
        $conditions[] = "(i.age BETWEEN ? AND ?)";
        $params[] = (int)$minAge;
        $params[] = (int)$maxAge;
        $types .= "ii";
    }
}

if (!empty($salary)) {
    $conditions[] = "i.salary >= ?";
    $params[] = (int)$salary;
    $types .= "i";
}

if (!empty($religion)) {
    $conditions[] = "i.religion = ?";
    $params[] = $religion;
    $types .= "s";
}

if (!empty($height)) {
    $conditions[] = "i.height = ?";
    $params[] = $height;
    $types .= "s";
}

if (!empty($country)) {
    $conditions[] = "i.country = ?";
    $params[] = $country;
    $types .= "s";
}

if (!empty($skin_tone)) {
    $conditions[] = "i.skin_tone = ?";
    $params[] = $skin_tone;
    $types .= "s";
}

// Final query
$sql = "
SELECT u.id, u.email, u.profile_pic, i.full_name, i.age, i.gender, i.country, i.religion, i.height, i.skin_tone, i.education, i.occupation
FROM users u
JOIN user_info i ON u.id = i.user_id
";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px'>";
        echo "<img src='uploads/" . htmlspecialchars($row['profile_pic']) . "' width='80' height='80' style='border-radius:50%;'><br><br>";
        echo "<strong>Name:</strong> " . htmlspecialchars($row['full_name']) . "<br>";
        echo "<strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "<br>";
        echo "<strong>Age:</strong> " . htmlspecialchars($row['age']) . "<br>";
        echo "<strong>Country:</strong> " . htmlspecialchars($row['country']) . "<br>";
        echo "<strong>Religion:</strong> " . htmlspecialchars($row['religion']) . "<br>";
        echo "<strong>Skin Tone:</strong> " . htmlspecialchars($row['skin_tone']) . "<br>";
        echo "<strong>Education:</strong> " . htmlspecialchars($row['education']) . "<br>";
        echo "<strong>Occupation:</strong> " . htmlspecialchars($row['occupation']) . "<br>";
        echo "<a href='view_profile.php?id=" . $row['id'] . "'>View Full Profile</a>";
        echo "</div>";
    }
} else {
    echo "No matching partners found.";
}
?>
