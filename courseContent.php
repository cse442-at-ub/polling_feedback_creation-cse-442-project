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
    </head>
    
    <body>
        <div class="mx-auto text-center">
                <?php
                // Raise while loop execution time limit to 10 minutes 
                set_time_limit(600);
                echo "<h1 class='m-3 text-center'>CSE 442</h1>";

                $dbServerName = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbName = "test";

                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "\n");
                }

                // Temporary admin control panel

                while (True) {
                    $poll_open = False;
                    $feedback_open = False;
                    // Check if poll is open
                    $sql = "SELECT * FROM pollquestions WHERE status = 'open'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $poll_open = True;
                    } else {
                        $poll_open = False;
                    }
                    // Broken feedback check
                    // $sql = "SELECT * FROM feedback WHERE course = 'CSE442'";
                    // $result = $conn->query($sql);
                    // if ($result->num_rows > 0) {
                    //     while ($row = $result->fetch_assoc()) {
                    //         $feedback_open = True;
                    //     }
                    // }
                    // xor allows it so that only one shows
                    if ($poll_open xor $feedback_open) {
                        // Poll handling
                        if ($poll_open) {
                            $sql = "SELECT * FROM pollquestions WHERE status = 'open'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['status'] == 'open'){
                                        // echo "<h1 class='m-3' style='text-align:center;'>Please answer the poll question below.</h1>";
                                        echo "<h3 class='m-3' style = 'text-align:center; text-decoration:underline;'>" . "Question: " . $row["question"] . "</h3>" . "\n";
                                        echo"<p class='m-3' style='text-align:center'>The poll is open. The poll will end when the instructor closes it.</p>";
                                        
                                        if($row["answer_choice1"]){
                                            echo 
                                            '<div class="form-check"> 
                                                <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "' . $row["answer_choice1"] . '" onclick=sendPoll(this)>' .     
                                                    $row["answer_choice1"] .
                                                '</button>
                                            </div>';
                                        }
                                        if($row["answer_choice2"]){
                                            echo 
                                            '<div class="form-check"> 
                                                <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "' . $row["answer_choice2"] . '" onclick=sendPoll(this)>' .     
                                                    $row["answer_choice2"] .
                                                '</button>
                                            </div>';                                    
                                        }
                                        if($row["answer_choice3"]){
                                            echo 
                                            '<div class="form-check"> 
                                                <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "' . $row["answer_choice3"] . '" onclick=sendPoll(this)>' .     
                                                    $row["answer_choice3"] .
                                                '</button>
                                            </div>';                                    
                                        }
                                        if($row["answer_choice4"]){
                                            echo 
                                            '<div class="form-check"> 
                                                <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "' . $row["answer_choice4"] . '" onclick=sendPoll(this)>' .     
                                                    $row["answer_choice4"] .
                                                '</button>
                                            </div>';                                    
                                        }
                                        if($row["answer_choice5"]){
                                            echo 
                                            '<div class="form-check"> 
                                                <button type= "button" class ="btn btn-outline-primary btn-lg m-2" value = "' . $row["answer_choice5"] . '" onclick=sendPoll(this)>' .     
                                                    $row["answer_choice5"] .
                                                '</button>
                                            </div>';                                    
                                        }
                                        // Store question ID in hidden input to be retrieved on submission
                                        echo '<input type="hidden" id="question_id" value="' . $row["id"] . '">';
                                        echo '<div id="notification"></div>';
                                    }
                                    else {
                                        $sql2 = "SELECT pollAnswer, count(*) as NUM FROM poll GROUP BY pollAnswer";
                                        $result2 = mysqli_query($conn, $sql) or die("Bad Query: $sql2");
                                        
                                        while($row = mysqli_fetch_array($result2)){
                                            echo"<p class='h3' style='text-align:center'>{$row['pollAnswer']}: {$row['NUM']}</p><br>";
                                        }
                                    }
                                }
                            }
                            else {
                                echo "<h3>There are no poll questions at the moment.</h3>";
                            }
                        }
                        // Feedback handling
                        else if ($feedback_open) {
                            echo 
                            '<div class="mx-auto" style="width: 50%; text-align: center;">
                                <h1 class="m-3">How are you understanding the material?</h1>
                                <button type="button" class="btn btn-outline-danger btn-lg m-2" data-bs-toggle="modal" data-bs-target="#lostModal" value="1" onclick=sendScore(this)>I\'m lost.</button>
                                <button type="button" class="btn btn-outline-primary btn-lg m-2" data-bs-toggle="modal" data-bs-target="#rightModal" value="2" onclick=sendScore(this)>Just right.</button>
                                <button type="button" class="btn btn-outline-success btn-lg m-2" data-bs-toggle="modal" data-bs-target="#easyModal" value="3" onclick=sendScore(this)>This is easy.</button>
                                <h4 id="notification" class="m-3">
                            </div>';
                        }
                    } 
                    // If both are open, display feedback as default
                    else if ($poll_open && $feedback_open) {
                        echo 
                        '<div class="mx-auto" style="width: 50%; text-align: center;">
                            <h1 class="m-3">How are you understanding the material?</h1>
                            <button type="button" class="btn btn-outline-danger btn-lg m-2" data-bs-toggle="modal" data-bs-target="#lostModal" value="1" onclick=sendScore(this)>I\'m lost.</button>
                            <button type="button" class="btn btn-outline-primary btn-lg m-2" data-bs-toggle="modal" data-bs-target="#rightModal" value="2" onclick=sendScore(this)>Just right.</button>
                            <button type="button" class="btn btn-outline-success btn-lg m-2" data-bs-toggle="modal" data-bs-target="#easyModal" value="3" onclick=sendScore(this)>This is easy.</button>
                            <h4 id="notification" class="m-3">
                        </div>';
                    }
                    // If both are closed, class is not active
                    else if (!$poll_open && !$feedback_open) {
                        echo '<h3 class="m-3">Class is not active.</h3>';
                    }
                }
                ?>

            <div id="responseString" class="text-success m-3"></div>
        </div>
    </body>
</html>