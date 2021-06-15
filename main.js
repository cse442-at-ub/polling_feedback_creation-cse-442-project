var pollAnswer = document.querySelector('active');
function sendPoll(current) {
    if (pollAnswer != null) {
        pollAnswer.classList.remove('active');
    }
    pollAnswer = current;
    pollAnswer.classList.add('active');
    // Send pollAnswer to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","submitPoll.php?answer=" + current.value, true);
    xmlhttp.send();
}

// Timer 
let timeElapsed = 0;
let startTime = 30;
let s = document.getElementById('s');
let currTime = document.getElementById('timer');
let results =document.getElementById('results');
// currTime.innerHTML = startTime - timeElapsed 

let countdown = setInterval(elapseTimer, 1000);

// $("#noModalLabel").click(function(){
//     setTimeout(function(){
//         $("#noModalLabel").hide();
//     },currTime.innerHTML)
// })
function elapseTimer() {
    timeElapsed += 1;
    currTime.innerHTML = startTime - timeElapsed
    if (currTime.innerHTML == 0){
        clearInterval(countdown)
        timeElapsed = 0;
        s.innerHTML = '';
        window.location.href = './pollResults.php'
        // document.getElementsByClassName('mx-auto')[0].style.visibility = 'hidden';
        // if (document.getElementsByClassName('modal-backdrop fade show')[0] != undefined){
        //     document.getElementsByClassName('modal-backdrop fade show')[0].style.visibility = 'hidden';
        // }
        // document.getElementsByClassName('mx-auto-2')[0].style.visibility = 'visible';
        
    }
}