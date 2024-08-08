<?php
require '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['list'])) {
        if ($_POST['list'] === 'user') {
            $users = getAllUsers($pdo);
            echo json_encode($users);
        } elseif ($_POST['list'] === 'report') {
            $reportedUsers = getReportedUsers($pdo);
            echo json_encode($reportedUsers);
        }
    }

    if (isset($_POST['remove'])) {
        removeUser($pdo, $_POST['remove']);
    }
}

// Function to get all users
function getAllUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get all reported users
function getReportedUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reported = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to remove a user by name
function removeUser($pdo, $name) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE name = ?");
    $stmt->execute([$name]);
}
?>
