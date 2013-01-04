<div class="nightclubs">
<?php
    $query = "SELECT nightclubs.id,name,title as img
              FROM nightclubs 
              LEFT JOIN images ON parent_id = nightclubs.id AND section = 'nightclubs' 
              ORDER BY name";
    $result = mysql_query($query,$link);
    echo mysql_error();
    while($row = mysql_fetch_assoc($result)){
?>
<a href="/fotos/antros/<?= strtolower(str_replace(" ", "-", utf8_encode($row["name"]))) ?>"><img src="/img/cms/nightclubs/<?= $row["id"] ?>/thumbnails/thumb_all/<?= $row["img"] ?>" alt="<?= utf8_encode(ucwords($row["name"])) ?>" title="<?= utf8_encode(ucwords($row["name"])) ?>" /><div class="shadow"></div><span><?= utf8_encode(ucwords($row["name"])) ?></span></a>
<?php } ?>
</div>