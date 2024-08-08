<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../settings/connection.php';

header('Content-Type: application/json'); // Ensure JSON response

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['list'])) {
            if ($_POST['list'] === 'user') {
                echo json_encode(getAllUsers());
            } elseif ($_POST['list'] === 'report') {
                echo json_encode(getReportedUsers());
            } else {
                echo json_encode(['error' => 'Invalid list parameter']);
            }
        } elseif (isset($_POST['remove'])) {
            $result = removeUser($_POST['remove']);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['error' => 'Invalid request']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

function getAllUsers()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReportedUsers()
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reported = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function removeUser($userID)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE userID = ?");
    return $stmt->execute([$userID]);
}
?>
