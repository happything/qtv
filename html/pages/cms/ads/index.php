<?php        
    $location_url = "ads/ad";    
    $description = "Ads for sale, get more money!";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"ad"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("ads.name","url","init_date","end_date","ads_categories.name as category","clients.name as client","ads.id","clients.enabled"),        
        "join"=>array(
            "clients"=>array("id","clients_id"),
            "ads_categories"=>array("id","ads_categories_id")            
        ),        
        "where"=>null,
        "order"=>"ads.orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        "description"=>array("name"=>array("url")),        
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "ads";        
    
    include_once 'modules/recordset.php';
?>    