<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor1/autoload.php'; // or use manual include if not using Composer

// Collect form data
$field = $_POST['field'];
$subfield = $_POST['subfield'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Setup PHPMailer
$mail = new PHPMailer(true);
try {
    // Email to user
    $mail->setFrom('yourcompany@example.com', 'YourCompany Internships');
    $mail->addAddress($email, $name);
    $mail->Subject = "Your Application for $subfield Internship";
    $mail->Body = "Hello $name,\n\nThank you for applying for the $subfield internship under $field.\n\nWe'll get back to you soon.\n\n— YourCompany";

    $mail->send();

    // Email to admin
    $admin = new PHPMailer(true);
    $admin->setFrom('yourcompany@example.com');
    $admin->addAddress('admin@example.com');
    $admin->Subject = "New Internship Application: $subfield";
    $admin->Body = "New application received:\n\nName: $name\nEmail: $email\nPhone: $phone\nField: $field\nSubfield: $subfield";

    $admin->send();

    echo "<h3>Application submitted! Confirmation sent to your email.</h3>";

} catch (Exception $e) {
    echo "Error sending email: " . $mail->ErrorInfo;
}
?>
