<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>UB Polling</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>
        <div class="mx-auto" style="width: 50%; text-align: center;">
            <h1 class="m-3">Average Feedback</h1>
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

                $sql = "SELECT timestamp, AVG(score) FROM scores WHERE timestamp > DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $average = $row['AVG(score)'];
                        if ($average == 0) {
                            echo "No recent submissions. <br>";
                        } else {
                            echo "<h1>" . round($average, 1) . "<h1>";
                        }
                    }
                }

                // echo "It is currently: " . date("Y-m-d H:m:s") . "<br>";
                
                header("Refresh:10");
                
                $conn->close();
            ?>
        </div>
    </body>
</html>