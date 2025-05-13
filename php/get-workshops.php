<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Include database connection
require_once 'db-connection.php';

// Get all workshops
$query = "SELECT id, duration AS category, name, icon FROM workshops ORDER BY duration, name";

$result = $conn->query($query);

$workshops = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $workshops[] = $row;
    }
}

// Group workshops by category
$grouped_workshops = [];
foreach ($workshops as $workshop) {
    $category = $workshop['category'];
    if (!isset($grouped_workshops[$category])) {
        $grouped_workshops[$category] = [];
    }
    $grouped_workshops[$category][] = $workshop;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($grouped_workshops);

// Close connection
$conn->close();
?>
