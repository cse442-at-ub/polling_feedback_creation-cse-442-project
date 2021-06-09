<?php
$score = $_GET['score'];

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "test";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";

$sql2 = "INSERT INTO scores (ubit, score) VALUES ('kchen223', $score) ON DUPLICATE KEY UPDATE score = $score";

if ($conn->query($sql2) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error . "\n";
}

$conn->close();
?>