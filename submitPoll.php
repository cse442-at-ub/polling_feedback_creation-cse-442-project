<?php
$pollAnswer = $_GET["answer"];
$pollAnswer2 = $_GET["answer"];
$questionId = $_GET["id"];

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "test";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully." . "\n";

// Testing cookies
$cookie_name = "ubit";
$cookie_value = "kchen223";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

if(!isset($_COOKIE['ubit'])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    $ubit = $_COOKIE['ubit'];
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $ubit;
}

$sql = "INSERT INTO poll (ubit, question_id, pollAnswer) VALUES ('$ubit', $questionId, '$pollAnswer') ON DUPLICATE KEY UPDATE pollAnswer = '$pollAnswer2'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. \n";
} else {
    echo "Error: " . $sql . "\n" . $conn->error . "\n";
}

$conn->close();
?>