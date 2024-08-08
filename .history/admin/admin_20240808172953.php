<?php
require '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['list']) && $_POST['list'] === 'user') {
        echo json_encode(getAllUsers());
    } elseif (isset($_POST['list']) && $_POST['list'] === 'report') {
        echo json_encode(getReportedUsers());
    } elseif (isset($_POST['remove'])) {
        removeUser($_POST['remove']);
        echo json_encode(['success' => true]);
    }
}

function getAllUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReportedUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reported = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeUser($userID) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE userID = ?");
    $stmt->execute([$userID]);
}
?>
