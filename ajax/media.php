<?php
    if ($handle = opendir('../img/cms/media/files')) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        if((strlen($entry)>3) && ($entry[0] != ".")) {
            echo "<a href='#' onclick='media_select_image(\"".rawurlencode($entry)."\"); return false;'><span class='add'>Add Image</span><img src='/img/cms/media/thumbnails/".rawurlencode($entry)."' /></a>";
        }
    }
    closedir($handle);
}
?>
