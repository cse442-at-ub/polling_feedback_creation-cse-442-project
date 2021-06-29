var score = document.querySelector('active');
var pollAnswer = document.querySelector('active');

function sendScore(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    ubit = document.getElementById("ubit").value;

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","score.php?score=" + score.value + "&ubit=" + ubit, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                sendNotification(score.innerHTML, ubit);
            } else {
                console.log('Request failed.');
                document.getElementById('notification').innerHTML = "<p class='text-danger'>Feedback could not be submitted.</p>"
            }
        }
    }
    xmlhttp.send();
}

function sendPoll(current) {
    if (pollAnswer != null) {
        pollAnswer.classList.remove('active');
    }
    pollAnswer = current;
    pollAnswer.classList.add('active');;
    responseString = document.getElementById("responseString");
    responseString.innerHTML = "<h5 class='text-center'>Your answer of " + current.value.toString() + " has been saved.</h5>";
    // Send pollAnswer to DB
    question_id = document.getElementById("question_id");
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","submitPoll.php?answer=" + current.value + "&id=" + question_id.value, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                sendNotification(score.innerHTML, ubit);
            } else {
                console.log('Request failed.');
                document.getElementById('notification').innerHTML = "<p class='text-danger'>Feedback could not be submitted.</p>"
            }
        }
    }
    xmlhttp.send();
}

function sendNotification(score, ubit) {
    if (score == undefined || score == "") {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>No response received.</p>";
    } else if (score == "I'm lost." || score == "Just right." || score == "This is easy.") {
        document.getElementById('notification').innerHTML = "<p class='text-success'>Your feedback has been submitted! </p>" + "<b>" + score + "</b>"
    } else {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>Invalid feedback option: </p>" + "<b>" + score + "</b>";
    }
    if (ubit == "") {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>Please enter a UBIT.</p>";
    }
}