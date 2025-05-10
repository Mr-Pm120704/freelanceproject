<?php
require_once 'db-connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files
require 'vendor1/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor1/phpmailer/phpmailer/src/SMTP.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$workshopId = $_POST['workshop_id'];

// Fetch workshop details
$workshopQuery = $conn->query("SELECT * FROM workshops WHERE id = $workshopId");
if (!$workshopQuery || $workshopQuery->num_rows == 0) {
    die("Invalid workshop ID");
}
$workshop = $workshopQuery->fetch_assoc();

// Insert application into DB
$conn->query("INSERT INTO applications (workshop_id, name, email, phone) VALUES ('$workshopId', '$name', '$email', '$phone')");

// Email setup
$mail = new PHPMailer(true);
try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;
    $mail->Username = 'muruganandhamm7639@gmail.com'; 
    $mail->Password = 'xrjf vaoq lkfm hhqz';  
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // ======================
    // Send email to User
    // ======================
    $mail->setFrom('yourgmail@gmail.com', 'Workshop Team');
    $mail->addAddress($email, $name);
    $mail->Subject = "Your Application for " . $workshop['name'];
    $mail->Body = "Hi $name,\n\nYou have successfully applied for the workshop: " . $workshop['name'] . " (" . $workshop['duration'] . ").\n\nThank you!";

    $mail->send();
    $mail->clearAddresses();

    // ======================
    // Send email to Admin
    // ======================
    $mail->addAddress('admin@example.com'); 
    $mail->Subject = "New Workshop Application: " . $workshop['name'];
    $mail->Body = "New applicant:\nName: $name\nEmail: $email\nPhone: $phone\nWorkshop: " . $workshop['name'];

    $mail->send();

    echo "<script>
    alert('Application submitted successfully. Confirmation emails sented.');
    window.location.href = 'all-workshops.html';
    </script>";

} catch (Exception $e) {
    echo "<script>
    alert('Message could not be sent. Error: {$mail->ErrorInfo}');
    </script>";
}
?>
