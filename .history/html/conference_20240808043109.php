<?php
//get buddy id from url
require '../settings/connection.php';
session_start();
$buddyid = $_GET['buddyid'];
$stmt = $pdo->prepare("SELECT name FROM users WHERE userID = ?");
$stmt->execute([$_SESSION['userID']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user = $user['name'];
//url
$url="https://vidcnf.onrender.com?username=".$user."&room=".$buddyid;
//adding to the message daatabase
$stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID,message, link) VALUES (?, ?,?, ?)");
$stmt->execute([$_SESSION['userID'], $buddyid,"chat", $url]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

header("Location: ".$url);

?>
