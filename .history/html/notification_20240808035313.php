<?php
session_start();  // Start the session at the beginning of the script

// redirect if not logged in
if(!isset($_SESSION['userID'])) {
    header("Location: ../index.php");
    exit;
}

//get user notification from database

require '../settings/connection.php';

$stmt = $pdo->prepare("SELECT * FROM messages WHERE receiverID = ?");
$stmt->execute([$_SESSION['userID']]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Notification</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #fce4ec;
            color: #880e4f;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .notification-container {
            background: #f8bbd0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 15px;
            font-size: 18px;
            line-height: 1.4;
        }
        a {
            padding: 10px 15px;
            background: #d81b60;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            background: #c2185b;
        }
    </style>
</head>
<body>
    <div class="notification-container">

    <?php



        //check if there are messages
        if(count($messages) > 0) {
            foreach($messages as $message) {
                $sender=$pdo->prepare("SELECT name FROM users WHERE userID = ?");
            $sender->execute([$message['senderID']]);
            $senderName = $sender->fetch(PDO::FETCH_ASSOC);
            $Sname = $senderName['name'];

                echo "<h1>New Chat Invitation</h1>";
                echo "<p class='message'>You have a new message from <strong>{$Sname}</strong>.</p>";
                echo "<a href='{$message['link']}'>Join Chat</a>";
            }
        } else {
            echo "<h1>No New Messages</h1>";
            echo "<p class='message'>You have no new chat invitations.</p>";
        }
    ?>
    
    </div>
</body>
</html>