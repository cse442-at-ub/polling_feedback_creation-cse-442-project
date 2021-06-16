var score = document.querySelector('active')

function keepHighlighted(current) {
    // Keep button highlighted
    if (score != null) {
        score.classList.remove('active');
    }
    score = current;
    score.classList.add('active');
    // Send poll question to DB
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","PollQuestion.php?answers=" + score.value, true);
    xmlhttp.send();
}

//function to add and remove answer boxes
$(document).ready(function() {
    $(".add-more").click(function(){
        var html = $(".copy").html();
        $(".after-add-more").after(html);
    });
    $("body").on("click",".remove",function(){ 
        $(this).parents(".addremove").remove();
    });
  });
