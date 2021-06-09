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