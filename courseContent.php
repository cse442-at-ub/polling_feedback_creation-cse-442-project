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
            // Hard coding course cookie; connect with login page later
            $course_key = "course";
            // $course_value = "CSE 442";
            // setrawcookie($course_key, $course_value, time() + (86400 * 30), "/");
            // $ubit_key = "ubit";
            // $ubit_value = "kchen223";
            // setrawcookie($ubit_key, $ubit_value, time() + (86400 * 30), "/");
            // Checking for course cookie
            // setcookie("course", "CSE 442", time() + (86400 * 30), "/"); 
            if(isset($_COOKIE[$course_key])) {
                echo "<h1 class='m-3 text-center'>" . htmlspecialchars($_COOKIE['course']) . "</h1>";
            }else{
                echo "not working";
            }
            ?>
            
            <h5 id="inactive" style="display: none;"></h5>
            <div id="poll" style="display: none;">
                <h2 id="question"></h2>
                <input id="question_id" type="hidden" value="">
                <div id="choice1"></div>
                <div id="choice2"></div>
                <div id="choice3"></div>
                <div id="choice4"></div>
                <div id="choice5"></div>
                <p id="instruction" class='m-3' style='text-align:center'>The poll is open. The poll will end when the instructor closes it.</p>
            </div>
            <div class="mx-auto" style="width: 50%; text-align: center; display: none;" id="feedback">
                <h5 class="m-3">How are you understanding the material?</h5>
                <button type="button" class="btn btn-outline-danger btn-lg m-2" value="1" onclick=sendScore(this)>I'm lost.</button>
                <button type="button" class="btn btn-outline-primary btn-lg m-2" value="2" onclick=sendScore(this)>Just right.</button>
                <button type="button" class="btn btn-outline-success btn-lg m-2" value="3" onclick=sendScore(this)>This is easy.</button>
                <h4 id="notification" class="m-3">
            </div>

            <div id="response_string" class="text-success m-3"></div>
        </div>
    </body>
</html>