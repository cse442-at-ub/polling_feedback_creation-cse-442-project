<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Instructor Feedback Panel</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="main.js" type="text/javascript" async defer></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
    
        <div class="mx-auto" style="width: 50%; text-align: center;">
            <h1 class="m-3">Instructors FeedBack Panel</h1>
            <h4 id="notification" class="m-3"></h4>

            <form method="post">
                <button type="submit" name="open" id="open" class="btn btn-success btn-flat"><i class="fa fa-check">Open Feedback</i></button>
                <button type="submit" name="close" id="close" class="btn btn-danger btn-flat"><i class="fa fa-times">Close Feedback</i></button>
                <p id = 'statusMsg'> </p>

            </form>
            <script type="text/javascript"> 
                openButton = document.getElementById("open");
                closeButton = document.getElementById("close");

                function openFB(){
                    openButton.style.display = "none";
                    closeButton.style.display = "block";
                    document.getElementById("statusMsg").innerHTML = 'Status: The Feedback is open'
                }
                function closeFB(){
                    openButton.style.display = "block";
                    closeButton.style.display = "none";
                    document.getElementById("statusMsg").innerHTML = 'Status: The Feedback is closed'
                }
                function closeBoth(){
                    openButton.style.display = "none";
                    closeButton.style.display = "none";
                    document.getElementById("statusMsg").innerHTML = 'Status: You are not teaching this course'
                }
            </script>
            <?php
                $open = $_POST["open"];
                $close = $_POST["close"];
                $class = $_GET["class"];
                $dbServerName = "oceanus.cse.buffalo.edu";
                $dbUsername = "kchen223";
                $dbPassword = "50277192";
                $dbName = "kchen223_db";

                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "\n");
                }
            
                $stmt = $conn ->prepare("SELECT * FROM feedbackstatus where course = ?");
                $stmt -> bind_param("s", $class);
                $status = $stmt -> execute();
                $result = $stmt->get_result();

                // $sql = "SELECT * FROM `feedbackstatus` WHERE `course` = '$class'";
                // $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if($row["open_closed"] = "open"){
                            echo '<script type="text/javascript">openFB()</script>';
                            if(isset($_POST["close"])){
                                $sql = "UPDATE feedbackstatus SET open_closed = 'closed' WHERE feedbackstatus . course = '$class'";
                                echo '<script type="text/javascript">closeFB()</script>';
                                $query_run = mysqli_query($conn, $sql);
                            }
                        }
                        if ($row["open_closed"] = "closed"){
                            echo '<script type="text/javascript">closeFB()</script>';
                            if(isset($_POST["open"])){
                                $sql = "UPDATE feedbackstatus SET open_closed = 'open' WHERE feedbackstatus . course = '$class'";
                                echo '<script type="text/javascript">openFB()</script>';
                                $query_run = mysqli_query($conn, $sql);
                            }
                        }
                    }
                }
                else{
                    // this part should never happen but just in case
                    echo '<script type="text/javascript">closeBoth()</script>';
                    echo"You are not teaching class $class";
                }
            ?>
        </div>
    </body>
</html>