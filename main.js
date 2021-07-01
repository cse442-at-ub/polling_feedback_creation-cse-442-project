var score = document.querySelector('active')

function keepHighlighted(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    document.getElementById('notification').innerHTML = "Your feedback has been submitted: " + "<br>" + "<b>" + score.innerHTML + "</b>"
    // Send poll question to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","PollQuestion.php?answers=" + score.value, true);
    xmlhttp.send();
}

function showResults(){
    window.location.href = './pollResults.php'
}

function hideButtons(){
    openButton.style.display = "none";
    closeButton.style.display = "none";

}

openButton = document.getElementById("open");
closeButton = document.getElementById("close");

function openPoll(){
    openButton.style.display = "none";
    closeButton.style.display = "block";
}

function closePoll(){
    openButton.style.display = "block";
    closeButton.style.display = "none";
}
function sendPoll(current) {
    var pollAnswer = document.querySelector('active');
    if (pollAnswer != null) {
        pollAnswer.classList.remove('active');
    }
    pollAnswer = current;
    responseString.innerHTML = "Your answer of " + current.value.toString() + " has been saved."
    // Send pollAnswer to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","submitPoll.php?answer=" + current.value, true);
    xmlhttp.send();
}


//function to add and remove answer boxes
// $(document).ready(function() {
//     $(".add-more").click(function(){
//         var html = $(".copy").html();
//         $(".after-add-more").after(html);
//     });
//     $("body").on("click",".remove",function(){ 
//         $(this).parents(".addremove").remove();
//     });
//   });

