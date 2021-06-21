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
        <div class="mx-auto" style="text-align: left;">
            <?php
                $email = $_REQUEST['input_email'];
              
                echo "<h1 class='m-3'>Courses</h1>";

                $dbServerName = "oceanus.cse.buffalo.edu";
                $dbUsername = "kchen223";
                $dbPassword = "50277192";
                $dbName = "kchen223_db";

                $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error . "\n");
                }
                
                $sql = "SELECT email, course FROM courses WHERE email = '$email'";
                
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<h4 class='m-3'>" . $row["course"] . "</h4>" . "\n";
                      }
                } else {
                    echo "<h4 class='m-3'>You are not enrolled in any courses.</h4> \n";
                }
            ?>
        </div>
    </body>
</html>