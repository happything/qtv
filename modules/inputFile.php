<div class="control-group" style="margin-left: 160px; margin-top: 20px; ">
    <div class="file-input">
        <div>
            <div class="fileupload-buttonbar">
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span> Add files</span>
                    <input id="archivos" type="file" name="archivos[]" multiple />
                </span>
                <button type="button" class="btn btn-primary start" style="display: none;"><i class="icon-upload icon-white"></i> Upload files</button>
                <button type="button" class="btn danger delete" style="display: none;">Delete files</button>
            </div>
        </div>
    </div>
</div>
<ul data-toggle="modal-gallery" data-target="#modal-gallery" class="media-grid media-list files group">
<?php
    if(isset($this->section)){        
        $sql = "SELECT id,title FROM images WHERE section = '".$this->section."' AND parent_id = ".$this->parent_id." ORDER BY orden";        
        $result = mysql_query($sql,$this->link);        
        while($row = @mysql_fetch_array($result)){            
            $url = "/img/cms/".$this->section."/".$this->parent_id."/thumbnails/thumb_big/".utf8_encode($row["title"]);
?>
    <li id="image_<?= $row["id"] ?>" class="template-upload in">
        <div class="preview">
            <div class='pop-over'>
                <div class='media-actions'>
                    <span class='delete'><button class='action delete' onclick="delete_hat(<?= $row["id"] ?>)">Delete</button></span>
                    <span class='action previewing'><a href='<?php echo "/img/cms/".$this->section."/".$this->parent_id."/files/".utf8_encode($row["title"]) ?>' rel='gallery'>Preview</a></span>
                </div>
                <img src="<?= $url ?>" />
            </div>
        </div>
        
    </li>    
<?php
        }
    }
?>
</ul>

<script>
    function delete_hat(id){
        if(confirm("¿Deseas realmente eliminar esa foto?")){
            $.ajax({
                url:"/ajax/reorder-images.php",
                type:"post",
                cache:false,
                data:{ id:id,type:"delete_hat" },
                beforeSend:function(){
                    
                },
                success:function(data){
                    if(data == 1) $("#image_"+id).fadeOut(400,function(){$("#image_"+id).remove();});
                }
            });    
        }
    }
</script>
<div id="modal-gallery" class="modal modal-gallery hide fade">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn btn-small modal-next">Next <i class="icon-arrow-right"></i></a>
        <a class="btn btn-small modal-prev"><i class="icon-arrow-left"></i> Previous</a>
        <a class="btn btn-small modal-play modal-slideshow" data-slideshow="5000"><i class="icon-play"></i> Slideshow</a>
        <a class="btn modal-download" target="_blank"><i class="icon-download"></i> Download</a>
    </div>
</div>