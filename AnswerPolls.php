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
    <div class="alert alert-primary" style ="text-align: center;" role="alert"><h4>Questions and Answer Received!</h4> </div>
              
        <div class="mx-auto" style="text-align: left;">
            <?php

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
                
                

                $stmt = $conn->prepare("INSERT INTO pollquestions (question, answer_choice1, answer_choice2, answer_choice3, answer_choice4, answer_choice5, status)
                VALUES (?,?,?,?,?,?,?)");

                $stmt->bind_param("sssssss", $question, $answers1, $answers2, $answers3, $answers4, $answers5, $status);
                // if(!empty($question) || !empty($answer1)){
                    $stmt->execute();
                // }
                $result = $stmt->get_result();
                $question = htmlspecialchars($_REQUEST['question']);
                $answers1 = htmlspecialchars($_REQUEST['answer1']);
                $answers2 = htmlspecialchars($_REQUEST['answer2']);
                $answers3 = htmlspecialchars($_REQUEST['answer3']);
                $answers4 = htmlspecialchars($_REQUEST['answer4']);
                $answers5 = htmlspecialchars($_REQUEST['answer5']);
                $status = htmlspecialchars("open");

                if(!empty($question) || !empty($answer1)){
                    $sql = "INSERT INTO pollquestions (question, answer_choice1, answer_choice2, answer_choice3, answer_choice4, answer_choice5,status) 
                    VALUES ('$question', '$answers1', '$answers2', '$answers3', '$answers4', '$answers5', '$status')";
                    $conn->query($sql);
                }else{
                    ;
                }
                
                
                $sql = "SELECT * FROM pollquestions";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<h4 class='m-3'>" . "Question ". $row["question_number"] . ": ". $row["question"] . "</h4>" . "\n";
                        echo "<h5 class='m-3'>" . "Answer Choice: " . $row["answer_choice1"] . "</h5>" . "\n";
                        if($row["answer_choice2"]){
                            echo "<h5 class='m-3'>" . "Answer Choice: " . $row["answer_choice2"] . "</h5>" . "\n";
                        }
                        if($row["answer_choice3"]){
                            echo "<h5 class='m-3'>" . "Answer Choice: " . $row["answer_choice3"] . "</h5>" . "\n";
                        }
                        if($row["answer_choice4"]){
                            echo "<h5 class='m-3'>" . "Answer Choice: " . $row["answer_choice4"] . "</h5>" . "\n";
                        }
                        if($row["answer_choice5"]){
                            echo "<h5 class='m-3'>" . "Answer Choice: " . $row["answer_choice5"] . "</h5>" . "\n";
                        }
                        echo "\n";
                    }
                } else {
                    echo "<h4 class='m-3'>There are no questions currently in the database.</h4> \n";
                }

                // header("Location: pollQuestion.html");
            ?>
        </div>
    </body>
    <script src="main.js" async defer></script>
</html>



