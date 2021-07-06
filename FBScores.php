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
                
                $class = mysqli_real_escape_string($conn, $_GET['class']);
                $stmt = $conn->prepare("SELECT AVG(feedback_score) FROM feedback WHERE timestamp > DATE_SUB(NOW(), INTERVAL 2 MINUTE) AND course = ?");
                $stmt->bind_param('s', $class);

                if ($stmt->execute() === TRUE) {
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()) {
                        $average = $row['AVG(feedback_score)'];
                        if ($average == NULL) {
                            echo "<h3>No recent submissions.</h3><br>";
                        } else {
                            echo "<h1>" . round($average, 1) . "<h1>";
                        }
                    }
                } else {
                    echo "An error has occurred. \n";
                }

                header("Refresh:10");
                
                $conn->close();
            ?>
        </div>
    </body>
</html>