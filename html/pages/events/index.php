<div class="content">
    <div class="left-content">
        <h3 class="title star">Que hacer?</h3>
        <div class="events">
            <ul>
                <?php
                    $query = "SELECT events.id,events.name,events.event_date,(SELECT images.title FROM images WHERE parent_id = events.id AND section = 'events' ORDER BY images.orden LIMIT 1) as img 
                              FROM events 
                              WHERE event_date >= '".date('Y-m-d')."'
                              ORDER BY events.event_date";
                    $result = mysql_query($query,$link);
                    $i = 1;
                    while($row = mysql_fetch_assoc($result)){
                        $class = "";
                        if(($i%4)==0) $class = "last";
                ?>
                <li class="event <?= $class ?>">
                    <a href="/eventos/evento/<?= str_replace(" ", "-", utf8_encode($row["name"])) ?>">
                        <strong><?= utf8_encode($row["name"]) ?></strong>
                        <span><?= $row["event_date"] ?></span>
                        <img src="/img/cms/events/<?= $row["id"] ?>/thumbnails/thumb_small/<?= $row["img"] ?>" />
                    </a>                    
                </li>
                <?php $i++; } ?>
            </ul>            
            
        <div class="fb-comments" data-href="http://www.quetevalga.com/eventos" data-num-posts="2" data-width="700"></div>
    </div>
    </div>
    <aside>
        <div class="right-content">
            <?= Cs_Modules::show("blog",null,$language,$link) ?>
        </div>    
    </aside>    
</div>