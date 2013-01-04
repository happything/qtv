<div class="gallery" style="display:inline-block">
    <ul>
    <?php        
    $query = "SELECT images.id,images.title FROM images WHERE section = 'galleries' AND parent_id = ".utf8_decode($nightclub_id)." ORDER BY orden ASC LIMIT 32";      
    $result = mysql_query($query,$link);
        $i=1;    
        while($row = mysql_fetch_assoc($result)){            
            $class = "";
            if(($i%8)==0) $class = "last";                    
    ?>            
        <li class="picture <?= $class ?>" style="height: 120px; margin-top: 10px;">            
            <a href="<?= $_SERVER["REQUEST_URI"]."/".$row["id"] ?>">                                
                <img src="/img/cms/galleries/<?= $nightclub_id ?>/thumbnails/thumb_album/<?= $row["title"] ?>" />                
            </a>                    
        </li>                      
    <?php                    
            if($i == mysql_num_rows($result)) echo "</ul>";
            $i++;
        }

        if($i==1) echo "<div class'no-pics'>Ahorita no hay fotos en esta parte, pero puedes visitar nuestras demás secciones.</div>";    
    ?>
    
</div>

<?php  
if($i==33){
?>        
    <a class="see-more-pictures" id="see-more-gallery">Ver más fotos</a>
<?php  
    }   
?>    

<script>
    $(document).ready(function(){
        var pg=1;
        var url = '<?= $_SERVER["REQUEST_URI"] ?>';
        $("#see-more-gallery").click(function(e){
            $.ajax({
                url:"/ajax/gallery.php",
                data:{pg:pg,ncid:<?= utf8_decode($nightclub_id) ?>,url:url},
                type:"post",
                beforeSend:function(){
                    $("#see-more-gallery").html("Cargando ...");
                },
                success:function(d){
                    if(d.trim().length < 200) $("#see-more-gallery").fadeOut(400,function(){$("#see-more-gallery").remove()});
                    else {$(".gallery").append(d);pg++;$("#see-more-gallery").html("Ver más fotos");}                    
                }
            });
        });
        $("#print-image").click(function(){
            $("#im").printElement();    
        });        
    });
</script>