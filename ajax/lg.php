<?php
    session_start();
    $type = $_POST["tp"];
    
    if($type=="lt") $_SESSION["qtvusrid"] = null;
?>
