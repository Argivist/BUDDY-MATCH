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
$url="https://vidcnf.onrender.com/conference.html?username=".$user."&room=".$buddyid;
//adding to the message daatabase
$today=date("Y-m-d H:i:s");
//timestamp
$created=time();
$stmt = $pdo->prepare("INSERT INTO conference (userOneID, userTwoID,startTime, link,createdAt) VALUES (?, ?,?, ?,?)");
$stmt->execute([$_SESSION['userID'], $buddyid,$today, $url,$created]);
// adding to messages
$stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID,message, link) VALUES (?, ?,?, ?)");
$stmt->execute([$_SESSION['userID'], $buddyid,"video", $url]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

header("Location: ".$url);

?>
