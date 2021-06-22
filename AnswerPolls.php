<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Poll Question Submitted</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        <div class="mx-auto" style="text-align: left;">
            <?php
                echo "<h1 class='m-3'>Questions and Answers Recieved!</h1>";

                $question = $_REQUEST['question'];
                $answers = $_REQUEST['answer'];
                $answers2 = $_REQUEST['extraAnswer'];
                $status = "open";
                
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
                
                if(!empty($question) || !empty($answer)){
                    $sql = "INSERT INTO pollquestions (question, question_answer, question_extra_answers, status) VALUES ('$question', '$answers', '$answers2', '$status')";
                    $conn->query($sql);
                }else{
                    ;
                }

                // $sql = "INSERT INTO pollquestions (question, question_answer) VALUES ('$question', '$answers')";
                // $sql = "INSERT INTO pollquestions (question, question_answer, question_extra_answers, status) VALUES ('$question', '$answers', '$answers2', '$status')";
                // $sql = "INSERT INTO poll (ubit, pollAnswer) VALUES ('kchen223', '$pollAnswer') ON DUPLICATE KEY UPDATE pollAnswer = '$pollAnswer2'";

                // $conn->query($sql);
                
                // $sql = "SELECT question, question_answer FROM pollquestions WHERE question = '$question'";
                $sql = "SELECT * FROM pollquestions";
                // $sql = "SELECT * FROM pollquestions WHERE question= '$question'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<h4 class='m-3'>" . "Question ". $row["question_number"] . ": ". $row["question"] . "</h4>" . "\n";
                        echo "<h5 class='m-3'>" . "Answers: " . $row["question_answer"] . "</h5>" . "\n";
                        if(!empty($row["question_extra_answers"])){
                            echo "<h5 class='m-3'>" . "Answers2: " . $row["question_extra_answers"] . "</h5>";
                        }else{
                            echo "\n";
                        }
                      }
                } else {
                    echo "<h4 class='m-3'>There are no questions.</h4> \n";
                }

                // header("Location: pollQuestion.html");
            ?>
        </div>
    </body>
    <script src="main.js" async defer></script>
</html>



