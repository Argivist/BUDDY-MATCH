<?php
session_start();
require '../settings/connection.php'; // Adjust the path if needed

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $userId = $_SESSION['userID']; // Assuming user ID is stored in session

        if ($action == 'record') {
            $startTime = $_POST['start_time'];
            $endTime = $_POST['end_time'];

            // Ensure start time is before end time
            if ($startTime >= $endTime) {
                echo json_encode(['success' => false, 'message' => 'Start time must be before end time.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO peertutor (userid, start_time, end_time) VALUES (?, ?, ?)");
            $success = $stmt->execute([$userId, $startTime, $endTime]);
            echo json_encode(['success' => $success]);
        } elseif ($action == 'load_logs') {
            $stmt = $pdo->prepare("SELECT start_time, end_time FROM peertutor WHERE userid = ?");
            $stmt->execute([$userId]);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($logs);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No action specified.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
