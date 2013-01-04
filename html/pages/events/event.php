<div class="content">
    <div class="left-content">
        <h3 class="title star">Que hacer?</h3>
        <div class="events">
            <?php
                $query = "SELECT events.id,events.name,events.date,events.description,events.event_date,events.schedule,facebook_account,twitter_account,place,telephone_1,telephone_2,extra_information,box_office,(SELECT images.title FROM images WHERE parent_id = events.id AND section = 'events' ORDER BY orden LIMIT 1) as img 
                          FROM events 
                          WHERE events.enabled = 1 AND events.name = '".@utf8_decode(str_replace("-", " ", $get))."'";
                $result = mysql_query($query,$link);
                //echo mysql_error();
                $row = mysql_fetch_assoc($result);
                if(mysql_num_rows($result)>=1){
            ?>
            <div class="breadcrumbs">
                <a href="/eventos">Eventos</a> > <span><?= utf8_encode($row["name"]) ?></span>
            </div>
            <div class="event">
                <img src="/img/cms/events/<?= $row["id"] ?>/thumbnails/thumb_big/<?= utf8_encode($row["img"]) ?>" class="big-cover" />
                <div class="info-event">
                    <h4><?= utf8_encode($row["name"]) ?></h4>
                    <span class="date"><?= utf8_encode($row["event_date"]) ?></span>
                    <span class="schedule"><?= utf8_encode($row["schedule"]) ?></span>
                    <span class="place"><?= utf8_encode($row["place"]) ?></span>
                    <span class="sell"><?= "Costo $".$row["box_office"].".00" ?></span>
                    <span class="contact"><?= utf8_encode($row["telephone_1"]) ?></span>
                    <span class="info"><?= utf8_encode($row["extra_information"]) ?></span>
                </div>
                <div class="social">                
                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="quetevalga.com te invita a este evento" data-via="quetevalga" data-lang="es" data-hashtags="quetevalga.com">Twittear</a>
                    <div class="fb-like" data-href="http://www.quetevalga.com/eventos/evento/<?= $get ?>" data-send="false" data-width="450" data-show-faces="true" data-action="recommend"></div>
                </div>
            </div>            
            <div class="fb-comments" data-href="http://www.quetevalga.com/eventos/evento/<?= $get ?>" data-num-posts="2" data-width="700"></div>
            <?php
                } else {
            ?>
            <div class="not-event">El evento que buscas no se encuentra. ¿Será que le estas moviendo por ahí?</div>
            <?php
                }
            ?>
        </div>  
    </div>    
    <aside>
        <div class="right-content">
            <?= Cs_Modules::show("blog",null,$language,$link) ?>
        </div>    
    </aside>    
</div>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>