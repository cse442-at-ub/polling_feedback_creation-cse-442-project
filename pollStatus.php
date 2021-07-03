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
    <div class="mx-auto" style="width: 50%; " text-align: center;>

        <h1 class="m-3" style='text-align:center;'>Poll Status Config.</h1>
        
        <form method="post">

            <button type="submit" name="open" id="open" class="btn btn-success btn-flat"><i class="fa fa-check"> Open Poll </i></button>
            <button type="submit" name="close" id="close" class="btn btn-danger btn-flat"><i class="fa fa-times"> Close Poll </i></button>

            </form>
            
            <?php
            
            $open = $_POST["open"];
            $close = $_POST["close"];
            $questionNumber = $_GET["number"];

            $dbServerName = "oceanus.cse.buffalo.edu";
            $dbUsername = "kchen223";
            $dbPassword = "50277192";
            $dbName = "kchen223_db";

            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error . "\n");
            }
            // if(isset($_POST["open"])){
            //     $sql = "UPDATE pollquestions SET status = 'open' question_number = '$questionNumber'";
            //     $query_run = mysqli_query($conn, $sql);
            //     echo"<p class='h3' style='text-align:center'>The poll is open.</p>";

            // }
            // if(isset($_POST["close"])){
            //     $sql = "UPDATE pollquestions SET status = 'close' where question_number = '$questionNumber'";
            //     $query_run = mysqli_query($conn, $sql);
            //     echo"<p class='h3' style='text-align:center'>The poll is closed.</p>";
            // }

            $stmt = $conn ->prepare("SELECT * FROM pollquestions WHERE question_number = ? ");
            $stmt -> bind_param("s", $questionNumber);
            $status = $stmt -> execute();
            
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if(isset($_POST["open"])){
                        $sql = "UPDATE pollquestions SET status = 'open' WHERE pollquestions . question_number = $questionNumber";
                        // $sql = "UPDATE pollquestions SET status = 'open' question_number = '$questionNumber'";
                        $query_run = mysqli_query($conn, $sql);
                        echo"<p class='h3' style='text-align:center'>The poll is open.</p>";
                    }
                    if(isset($_POST["close"])){
                        $sql = "UPDATE pollquestions SET status = 'close' WHERE pollquestions . question_number = $questionNumber";
                        // $sql = "UPDATE pollquestions SET status = 'open' question_number = '$questionNumber'";
                        $query_run = mysqli_query($conn, $sql);
                        echo"<p class='h3' style='text-align:center'>The poll is closed.</p>";
                    }

                }
            }
            else {
                echo '<script src="main.js" async defer></script> <script type="text/javascript">hideButtons()</script>';
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