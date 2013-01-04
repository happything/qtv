<?php        
    $location_url = "places/places-types/place-type";    
    $description = "Area for Culichi beautiful places";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"place-type"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("places_types.name as type","places_types.id","places_types.description","places_types.enabled"),                            
        "order"=>"places_types.orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        //"description"=>array("place"=>array("description")),
        "image"=>array()
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "places_types";        
    
    include_once 'modules/recordset.php';
?>    