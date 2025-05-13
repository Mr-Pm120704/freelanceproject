<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor1/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'muruganandhamm7639@gmail.com'; //sales@fusionfathom.com
        $mail->Password = 'xrjf vaoq lkfm hhqz';  //Fathom@2024
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->setFrom('muruganandhamm7639@gmail.com', 'Fusion Fathom Contact Form'); 
        $mail->addReplyTo($email, $name); 

        // Set the recipient email address
        $mail->addAddress('muruganandhamm7639@gmail.com', 'Recipient Name');

        // Email content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = "<h3>Contact Form Details</h3>
                       <p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Mobile No.:</strong> $number</p>
                       <p><strong>Subject:</strong> $subject</p>
                       <p><strong>Message:</strong><br>$message</p>";
        $mail->send();
        header("Location: ../html/index.html?status=success");
        exit();
    } catch (Exception $e) {
        header("Location: ../html/index.html?status=error");
        exit();
    }
}
?>
