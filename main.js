let score = document.querySelector('active');
let pollAnswer = document.querySelector('active');

function sendScore(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    ubit = getCookie('ubit');

    let xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET",`updateFeedback.php?score=${score.value}&ubit=${ubit}`, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                sendNotification(score.innerHTML);
            } else {
                console.log('Request failed.');
                document.getElementById('feedback_notification').innerHTML = "<p class='text-danger'>Feedback could not be submitted.</p>"
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
    pollAnswer.classList.add('active');
    responseString = document.getElementById("poll_success");
    responseString.innerHTML = "<h5 class='text-center'>Your answer of " + current.value.toString() + " has been saved.</h5>";
    // Send pollAnswer to DB
    let question_id = document.getElementById("question_id");
    let course_name = encodeURIComponent(document.getElementById('course_name').innerHTML);
    let xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET",`submitPoll.php?course=${course_name}&answer=${current.value}&id=${question_id.value}`, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
            } else {
                console.log('Request failed.');
            }
        }
    }
    xmlhttp.send();
}

function feedbackNotification(score) {
    let feedback_notification = document.getElementById('feedback_notification');
    if (score == undefined || score == "") {
        feedback_notification.innerHTML = "<p class='text-danger'>No response received.</p>";
    } else if (score == "I'm lost." || score == "Just right." || score == "This is easy.") {
        feedback_notification.innerHTML = "<p class='text-success'>Your feedback has been submitted! </p>" + "<b>" + score + "</b>"
    } else {
        feedback_notification.innerHTML = "<p class='text-danger'>Invalid feedback option: </p>" + "<b>" + score + "</b>";
    }
}

// Source: https://www.w3schools.com/js/js_cookies.asp
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCourseStatus() {
    let course_name = encodeURIComponent(document.getElementById('course_name').innerHTML);

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET",`courseStatus.php?course=${course_name}`, true);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                let course_data = JSON.parse(xmlhttp.responseText);
                parseData(course_data);
                console.log(course_data);
            } else {
                console.log('Request failed.');
            }
        }
    }
    xmlhttp.send();
}

function parseData(data) {
    let poll_status = data['poll_status'];
    let feedback_status = data['feedback_status'];
    
    let class_inactive = document.getElementById('class_inactive');
    let poll = document.getElementById('poll');
    let feedback = document.getElementById('feedback');

    // Feedback open but poll closed
    if (feedback_status == true && poll_status == false) {
        hideClassInactive(class_inactive);
        showFeedback(feedback);
        hidePoll(poll);
    }
    // Feedback closed but poll open
    else if (feedback_status == false && poll_status == true) {
        hideClassInactive(class_inactive);
        hideFeedback(feedback);
        populatePoll(data);
        showPoll(poll);
    }
    // Default to poll question if both are open
    else if (poll_status == true && feedback_status == true) {
        hideClassInactive(class_inactive);
        hideFeedback(feedback);
        populatePoll(data);
        showPoll(poll);
    } 
    // Show class is not active message if both are closed
    else if (poll_status == false && feedback_status == false) {
        hideFeedback(feedback);
        hidePoll(poll);
        showClassInactive(class_inactive);
    }
}

function populatePoll(data) {
    let question = data['question'];
    let question_id = data['question_id'];
    document.getElementById('question').innerHTML = question;
    document.getElementById('question_id').value = question_id;
    for (let i = 0; i < data['choices'].length ; i++) {
        let choice = data['choices'][i];
        let choice_button = document.getElementById(`choice${i+1}`);
        choice_button.innerHTML = createChoiceButton(choice);
    }
}

function createChoiceButton(choice) {
    return `<button class ="btn btn-outline-primary btn-lg m-2" value="${choice}" onclick=sendPoll(this)>${choice}</button>`
}

function showFeedback(feedback) {
    feedback.style.display = 'block';
}

function hideFeedback(feedback) {
    feedback.style.display = 'none';
}

function showPoll(poll) {
    poll.style.display = 'block';
}

function hidePoll(poll) {
    poll.style.display = 'none';   
}

function showClassInactive(class_inactive) {
    class_inactive.style.display = 'block';
}

function hideClassInactive(class_inactive) {
    class_inactive.style.display = 'none';
}

window.onload = function() {
    checkCourseStatus();
    setInterval(checkCourseStatus, 10000);
}