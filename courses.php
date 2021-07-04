<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>UB Polling Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        <div class="mx-auto text-center">
            <?php 
                $dbServerName = "oceanus.cse.buffalo.edu";
                $dbUsername = "kchen223";
                $dbPassword = "50277192";
                $dbName = "kchen223_db";

                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "\n");
                }
                
                $email = mysqli_real_escape_string($conn, $_POST['input_email']);

                $stmt = $conn->prepare('SELECT email, course, instructor_student FROM courses WHERE email = ?');
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();

                $count = 0;
                $count2 = 0;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        //for instructors
                        if(htmlspecialchars($row["instructor_student"]) == "instructor" && $count == 0){
                            echo "<h1 class='m-3'>Welcome back " . htmlspecialchars($row["instructor_student"]) . " </h1>";
                            echo "<h4 class='m-3'>Here are the courses you are currently teaching. </h4>";
                            
                            $ubit_key = "ubit";
                            $ubit_value = str_replace("@buffalo.edu","",$row["email"]);
                            setcookie($ubit_key, $ubit_value, time() + (86400 * 30), "/"); 
                            setcookie("status","instructor", time() +(86400 * 30), "/");
                            $count += 1;
                            //send to alex's page
                        }
                        if(htmlspecialchars($row["instructor_student"]) == "instructor" && $count2 == 0){
                            ?>
                            <h4 class='m-3'>Click the button below to set up a new course</h4>
                            <form action="setupCourse.php"> 
                                <button type= "submit" name="number" id="number" class ="btn btn-outline-primary btn-lg m-2" 
                                value = 
                                "New Course Setup"> 
                                Setup New Course    
                            </button>
                        </form>
                        <br>
                        <?php
                            $count2 += 1;
                            echo '<i>Click the button corresonding to your class you want to access to enter your instructor dashboard</i>';
                        }
                        if(htmlspecialchars($row["instructor_student"]) == "instructor"){
                            ?>
                            <form action="instructorAdminPanel.php" method="post">
                                    <button type= "submit" name = "class" id = "<?php echo $row["course"] ?>" class="btn btn-outline-primary btn-lg m-2" 
                                        value = 
                                            "<?php echo $row["course"]?>"> 
                                            <?php echo $row["course"]?>
                                    </button>

                            </form>
                            <?php
                        }



                        //for students
                        if(htmlspecialchars($row["instructor_student"]) == "student" && $count == 0){
                            echo "<h1 class='m-3'>Welcome back " . htmlspecialchars($row["instructor_student"]) . " </h1>";
                            echo "<h2 class='m-3'>Here are the courses you are taking. </h4>";
                            echo '<i>Click the button corresonding to your class you want to access</i>';
                            $cookie_name = "ubit";
                            $cookie_value = str_replace("@buffalo.edu","",$row["email"]);
                            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                            setcookie("status",$row["instructor_student"], time() +(86400 * 30), "/");
                            $count += 1;
                            //send to kevin's page
                        }
                        if(htmlspecialchars($row["instructor_student"]) == "student"){
                            $class = $_POST["class"];
                            ?>
                            <form action="courseContent.php">
                                    <button type= "submit" name = "class" id = "<?php echo $row["course"] ?>" class="btn btn-outline-primary btn-lg m-2" 
                                        value = 
                                            "<?php echo $row["course"]?>"> 
                                            <?php echo $row["course"]?>
                                    </button>
                            </form>
                            <?php
                        }

                    }
                }else{
                        setcookie("ubit", "", time() - 3600, "/");
                        setcookie("status", "", time() - 3600, "/");
                        echo "<h4 class='m-3'>You are not enrolled in any courses.</h4> \n";
                }
                    ?>
        </div>
    </body>
</html>