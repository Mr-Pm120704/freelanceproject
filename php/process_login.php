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
    $email = sanitize_input($_POST["email"]);
    $password = $_POST["password"]; // Don't sanitize password before verification
    $remember = isset($_POST["remember"]) ? true : false;
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Invalid email format";
        header("Location: login.php");
        exit();
    }
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, firstname, lastname, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            session_regenerate_id(); // Prevent session fixation attacks
            
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['user_email'] = $user['email'];
            
            // Set remember me cookie if checked
            if ($remember) {
                // Generate a secure token
                $token = bin2hex(random_bytes(32));
                
                // Store token in database
                $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));
                $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expiry) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $user['id'], $token, $expiry);
                $stmt->execute();
                
                // Set cookie
                setcookie('remember_token', $token, time() + (86400 * 30), "/", "", true, true); // 30 days
            }
            
            // Log login activity
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $stmt = $conn->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user['id'], $ip_address, $user_agent);
            $stmt->execute();
            
            // Redirect to dashboard
            header("Location: ../html/index.html");
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid email or password";
            header("Location: login.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "Invalid email or password";
        header("Location: login.php");
        exit();
    }
    
    $stmt->close();
} else {
    // If not a POST request, redirect to login page
    header("Location: login.php");
    exit();
}

$conn->close();
?>