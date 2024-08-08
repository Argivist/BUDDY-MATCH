<?php
require '../settings/connection.php';

//getting alll users if post of list is user
if (isset($_POST['list']) && $_POST['list'] == 'user') {
    $users = $user->getAllUsers();
    echo json_encode($users);
}
//getting all reported users if post of list is report
if (isset($_POST['list']) && $_POST['list'] == 'report') {
    $users = $user->getReportedUsers();
    echo json_encode($users);
}

//removing user if post of remove is set
if (isset($_POST['remove'])) {
    $user->removeUser($_POST['remove']);
}

//get all users funtion
function getAllUsers()
{
    $stmt = $this->conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

//get all reported users function
function getReportedUsers()
{
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE reported = 1");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

//remove user function
function removeUser($name)
{
    $stmt = $this->conn->prepare("DELETE FROM users WHERE name = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
}
?>