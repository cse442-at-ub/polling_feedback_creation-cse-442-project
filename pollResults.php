<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>UB Polling</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        
            <p class="h1" style="text-align:center">The poll has ended.</p>
            <br>
            <p class="h2" style="text-align:center; text-decoration:underline">Results:</p>
            </div>
                        <?php
                            $dbServerName = "oceanus.cse.buffalo.edu";
                            $dbUsername = "kchen223";
                            $dbPassword = "50277192";
                            $dbName = "kchen223_db";

                            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
                            $course = urldecode(mysqli_real_escape_string($conn, $_GET['class']));
                            $question_id = mysqli_real_escape_string($conn, $_GET['number']);
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error . "\n");
                            }
                            // echo "Connected successfully." . "\n";

                            $stmt = $conn->prepare("SELECT response, count(*) as NUM FROM pollresponses WHERE course = ? AND question_id = ? GROUP BY response");
                            $stmt->bind_param('si', $course, $question_id);
                        
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                if ($result->num_rows >= 1) {
                                    while($row = mysqli_fetch_array($result)){
                                        echo"<p class='h3' style='text-align:center'>{$row['response']}: {$row['NUM']}</p><br>";
                                    }
                                } else if ($result->num_rows == 0) {
                                    echo "<p class='h3' style='text-align:center'>No responses.</p>";
                                }
                            }
                            $conn->close();
                        ?>
      
        <script src="main.js" async defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>
