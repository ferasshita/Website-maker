<?php
    if($_SESSION['mode'] == "night"){
    echo "dark-skin";
    }elseif($_SESSION['mode'] == "light"){
    echo "light-skin";
    }else{
    $dhsh = date("H");
    if($dhsh>=4&&$dhsh<=18){
    echo "light-skin";
    }else{
    echo "dark-skin";
    }
    }
    ?>
