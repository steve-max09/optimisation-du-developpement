<?php
session_start();

$conn = require_once 'connection.php';

$nameErr = $emailErr = $genderErr = $addressErr = $icErr = $contactErr = $usernameErr = $passwordErr = "";
$name = $email = $gender = $address = $ic = $contact = $uname = $upassword = "";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    return;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name = test_input($_POST["name"] ?? "");
$uname = test_input($_POST["uname"] ?? "");
$upassword = test_input($_POST["upassword"] ?? "");
$ic = test_input($_POST["ic"] ?? "");
$email = test_input($_POST["email"] ?? "");
$contact = test_input($_POST["contact"] ?? "");
$gender = test_input($_POST["gender"] ?? "");
$address = test_input($_POST["address"] ?? "");

if (empty($name)) {
    $nameErr = "Please enter your name";
} elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    $nameErr = "Only letters and white space allowed";
}

if (empty($uname)) {
    $usernameErr = "Please enter your Username";
}

if (empty($upassword)) {
    $passwordErr = "Please enter your Password";
}

if (empty($ic)) {
    $icErr = "Please enter your IC number";
} elseif (!preg_match("/^[0-9 -]*$/", $ic)) {
    $icErr = "Please enter a valid IC number";
}

if (empty($email)) {
    $emailErr = "Please enter your email address";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
}

if (empty($contact)) {
    $contactErr = "Please enter your phone number";
} elseif (!preg_match("/^[0-9 -]*$/", $contact)) {
    $contactErr = "Please enter a valid phone number";
}

if (empty($gender)) {
    $genderErr = "* Gender is required!";
}

if (empty($address)) {
    $addressErr = "Please enter your address";
}

if (
    !$nameErr && !$usernameErr && !$passwordErr && !$icErr &&
    !$emailErr && !$contactErr && !$genderErr && !$addressErr
) {
    $sql = "INSERT INTO users(UserName, Password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uname, $upassword);
    $stmt->execute();

    $userID = $stmt->insert_id;

    $sql = "INSERT INTO customer(CustomerName, CustomerPhone, CustomerIC, CustomerEmail, CustomerAddress, CustomerGender, UserID) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $contact, $ic, $email, $address, $gender, $userID);
    $stmt->execute();

    header("Location:index.php");
    exit();
}

require 'templates/register.html.php';
?>
