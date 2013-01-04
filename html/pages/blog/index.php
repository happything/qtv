<?php
    $blog_category = "";
    $blog_date = "";
    if($get != false && !is_array($get)) $blog_category = str_replace("-", " ", $get);
    else if(is_array($get)) $blog_date = $get[0]."-".$get[1];

?>
<div class="content">
    <div class="left-content">
        <h3 class="title pensil">Algunas novedades</h3>
        <div class="blog" id="blog-container">
            <div class="breadcrumbs" style="margin-bottom:30px;">
                <a href="/blog">Blog</a>  
                <?php
                    if($blog_category!=""){
                ?>
                    > <span><?= ucwords($blog_category) ?></span> 
                <?php        
                    }
                ?>
            </div>
            <?php
                if(is_array($get))
                    $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                              FROM blog 
                              WHERE YEAR(blog.date) = ".$get[0]." AND MONTH(blog.date) = ".$get[1]." 
                              ORDER BY blog.date DESC   
                              LIMIT 10";         
                else if($blog_category!="")
                    $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                              FROM blog 
                              LEFT JOIN blog_categories ON blog_categories.name = '".@utf8_decode($blog_category)."' 
                              WHERE blog_categories_id = blog_categories.id 
                              ORDER BY blog.date DESC   
                              LIMIT 10";                
                else 
                    $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                              FROM blog 
                              ORDER BY blog.date DESC   
                              LIMIT 10";

                $result = mysql_query($query,$link);
                
                $i = 1;
                while($row = mysql_fetch_assoc($result)){
                    if($i == 1) echo "<ul>";
                    $class = "";
                    if(($i%2)==0) $class = "last";
            ?>            
                <li class="entrance <?= $class ?>">                    
                        <span class="date">
                            <?php                                
                                $date_arr = explode("-", $row["date"]);
                                $mounth = "Ene";
                                switch ($date_arr[1]) {
                                    case 2:
                                        $mounth = "Feb";
                                        break;
                                    case 3:
                                        $mounth = "Mar";
                                        break;
                                    case 4:
                                        $mounth = "Abr";
                                        break;
                                    case 5:
                                        $mounth = "May";
                                        break;
                                    case 6:
                                        $mounth = "Jun";
                                        break;
                                    case 7:
                                        $mounth = "Jul";
                                        break;
                                    case 8:
                                        $mounth = "Ago";
                                        break;
                                    case 9:
                                        $mounth = "Sep";
                                        break;
                                    case 10:
                                        $mounth = "Oct";
                                        break;
                                    case 11:
                                        $mounth = "Nov";
                                        break;
                                    case 12:
                                        $mounth = "Dic";
                                        break;                                        
                                }
                            ?>
                            <span class="mounth"><?= $mounth ?></span>
                            <span class="day"><?= $date_arr[2] ?></span>
                        </span>                        
                        <?php
                            //Check post image
                            $img_src = "img/cms/blog/".$row["id"]."/thumbnails/thumb_preview/".$row["img"];
                            if(!is_file($img_src)) $img_src = "img/image-not-found.jpg";
                        ?>
                        <a href="/blog/entrada/<?= str_replace(" ", "-", utf8_encode($row["title"])) ?>"><img src="/<?= $img_src ?>" /></a>
                        <h4><a href="/blog/entrada/<?= str_replace(" ", "-", utf8_encode($row["title"])) ?>"><?= utf8_encode($row["title"]) ?></a></h4>
                        <div class="text">
                            <?= Text::truncate(stripslashes(utf8_encode($row["content"])), 170,array('ending' => '','exact' => true)) ?> <a class="see-more" href="/blog/entrada/<?= str_replace(" ", "-", utf8_encode($row["title"])) ?>">[...]</a>
                        </div>                                      
                </li>                        
            <?php
                    if(($i%2)==0 && ($i)<mysql_num_rows($result)) {
            ?>
                    </ul><ul>
            <?php                
                    } else if($i==mysql_num_rows($result)) echo "</ul>";
                    $i++;    
                }

                if($i==1){
             ?>
                <div class="not-posts">
                    <h2>No hay entradas aún :(</h2>
                    <p>No se encontraron entradas en esta categoría, pero puedes buscar en las otras información múy interesante la neta.</p>    
                </div>
                
             <?php       
                }
            ?>          
        </div>
        
        <?php if($i==11) { ?>

        <button id="see_more" class="see_more">Ver más +</button>              

        <?php } ?>
            
        <div style="margin-left:10px;" class="fb-comments" data-href="http://www.quetevalga.com/blog" data-num-posts="2" data-width="700"></div>
    </div>
    <aside>
        <div class="right-content">
            <?= Cs_Modules::show("blog_section",null,$language,$link) ?>
        </div>    
    </aside>    
</div>

<script charset="utf-8">    
    var current_page = 1; 
    var blog_category = "<?= $blog_category ?>";
    var blog_date = "<?= $blog_date ?>";
    $(document).ready(function(){
        $("#see_more").bind("click",function(){
            $.ajax({
                url:"/ajax/blog.php",
                cache:false,
                type:"post",
                data:{current_page:current_page,blog_category:blog_category,blog_date:blog_date},
                beforeSend:function(){

                },
                success:function(data){                                    
                    if($.trim(data) != "") { $("#blog-container").append(data); current_page++; }
                    else { $("#see_more").fadeOut(400,function(){ $("#see_more").remove(); }); }
                }
            });
        });
    });
</script>