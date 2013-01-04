<?php
    
    if(isset($_POST['form']['id'])){
        include_once '../libs/forms.php';
        include_once '../libs/queries.php';
        include_once '../config/connection.php';
    }else{
        include_once 'libs/forms.php';
        include_once 'libs/queries.php';
    }
    
    $queries = new Queries($link);
    $select_row = null;
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['form'])){
            if(!isset($_POST["form"]["date"])) $_POST["form"]["date"] = date("Y-m-d");
            $form = $_POST['form'];            
            if(!isset($_POST['validate'])) $validate = null; else $validate = $_POST['validate'];
            if(!isset($_POST['form']['id']) || (!$_POST['form']['id'])) $id = null; else $id = $_POST['form']['id']; 
            if(isset($_POST['table'])){ $table = $_POST['table']; $save = $queries->save($form, $table, $validate, $id); } else  $save = null; 

            //If is FTP upload files section, make the magic ...
            if(isset($save) && $save["error"] == 0 && $_POST['table'] == "galleries" && isset($_POST['form']['url'])){                
                $folder  = $_POST["url"];
                if(is_dir("../temp_galleries/".$folder)){     
                    $default_dir = "../img/cms/galleries/";
                    mkdir($default_dir.$save["insert_id"],0777);
                    mkdir($default_dir.$save["insert_id"]."/thumbnails",0777);
                    mkdir($default_dir.$save["insert_id"]."/files",0777);
                }
            }
        }else{
            if($table == "galleries" && !isset($_POST["nightclubs_id"])) $_POST["nightclubs_id"] = -1;        
            $form = $_POST;            
            if(!isset($validate)) $validate = null;
            if(!isset($id) || !$id) $id = null;            
            if(isset($table)) $save = $queries->save($form, $table, $validate,$id); else  $save = null;            
        }
        
        if($table == "galleries" && isset($_POST["url"])){

        } else if(is_array($save) && !isset($_POST['form']['id'])){
            if($save['success'] == 1){
                if(!isset($redirect_url)) header ('Location: /happycms/'.$table);                                
                else header ('Location: /happycms/'.$redirect_url);                     
            }                
                
        }
        $select_row = $form;
        echo json_encode($save);
        
        
    } else if(isset($id) && $id!=false){        
        if(isset($table)) $select_sql = "SELECT * FROM ".$table." WHERE id = ".$id;
        else { echo "<p>Selecciona una tabla de la Base de Datos.</p>"; $select_sql = null; }
        
        if(isset($select_sql)){
            $result = mysql_query($select_sql,$link);
            $select_row = mysql_fetch_assoc($result);
        }
        //print_r($select_row);
    }
        
?>
