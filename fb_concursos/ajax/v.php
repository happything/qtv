<?php
    session_start();
    include_once '../libs/connection.php';
    
    if(isset($_SESSION["voted"])) $_SESSION["voted"] = false;
    
    
    if(!$_SESSION["voted"]){
        $_SESSION["voted"] = true;
        $user_id = $_POST["vl"];
        $facebook_id = $_POST["fvl"];

        $facebook_user = file_get_contents('http://graph.facebook.com/'.$facebook_id);
        if($facebook_user != 'false'){
            $query = "SELECT id FROM votes WHERE facebook_id = ".$facebook_id." AND users_id = ".$user_id;
            $result = mysql_query($query,$link);

            //If facebook user voted earlier, he is making trap
            if(mysql_num_rows($result) == 0) {
                $query = "INSERT INTO votes SET facebook_id = ".$facebook_id.", users_id = ".$user_id.", date = now()";
                if(mysql_query($query,$link)) echo 1;
                else echo 0; //Error in the query
            } else {
                echo -1; //Voted earlier
            }    
        } else echo -2; //Unknown User    
    } else echo -3; //Voted already
    
    
    
?>
