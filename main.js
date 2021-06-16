var score = document.querySelector('active')

function sendScore(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    // Send score to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","score.php?score=" + score.value, true);
    xmlhttp.send();
    // Display notification
    document.getElementById('notification').innerHTML = "Your feedback has been submitted: " + "<br>" + "<b>" + score.innerHTML + "</b>"
}