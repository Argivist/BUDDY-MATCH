<?php
// Include PHPMailer classes
use PHPMailer;
use Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

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

// Send email to the receiver
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use Gmail SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nobodycoe@gmail.com'; // Your Gmail address
    $mail->Password   = 'pat@8049'; // Your Gmail password or App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('your-email@gmail.com', 'Your Team');
    $mail->addAddress($receiverEmail);

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'New Chat Invitation and Rating Request';
    $mail->Body    = "Hi there,\n\n$user has invited you to a chat. You can join the chat room by clicking the link below:\n\n" . $chatUrl . "\n\n" .
                      "After your chat, please take a moment to rate the conversation using the following link:\n\n" . $ratingUrl . "\n\n" .
                      "Best regards,\nYour Team";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}

// Redirect to chat URL
header("Location: " . $chatUrl);
exit();
?>
