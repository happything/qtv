<?php        
    $location_url = "galleries/nightclubs/nightclub";    
    $description = "This are the best nightclubs on Culiacan.";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"nightclub"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("nightclubs.name as nightclub","id","enabled"),                
        "order"=>"orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        //"description"=>array("title"=>array("description")),
        "image"=>array()
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "nightclubs";        
    
    include_once 'modules/recordset.php';
?>    