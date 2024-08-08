<?php
session_start();
require '../settings/connection.php';  // Ensure this path is correctly linked to your database connection settings

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: ../register.php');
    exit();
}

$userID = $_SESSION['userID'];

// Fetch user profile data
$stmt = $pdo->prepare("SELECT * FROM userprofiles WHERE userID = ?");
$stmt->execute([$userID]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the profile exists
if (!$profile) {
    echo "Profile not found.";
    header("Location:profile.php");
    exit();
}

// Fetch user data
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
$stmtUser->execute([$userID]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            margin: 5px 0;
            font-size: 16px;
        }
        .home-link {
            text-decoration: none;
            color: #4CAF50;
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Profile</h1>
        <img src="../uploads/<?= htmlspecialchars($profile['profilePicture']); ?>" alt="Profile Picture" class="profile-picture">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Major:</strong> <?= htmlspecialchars($profile['major']); ?></p>
        <p><strong>Graduation Year:</strong> <?= htmlspecialchars($profile['gradYear']); ?></p>
        <p><strong>Study Habits:</strong> <?= htmlspecialchars($profile['studyHabits']); ?></p>
        <p><strong>Interests:</strong> <?= htmlspecialchars($profile['interests']); ?></p>
        <a href="../index.php" class="home-link">Back to Home</a>
        <a class="update" href="profile.php">Update</a>
    </div>
</body>
</html>
