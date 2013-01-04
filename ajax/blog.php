<?php
	include_once("../config/connection.php");
	include_once("../libs/text.php");

	$current_page = $_POST["current_page"];
    $blog_category = $_POST["blog_category"];
    $blog_date = $_POST["blog_date"];
	$current_post = $current_page * 10;
    if($blog_date != ""){ 
        $date_arr = explode("-", $blog_date);
        $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                  FROM blog 
                  WHERE YEAR(blog.date) = ".$date_arr[0]." AND MONTH(blog.date) = ".$date_arr[1]." 
                  ORDER BY blog.date DESC   
                  LIMIT ".$current_post.", 10";        
    } else if($blog_category != "")
        $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                  FROM blog 
                  LEFT JOIN blog_categories ON blog_categories.name = '".utf8_decode($blog_category)."' 
                  WHERE blog_categories_id = blog_categories.id 
                  ORDER BY blog.date DESC 
                  LIMIT ".$current_post.", 10";
    else                               
	   $query = "SELECT blog.id,blog.title,blog.content,blog.date,(SELECT images.title FROM images WHERE parent_id = blog.id AND section = 'blog' ORDER BY orden LIMIT 1) as img 
                 FROM blog 
                 ORDER BY blog.date DESC 
                 LIMIT ".$current_post.", 10";

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
                    if(!is_file("../".$img_src)) $img_src = "img/image-not-found.jpg";
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
    ?>          
