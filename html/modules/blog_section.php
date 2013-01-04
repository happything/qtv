<div class="sidebar-blog">
    <h3>Categorias</h3>
    <div class="sidebar-container blog div">
        <?php
            $query = "SELECT id,name FROM blog_categories ORDER BY name";
            $result = mysql_query($query,$link);
            while($row = mysql_fetch_assoc($result)){
        ?>
        <a href="/blog/<?= str_replace(" ","-",utf8_encode(strtolower($row["name"]))) ?>" class="blog-category"><?= utf8_encode($row["name"]) ?></a>
        <?php        
            }
        ?>
        <a href="/blog" class="blog-category"><strong>Todas</strong></a>
    </div>
</div>
<div class="sidebar-blog">
    <h3>Archivo</h3>
    <div class="sidebar-container blog div">
        <?php
            $query = "SELECT date,count(date) as count_date FROM blog GROUP BY date ORDER BY date DESC";
            $result = mysql_query($query,$link);
            $files = array();
            while($row = mysql_fetch_assoc($result)){
                $date_arr = explode("-", $row["date"]);
                if(!isset($files[$date_arr[0]])) $files[$date_arr[0]] = array();
                if(!isset($files[$date_arr[0]][$date_arr[1]])) $files[$date_arr[0]][$date_arr[1]] = 0;
                $files[$date_arr[0]][$date_arr[1]] += $row["count_date"];
            }

            $files_keys = array_keys($files);    
            for($i=0; $i<count($files); $i++){
        ?>
            <h4 class="file-year"><?= $files_keys[$i] ?></h4>
        <?php   
                $mounths = array_keys($files[$files_keys[$i]]);               
                for($j=0; $j<count($mounths); $j++){
                    $mounth = "Enero";
                    switch($mounths[$j]){
                        case "02": $mounth = "Febrero"; break;
                        case "03": $mounth = "Marzo"; break;
                        case "04": $mounth = "Abril"; break;
                        case "05": $mounth = "Mayo"; break;
                        case "06": $mounth = "Junio"; break;
                        case "07": $mounth = "Julio"; break;
                        case "08": $mounth = "Agosto"; break;
                        case "09": $mounth = "Septiembre"; break;
                        case "10": $mounth = "Octubre"; break;
                        case "11": $mounth = "Noviembre"; break;
                        case "12": $mounth = "Diciembre"; break;
                    }
        ?>
            <a href="/blog/<?= $files_keys[$i] ?>/<?= $mounths[$j] ?>" class="file blog-category"><?= $mounth ?></a>
        <?php            
                }
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
    <div class="sidebar-container blog facebook div">
        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fquetevalga&amp;width=220&amp;height=70&amp;colorscheme=light&amp;show_faces=false&amp;border_color&amp;stream=false&amp;header=false&amp;appId=210336799024233" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:220px; height:70px;" allowTransparency="true"></iframe>        
    </div>
</div>