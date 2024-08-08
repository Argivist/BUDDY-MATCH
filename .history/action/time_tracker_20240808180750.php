<?php
session_start();
require '../settings/connection.php'; // Adjust the path if needed

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $userID = $_SESSION['userID']; // Assuming user ID is stored in session

        if ($action == 'record') {
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];

            // Ensure start time is before end time
            if ($startTime >= $endTime) {
                echo json_encode(['success' => false, 'message' => 'Start time must be before end time.']);
                exit;
            }

            // Prepare and execute the query safely
            try {
                $stmt = $pdo->prepare("INSERT INTO peertutor (userID, start_time, end_time) VALUES (?, ?, ?)");
                $success = $stmt->execute([$userID, $startTime, $endTime]);
                echo json_encode(['success' => $success]);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } elseif ($action == 'load_logs') {
            try {
                $stmt = $pdo->prepare("SELECT start_time, end_time FROM peertutor WHERE userID = ?");
                $stmt->execute([$userID]);
                $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($logs);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
