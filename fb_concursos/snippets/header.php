<?php
	include_once '../config/connection.php';
	$query = "SELECT title, subtitle, content FROM areas WHERE sections_id = 1 ORDER BY id LIMIT 1;";
	$result_h = mysql_query($query, $link);
?>
<div class="title">
	<?php $row_h = mysql_fetch_assoc($result_h); ?>
    <h1><img src="img/quetevalga-logo.png" alt="quetevalga.com" /><?=$row_h['subtitle'];?></h1>
    <?=$row_h['content'];?>
</div>

<div class="bg-title"></div>

<nav>
    <ul class="menu text-description">        
        <li class="vote"><a href="vota.php?fbid=<?= @$facebook_id ?>">Vota</a></li>
        <li class="ranking"><a href="ranking.php?fbid=<?= @$facebook_id ?>">Ranking</a></li>
        <li class="conditions"><a href="condiciones.php">Condiciones</a></li>                    
    </ul>
</nav>