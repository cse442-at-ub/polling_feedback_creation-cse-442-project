<?php
$score = $_GET['score'];

$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "kchen223";
$dbPassword = "50277192";
$dbName = "kchen223_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}
echo "Connected to database." . "<br>";

if ($score == 1 || $score == 2 || $score == 3) {
    echo "Valid entry provided: " . $score . "<br>";
    $sql = "INSERT INTO scores (email, score) VALUES ('kchen223@buffalo.edu', $score) ON DUPLICATE KEY UPDATE score = $score";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback successfully recorded." . "<br>";
    } else {
        echo "Feedback submission failed. " . "<br>" . "Query: " . $sql . "<br>" . "Error: " . $conn->error . "<br>";
    }
} else {
    echo "Invalid entry provided: " . $score . "<br>";
}

$conn->close();
?>