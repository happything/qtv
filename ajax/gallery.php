<ul>
<?php   
    include_once '../config/connection.php';
    if(isset($_POST["ncid"])) $nightclub_id = $_POST["ncid"];    
    $pg = 1;
    $pg = @$_POST["pg"]; 
    $url = $_POST["url"];

    $start = $pg*32;

    $query = "SELECT images.id,images.title 
                FROM images 
               WHERE section = 'galleries' 
                 AND parent_id = ".utf8_decode($nightclub_id)." 
            ORDER BY orden ASC 
               LIMIT ".$start.", 32";      
           
    $result = mysql_query($query,$link);
        $i=1;    
        while($row = mysql_fetch_assoc($result)){            
            $class = "";
            if(($i%8)==0) $class = "last";                    
?>            
    <li class="picture <?= $class ?>" style="height: 120px; margin-top: 10px;">            
        <a href="<?= $url."/".$row["id"] ?>">                                
            <img src="/img/cms/galleries/<?= $nightclub_id ?>/thumbnails/thumb_album/<?= $row["title"] ?>" />                
        </a>                    
    </li>                      
<?php                    
        if($i == mysql_num_rows($result)) echo "</ul>";
        $i++;
    }

    if($i==1) echo "<div class'no-pics'>Ahorita no hay fotos en esta parte, pero puedes visitar nuestras demás secciones.</div>";    
?>