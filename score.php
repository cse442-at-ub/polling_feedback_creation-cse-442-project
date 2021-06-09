<?php
$score = $_GET['score'];

$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "kchen223";
$dbPassword = "50277192";
$dbName = "kchen223_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";

$sql = "INSERT INTO scores (ubit, score) VALUES ('kchen223', $score) ON DUPLICATE KEY UPDATE score = $score";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "\n";
}

$conn->close();
?>