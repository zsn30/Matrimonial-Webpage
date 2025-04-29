<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io'; // ✅ Correct SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = '703a7e2c4ce69a'; // ✅ Use your Mailtrap username
    $mail->Password = 'e6449be6fcb81b'; // ✅ Use your Mailtrap password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ✅ Use STARTTLS
    $mail->Port = 2525; // ✅ Recommended Mailtrap port

    $mail->setFrom('noreply@yourdomain.com', 'Matrimonial Website');
    $mail->addAddress('test@example.com', 'Test User');

    $mail->Subject = 'Test Email via Mailtrap';
    $mail->Body    = 'Hello, this is a otp for you.';

    $mail->send();
    echo "✅ Email sent successfully via Mailtrap!";
} catch (Exception $e) {
    echo "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
