<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(strip_tags($_POST["name"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(strip_tags($_POST["phone"]));
    $message = htmlspecialchars(strip_tags($_POST["message"]));

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $to = "info@adiclinic.com"; // Replace with clinic's actual email
        $subject = "New Contact Form Submission from $name";
        $body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
        $headers = "From: $email";

        // In a real environment, uncomment the mail() function below
        // if (mail($to, $subject, $body, $headers)) {
        //     echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.html';</script>";
        // } else {
        //     echo "<script>alert('Oops! Something went wrong, please try again.'); window.history.back();</script>";
        // }

        // For demonstration, just show success:
        echo "<script>alert('Thank you! Your message has been processed successfully.'); window.location.href='contact.html';</script>";

    } else {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
    }
} else {
    header("Location: contact.html");
    exit();
}
?>
