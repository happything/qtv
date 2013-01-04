<?php
    include_once '../config/connection.php';
    $table = $_POST["table"];
    if(isset($_POST["value_id"])) $value_id = $_POST["value_id"]; else $value_id = "id";
    $id = $_POST["id"];
    if(isset($_POST["value"])) $value = $_POST["value"]; else $value = "name";
    
    $query = "SELECT id,".$value." FROM ".$table." WHERE ".$value_id." = ".$id;
    
    $result = mysql_query($query,$link);
    $option = "";
    while($row = mysql_fetch_assoc($result)){
        $option .= "<option value='".$row["id"]."'>".  utf8_encode($row[$value])."</option>";
    }
    
    echo $option;
?>
