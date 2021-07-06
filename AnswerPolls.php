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
    <div class="alert alert-primary" style ="text-align: center;" role="alert"><h4>Poll Questions and Answer Received!</h4> </div>
              
        <div class="mx-auto" style="text-align: left;">
            <?php
                
                $dbServerName = "oceanus.cse.buffalo.edu";
                $dbUsername = "kchen223";
                $dbPassword = "50277192";
                $dbName = "kchen223_db";
                
                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "\n");
                }
                
                $course = htmlspecialchars($_REQUEST['course']);
                $question = htmlspecialchars($_REQUEST['question']);
                $answers1 = htmlspecialchars($_REQUEST['answer1']);
                $answers2 = htmlspecialchars($_REQUEST['answer2']);
                $answers3 = htmlspecialchars($_REQUEST['answer3']);
                $answers4 = htmlspecialchars($_REQUEST['answer4']);
                $answers5 = htmlspecialchars($_REQUEST['answer5']);
                $status = htmlspecialchars("open");
                
                if(!empty($question) || !empty($answer1)){
                    $stmt = $conn->prepare("INSERT INTO pollquestions (course, question, answer_choice1, answer_choice2, answer_choice3, answer_choice4, answer_choice5, open_closed)
                    VALUES (?,?,?,?,?,?,?,?)");
                    $stmt->bind_param("ssssssss", $course, $question, $answers1, $answers2, $answers3, $answers4, $answers5, $status);
                    $stmt->execute();
                    $result = $stmt->get_result();
                }else{
                    ;
                }
                
                
                $sql = "SELECT * FROM pollquestions";
                $result = $conn->query($sql);
                if(($course && $question && $answers1) != "" ){
                    echo "<h4 class='m-3'>" . "Class " . $course . "</h4>" . "\n";
                    echo "<h4 class='m-3'>" . "Question: " . $question . "</h4>" . "\n";
                    echo "<h5 class='m-3'>" . "Answer Choice: " . $answers1 . "</h5>" . "\n";
                }
                if($answers2 != ""){
                    echo "<h5 class='m-3'>" . "Answer Choice: " . $answers2 . "</h5>" . "\n";
                }
                if($answers3 != ""){
                    echo "<h5 class='m-3'>" . "Answer Choice: " . $answers3 . "</h5>" . "\n";
                }
                if($answers4 != ""){
                    echo "<h5 class='m-3'>" . "Answer Choice: " . $answers4 . "</h5>" . "\n";
                }
                if($answers5 != ""){
                    echo "<h5 class='m-3'>" . "Answer Choice: " . $answers5 . "</h5>" . "\n";
                }
                echo "\n";
            ?>
        </div>
    </body>
    <script src="main.js" async defer></script>
</html>