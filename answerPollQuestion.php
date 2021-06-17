<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Answer Poll Question</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <div class="mx-auto" style="width: 50%; " text-align: center;">

        <h1 class="m-3"> Answer Poll Question</h1>

        <form action="answerReceived.html">
            <div class="form-group">
            </div>
            <?php
            // $question = $_REQUEST['question'];
            // $answers = $_REQUEST['answer'];
            // $answers2 = $_REQUEST['extraAnswer'];
            $questionNumber = $_GET["number"];

            $dbServerName = "oceanus.cse.buffalo.edu";
            $dbUsername = "kchen223";
            $dbPassword = "50277192";
            $dbName = "kchen223_db";

            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error . "\n");
            }

            // $sql = "SELECT * FROM pollquestions";
            $sql = "SELECT * FROM pollquestions WHERE question_number = '$questionNumber'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h4 class='m-3'>" . "Question ". $row["question_number"] . ": ". $row["question"] . "</h4>" . "\n";
                    echo '<div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                            </label>';
                    echo $row["question_answer"] . "\n";
                    if(!empty($row["question_extra_answers"])){
                        echo '</div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                </label>';
                        echo $row["question_extra_answers"] . "\n";
                    }
                    echo '</div>';
                }
            } 
            else {
                echo "<h4 class='m-3'>There are no questions with that number.</h4> \n";
            }
            ?>
            <br><br>
            <div class="mx-auto" style="text-align: center;">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>