<?php
session_start();
require '../settings/connection.php'; // Adjust the path if needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $userId = $_SESSION['userID']; // Assuming user ID is stored in session

        if ($action == 'start') {
            $stmt = $pdo->prepare("INSERT INTO peertutor (userid, start_time) VALUES (?, NOW())");
            $success = $stmt->execute([$userId]);
            echo json_encode(['success' => $success]);
        } elseif ($action == 'end') {
            $stmt = $pdo->prepare("UPDATE peertutor SET end_time = NOW() WHERE userid = ? AND end_time IS NULL");
            $success = $stmt->execute([$userId]);
            echo json_encode(['success' => $success]);
        } elseif ($action == 'load_logs') {
            $stmt = $pdo->prepare("SELECT start_time, end_time FROM peertutor WHERE userid = ?");
            $stmt->execute([$userId]);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($logs);
        }
    }
}
?>
