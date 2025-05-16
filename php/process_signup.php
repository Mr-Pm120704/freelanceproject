<?php
session_start();
require_once 'db-connection.php';

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $firstname = sanitize_input($_POST["firstname"]);
    $lastname = sanitize_input($_POST["lastname"]);
    $email = sanitize_input($_POST["email"]);
    $phone = sanitize_input($_POST["phone"]);
    $password = $_POST["password"]; // Don't sanitize password before hashing
    $confirm_password = $_POST["confirm_password"];
    $terms = isset($_POST["terms"]) ? true : false;
    
    // Validate inputs
    $errors = [];
    
    // Validate name
    if (strlen($firstname) < 2 || strlen($lastname) < 2) {
        $errors[] = "First and last name must be at least 2 characters";
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists. Please use a different email or login.";
    }
    $stmt->close();
    
    // Validate phone
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits";
    }
    
    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    
    if (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }
    
    if (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }
    
    if (!preg_match("/[0-9]/", $password) && !preg_match("/[^a-zA-Z0-9]/", $password)) {
        $errors[] = "Password must contain at least one number or special character";
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check terms agreement
    if (!$terms) {
        $errors[] = "You must agree to the terms and conditions";
    }
    
    // If there are errors, redirect back to signup page
    if (!empty($errors)) {
        $_SESSION['signup_error'] = implode("<br>", $errors);
        header("Location: signup.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, phone, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $hashed_password);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Get the new user ID
        $user_id = $conn->insert_id;
        
        // Create verification token
        $verification_token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        // Store verification token
        $stmt = $conn->prepare("INSERT INTO email_verifications (user_id, token, expiry) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $verification_token, $expiry);
        $stmt->execute();
        
        // Send verification email
        $to = $email;
        $subject = "Verify Your Zara Tech Account";
        
        $message = "
        <html>
        <head>
            <title>Email Verification</title>
        </head>
        <body>
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <div style='background-color: #4154f1; padding: 20px; text-align: center; color: white;'>
                    <h2>Welcome to Zara Tech!</h2>
                </div>
                <div style='padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9;'>
                    <p>Dear $firstname,</p>
                    <p>Thank you for creating an account with Zara Tech. Please verify your email address by clicking the button below:</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='https://yourdomain.com/verify_email.php?token=$verification_token' style='background-color: #4154f1; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Verify Email</a>
                    </div>
                    <p>If the button doesn't work, you can copy and paste the following link into your browser:</p>
                    <p>https://yourdomain.com/verify_email.php?token=$verification_token</p>
                    <p>This link will expire in 24 hours.</p>
                    <p>Best Regards,<br>The Zara Tech Team</p>
                </div>
                <div style='text-align: center; padding: 10px; font-size: 12px; color: #666;'>
                    <p>© 2024 Zara Tech. All Rights Reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Zara Tech <zaratechpvt001@gmail.com>" . "\r\n";
        
        // Send email
        mail($to, $subject, $message, $headers);
        
        // Set success message and redirect to login page
        $_SESSION['login_message'] = "Account created successfully! Please check your email to verify your account.";
        header("Location: login.php");
        exit();
    } else {
        // If there was an error with the query
        $_SESSION['signup_error'] = "Error: " . $stmt->error;
        header("Location: signup.php");
        exit();
    }
    
    $stmt->close();
} else {
    // If not a POST request, redirect to signup page
    header("Location: signup.php");
    exit();
}

$conn->close();
?>