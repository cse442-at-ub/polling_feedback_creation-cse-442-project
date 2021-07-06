<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Instructor Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
    
        <div class="mx-auto" style="width: 50%; text-align: center;">
            <h1 class="m-3">Instructors Admin Panel</h1>
            <h4 id="notification" class="m-3"></h4>


            <?php                
                $dbServerName = "oceanus.cse.buffalo.edu";
                $dbUsername = "kchen223";
                $dbPassword = "50277192";
                $dbName = "kchen223_db";
                
                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "<br>");
                }
                $class = $_POST["class"];
                $sql = "SELECT id, question FROM pollquestions where COURSE = '$class'";
                $result = $conn->query($sql);
                echo "<h1 class='m-3'>Dashboard for " . $class . " </h1>";
                ?>
                    <form action="instructorAdminFBPanel.php"> 
                        <button type= "submit" name="class" id="class" class ="btn btn-outline-primary btn-lg m-2" 
                            value = 
                                "<?php echo $class ?>"> 
                                Enter FeedBack Config
                        </button>
                    </form>
        
                    
                <?php
                        
                echo '<br>';
                echo '<i>Click the button above me to access FeedBack Config</i>';
                echo '<br>'; echo '<br>';
                ?>
                <form method="post" action="pollCreation.html"> 
                        <button type= "submit" name="class" id="class" class ="btn btn-outline-primary btn-lg m-2" 
                            value = 
                                $class> 
                                Insert Poll Question for specified class
                        </button>
                    </form>
                <?php
                echo '<br>'; echo '<br>';

                if ($result -> num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo $row["question"];
                        ?>
                            <form action="pollStatus.php"> 
                                <button type= "submit" name="number" id="number" class ="btn btn-outline-primary btn-lg m-2" 
                                    value = 
                                        "<?php echo $row["id"] ?>"> 
                                        Enter Poll Config
                                </button>
                            </form>
                        <?php
                        echo "<br>";
                    }
                }
                $conn->close();
            ?>
        </div>
    </body>
</html>