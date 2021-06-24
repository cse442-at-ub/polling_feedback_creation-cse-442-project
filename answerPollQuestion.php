<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Answer Poll Question</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="main.js" type="text/javascript" async defer></script>
        <script> 
        function showResults(){
            window.location.href = "./pollResults.php"
            }
        </script>
    </head>
    
    <body>
    <div class="mx-auto" style="width: 50%; " text-align: center;>

        <h1 class="m-3" style='text-align:center;'>Please answer the poll question below.</h1>
        
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
            $stmt = $conn ->prepare("SELECT * FROM pollquestions WHERE question_number = ? ");
            $stmt -> bind_param("s", $questionNumber);
            $status = $stmt -> execute();
            
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'open'){
                        echo"<p class='h3' style='text-align:center'>The poll is open. The poll will end when the instructor closes it.</p>";
                        echo "<h4 class='m-3' style = 'text-align:center; text-decoration:underline;'>" . "Question ". $row["question_number"] . ": ". $row["question"] . "</h4>" . "\n";
                        
                        if($row["answer_choice1"]){
                            ?>
                            <div class="form-check"> <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "<?php echo $row["answer_choice1"] ?>" onclick=sendPoll(this)> <?php echo $row["answer_choice1"]?> </button></div>
                        <?php
                        }
                        if($row["answer_choice2"]){
                            ?>
                            <div class="form-check"> <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "<?php echo $row["answer_choice2"] ?>" onclick=sendPoll(this)> <?php echo $row["answer_choice2"]?> </button></div>
                        <?php
                        }
                        if($row["answer_choice3"]){
                            ?>
                            <div class="form-check"> <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "<?php echo $row["answer_choice3"] ?>" onclick=sendPoll(this)> <?php echo $row["answer_choice3"]?> </button></div>
                        <?php
                        }
                        if($row["answer_choice4"]){
                            ?>
                            <div class="form-check"> <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "<?php echo $row["answer_choice4"] ?>" onclick=sendPoll(this)> <?php echo $row["answer_choice4"]?> </button></div>
                        <?php
                        }
                        if($row["answer_choice5"]){
                            ?>
                            <div class="form-check"> <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "<?php echo $row["answer_choice5"] ?>" onclick=sendPoll(this)> <?php echo $row["answer_choice5"]?> </button></div>

                        <?php
                        }
                
                        
                    }
                    else{
                        
                        echo '<script src="main.js" async defer></script> <script type="text/javascript">showResults()</script>';
                    }
                    echo '</div>';
                    
                    // echo "<h4 class='m-3'>" . "Question ". $row["question_number"] . ": ". $row["question"] . "</h4>" . "\n";
                    // echo '<div class="form-check">
                    //         <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    //         <label class="form-check-label" for="exampleRadios1">
                    //         </label>';
                    // echo $row["question_answer"] . "\n";
                    // if(!empty($row["question_extra_answers"])){
                    //     echo '</div>
                    //           <div class="form-check">
                    //             <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    //             <label class="form-check-label" for="exampleRadios2">
                    //             </label>';
                    //     echo $row["question_extra_answers"] . "\n";
                    // }
                    // if ($row['status'] == 'open'){
                    //     echo"<p class='h3' style='text-align:center'>The poll is open. The poll will end when the instructor closes it.</p>";
                    // }
                    // else{
                    //     echo '<script type="text/javascript">showResults()</script>';
                    // }
                    // echo '</div>';
                }

                
        
            }
            else {
                echo "<h4 class='m-3'>There are no questions with that number.</h4> \n";
            }
            ?>
            <br><br>
            <p style = "text-align: center;" class="h3" id = "responseString"></p>
            <div class="mx-auto" style="text-align: center;">
                <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
            </div>
        </form>
    </div>
</body>
</html>