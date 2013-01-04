<?php
include_once '../config/connection.php';

if(!isset($_POST["type"])){
    $section 	    = $_POST['section'];
    //$updateRecordsArray = explode(",", $_POST['recordsArray']);    
    $updateRecordsArray = $_POST['image'];    

    $i = 1;
    foreach ($updateRecordsArray as $recordIDValue) {
        $value = $recordIDValue;
        $query = "UPDATE images SET orden = " . $i . " WHERE section = '".$section."' AND id = " . $value."";
        echo $query." - ";
        mysql_query($query,$link);
        $i++;
    }
} else if($_POST["type"]=="delete_hat"){
    $id = $_POST["id"];
    $sql = "DELETE FROM images WHERE id = ".$id;
    if(mysql_query($sql,$link)) echo 1;
    else echo 0;
}

   
?>
