<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Poll Question Submitted</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <div class="alert alert-primary" style="text-align: center;" role="alert">
        <h4>Course Submission Recieved</h4>
    </div>

    <div class="mx-auto" style="text-align: center;">
        <?php
        $dbServerName = "oceanus.cse.buffalo.edu";
        $dbUsername = "kchen223";
        $dbPassword = "50277192";
        $dbName = "kchen223_db";

        $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error . "\n");
        }

        $courseCode = htmlspecialchars($_REQUEST['courseCode']);
        $courseName = htmlspecialchars($_REQUEST['courseName']);
        $semester = htmlspecialchars($_REQUEST['semester']);
        $instructor1 = htmlspecialchars($_REQUEST['instructor1']);
        $instructor2 = htmlspecialchars($_REQUEST['instructor2']);
        $instructor3 = htmlspecialchars($_REQUEST['instructor3']);
        $instructor4 = htmlspecialchars($_REQUEST['instructor4']);
        $instructor5 = htmlspecialchars($_REQUEST['instructor5']);

        if(!empty($courseCode)){
            $stmt = $conn->prepare("INSERT INTO `course setup` (`Course Code`, `Course Name`, `semester`, `instructor1`, `instructor2`, `instructor3`, `instructor4`, `instructor5`) 
            VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssss",$courseCode, $courseName, $semester, $instructor1, $instructor2, $instructor3, $instructor4, $instructor5);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        ?>
    </div>
</body>
<script src="main.js" async defer></script>

</html>