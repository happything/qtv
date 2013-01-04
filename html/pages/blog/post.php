<div class="content">
    <div class="left-content">
        <h3 class="title pensil">Algunas novedades</h3>
        <div class="blog">            
            <?php
                $nget = $get;
                if(is_array($nget)) $nget = $get[0];
                $blog_title = str_replace("-", " ", $nget);
                $query = "SELECT blog.id,blog.title,blog.date,blog.content,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img,users.name as username,users.lastname,blog_categories.name as blog_categories  
                          FROM blog 
                          LEFT JOIN users ON users.id = users_id 
                          LEFT JOIN blog_categories ON blog_categories.id = blog_categories_id 
                          WHERE title = '".utf8_decode($blog_title)."'";
                $result = mysql_query($query,$link);
                $row = mysql_fetch_assoc($result);
                if(mysql_num_rows($result) >= 1){
            ?>
            <div class="breadcrumbs">
                <a href="/blog">Blog</a> > <a href="/blog/<?= str_replace(" ", "-", utf8_encode(strtolower($row["blog_categories"]))) ?>"><?= utf8_encode($row["blog_categories"]) ?></a> > <span><?= utf8_encode($row["title"]) ?></span>
            </div>
            <h4><?= utf8_encode($row["title"]) ?></h4>
            <p class="by">Por <?= utf8_encode($row["username"]." ".$row["lastname"]) ?></p>
            
            <img src="/img/cms/blog/<?= $row["id"] ?>/thumbnails/thumb_post/<?= $row["img"] ?>" alt="" title="" class="cover" />
            
            <div class="post-content"><?= utf8_encode(stripslashes($row["content"])) ?></div>

            <div class="social">                
                <a href="https://twitter.com/share" class="twitter-share-button" data-text="Mira este post en quetevalga.com" data-via="quetevalga" data-lang="es" data-hashtags="quetevalga.com">Twittear</a>
                <div class="fb-like" data-href="http://www.quetevalga.com/blog/entrada/<?= rawurlencode($get) ?>" data-send="false" data-width="450" data-show-faces="true" data-action="recommend"></div>
            </div>

            <div class="fb-comments" data-href="http://www.quetevalta.com/blog/entrada/<?= rawurlencode($get) ?>" data-num-posts="2" data-width="700"></div>
            <?php } else { ?>
            <div class="not-post">El post que buscas no se encuentra. ¿Será que le estas moviendo por ahí?</div>
            <?php
            }
            ?>
        </div>
    </div>
    <aside>
        <div class="right-content">
            <?= Cs_Modules::show("blog_section",null,$language,$link) ?>
        </div>    
    </aside>    
</div>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>