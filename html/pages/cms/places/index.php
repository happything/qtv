<?php        
    $location_url = "places/place";    
    $description = "Area for Culichi beautiful places";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"place"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("places.name as place","address","schedule","places.telephone_1 as Tel","places.date","places.id","places.description","places.enabled"),                    
        "join"=>array(
            "places_types"=>array("id","places_types_id")
            ),        
        "order"=>"places.orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        "description"=>array("place"=>array("description")),
        "image"=>array("db_table"=>"events")
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "places";        
    
    include_once 'modules/recordset.php';
?>    