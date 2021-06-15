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
        <div class="mx-auto-2" style="width: 50%; text-align: center;">
            <p class="h1">The poll has ended.</p>
            <button type="button" class="btn btn-outline-danger btn-lg m-2" data-bs-toggle="modal" data-bs-target="#resultsModal" value="results">Show Results.</button>

            <div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resultsModalLabel">Results:</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                        <?php
                            $dbServerName = "oceanus.cse.buffalo.edu";
                            $dbUsername = "kchen223";
                            $dbPassword = "50277192";
                            $dbName = "kchen223_db";

                            $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error . "\n");
                            }
                            // echo "Connected successfully." . "\n";

                            $sql = "SELECT pollAnswer, count(*) as NUM FROM poll GROUP BY pollAnswer";

                            $result = mysqli_query($conn, $sql) or die("Bad Query: $sql");
                            
                            while($row = mysqli_fetch_array($result)){
                                echo"{$row['pollAnswer']}: {$row['NUM']} <br>";
                            }

                            $conn->close();
                        ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="main.js" async defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </body>
</html>