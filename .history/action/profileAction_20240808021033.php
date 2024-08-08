<?php
session_start();
require '../settings/connection.php';  // Ensure this path is correctly linked to your database connection settings

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profilePicture'])) {
    $profilePicture = $_FILES['profilePicture'];
    $major = $_POST['major'];
    $courseName = $_POST['courseName'];
    $studyHabits = $_POST['studyHabits'];
    $interests = $_POST['interests'];
    $gradYear = $_POST['gradYear'];
    $userID = $_SESSION['userID'];  // Assuming userID is stored in session upon login
    $timeToStudy = $_POST['timeToStudy'];
    $stressLevel = $_POST['stressLevel'];


    // Handling file upload
    $fileExt = strtolower(pathinfo($profilePicture['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowed)) {
        if ($profilePicture['error'] === 0) {
            if ($profilePicture['size'] < 5000000) {  // less than 5MB
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $uploadDir = '../uploads/';
                
                // Check if the uploads directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);  // Create directory if it doesn't exist
                }
                
                $fileDestination = $uploadDir . $fileNameNew;
                if (move_uploaded_file($profilePicture['tmp_name'], $fileDestination)) {
                    // Insert into database
                    $stmt = $pdo->prepare("INSERT INTO userProfiles (userID, major, profilePicture, courseID, gradYear, studyHabits, interests, timeToStudy, stressLevel, availableDate) VALUES (?,?,?,?, ?,?, ?, ?, ?, ?)");
                    if ($stmt->execute([$userID, $major, $fileNameNew, $courseName ,$gradYear, $studyHabits, $interests, $timeToStudy, $stressLevel, date('Y-m-d')])) {
                        header("Location: ../html/profileCreated.php");  // Redirect on success
                        exit();
                    } else {
                        echo "There was an error saving your profile.";
                    }
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Your file is too large.";
            }
        } else {
            echo "There was an error uploading your file.";
        }
    } else {
        echo "You cannot upload files of this type.";
    }
} else {
    echo "Please fill in all fields.";
}
?>
