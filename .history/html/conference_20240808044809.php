<?php
//get buddy id from url
require '../settings/connection.php';
session_start();

$buddyid = $_GET['buddyid'];

// Fetch the user name
$stmt = $pdo->prepare("SELECT name FROM users WHERE userID = ?");
$stmt->execute([$_SESSION['userID']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$user = $userData['name'];

// Construct the URL
$url = "https://vidcnf.onrender.com/conference.html?username=" . urlencode($user) . "&room=" . urlencode($buddyid);

// Add to the conference database
$today = date("Y-m-d H:i:s");
$created = date("Y-m-d H:i:s");
$stmt = $pdo->prepare("INSERT INTO conferences (userOneID, userTwoID, startTime, link, createdAt) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$_SESSION['userID'], $buddyid, $today, $url, $created]);

// Add to messages
$stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID, message, link) VALUES (?, ?, ?, ?)");
$stmt->execute([$_SESSION['userID'], $buddyid, "video", $url]);

// Redirect to the conference URL
header("Location: " . $url);
exit();
?>
