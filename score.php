<?php
$score = $_GET['score'];

$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "alexcen";
$dbPassword = "50273481";
$dbName = "alexcen_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";

$sql = "INSERT INTO scores (ubit, score) VALUES ('alexcen', $score) ON DUPLICATE KEY UPDATE score = $score";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "\n";
}

$conn->close();
?>