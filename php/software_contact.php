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

// Sanitize and receive input
$name = htmlspecialchars(trim($_POST['name']));
$number = htmlspecialchars(trim($_POST['number']));
$email = htmlspecialchars(trim($_POST['email']));
$service_category = htmlspecialchars(trim($_POST['service']));
$software_option = isset($_POST['software_option']) ? htmlspecialchars(trim($_POST['software_option'])) : null;
$custom_service = isset($_POST['custom_service']) ? htmlspecialchars(trim($_POST['custom_service'])) : null;
$message = htmlspecialchars(trim($_POST['message']));

// Insert into database
$stmt = $conn->prepare("INSERT INTO software_contact (name, number, email, service_category, software_option, custom_service, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $number, $email, $service_category, $software_option, $custom_service, $message);

if ($stmt->execute()) {
    echo "<script>
            alert('Your software installation has been enrolled successfully!');
            window.location.href = '../html/index.html';
          </script>";
  } else {
    echo "<script>
            alert('Something went wrong. Please try again later.');
            window.history.back();
          </script>";
  }  

$stmt->close();
$conn->close();
?>
