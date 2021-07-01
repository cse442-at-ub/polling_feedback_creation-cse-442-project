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

function get_question_id($course, $conn) {
    $stmt = $conn->prepare("SELECT * FROM pollquestions WHERE course = ? AND open_closed = 'open'");
    $stmt->bind_param('s', $course);

    if ($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while($row = $result->fetch_assoc()) {
                return $row['id'];
            }
        } else if ($result->num_rows > 1) {
            echo "More than one poll question is open.";
        }
    }
    $conn->close;
}

function check_poll_status($course, $conn) {
    $stmt = $conn->prepare("SELECT * FROM pollquestions WHERE course = ? AND open_closed = 'open'");
    $stmt->bind_param('s', $course);

    if ($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return True;
        } else {
            return False;
        }
    }
    $conn->close;
}

function check_feedback_status($course, $conn) {
    $stmt = $conn->prepare("SELECT * FROM feedbackstatus WHERE course = ? AND open_closed = 'open'");
    $stmt->bind_param('s', $course);

    if ($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return True;
        } else {
            return False;
        }
    }
    $conn->close;
}

function fetch_question($course, $conn) {
    $stmt = $conn->prepare("SELECT * FROM pollquestions WHERE course = ? AND open_closed = 'open'");
    $stmt->bind_param('s', $course);

    if ($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            while($row = $result->fetch_assoc()) {
                return $row['question'];
            }
        } else if ($result->num_rows > 1) {
            echo "More than one poll question is open.";
        }
    }
    $conn->close;
}

function fetch_choices($course, $conn) {
    $stmt = $conn->prepare("SELECT * FROM pollquestions WHERE course = ? AND open_closed = 'open'");
    $stmt->bind_param('s', $course);
    if ($stmt->execute() === TRUE) {
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $choices = [];
            while($row = $result->fetch_assoc()) {
                for ($i = 1; $i <= 5; $i++) {
                    if ($row['answer_choice'.$i]) {
                        $choices[] = $row['answer_choice'.$i];
                    }
                }
            }
            return $choices;
        } else if ($result->num_rows > 1) {
            echo "More than one poll question is open.";
        }
    }
    $conn->close;
}

function return_course_data() {
    $conn = connect();
    $course = urldecode(mysqli_real_escape_string($conn, $_GET['course']));
    $poll_status = check_poll_status($course, $conn);
    $feedback_status = check_feedback_status($course, $conn);
    if ($poll_status == True) {
        $question = fetch_question($course, $conn);
        $choices = fetch_choices($course, $conn);
        $question_id = get_question_id($course, $conn);
        $course_data =  json_encode([
            'course' => $course,
            'poll_status' => $poll_status,
            'feedback_status' => $feedback_status,
            'question' => $question,
            'choices' => $choices,
            'question_id' => $question_id
        ]);
    } else if ($poll_status == False) {
        $course_data =  json_encode([
            'course' => $course,
            'poll_status' => $poll_status,
            'feedback_status' => $feedback_status
        ]);
    }
    return $course_data;
}

echo return_course_data();
?>