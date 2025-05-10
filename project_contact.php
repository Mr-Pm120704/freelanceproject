<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Xoventa";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    // Get and sanitize form inputs
    $name          = htmlspecialchars(trim($_POST["name"]));
    $number        = htmlspecialchars(trim($_POST["number"]));
    $email         = htmlspecialchars(trim($_POST["email"]));
    $project_type  = htmlspecialchars(trim($_POST["project_type"]));
    $project_title = htmlspecialchars(trim($_POST["project_title"]));
    $message       = htmlspecialchars(trim($_POST["message"]));

    // Prepare SQL insert statement
    $stmt = $conn->prepare("INSERT INTO project_contact (name, number, email, project_type, project_title, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $number, $email, $project_type, $project_title, $message);

    // Execute and handle response
    if ($stmt->execute()) {
        echo "<script>
                alert('Your project request has been submitted successfully!');
                window.location.href = 'index.html'; // ✅ Change this if needed
              </script>";
    } else {
        echo "<script>
                alert('Error: Unable to send your project request.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
