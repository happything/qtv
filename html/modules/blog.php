<div class="sidebar-blog">    
    <h3>Blog</h3>
    <div class="sidebar-container blog">
        <?php
            $query = "SELECT blog.id,blog.title,blog.content,images.title as img 
                      FROM blog 
                      LEFT JOIN images ON images.parent_id = blog.id AND images.section = 'blog' 
                      ORDER BY date DESC 
                      LIMIT 2";
            $result = mysql_query($query,$link);
            while($row = mysql_fetch_assoc($result)){
        ?>
        <div class="entrance div">
            <h4 class='side-title'><a class='lnk' href="/blog/entrada/<?= str_replace(" ", "-", utf8_encode(strtolower($row["title"]))) ?>"><?=  utf8_encode($row["title"])?></a></h4>
            <img class="img" src="/img/cms/blog/<?= $row["id"] ?>/thumbnails/thumb_preview/<?= $row["img"] ?>" />
            <?= Text::truncate(stripslashes(utf8_encode($row["content"])), 150,array('ending' => '','exact' => true)) ?> <a href="/blog/entrada/<?= str_replace(" ", "-", utf8_encode(strtolower($row["title"]))) ?>" style="color:#fff">[...]</a>
        </div>
        <?php
            }
        ?>        
    </div>
</div>
<div class="sidebar-blog">
    <h3>Patrocinadores</h3>
    <div class="sidebar-container blog div">
        <?php 
            //Charge the ads randomly and filtered
            $now_date = date("Y-m-d");
            $query = "SELECT id 
                        FROM ads 
                       WHERE ads_categories_id = 3 
                         AND ((impressions_count < impressions AND unlimited = 0) OR (unlimited = 1))
                         AND ((init_date <= '$now_date' AND end_date >= '$now_date' AND unlimited_date = 0) OR (unlimited_date = 1))
                    ORDER BY RAND() 
                       LIMIT 3";                             
            $ad_result = mysql_query($query,$link); 
            //echo $query;                       
            
            $ads_ids = array();
            while($ad_row = mysql_fetch_assoc($ad_result)){
                include_once 'ads/'.$ad_row["id"].'/index.php';                 
                array_push($ads_ids,$ad_row["id"]);
            }

            if(count($ads_ids) > 0) {
                $ads_ids = implode(",", $ads_ids);
                $query = "UPDATE ads SET impressions_count = impressions_count + 1 WHERE id IN ($ads_ids)";
                mysql_query($query,$link);
            }
            
        ?>                         
    </div>
</div>
<div class="sidebar-blog ">
    <h3>Regálanos un like</h3>
    <div class="sidebar-container blog facebook">
        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fquetevalga&amp;width=220&amp;height=70&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=false&amp;appId=210336799024233" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:70px;" allowTransparency="true"></iframe>        
    </div>
</div>