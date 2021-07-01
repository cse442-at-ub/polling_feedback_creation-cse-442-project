<?php
function update_poll_answer() {
    $dbServerName = "oceanus.cse.buffalo.edu";
    $dbUsername = "kchen223";
    $dbPassword = "50277192";
    $dbName = "kchen223_db";
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
    }
    echo "Connected successfully.\n";

    $poll_answer = mysqli_real_escape_string($conn, $_GET["answer"]);
    echo $poll_answer;
    $question_id = mysqli_real_escape_string($conn, $_GET["id"]);
    // $pollAnswer2 = mysqli_real_escape_string($conn, $_GET["answer"]);

    if(isset($_COOKIE['ubit'])) {
        $ubit = mysqli_real_escape_string($conn, $_COOKIE['ubit']);
    }
    if(isset($_COOKIE['course'])) {
        $course = mysqli_real_escape_string($conn, $_COOKIE['course']);
    }
    
    $stmt = $conn->prepare("INSERT INTO pollresponses (ubit, course, question_id, response) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE response = ?");
    $stmt->bind_param('ssiss', $ubit, $course, $question_id, $poll_answer, $poll_answer);
    
    if ($stmt->execute() === TRUE) {
        echo "New record created successfully. \n";
    } else {
        echo "Error: " . $stmt . "\n" . $conn->error . "\n";
    }
    
    $conn->close();
}

update_poll_answer();
?>