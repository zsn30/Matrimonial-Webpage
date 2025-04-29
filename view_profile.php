<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    echo "❌ Invalid request.";
    exit;
}

$user_id = intval($_GET['id']); // Very important: secure against SQL injection

// Fetch user details
$stmt = $conn->prepare("
    SELECT u.email, u.profile_pic, i.full_name, i.gender, i.age, i.religion, i.country, 
           i.height, i.weight, i.skin_tone, i.education, i.occupation, i.salary, i.bio
    FROM users u
    JOIN user_info i ON u.id = i.user_id
    WHERE u.id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "❌ Profile not found.";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Partner Profile</title>
    <style>
        .profile-card {
            width: 400px;
            margin: 30px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .profile-card h2 {
            margin-bottom: 10px;
        }
        .profile-card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="profile-card">
    <img src="uploads/<?php echo htmlspecialchars($row['profile_pic']); ?>" alt="Profile Picture">
    <h2><?php echo htmlspecialchars($row['full_name']); ?></h2>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($row['age']); ?></p>
    <p><strong>Religion:</strong> <?php echo htmlspecialchars($row['religion']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
    <p><strong>Height:</strong> <?php echo htmlspecialchars($row['height']); ?></p>
    <p><strong>Weight:</strong> <?php echo htmlspecialchars($row['weight']); ?> kg</p>
    <p><strong>Skin Tone:</strong> <?php echo htmlspecialchars($row['skin_tone']); ?></p>
    <p><strong>Education:</strong> <?php echo htmlspecialchars($row['education']); ?></p>
    <p><strong>Occupation:</strong> <?php echo htmlspecialchars($row['occupation']); ?></p>
    <p><strong>Salary:</strong> <?php echo htmlspecialchars(number_format($row['salary'])); ?> Tk</p>
    <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($row['bio'])); ?></p>
    <br>
    <a href="search.php">🔙 Back to Search</a>
</div>

</body>
</html>
