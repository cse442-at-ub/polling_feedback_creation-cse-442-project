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
        <div class="mx-auto text-center">
            <?php
                $course = $_GET["class"];
                echo "<h1 id='course_name' class='m-3 text-center'>" . htmlspecialchars($course) . "</h1>";
            ?>
            
            <h5 id="class_inactive" style="display: none;">Class is not active. Please wait for the instructor to open the class.</h5>
            <div id="poll" style="display: none;">
                <h2 id="question"></h2>
                <input id="question_id" type="hidden" value="">
                <div id="choice1"></div>
                <div id="choice2"></div>
                <div id="choice3"></div>
                <div id="choice4"></div>
                <div id="choice5"></div>
                <p id="poll_instruction" class='m-3 text-muted'>The poll is open. The poll will end when the instructor closes it.</p>
                <div id="poll_success" class="text-success m-3"></div>
                <input id="poll_status" type="hidden" value="false"></input>
            </div>
            <div id="poll_results">
            </div>
            <div class="mx-auto" style="width: 50%; text-align: center; display: none;" id="feedback">
                <h2 class="m-3">How are you understanding the material?</h2>
                <button type="button" class="btn btn-outline-danger btn-lg m-2" value="0" onclick=sendScore(this)>I'm lost.</button>
                <button type="button" class="btn btn-outline-primary btn-lg m-2" value="5" onclick=sendScore(this)>Just right.</button>
                <button type="button" class="btn btn-outline-success btn-lg m-2" value="10" onclick=sendScore(this)>This is easy.</button>
                <h4 id="feedback_notification" class="m-3">
            </div>
        </div>
    </body>
</html>