var score = document.querySelector('active')

function sendScore(current) {
    // Alert user
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    alert("Feedback submitted: " + score.innerHTML);
    // Send score to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","score.php?score=" + score.value, true);
    xmlhttp.send();


}

// Timer 
let timeElapsed = 0;
let startTime = 10;
let s = document.getElementById('s');
let currTime = document.getElementById('timer');
let results =document.getElementById('results');
currTime.innerHTML = startTime - timeElapsed 

let countdown = setInterval(elapseTimer, 1000);

function elapseTimer() {
    timeElapsed += 1;
    currTime.innerHTML = startTime - timeElapsed
    if (currTime.innerHTML == 0){
        clearInterval(countdown)
        timeElapsed = 0;
        s.innerHTML = '';
        currTime.innerHTML = 'Times up!'
        document.getElementsByClassName('scores')[0].style.visibility = 'hidden';
        results.innerHTML = "Results: 10 voted Yes | 5 voted No | 25 voted Tentative";

    }
}
