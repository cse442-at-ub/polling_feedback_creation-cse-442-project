<?php
$dbServerName = "oceanus.cse.buffalo.edu";
$dbUsername = "kchen223";
$dbPassword = "50277192";
$dbName = "kchen223_db";

$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}
echo "Connected to database." . "<br>";

$score = mysqli_real_escape_string($conn, $_GET['score']);
$ubit = mysqli_real_escape_string($conn, $_GET['ubit']);

if(empty($ubit)) {
    die("Empty UBIT. Aborting query.");
}

if ($score == 1 || $score == 2 || $score == 3) {
    echo "Valid entry provided: " . $score . "<br>";
    $stmt = $conn->prepare("INSERT INTO scores (ubit, score) VALUES (?, ?) ON DUPLICATE KEY UPDATE score = ?");
    $stmt->bind_param('sii', $ubit, $score, $score);

    if ($stmt->execute() === TRUE) {
        echo "Feedback successfully recorded." . "<br>";
    } else {
        echo "Feedback submission failed. " . "<br>" . "Query: " . htmlspecialchars($sql) . "<br>" . "Error: " . htmlspecialchars($conn->error) . "<br>";
    }
} else {
    echo "Invalid entry provided: " . htmlspecialchars($score) . "<br>";
}

$conn->close();
?>