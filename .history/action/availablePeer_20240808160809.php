<?php
// Start session and include database connection settings
session_start();
require '../settings/connection.php'; // Update the path as necessary

// Check if the request is coming from a POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supportType = $_POST['supportType'] ?? '';
    $course = $_POST['course'] ?? '';
    $time = $_POST['time'] ?? '';

    // Prepare and execute query to find matching supports
    if ($supportType === 'FI') {
        $query = "SELECT u.name, uc.courseID, p.availableDate
                  FROM users u
                  JOIN userprofiles p ON u.userID = p.userID
                  JOIN usercourses uc ON u.userID = uc.userID
                  WHERE u.role = 4 AND uc.courseID = ? AND p.availableDate LIKE ?";
    } else if ($supportType === 'Peer Tutor') {
        $query = "SELECT u.name, uc.courseID, p.availableDate
                  FROM users u
                  JOIN userprofiles p ON u.userID = p.userID
                  JOIN userCourses uc ON u.userID = uc.userID
                  WHERE u.role = 3 AND uc.courseID = ? AND p.availableDate LIKE ?";
    } else {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare($query);
    $likeTime = '%' . $time . '%';
    $stmt->execute([$course, $likeTime]);

    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if matches were found
    if ($matches) {
        echo json_encode($matches);
    } else {
        echo json_encode([]);
    }
} else {
    // Handle non-POST request
    http_response_code(405); // Method Not Allowed
}
?>