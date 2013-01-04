<?php        
    $location_url = "ads/clients/client";    
    $description = "Clients for the ads, we need them!";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"client"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("name","id","enabled"),                
        "order"=>"orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        //"description"=>array("name"=>array("url")),        
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "clients";        
    
    include_once 'modules/recordset.php';
?>    