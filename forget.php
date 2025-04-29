<?php
require 'db.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Send email with Mailtrap
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '703a7e2c4ce69a';
            $mail->Password = 'e6449be6fcb81b';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;

            $mail->setFrom('noreply@yourdomain.com', 'Matrimonial Website');
            $mail->addAddress($email);

            $mail->Subject = 'Your Password';
            $mail->Body    = "Your password is: " . $hashed_password;

            $mail->send();
            echo "✅ Password sent to your email!";
        } catch (Exception $e) {
            echo "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Email not found!";
    }

    $stmt->close();
    $conn->close();
}
?>
