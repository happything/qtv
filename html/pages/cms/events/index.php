<?php        
    $location_url = "events/event";    
    $description = "Organize events with some clicks :)";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"event"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("events.name as event","events.place","CONCAT('$',events.box_office,'.00') as Box_Office","events.telephone_1 as Tel","events.date","events.id","events.description","events.enabled"),                    
        "order"=>"events.orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        "description"=>array("event"=>array("description")),
        "image"=>array()
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "events";        
    
    include_once 'modules/recordset.php';
?>    