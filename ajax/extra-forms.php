<?php    
    if(isset($_POST["type"])){
        include_once '../config/connection.php';
        $type = $_POST["type"];
        if($type == "save"){
            $table = $_POST["table"]; $id = $_POST["id"]; $field = $_POST["field"]; $value = $_POST["value"];            
            if(trim($value) != ""){            
                $sql = "INSERT INTO ";
                if($id != -1) $sql = "UPDATE ";

                $sql .= $table." SET ".$field." = '".utf8_decode($value)."' ";
                if($id != -1) $sql .= "WHERE id = ".$id;  
                
                if(mysql_query($sql,$link)) {
                    if($id != -1) echo $id;
                    else echo mysql_insert_id($link);
                } else {
                    echo -1;
                }
            }            
        } else if($type == "remove"){
            $id = $_POST["id"];
            $table = $_POST["table"];
            
            $sql = "DELETE FROM ".$table." WHERE id = ".$id;
            if(mysql_query($sql,$link)) echo 1;
            else echo 0;
        }
    }
    
?>
