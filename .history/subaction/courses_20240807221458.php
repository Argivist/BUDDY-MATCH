<?php
require '../settings/connection.php'; // Ensure this path is correct

// course listing function
function courseListing($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM courses");
    $stmt->execute();
    $courses = $stmt->fetchAll();

    foreach ($courses as $course) {
        echo "<option value='{$course['courseID']}'>{$course['courseName']}</option>";
    }
}

?>