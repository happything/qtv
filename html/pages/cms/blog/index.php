<?php        
    $location_url = "blog/post";    
    $description = "News, events and more! Say it in your website using this area.";
    $limit = 30;
    $page = 1;
    
    $options = array(                
        "new"=>"post"
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("blog.title","blog.id","blog_categories.name as Category","blog.enabled","blog.content","blog.date","tags"),        
        "join"=>array(
            "blog_categories"=>array("id","blog_categories_id")            
        ),        
        "order"=>"blog.orden",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        "description"=>array("title"=>array("content")),
        "image"=>array("db_table"=>"blog")
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "blog";        
    
    include_once 'modules/recordset.php';
?>    