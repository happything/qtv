<div class="content">
    <div class="left-content">
        <h3 class="title places">A donde ir?</h3>
        <?php            
            if($get==false){
                //All the categories of places
        ?>
        <div class="blog places">
            
            <ul>
                <?php
                $facebook_comp_url = "lugares";
                $query = "SELECT places_types.id,name,(SELECT images.title FROM images WHERE parent_id = places_types.id AND section = 'places_types' ORDER BY images.orden LIMIT 1) as img,places_types.description 
                          FROM places_types 
                          ORDER BY places_types.orden";
                $result = mysql_query($query,$link);                
                $i=1;
                while($row = mysql_fetch_assoc($result)){
                    $class = "";
                    if(($i%2)==0) $class = "last";
                ?>
                <li class="place <?= $class ?>">
                    <a href="/lugares/<?= strtolower(str_replace(" ", "-",$row["name"])) ?>">                        
                        <img src="/img/cms/places_types/<?= $row["id"] ?>/thumbnails/thumb_big/<?= $row["img"] ?>" title="<?= utf8_encode($row["description"]) ?>" />
                        <h4><?= utf8_encode($row["name"]) ?></h4>                        
                    </a>                    
                </li>        
                <?php
                $i++;
                }
                ?>
            </ul>                        
            <div class="fb-comments" data-href="http://www.quetevalga.com/<?= @$facebook_comp_url ?>" data-num-posts="2" data-width="700"></div>
        </div>
        <?php
            } else if(!is_array($get)) {         
                //A single category of a place
        ?>
        <div class="pictures">
            <div class="breadcrumbs">
                <a href="/lugares">Lugares</a> > <span><?= str_replace("-", " ", ucwords($get)) ?></span>
            </div>
            <?php
                $facebook_comp_url = "lugares/".$get;
                $query = "SELECT places.id,places.name,places.date,(SELECT images.title FROM images WHERE parent_id = places.id AND section = 'places') as img,places.description
                          FROM places 
                          LEFT JOIN places_types ON places_types.name = '".utf8_decode(str_replace("-", " ", $get))."'
                          WHERE places_types_id = places_types.id 
                          ORDER BY places.id";
                                   
                $result = mysql_query($query,$link);
                $total_places = mysql_num_rows($result);
                $i=1;   
                while($row = mysql_fetch_assoc($result)){
                    if($i==1) echo "<ul>";
                    $class = "";
                    if(($i%4)==0) $class = "last";
            ?>
                <li class="picture <?= $class ?>">
                    <a href="/lugares/<?= $get ?>/<?= str_replace(" ", "-", utf8_encode(strtolower($row["name"]))) ?>">
                        <strong><?= utf8_encode($row["name"]) ?></strong>
                        <span><?= $row["date"] ?></span>
                        <img src="/img/cms/places/<?= $row["id"] ?>/thumbnails/thumb_small/<?= $row["img"] ?>" />
                        <p><?= utf8_encode($row["description"]) ?></p>
                    </a>                    
                </li>
            <?php       
                    if(($i%4)==0 && ($i+1)<mysql_num_rows($result)){                        
            ?>
                </ul>
                <a href="" class="brand"><img src="/img/publicity.jpg" /></a>
                <ul>
            <?php            
                    } else if(($i)==$total_places) echo "</ul>"; 
                    $i++;    
                } 

                if($i==1){                      
            ?>
            <div class="not-pictures">
                <h2>No hay lugares aún :(</h2>
                <p>Por el momento no tenemos lugares en esta categoría, pero te invitamos a visitar nuestras otras secciones para que encuentres donde pasar mejor tu día.</p>
            </div>
            <?php } ?> 

            <div class="fb-comments" data-href="http://www.quetevalga.com/<?= @$facebook_comp_url ?>" data-num-posts="2" data-width="700"></div>
        </div>
        <?php
            } else {
        ?>
        <div class="events">
            <div class="breadcrumbs">
                <a href="/lugares">Lugares</a> > <a href="/lugares/<?= $get[0] ?>"><?= str_replace("-", " ", ucwords($get[0])) ?></a> > <span><?= str_replace("-", " ", ucwords($get[1])) ?></span>
            </div>
            <div class="event">
                <?php
                    $facebook_comp_url = "lugares/".$get[0]."/".$get[1];
                    $place_name = str_replace("-", " ", $get[1]);
                    $query = "SELECT places.id,places.name,places.description,schedule,address,telephone_1,telephone_2,facebook_account,twitter_account,website,cost,(SELECT images.title FROM images WHERE parent_id = places.id AND section = 'places' ORDER BY orden LIMIT 1) as img
                              FROM places 
                              WHERE places.name = '".utf8_decode($place_name)."' 
                              ORDER BY orden";                    
                    $result = mysql_query($query,$link);
                    $row = mysql_fetch_assoc($result);    
                    if(mysql_num_rows($result)>=1){
                ?>
                <img src="/img/cms/places/<?= $row["id"] ?>/thumbnails/thumb_big/<?= $row["img"] ?>" class="big-cover" />
                <div class="info-event">
                    <div class="place-name">
                        <h4><?= utf8_encode($row["name"]) ?></h4>
                        <?php if($row["website"]!="") { ?>
                            <a href="<?= $row["website"] ?>" target="_blank"><?= $row["website"] ?></a>
                        <?php } ?>
                        <div>

                        </div>    
                    </div>
                    
                    <span class="info"><?= utf8_encode($row["description"]) ?></span>                    
                    <span class="schedule"><?= utf8_encode($row["schedule"]) ?></span>                    
                    <span class="place"><?= utf8_encode($row["address"]) ?></span>                    
                    <span class="contact"><?= utf8_encode($row["telephone_1"]) ?></span>                    
                    <span class="sell">Si tu idea es ir a cenar, te recomendamos llevar un mínimo de $<?= utf8_encode($row["cost"]) ?> pesos.</span>
                    <span class="social">
                        <?php if($row["facebook_account"] != "") {    ?>
                        <a href="<?= utf8_encode($row["facebook_account"]) ?>" class='facebook' target="_blank">Facebook</a>
                        <?php } if($row["twitter_account"]!= "") { ?>
                        <a href="<?= utf8_encode($row["twitter_account"]) ?>" class='twitter' target="_blank">Twitter</a>
                        <?php } ?>
                    </span>

                </div>
                <div class="social">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="Ven a conocer este lugar" data-via="quetevalga" data-lang="es" data-hashtags="quetevalga.com">Twittear</a>
                    <div class="fb-like" data-href="http://www.quetevalga.com/<?= @$facebook_comp_url ?>" data-send="false" data-width="450" data-show-faces="true" data-action="recommend"></div>
                </div>
            </div>            
            <div class="fb-comments" data-href="http://www.quetevalga.com/<?= @$facebook_comp_url ?>" data-num-posts="2" data-width="700"></div>
            <?php } else { ?>
            <div class="not-place">El lugar que buscas no se encuentra. ¿Será que tambien le estas moviendo por acá?</div></div>
            <?php } ?>
        </div>  
        <?php
            }
        ?>
    </div>
    <aside>
        <div class="right-content">
            <?= Cs_Modules::show("blog",null,$language,$link) ?>
        </div>    
    </aside>    
</div>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>