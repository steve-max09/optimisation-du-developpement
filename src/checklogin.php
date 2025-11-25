<?php

session_start();
$conn = require_once "connection.php";

if(isset($_POST['username'])&&isset($_POST['pwd'])){
    $username=$_POST['username'];
    $pwd = $_POST['pwd'];

    $sql="SELECT UserID FROM users WHERE UserName = ? AND Password = ? LIMIT 1";
    $stmt = $conn->execute_query($sql, [$username, $pwd]);

    $userID = $stmt->fetch_column();
    if (!empty($userID)) {
        $_SESSION['id']= $userID;
        header("Location:index.php");
    } else {
        header("Location:login.php?errcode=1");
    }


}