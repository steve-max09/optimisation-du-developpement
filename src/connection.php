<?php

$servername = getenv("APP_DATABASE_HOST");
$username = getenv("APP_DATABASE_USER");
$password = getenv("APP_DATABASE_PASSWORD");
$database = getenv("APP_DATABASE_NAME");

<<<<<<< Updated upstream
$conn = new mysqli($servername, $username, $password); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
=======
$conn = new mysqli($servername, $username, $password, $database); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
>>>>>>> Stashed changes

return $conn;