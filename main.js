var score = document.querySelector('active')

function sendScore(current) {
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    alert("You gave a score of " + score.value + ".");
}
