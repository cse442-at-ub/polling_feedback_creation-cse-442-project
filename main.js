var score = document.querySelector('active')

function sendScore(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","score.php?score=" + score.value, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                sendNotification(score.innerHTML);
            } else {
                console.log('Request failed.');
                document.getElementById('notification').innerHTML = "<p class='text-danger'>Feedback could not be submitted.</p>"
            }
        }
    }

    xmlhttp.send();
}

function sendNotification(text) {
    if (text == undefined || text == "") {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>No response received.</p>";
    } else if (text == "I'm lost." || text == "Just right." || text == "This is easy.") {
        document.getElementById('notification').innerHTML = "<p class='text-success'>Your feedback has been submitted! </p>" + "<b>" + text + "</b>"
    } else {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>Invalid feedback option: </p>" + "<b>" + text + "</b>";
    }
}