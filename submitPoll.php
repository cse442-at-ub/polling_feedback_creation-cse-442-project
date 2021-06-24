<?php
$pollAnswer = $_GET["answer"];
$pollAnswer2 = $_GET["answer"];

$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "kchen223";
$dbPassword = "50277192";
$dbName = "kchen223_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";
$sql = "INSERT INTO poll (ubit, pollAnswer) VALUES ('kchen223', '$pollAnswer') ON DUPLICATE KEY UPDATE pollAnswer = '$pollAnswer2'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error . "\n";
}

$conn->close();
?>