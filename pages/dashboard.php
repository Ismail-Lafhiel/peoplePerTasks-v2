<?php
include_once("../resources/session.php");

if(isset($_SESSION["username"])){
    if($_SESSION["user_type"] == "client"){
        echo "this is dashboard";
    }
    else{
        header("Location: index.php");
    }
    
}else{
    header("Location: login.php");
}

?>