<?php
// Include database connection
require_once 'db-connection.php';

// Get all courses
$query = "SELECT id, category, name, icon FROM courses ORDER BY category, name";
$result = $conn->query($query);

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Group courses by category
$grouped_courses = [];
foreach ($courses as $course) {
    $category = $course['category'];
    if (!isset($grouped_courses[$category])) {
        $grouped_courses[$category] = [];
    }
    $grouped_courses[$category][] = $course;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($grouped_courses);

// Close connection
$conn->close();
?>