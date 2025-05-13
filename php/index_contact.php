<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Xoventa";
// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    // Collect and sanitize input
    $name    = htmlspecialchars(trim($_POST["name"]));
    $number  = htmlspecialchars(trim($_POST["number"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO index_contact (name, number, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $number, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>
                alert('Message sent successfully!');
                window.location.href = '../html/index.html'; // change to your home page
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not send message.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
