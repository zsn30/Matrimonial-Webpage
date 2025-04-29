<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "matdm";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryType = $_POST['queryType'];

    if ($queryType == 'nested') {
        $sql = "SELECT full_name, occupation
                FROM user_info
                WHERE occupation = (
                    SELECT occupation
                    FROM user_info
                    GROUP BY occupation
                    ORDER BY COUNT(*) ASC
                    LIMIT 1
                )";
    } 
    else if ($queryType == 'having') {
        $sql = "SELECT religion, COUNT(*) AS total 
                FROM user_info 
                GROUP BY religion 
                HAVING COUNT(*) > 2";
    }
    else if ($queryType == 'view') {
        // Create the view first if not exists (optional)
        $conn->query("CREATE OR REPLACE VIEW user_full_profile AS
                      SELECT u.id, u.email, ui.full_name, ui.gender, ui.age, ui.religion, ui.country
                      FROM users u
                      JOIN user_info ui ON u.id = ui.user_id");

        $sql = "SELECT * FROM user_full_profile";
    }
    else if ($queryType == 'insert_into') {
        // Create table if not exists
        $conn->query("CREATE TABLE IF NOT EXISTS female_users (
            user_id INT PRIMARY KEY,
            full_name VARCHAR(100),
            age INT,
            country VARCHAR(50)
        )");

        $conn->query("INSERT IGNORE INTO female_users (user_id, full_name, age, country)
                      SELECT user_id, full_name, age, country
                      FROM user_info
                      WHERE gender = 'Female'");

        echo "<h3>Female users inserted into 'female_users' table successfully!</h3>";

        // Fetch and display the data from female_users table
        $sql = "SELECT * FROM female_users";
    }
    else if ($queryType == 'procedure') {
        // Create procedure if not exists
        $conn->query("DROP PROCEDURE IF EXISTS UpdateSalary");
        $conn->query("CREATE PROCEDURE UpdateSalary(IN uid INT, IN new_salary INT)
                      BEGIN
                          UPDATE user_info
                          SET salary = new_salary
                          WHERE user_id = uid;
                      END");

        $conn->query("CALL UpdateSalary(5, 60000)");
        echo "<h3>Salary updated for user ID 5!</h3>";
        exit();
    }
    else if ($queryType == 'trigger') {
        // Create trigger if not exists
        $conn->query("DROP TRIGGER IF EXISTS after_user_insert");
        $conn->query("CREATE TRIGGER after_user_insert
                      AFTER INSERT ON users
                      FOR EACH ROW
                      BEGIN
                        INSERT INTO family_info(user_id) VALUES (NEW.id);
                      END");

        echo "<h3>Trigger 'after_user_insert' created successfully!</h3>";
        exit();
    }
    else {
        echo "Invalid Query!";
        exit();
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'><tr>";
        while ($fieldinfo = $result->fetch_field()) {
            echo "<th>" . htmlspecialchars($fieldinfo->name) . "</th>";
        }
        echo "</tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
}
$conn->close();
?>
