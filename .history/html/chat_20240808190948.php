<?php
// Get buddy ID from URL
require '../settings/connection.php';
session_start();
$buddyid = $_GET['buddyid'];

// Fetch the sender's name
$stmt = $pdo->prepare("SELECT name FROM users WHERE userID = ?");
$stmt->execute([$_SESSION['userID']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user = $user['name'];

// Create the chat URL
$chatUrl = "https://chatplat.onrender.com?username=" . urlencode($user) . "&room=" . urlencode($buddyid);
$ratingUrl = "rating.php?ratee=" . urlencode($buddyid) . "&rater=" . urlencode($_SESSION['userID']);

// Adding to the message database
$stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID, message, link) VALUES (?, ?, ?, ?)");
$stmt->execute([$_SESSION['userID'], $buddyid, "chat", $chatUrl]);

// Rating message
$stmt = $pdo->prepare("INSERT INTO messages (receiverID, senderID, message, link) VALUES (?, ?, ?, ?)");
$stmt->execute([$buddyid, $_SESSION['userID'], "rate", $ratingUrl]);

// Fetch the receiver's email
$stmt = $pdo->prepare("SELECT email FROM users WHERE userID = ?");
$stmt->execute([$buddyid]);
$receiver = $stmt->fetch(PDO::FETCH_ASSOC);
$receiverEmail = $receiver['email'];


// Redirect to chat URL
header("Location: " . $chatUrl);
exit();
?>
