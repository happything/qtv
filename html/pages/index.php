<?php

    $query = "SELECT galleries.id,galleries.title,description, (SELECT images.title FROM images WHERE section = 'galleries' AND parent_id = galleries.id ORDER BY orden ASC LIMIT 1) as img,galleries_type.name as type,nightclubs.name as nightclub 
                FROM galleries 
           LEFT JOIN galleries_type ON galleries_type.id = galleries_type_id 
           LEFT JOIN nightclubs ON nightclubs.id = nightclubs_id 
               WHERE banner = 1 
                 AND galleries.enabled = 1 
            ORDER BY galleries.orden,galleries.id DESC";
    $result = mysql_query($query,$link);
    $total_imgs = mysql_num_rows($result);
    $total_width = $total_imgs * 487;    
            
?>
<div class="home-events clearfix">
    <div class="slider-container">
        <div class="slider" id="slider" style="width: <?= $total_width ?>px">
            <?php                    
                while($row = mysql_fetch_assoc($result)){                
                    $nightclub_lnk = ""; 
                    if(utf8_encode(strtolower($row["type"])) == "antros") $nightclub_lnk = $row["nightclub"]."/";
            ?>
            <div class="event">
                <h2><a href="/fotos/<?= str_replace(" ", "-", utf8_encode(strtolower($row["type"]))) ?>/<?= $nightclub_lnk.$row["id"] ?>"><?= utf8_encode($row["title"]) ?></a></h2>
                <a href="/fotos/<?= str_replace(" ", "-", utf8_encode(strtolower($row["type"]))) ?>/<?= $nightclub_lnk.$row["id"] ?>"><img src="/img/cms/galleries/<?= $row["id"] ?>/thumbnails/thumb_banner/<?= $row["img"] ?>" /></a>
                <p><?= utf8_encode($row["description"]) ?></p>    
            </div>    
            <?php } ?>
        </div>
    </div>
        
    <a href="" id="left-arrow" class="banner-lnk banner-left-flag">Atras</a>
    <a href="" id="right-arrow" class="banner-lnk banner-right-flag">Adelante</a>
</div>

<div class="content">
    <div class="left-content">
        <h3 class="title camera">Te encontraste con nuestra cámara?</h3>
        <div class="pictures pic-home">
            <?php                 
                include_once 'ajax/pct.php'; //Use the same file for ajax see more 
            ?>
        </div>
        <?php if($i == 17){ ?>
            <a class="see-more-pictures" id="see-more">Ver más fotos</a>
        <?php } ?>
    </div>
    <aside>
        <div class="right-content">
             <?= Cs_Modules::show("blog",null,$language,$link); //Show aside section ?>            
        </div>    
    </aside>    
</div>
<script>
    var pg = 1;
    var curimg = 1;
    var tlevt = <?= $total_imgs ?>;
    var clk = false;
    $(document).ready(function(){        
        $("#see-more").click(function(e){$.ajax({url:"/ajax/pct.php",data:{pg:pg},type:"post",beforeSend:function(){$("#see-more").html("Cargando ...");},success:function(d){if(d.trim().length < 200) $("#see-more").fadeOut(400,function(){$("#see-more").remove()});else {$(".pic-home").append(d);pg++;$("#see-more").html("Ver más fotos");}}});});
        $("#left-arrow").click(function(e){move(0); e.preventDefault();});
        $("#right-arrow").click(function(e){move(1); e.preventDefault();});
    });
    setInterval("move(1)", 10000);
    function move(side){
        if(!clk){
            if(tlevt>1){
                clk = true;
                var distance = 487;
                var sign = '-=';
                var total_distance = (tlevt-1) * 487;
                if(curimg == 1 && side == 0) { distance = total_distance; curimg = tlevt; }
                else if(curimg == tlevt && side == 1) { distance = "0"; sign = ''; curimg = 1; }
                else if(side == 0) {curimg--;sign='+=';} else if(side == 1) curimg++;
                
                $("#slider").animate({
                    left: sign+distance
                },500,function(){ clk = false; });    
            }            
        }
    }    
</script>