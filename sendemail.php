<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer classes using Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email']; // Sender's email
    $query = $_POST['query'];
    $address = $_POST['address'];

    $mail = new PHPMailer(true);

    try {
        // 1. Sending the main query email to your company
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sk.globalcounsaltant@gmail.com'; // Your Gmail email
        $mail->Password = 'ioro hyvd tbfb wdkb'; // Your Google App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('sk.globalcounsaltant@gmail.com', 'SK Global Consultant'); // Your company's email and name
        $mail->addAddress('sk.globalcounsaltant@gmail.com', 'SK Global Consultant'); // Your company's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Query from $name";
        $mail->Body = "
            <h4>New Query from: $name</h4>
            <p><strong>Mobile:</strong> $mobile</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Address:</strong> $address</p>
            <p><strong>Query:</strong> $query</p>
        ";

        $mail->send();

        // 2. Sending an auto-reply to the sender
        $autoReply = new PHPMailer(true);
        $autoReply->isSMTP();
        $autoReply->Host = 'smtp.gmail.com';
        $autoReply->SMTPAuth = true;
        $autoReply->Username = 'sk.globalcounsaltant@gmail.com'; // Your Gmail email
        $autoReply->Password = 'ioro hyvd tbfb wdkb'; // Your Google App Password
        $autoReply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $autoReply->Port = 587;

        // Auto-reply Recipients
        $autoReply->setFrom('sk.globalcounsaltant@gmail.com', 'SK Global Consultant'); // Your company's email
        $autoReply->addAddress($email); // Sender's email (user who filled out the form)

        // Auto-reply content
        $autoReply->isHTML(true);
        $autoReply->Subject = 'Thank you for your query!';
        $autoReply->Body = "
            <h4>Thank you for reaching out, $name!</h4>
            <p>We have received your query and will get back to you as soon as possible. Here's a summary of your query:</p>
            <p><strong>Query:</strong> $query</p>
            <br>
            <p>In the meantime, feel free to explore our services on <a href='https://yourwebsite.com'>our website</a> or contact us at +1234567890.</p>
            <p>Best Regards,<br>SK Global Consultant</p>
            <p><em>--Your trusted partner in global consulting.--</em></p>
        ";

        $autoReply->send();

        echo 'Email has been sent, and a confirmation has been sent to the user.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
