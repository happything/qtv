<?php        
    $location_url = "galleries/gallery";    
    $description = "You can manage all the pictures of the nightclubs in this area. Use it with responsability";
    $limit = 200;
    $page = 1;
    
    $options = array(                
        "new"=>"gallery",
        "Nuevo FTP"=>array("href"=>"/happycms/galleries/ftp"),
        "Agregar Portada"=>array("onclick"=>"banner(1)"),
        "Quitar Portada"=>array("onclick"=>"banner(0)")
    );
    
    include_once 'modules/pagination-set.php';
    
    $read_options = array(
        "fields"=>array("galleries.title","galleries.id","galleries_type.name as Tipo","nightclubs.name as nightclub","banner as Portada","galleries.date","galleries.enabled","galleries.description"),        
        "join"=>array(
            "nightclubs"=>array("id","nightclubs_id"),
            "galleries_type"=>array("id","galleries.galleries_type_id")            
        ),        
        "order"=>"galleries.id DESC",
        "limit"=> $limit_statement
    );

    $rows_options = array( 
        "description"=>array("title"=>array("description")),
        "image"=>array("db_table"=>"galleries")
    );
    
    //$headers = array("Nombre","Id","Usuario","Options");    
    $db_table = "galleries";        
    
    include_once 'modules/recordset.php';
?>    

<script>
    function banner(val){
        var ids = get_checked();        
        if(ids!=""){
            $.ajax({
                url:"/ajax/recordset.php",
                type:"post",
                cache:false,
                data:{id:ids,type:"banner",val:val},
                success:function(d){
                    location.reload();
                }
            });    
        } else {
            alert("Select a gallery to continue please");
        }
        
    }
</script>