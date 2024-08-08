<?php
require 'settings/connection.php'; // Ensure this path is correct

// course listing function
$stmt = $pdo->prepare("SELECT * FROM courses");
$stmt->execute();
$courses = $stmt->fetchAll();
// if no courses
if (count($courses) == 0) {
    echo "<option value=''>No courses available</option>";
    return;
}else{
    foreach ($courses as $course) {
        echo "<option value='{$course['courseID']}'>{$course['courseName']}</option>";
    }
}

?>