<?php

$servername = "fbi-mysqllehre.th-brandenburg.de";
$username = "kosts";
$password = "20192019";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
