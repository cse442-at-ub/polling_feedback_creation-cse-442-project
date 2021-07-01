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
    xmlhttp.open("GET","updateFeedback.php?score=" + score.value + "&ubit=" + ubit, true);

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

function sendPoll(current) {
    if (pollAnswer != null) {
        pollAnswer.classList.remove('active');
    }
    pollAnswer = current;
    pollAnswer.classList.add('active');
    responseString = document.getElementById("response_string");
    responseString.innerHTML = "<h5 class='text-center'>Your answer of " + current.value.toString() + " has been saved.</h5>";
    // Send pollAnswer to DB
    question_id = document.getElementById("question_id");
    let xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","submitPoll.php?answer=" + current.value + "&id=" + question_id.value, true);

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
    if (score == undefined || score == "") {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>No response received.</p>";
    } else if (score == "I'm lost." || score == "Just right." || score == "This is easy.") {
        document.getElementById('notification').innerHTML = "<p class='text-success'>Your feedback has been submitted! </p>" + "<b>" + score + "</b>"
    } else {
        document.getElementById('notification').innerHTML = "<p class='text-danger'>Invalid feedback option: </p>" + "<b>" + score + "</b>";
    }
}

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
    // console.log(document.cookie);
    console.log(getCookie('course'));
    let currentCourse = encodeURIComponent(getCookie("course"));
    // console.log(currentCourse);
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET",`courseStatus.php?course=${currentCourse}`, true);

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4) {
            if (xmlhttp.status === 200) {
                console.log('Request successful.');
                let courseData = JSON.parse(xmlhttp.responseText);
                console.log(courseData);
                populateWindow(courseData);
            } else {
                console.log('Request failed.');
            }
        }
    }
    xmlhttp.send();
}

function populateWindow(data) {
    let poll_status = data['poll_status'];
    let feedback_status = data['feedback_status'];

    let feedback_node = document.getElementById('feedback');
    let poll_node = document.getElementById('poll');
    let inactive_node = document.getElementById('inactive');
    let instruction_node = document.getElementById('instruction');
    let id_node = document.getElementById('question_id');
    let response_node = document.getElementById('response_string');

    if (poll_status == true) {
        let question = data['question'];
        let question_id = data['question_id'];
        document.getElementById('question').innerHTML = question;
        id_node.value = question_id;
        for (let i = 0; i < data['choices'].length ; i++) {
            let choice = data['choices'][i];
            document.getElementById(`choice${i+1}`).innerHTML = `<button class ="btn btn-outline-primary btn-lg m-2" value="${choice}" onclick=sendPoll(this)>${choice}</button>`
        }
    }

    if (poll_status != feedback_status) {
        // feedback open but poll closed
        if (feedback_status == true && poll_status == false) {
            inactive_node.textContent = '';
            feedback_node.style.display = 'block';
            poll_node.style.display = 'none';
            instruction_node.style.display = 'none';
            response_node.textContent = '';
        }
        // feedback closed but poll open
        if (feedback_status == false && poll_status == true) {
            inactive_node.textContent = '';
            feedback_node.style.display = 'none';
            poll_node.style.display = 'block';
            instruction_node.style.display = 'block';
        }
    } 
    // default to poll question if both are open
    else if (poll_status == true && feedback_status == true) {
        inactive_node.textContent = '';
        feedback_node.style.display = 'none';
        poll_node.style.display = 'block';
        instruction_node.style.display = 'block';
    } 
    // show class is not active message if both are closed
    else if (poll_status == false && feedback_status == false) {
        feedback_node.style.display = 'none';
        poll_node.style.display = 'none';
        inactive_node.style.display = 'block';
        inactive_node.textContent = 'Class is not active. Please wait for the instructor to open the class.';
        response_node.textContent = '';
    }
}

window.onload = function() {
    checkCourseStatus();
    setInterval(checkCourseStatus, 10000);
}