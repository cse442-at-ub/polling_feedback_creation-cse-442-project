<?php
function polls(){
    echo "Poll Question <br> \n";
    echo "Do you like to drink water? <br>\n";
    echo "A: Yes<br> \n";
    echo "B: No<br> \n";
    $x = readline("Enter an Input: ");

    if($x == "A" || $x == "a"){
        echo "You chose A <br>\n";
    }

    elseif($x == "B" || $x == "b"){
        echo "You chose B <br> \n";
    }
    
    else{
        echo "Please choose from A or B";
    }
    echo "Answer recieved";
}
polls();
?>