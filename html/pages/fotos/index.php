<?php    
    if($get == false) $type = null; 
    else if(!is_array($get)) $type = $get;
    else if(is_array($get)) { 
        $type = $get[0]; 
        if($type == "antros"){
            $nightclub = $get[1];        
            if(isset($get[2])) $nightclub_id = $get[2];
            if(isset($get[3])) $photo_id = $get[3];
        } else {
            $nightclub_id = $get[1];
            if(isset($get[2])) $photo_id = $get[2];
        }
        
    }
    $last_type = -1;
    $last_nightclub = -1;
?>
<script type="text/javascript" src="/js/jquery.print.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=127488900729513";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="content">
    <div class="left-content">
        <h3 class="title camera">Las fotos de <?= $type ?></h3>
        <div class="pictures pic-home">
            <div class="breadcrumbs">
                <a href="/fotos">Fotos</a>  
                <?php if(isset($type) && isset($nightclub) && isset($get[3])) { ?>
                    > <a href="/fotos/<?= $type ?>"><?= ucwords($type) ?></a> > <a href="/fotos/<?= $type ?>/<?= $nightclub ?>"><?= ucwords(str_replace("-", " ", $nightclub)) ?></a> > <a href="/fotos/<?= $type ?>/<?= $nightclub."/".$nightclub_id ?>">Galeria</a> > <span>Foto</span>
                <?php } else if(isset($type) && isset($nightclub) && isset($get[2])) { ?>
                    > <a href="/fotos/<?= $type ?>"><?= ucwords($type) ?></a> > <a href="/fotos/<?= $type ?>/<?= $nightclub ?>"><?= ucwords(str_replace("-", " ", $nightclub)) ?></a> > <span>Galeria</span>
                <?php } else if(isset($type) && !isset($nightclub) && isset($get[2]) && is_array($get)) { ?>
                    > <a href="/fotos/<?= $type ?>"><?= ucwords($type) ?></a> > <a href="/fotos/<?= $type ?>/<?= $nightclub_id ?>">Galeria</a> > <span>Foto</span>
                <?php } else if(isset($type) && isset($nightclub)) { ?>
                    > <a href="/fotos/<?= $type ?>"><?= ucwords($type) ?></a> > <span><?= ucwords(str_replace("-", " ", $nightclub)) ?></span>
                <?php 
                    $last_type = $type;
                    $last_nightclub = $nightclub;
                    } else if(isset($nightclub_id)) { 
                ?>    
                    > <a href="/fotos/<?= $type ?>"><?= ucwords($type) ?></a> > <span>Galeria</span>
                <?php } else if(isset($type)) { ?>
                    > <span><?= ucwords($type) ?></span>
                <?php
                    $last_type = $type;
                    }
                ?>
            </div>
            <?php
                if(isset($nightclub) && $type == "antros"){
                    /*$query = "SELECT nightclubs.id, title as img  
                              FROM nightclubs 
                              LEFT JOIN images ON parent_id = nightclubs.id AND section = 'nightclubs' 
                              WHERE nightclubs.name = '".utf8_decode($nightclub)."'";
                    $result = mysql_query($query,$link);                    
                    $row = mysql_fetch_assoc($result);
            ?>
                <img src="/img/cms/nightclubs/<?= $row["id"] ?>/thumbnails/thumb_single/<?= $row["img"] ?>" alt="<?= ucwords($nightclub) ?>" title="<?= utf8_encode(ucwords($nightclub)) ?>" />
            <?php
                */}
            ?>
            <?php
                $is_gallery=false;
                if(isset($type) && $type == "antros" && ((!isset($nightclub_id)) && (!isset($nightclub)))) include_once 'modules/nightclubs.php';
                else if(isset($nightclub_id) && !isset($photo_id)) { include_once 'modules/gallery.php'; $is_gallery=true; }
                else if(isset($nightclub_id) && isset($photo_id)) include_once 'modules/gallery-photo.php';
                else include_once 'ajax/pct.php'; //Use the same file for ajax see more 
            ?>
        </div>
        <?php if(@$i == 17 && !$is_gallery){ ?>
            <a class="see-more-pictures" id="see-more">Ver más fotos</a>
        <?php } ?>
    </div>
    <aside>
        <div class="right-content">
             <?= Cs_Modules::show("blog",null,$language,$link) ?>            
        </div>    
    </aside>    
</div>
<script>
    $(document).ready(function(){
        var pg=1;
        $("#see-more").click(function(e){
            $.ajax({
                url:"/ajax/pct.php",
                data:{pg:pg,ltp:"<?= $last_type ?>",lncb:"<?= $last_nightclub ?>"},
                type:"post",
                beforeSend:function(){
                    $("#see-more").html("Cargando ...");
                },
                success:function(d){
                    if(d.trim().length < 200) $("#see-more").fadeOut(400,function(){$("#see-more").remove()});
                    else {$(".pic-home").append(d);pg++;$("#see-more").html("Ver más fotos");}                    
                }
            });
        });
        $("#print-image").click(function(){
            $("#im").printElement();    
        });        
    });
</script>