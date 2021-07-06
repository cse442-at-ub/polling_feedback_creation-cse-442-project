<?php
function update_feedback() {
    $dbServerName = "oceanus.cse.buffalo.edu";
    $dbUsername = "kchen223";
    $dbPassword = "50277192";
    $dbName = "kchen223_db";
    
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>");
    }
    echo "Connected to database." . "<br>";
    
    $ubit = mysqli_real_escape_string($conn, $_GET['ubit']);
    $course = mysqli_real_escape_string($conn, $_GET['course']);
    $score = mysqli_real_escape_string($conn, $_GET['score']);
    
    if(empty($ubit)) {
        die("Empty UBIT. Aborting query.");
    }
    
    if ($score == 0 || $score == 5 || $score == 10) {
        echo "Valid entry provided: " . $score . "<br>";
        $stmt = $conn->prepare("INSERT INTO feedback (ubit, course, feedback_score) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE feedback_score = ?");
        $stmt->bind_param('ssii', $ubit, $course, $score, $score);
    
        if ($stmt->execute() === TRUE) {
            echo "Feedback successfully recorded." . "<br>";
        } else {
            echo "Feedback submission failed. " . "<br>" . "Query: " . htmlspecialchars($stmt) . "<br>" . "Error: " . htmlspecialchars($conn->error) . "<br>";
        }
    } else {
        echo "Invalid entry provided: " . htmlspecialchars($score) . "<br>";
    }
    
    $conn->close();
}

update_feedback();
?>