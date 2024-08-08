<?php
session_start();

// Check if the user is logged in and has successfully created a profile
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if the user is not logged in
    header("Location: ../register.php");
    exit();
}

// Optional: Retrieve additional user information if needed
require '../settings/connection.php';

$userID = $_SESSION['userID'];
$stmt = $pdo->prepare("SELECT name FROM users WHERE userID = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdn.userway.org/widget.js" data-account="yHxBfPK57z"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Created</title>
    <link rel="stylesheet" href="../css/profileSave.css">
</head>
<body>
    <div class="container">
        <h1>Profile Created Successfully</h1>
        <?php if ($user): ?>
            <p>Congratulations, <?= htmlspecialchars($user['name']); ?>! Your profile has been created successfully!</p>
        <?php else: ?>
            <p>Your profile has been created successfully!</p>
        <?php endif; ?>
        <a href="../index.php" class="btn">Go to Home</a>
        <a href="viewProfile.php" class="btn">View Profile</a>
    </div>
</body>
</html>
