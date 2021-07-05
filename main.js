let score = document.querySelector('active');
let pollAnswer = document.querySelector('active');
let previousPollStatus = document.getElementById('poll_status');

function sendScore(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');

    let ubit = getCookie('ubit');
    let course_name = encodeURIComponent(document.getElementById('course_name').innerHTML);
    let xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET",`updateFeedback.php?course=${course_name}&score=${score.value}&ubit=${ubit}`, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                feedbackNotification(score.innerHTML);
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
        feedback_notification.innerHTML = `<p class='text-success'>Your feedback has been submitted! </p> <p>${score}</p>`
    } else {
        feedback_notification.innerHTML = `<p class='text-danger'>Invalid feedback option: </p>${score}</p>`;
    }
}


function fetchCourseStatus() {
    let course_name = encodeURIComponent(document.getElementById('course_name').innerHTML);
    
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET",`courseStatus.php?course=${course_name}`, true);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Course status request successful.');
                let course_data = JSON.parse(xmlhttp.responseText);
                console.log(course_data);
                parseData(course_data);
            } else {
                console.log('Course status request failed.');
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
    let poll_results = document.getElementById('poll_results');
    let poll_success = document.getElementById('poll_success');
    let feedback_notif = document.getElementById('feedback_notification');
    
    // Feedback open but poll closed
    if (feedback_status == true && poll_status == false) {
        showElement(feedback);
        hideElement(poll);
        hideElement(class_inactive);
        detectPollChange(poll_status);
        hideElement(poll_results);
        resetTextElement(poll_success);
    }
    // Feedback closed but poll open
    else if (feedback_status == false && poll_status == true) {
        showElement(poll);
        hideElement(feedback);
        hideElement(class_inactive);
        populatePollQuestion(data);
        detectPollChange(poll_status);
        removeAllChildNodes(poll_results);
    }
    // Default to poll question if both are open
    else if (poll_status == true && feedback_status == true) {
        showElement(poll);
        hideElement(feedback);
        hideElement(class_inactive);
        populatePollQuestion(data);
        detectPollChange(poll_status);
        removeAllChildNodes(poll_results);
    } 
    // Show class is not active message if both are closed
    else if (poll_status == false && feedback_status == false) {
        hideElement(feedback);
        hideElement(poll);
        showElement(class_inactive);
        detectPollChange(poll_status);
        resetTextElement(poll_success);
    }
}

function populatePollQuestion(data) {
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


function detectPollChange(current_status) {
    if (previousPollStatus.value == "true" && current_status.toString() == "false") {
        fetchPollResults();
        let poll_results = document.getElementById('poll_results');
        showElement(poll_results);    
    }
    if (previousPollStatus != current_status.toString()) {
        previousPollStatus.value = current_status.toString();
    }
}

function fetchPollResults() {
    let course_name = encodeURIComponent(document.getElementById('course_name').innerHTML);
    let question_id = document.getElementById('question_id').value;
    
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET",`studentPollResults.php?course=${course_name}&id=${question_id}`, true);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Poll Results request successful.');
                let poll_results_data = JSON.parse(xmlhttp.responseText);
                console.log(poll_results_data);
                populatePollResults(poll_results_data);
            } else {
                console.log('Poll results request failed.');
            }
        }
    }
    xmlhttp.send();
}

function populatePollResults(data) {
    let poll_results = document.getElementById('poll_results');
    let h5 = document.createElement("h5");
    h5.textContent = `Poll Results:`;
    poll_results.appendChild(h5);
    Object.keys(data).forEach(key => {
        let result = createPollResultElement(key, data[key]);
        poll_results.appendChild(result);
    });
    showElement(poll_results);
}

function createPollResultElement(key, value) {
    let p = document.createElement("p");
    p.textContent = `${key}: ${value}`;
    return p;
}

function createChoiceButton(choice) {
    return `<button class ="btn btn-outline-primary btn-lg m-2" value="${choice}" onclick=sendPoll(this)>${choice}</button>`
}

function hideElement(element) {
    element.style.display = 'none';
}

function showElement(element) {
    element.style.display = 'block';
}

function resetTextElement(element) {
    element.textContent = '';
}

// Source: https://www.javascripttutorial.net/dom/manipulating/remove-all-child-nodes/
function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
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

window.onload = function() {
    fetchCourseStatus();
    setInterval(function() {
        fetchCourseStatus();
    }, 10000);
}