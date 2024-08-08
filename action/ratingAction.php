<?php
// Start session and include database connection settings
session_start();
require '../settings/connection.php'; // Update the path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitRating'])) {
        // Fetch user-submitted data
        $ratee = $_POST['ratee'];
        $rater = $_POST['rater'];
        $rating = $_POST['rating'];
        $userID = $_SESSION['userID']; // Assuming the user's ID is stored in the session

        // Insert the rating into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO ratings (raterID, rateeID, ratingVal,createdAt) VALUES (?, ?,?, ?)");
            $stmt->execute([$rater, $ratee, $rating, date("Y-m-d H:i:s")]);
            echo "Rating submitted successfully.";
            // if there was a report
            if (isset($_POST['reason'])) {
                
                $reason = $_POST['reason'];
                $

                // Logic to insert the report into a 'reports' table, which must be created in your database
            
                    $stmt = $pdo->prepare("INSERT INTO reports (reporterID, reportedID, reason) VALUES (?, ?, ?)");
                    $stmt->execute([$rater, $ratee, $reason]);
                    echo "Report submitted successfully.";
            
            }
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
