<?php

require 'settings/connection.php'; // Ensure this path is correct

// major listing function
$stmt = $pdo->prepare("SELECT * FROM majors");
$stmt->execute();
$majors = $stmt->fetchAll();
// if no majors
if (count($majors) == 0) {
    echo "<option value=''>No majors available</option>";
    return;
}else{
    foreach ($majors as $major) {
        echo "<option value='{$major['majorID']}'>{$major['major']}</option>";
    }
}
?>
