<?php
    if(is_numeric($nightclub_id)){
    $query = "SELECT id,title FROM images WHERE section = 'galleries' AND parent_id = ".$nightclub_id." ORDER BY orden ASC";
    $result = mysql_query($query,$link);        
    $nightclub_url = "";
    if(isset($nightclub)) $nightclub_url = $nightclub."/";
    $img_index = -1;
    if(isset($get[3]) && is_numeric($get[3])) $img_index = $get[3];
    else if(isset($get[2]) && is_numeric($get[2])) $img_index = $get[2];

    $query = "SELECT title,description,contest FROM galleries WHERE id = ".  utf8_decode($nightclub_id);
    $desc_result = mysql_query($query,$link);
    $desc_row = mysql_fetch_assoc($desc_result);
?>

<p class="gallery-description"><strong><?= utf8_encode($desc_row["title"]) ?></strong></p>
<div class="gallery">    
    <?php
        if(mysql_num_rows($result)>0){                        
    ?>    
    <div class="big-img">
        <?php
            $i = $tl = mysql_num_rows($result); //Total images            
            $tmp_imgs = array(); //Save the prev images
            $img_founded = false; //Selected id founded
            $ids = ""; //Id for JS
            $tmp_ids = "";                        
            $before_id = -1;
            $last_id = -1;
            $first_id = -1;
            
            while($row = mysql_fetch_assoc($result)){                
                if($first_id == -1) $first_id = $row["id"];
                $last_id = $row["id"];
                if(($row["id"]==$img_index)){
                    if($img_index == $before_id) $before_id = -1; //So, before will be the last                                        
                    $ids .= $row["id"].",";
                    $img_founded = true;                        
                    $tmp_image = $row["title"]; 
                    $class = "top-img";   
                    //header("Content-Disposition: attachment; filename='img/cms/galleries/".$nightclub_id."/files/".$row["title"]."'");                  
        ?>
        <div class="img-container <?= $class ?>" id="bigimg<?= $row["id"] ?>"><img id="im" src="/img/cms/galleries/<?= $nightclub_id ?>/thumbnails/thumb_gallery/<?= $tmp_image ?>" class="main-image" src="" alt="" title="" /></div>        
        <?php           
                } else if($img_founded) { if($tmp_ids == "") $tmp_ids = $row["id"];}
                if(!$img_founded) $before_id = $row["id"];
                $i--;
            }

            if($before_id == -1) $before_id = $last_id;
            if($tmp_ids == "") $tmp_ids = $first_id;
            
            for($j=0; $j<count($tmp_imgs); $j++){ 
                //---------- I M P O R T A N T -------------//
                //Show the tmp images, we don't need this if you are using URL navigation               
        ?>
        <!--<div class="img-container" id="bigimg<?= $tmp_imgs[$j][0] ?>"><img src="/img/cms/galleries/<?= $nightclub_id ?>/thumbnails/thumb_gallery/<?= $tmp_imgs[$j][1] ?>" alt="" title="" /></div> -->
        <?php
            }            
            $tmp_img_index = $tl;
            if($img_index > -1) $tmp_img_index = $img_index;               
            $ids = $ids.$tmp_ids.",".$before_id;
            //$ids = substr($ids, 0,  strlen($ids)-1);
        ?>
    </div>        
    <div class="options">                
        <a class="print" id="print-image">Imprimir</a>
        <a class="download" target="_blank" href="/imd.php?nci=<?= $nightclub_id ?>&imn=<?= $tmp_image ?>" id="download">Descargar en HD</a>
        <a class="fb-share" id="fb-share">Compartir en Facebook</a>
        <a class="twitter-share-button tw-share last" href="https://twitter.com/share" data-lang="en">Compartir en Twitter</a>
    </div>

    <p class="gallery-description"><?= utf8_encode(stripslashes($desc_row["description"])) ?></p>
    
    <div class="pagination">        
        <a id="backward">Atras</a>
        <a id="forward">Adelante</a>        
    </div>
    
    <div class="social">        
        <div class="fb-like" data-href="http://www.quetevalga.com/fotos/<?= $type ?>/<?= $nightclub_url.$nightclub_id ?>/<?= $img_index ?>" data-send="false" data-width="600" data-show-faces="true"></div>
    </div>
    
    <div class="fb-comments" id="fb-comments" data-href="http://www.quetevalga.com/fotos/<?= $type ?>/<?= $nightclub_url.$nightclub_id ?>/<?= $img_index ?>" data-num-posts="5" data-width="660"></div>
    <?php } else { ?>
    <h3>Ups</h3>
    <p>Lo sentimos, pero no hay fotos en este álbum ¿No andaras perdido?</p>
    <?php } ?>
    
</div>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script>        
    var tl = <?= $tl ?>;    
    var img = 1;    
    var imgs = "<?= $ids ?>";    
    imgs = imgs.split(",");   
    var clk = false;
    var loaded = false;
    var img_name = "<?= @$tmp_image ?>"; 

    $(document).ready(function(){           
        loaded = true;             
        $("#forward").click(function(e){if(!clk){move(1);}});
        $("#backward").click(function(e){if(!clk){move(2);}});
        $(document).keyup(function(e){
            if(!clk){
                if(e.keyCode == 39) move(1);
                else if(e.keyCode == 37) move(2);
            }
        });  

        $(".main-image").click(function(e){
            var offset = $(this).offset();
            var click_point = e.clientX - offset.left;
            var img_width = $(this).width();
            if(click_point <= (img_width / 4)) move(2);
            else move(1);
        });

        $("#iphone5_contest").click(function(){
            if(confirm("Para participar, tienes que aparecer en la foto, deberás utilizar tu disfraz al recoger el premio, en fotos con múltiples personas, el ganador es el que registre la foto dentro de la aplicación. ¿Deseas participar?")){
                var imid = imgs[0];
                $.ajax({
                    url:"/ajax/fbr.php",
                    cache:false,
                    type:"post",
                    dataType:"json",
                    data:{imid:imid},
                    beforeSend:function(){

                    },
                    success:function(d){
                        if(d.code == "1") {                            
                            var obj = {
                                method: 'feed',
                                display:"iframe",
                                link: "https://www.facebook.com/quetevalga/app_195686627223005?app_data="+d.id,
                                picture: 'https://www.quetevalga.com'+$(".main-image").attr("src").replace("thumb_gallery","thumb_big"),
                                name: 'Yo quiero un iPhone 5.',
                                caption: 'Quetevalga.com',
                                description: 'Ayudame a ganar un iPhone 5 con Quetevalga.com, iFix y Grupo Premier'                                
                            };
                            function callback(response) {
                                window.open('https://www.facebook.com/quetevalga/app_195686627223005?app_data='+d.id, '_blank');
                                window.focus();                                
                            }                                        

                            FB.ui(obj, callback);                             
                        }
                        else if(d.code == "-1") alert("Ya te registraste anteriormente. Si deseas que se elimine el registro contactate con el staff de Quetevalga.com");
                        else if(d.code == "-2") alert("No se seleccionó ninguna imagen. Intentalo de nuevo.");
                    }
                });    
            }            
        });
        
        $("#fb-share").click(function(){ 
            //var access_token =   FB.getAuthResponse()['accessToken'];
            var obj = {
                method: 'feed',
                link: location.href,
                display:"iframe",
                picture: 'http://www.quetevalga.com'+$(".main-image").attr("src").replace("thumb_gallery","thumb_big"),
                name: 'Mira esta foto en Quetevalga.com',
                caption: 'Quetevalga.com',
                description: 'Quetevalga.com es un portal para conocer mejor la vida nocturna en Culiacán, conócenos entrando a nuestro sitio web.'                          
            };

            function callback(response){
                if(response['post_id']!="") alert("Tu foto ya fue compartida en tu timeline.");
            }
            
            FB.ui(obj, callback);      
        });      
    });

    function move(side){                
        var tmp_img = imgs[img-1];        
        if(side == 1) { img = 1; }            
        if(side == 2) { img = 2; } 
        
        var imgpage = location.href;
        imgpage = imgpage.substr(0,imgpage.lastIndexOf("/")+1) + imgs[img];
        location.href = imgpage+"#im";
    }
</script>
<?php
    }
?>