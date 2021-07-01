<?php
ini_set("display_errors", "1");

error_reporting(E_ALL);
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

function update_poll($conn, $course, $status) {
    $stmt = $conn->prepare("UPDATE pollquestions SET open_closed = ? WHERE course = ?");
    $stmt->bind_param('ss', $status, $course);
    if ($stmt->execute() === TRUE) {
        echo "Poll mode updated.";
    }
    $conn->close;
}

function run_query() {
    $poll = $_GET['poll'];
    $course = $_COOKIE['course'];

    $conn = connect();
    update_poll($conn, $course, $poll);
}
run_query();
?>