<?php
function polls(){
    echo "Poll Question\n";
    echo "Do you like to drink water\n";
    echo "A: Yes";
    echo "B: No";
    $x = readline();

    if($x == "A" || $x == "a"){
        echo "You chose A\n";
    }

    elseif($x == "B" || $x == "b"){
        echo "You chose B\n";
    }
    
    else{
        echo "Please choose from A or B";
    }
}
?>