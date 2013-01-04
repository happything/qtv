<?php        
    $location_url = "users/user";    
    $description = "In this section you may create the users you want wherever you want.\n Don't forget create them with love!";
    $limit = 150;
    $page = 1;
    
    $options = array(                
        "new"=>"user",        
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("users.name","facebook_id","users.id","users.enabled", "email"),        
        "join"=>array(
            "user_types"=>array("id","user_types_id")            
        ),        
        "where"=>array(array("user_types_id",4)),
        "order"=>"users.orden",
        "limit"=> $limit_statement
    );
    $rows_options = array( 
        "description"=>array("name"=>array("email")),
        //"image"=>array("db_table"=>"users")
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "users";        
    
    include_once 'modules/recordset.php';
?>    