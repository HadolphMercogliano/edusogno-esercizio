<?php

$host = "localhost";
$dbname = "edusogno";
$username = "root";
$password = "root";

$conn = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($conn->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $conn;