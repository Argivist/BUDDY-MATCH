<?php
session_start();
require '../settings/connection.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $roleID = $_POST['role']; // Directly using the value as role ID
        $majorID = $_POST['major'];


        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
            exit;
        }

        // Check if email exists
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            header("Location: ../register.php?success=2");//exists
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, majorID, password, roleID) VALUES (?, ?, ?,?, ?)");
        if ($stmt->execute([$name, $email,$majorID, $passwordHash, $roleID])) {
            //header('Location: ../html/register.php');
            header("Location: ../register.php?success=1");//success
            exit;
        } else {
            header("Location: ../register.php?success=0");//failed
        }
    } elseif (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT userID, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['name'] = $user['name'];
            header('Location: ../index.php?');
            exit;
        } else {
            echo "Invalid login credentials.";
        }
    }
}
?>
