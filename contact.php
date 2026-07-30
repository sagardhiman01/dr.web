<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/Exception.php';
require 'vendor/phpmailer/PHPMailer.php';
require 'vendor/phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $service = strip_tags(trim($_POST["service"]));
    $message_content = trim($_POST["message"]);

    if (empty($name) || empty($message_content) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please fill all required fields correctly.'); window.history.back();</script>";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // TODO: Yahan apni real Gmail ID daalein (Jaise: dr.anilkumar@gmail.com)
        $mail->Username   = 'aadiphysiotherapy@gmail.com';
        
        // TODO: Yahan apna 16-digit Gmail App Password daalein (Spaces ke bina)
        $mail->Password   = 'yvzkaqrvxiywzdjh';
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('aadiphysiotherapy@gmail.com', 'Dr. Anil Kumar Website');
        $mail->addAddress('aadiphysiotherapy@gmail.com'); // This is where the emails will be received
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Appointment Request from $name";
        $mail->Body    = "
            <h2>New Appointment Request</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Service Needed:</strong> {$service}</p>
            <p><strong>Message:</strong><br/>" . nl2br(htmlspecialchars($message_content)) . "</p>
        ";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nService Needed: {$service}\nMessage:\n{$message_content}";

        $mail->send();
        echo "<script>alert('Thank you! Your appointment request has been sent successfully. We will get back to you soon.'); window.location.href = 'contact.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
} else {
    header("Location: contact.html");
    exit;
}
?>
