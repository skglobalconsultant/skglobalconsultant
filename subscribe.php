<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer classes using Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);

        try {
            // Set up PHPMailer for SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sk.globalcounsaltant@gmail.com'; // Your Gmail email
            $mail->Password = 'ioro hyvd tbfb wdkb'; // Your Google App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Send subscription notification to your email
            $mail->setFrom('sk.globalcounsaltant@gmail.com', 'SK Global Consultant');
            $mail->addAddress('sk.globalcounsaltant@gmail.com'); // Your email

            // Email content for admin
            $mail->isHTML(true);
            $mail->Subject = 'New Newsletter Subscription';
            $mail->Body = "<p>You have a new newsletter subscription from: $email</p>";

            $mail->send();

            // Now send an automatic reply to the subscriber
            $autoReply = new PHPMailer(true);
            $autoReply->isSMTP();
            $autoReply->Host = 'smtp.gmail.com';
            $autoReply->SMTPAuth = true;
            $autoReply->Username = 'sk.globalcounsaltant@gmail.com'; // Your Gmail email
            $autoReply->Password = 'ioro hyvd tbfb wdkb'; // Your Google App Password
            $autoReply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $autoReply->Port = 587;

            // Set from and to address for the auto-reply
            $autoReply->setFrom('sk.globalcounsaltant@gmail.com', 'SK Global Consultant');
            $autoReply->addAddress($email); // The subscriber's email

            // Auto-reply email content
            $autoReply->isHTML(true);
            $autoReply->Subject = 'Thank you for subscribing to SK Global Consultant Newsletter!';
            $autoReply->Body = "
                <h4>Thank you for subscribing to our newsletter!</h4>
                <p>We are thrilled to have you on board. As part of the SK Global Consultant family, you'll receive exclusive updates on our services and offerings.</p>
                <p>Here is what we offer:</p>
                <ul>
                    <li>Global consulting for business strategies</li>
                    <li>Market insights and analysis</li>
                    <li>Personalized business solutions</li>
                </ul>
                <p>Stay tuned for more information and feel free to contact us for any further assistance.</p>
                <p>Best Regards,<br>SK Global Consultant Team</p>
                <p><em>Leading the way in global business consulting.</em></p>
            ";

            $autoReply->send();

            // Show success message to the user
            echo "<p>Thank you for subscribing to our newsletter! A confirmation email has been sent to your inbox.</p>";

        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<p>Invalid email address. Please try again.</p>";
    }
}
?>
