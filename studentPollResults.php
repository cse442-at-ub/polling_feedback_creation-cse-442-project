<?php

function connect() {
    $dbServerName = "oceanus.cse.buffalo.edu";
    $dbUsername = "kchen223";
    $dbPassword = "50277192";
    $dbName = "kchen223_db";
    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
    }
    return $conn;
}

function get_poll_results($conn, $course, $question_id) {
    $stmt = $conn->prepare("SELECT response, count(*) as NUM FROM pollresponses WHERE course = ? AND question_id = ? GROUP BY response");
    $stmt->bind_param('si', $course, $question_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $poll_results = [];
            while($row = $result->fetch_assoc()) {
                $poll_results[$row['response']] = $row['NUM'];
            }
            return json_encode($poll_results);
        }
    }
}

function return_poll_results() {
    $conn = connect();
    $course = urldecode(mysqli_real_escape_string($conn, $_GET['course']));
    $question_id = mysqli_real_escape_string($conn, $_GET['id']);

    return get_poll_results($conn, $course, $question_id);
}

echo return_poll_results();
?>