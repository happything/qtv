<?php
    if(is_file('../config/connection.php')) include_once '../config/connection.php';
    
    if(isset($_POST["pg"])) $page = $_POST["pg"];
    else $page = 0;
    $init = $page * 16;
    
    //Photos section settings
    $extra_where = "";
    $extra_join = "";               
    if(isset($type)) $extra_where .= " AND galleries_type.name = '".$type."'";
    if(isset($nightclub)) {
        $nightclub_q = str_replace("-", " ", $nightclub);
        $extra_join .= "LEFT JOIN nightclubs ON nightclubs.id = nightclubs_id ";
        $extra_where .= ' AND nightclubs.name = "'.trim(utf8_decode($nightclub_q)).'"';        
    }
    if(isset($_POST["ltp"]) && @$_POST["ltp"]!=-1){
        $extra_where .= " AND galleries_type.name = '".utf8_decode($_POST["ltp"])."'";
    }
    if(isset($_POST["lncb"]) && @$_POST["lncb"]!=-1){
        $extra_where .= " AND nightclubs.name = '".utf8_decode(str_replace("-", " ", $_POST["lncb"]))."'";
    }

    $query = "SELECT galleries.id,galleries.date,galleries.title,galleries.description,(SELECT images.title FROM images WHERE section = 'galleries' AND parent_id = galleries.id ORDER BY orden ASC LIMIT 1) as img,galleries_type.name as type,nightclubs.name as nightclub 
                          FROM galleries                           
                          LEFT JOIN galleries_type ON galleries_type.id = galleries_type_id 
                          LEFT JOIN nightclubs ON nightclubs.id = nightclubs_id 
                          WHERE galleries.enabled = 1 ".$extra_where." 
                          GROUP BY galleries.id 
                          ORDER BY galleries.orden,galleries.id DESC  
                          LIMIT ".$init.", 16";      

    echo "<div style='display:none'>".$query."</div>";                          
    $result = mysql_query($query,$link);
    
        $i = 1;
        while($row = mysql_fetch_assoc($result)){
            if($i == 1) echo "<ul>";
            $class = "";
            if(($i%8)==0) $class = "last";                    
    ?>            
        <li class="picture <?= $class ?>">
            <?php
                $nightclub_lnk = ""; 
                if(utf8_encode(strtolower($row["type"])) == "antros") $nightclub_lnk = utf8_encode(strtolower(str_replace(" ", "-", $row["nightclub"])))."/";
            ?>
            <a href="/fotos/<?= str_replace(" ", "-", utf8_encode(strtolower($row["type"]))) ?>/<?= $nightclub_lnk.$row["id"] ?>">
                <strong>
                    <?php 
                        if(strlen($row["title"])<50) echo utf8_encode($row["title"]);
                        else echo utf8_encode(substr($row["title"],0,50))." ...";

                    ?></strong>
                <span><?= $row["date"] ?></span>
                <?php  
                    $gallery_date = (strtotime($row["date"]))/60/60/24;
                    $now_date = strtotime(date("Y-m-d"))/60/60/24;
                    if(($now_date - $gallery_date) <= 7) {
                ?>
                <div class="new"></div>
                <?php } ?>    

                <img  src="/img/cms/galleries/<?= $row["id"] ?>/thumbnails/thumb_album/<?= $row["img"] ?>" />
                <p><?= substr(utf8_encode(stripslashes($row["description"])),0,50)."..."; ?></p>
            </a>                    
        </li>

    <?php    
            if(($i%8)==0) {
    ?>
        </ul>
        <a href="" class="brand"><img src="/img/publicity.jpg" /></a><a href="" class="brand"><img src="/img/publicity.jpg" /></a> <ul>                           
    <?php                    
            } if($i == mysql_num_rows($result)) echo "</ul>";
        $i++;
        }

        if($i==1) echo "<div class'no-pics'>Ahorita no hay fotos en esta parte, pero puedes visitar nuestras demás secciones.</div>";    
    ?>    
    