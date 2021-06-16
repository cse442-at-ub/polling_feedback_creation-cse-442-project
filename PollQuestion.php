<?php
$question = $_GET["question"];
$answers = $_GET["answers"];
$answers2 = $_GET["answers"];


$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "kchen223";
$dbPassword = "50277192";
$dbName = "kchen223_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";

$sql = "INSERT INTO pollquestions (question, question_answer) VALUES ('$question', '$answers') ON DUPLICATE KEY UPDATE question_answer = '$answers2'";
// $sql = "SELECT * FROM `pollquestions`";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "\n";
}

$conn->close();
?>