<?php
// Start session and include database connection settings
session_start();
require '../settings/connection.php'; // Update the path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitRating'])) {
        // Fetch user-submitted data
        $partnerID = $_POST['partnerID'];
        $rating = $_POST['rating'];
        $userID = $_SESSION['userID']; // Assuming the user's ID is stored in the session

        // Insert the rating into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO ratings (raterID, rateeID, ratingVal) VALUES (?, ?, ?)");
            $stmt->execute([$userID, $partnerID, $rating]);
            echo "Rating submitted successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['submitReport'])) {
        // Handle issue reporting
        $partnerID = $_POST['partnerID'];
        $reason = $_POST['reason'];
        $userID = $_SESSION['userID'];

        // Logic to insert the report into a 'reports' table, which must be created in your database
        try {
            $stmt = $pdo->prepare("INSERT INTO reports (reporterID, reportedID, reason) VALUES (?, ?, ?)");
            $stmt->execute([$userID, $partnerID, $reason]);
            echo "Report submitted successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Invalid request method.";
}
?>
