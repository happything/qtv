<div class="sidebar">
    <div class="desc-section side">
        <h2><?= str_replace('_', ' ', $table); ?></h2>
        <p><?= $description; ?></p>
    </div>
    <div class="arrow"></div>
    <div class="categorizer side">
       <h2>Quick Options</h2>
        <?php
            include_once 'modules/quick-options.php';
            if(isset($quick_options) && is_array($quick_options)){
                $quick_options_keys = array_keys($quick_options);
                for($i=0; $i<count($quick_options); $i++){
        ?>
        <a href="/<?= $quick_options_keys[$i] ?>" class="quick-option"><?= $quick_options[$quick_options_keys[$i]] ?></a> / 
        <?php            
                //if($i < (count($quick_options)-1)) echo " / ";
                }
            }
        ?>        
    </div>
    <div class="categorizer side sections" style="margin-top: 0;">
        <?php            
            if(isset($extra_forms) && is_array($extra_forms)){
        ?>
        <h2>Extra Forms</h2>
        <?php
                for($i=0; $i<count($extra_forms); $i++){
                    $extra_forms_keys = array_keys($extra_forms);
                    $field = "name";
                    if(isset($extra_forms[$extra_forms_keys[$i]]["field"])) $field = $extra_forms[$extra_forms_keys[$i]]["field"];
        ?>
        <div class="extra_form">
            <div>
                <label><?= str_replace(array("_","-"), " ", utf8_encode(ucwords($extra_forms_keys[$i]))) ?></label><a href="" class="stop-editing" id="stop-editing" onclick="stop_editing('<?= $extra_forms_keys[$i] ?>'); return false;">Stop editing ...</a>
                <input type="text" id="input-<?= $extra_forms_keys[$i] ?>" placeholder="Add <?= str_replace(array("_","-"), " ", utf8_encode($extra_forms_keys[$i])) ?>" class="span4 extra-form-input" />
                <button class="btn btn-info" onclick="extra_form_save('<?= $extra_forms_keys[$i] ?>','<?= $field ?>')">Save</button>
            </div>
            <div class="list" id="extra_form_content_<?= $extra_forms_keys[$i] ?>">            
            <?php                
                $sql = "SELECT id,".$field." FROM ".$extra_forms_keys[$i];                    
                
                $result = mysql_query($sql,$link);
                if($result){
                    while($row = mysql_fetch_array($result)){
            ?>
                    <span id="<?= $extra_forms_keys[$i] ?>-option-<?= $row["id"] ?>"><a class="del" href="" onclick="section_remove(<?= $row["id"] ?>,'<?= $extra_forms_keys[$i] ?>'); return false;">x</a> <a href="" id="<?= $extra_forms_keys[$i] ?>-label-<?= $row["id"] ?>" onclick="section_edit(<?= $row["id"] ?>,'<?= $extra_forms_keys[$i] ?>'); return false;"><?= utf8_encode($row[1]) ?></a></span>
            <?php
                    }
                }
            ?>
            </div>
        </div>
        <?php
                }
            }   
        ?>
    </div>
    
</div>
<div class="content">
    <?php
        echo $forms->end(); 
    ?>
</div>

<div id="modal-gallery" class="modal modal-gallery hide fade"></div>


<script>
    var section_id = -1;    
    
    $(document).ready(function(){
        $(".extra-form-input").keyup(function(k){
            if(k.keyCode == 13) {
                
            }
        });
    });
    
    function section_edit(id,table){ section_id = id; $("#input-"+table).val($("#"+table + "-label-"+id).html()).focus(); $(".stop-editing").fadeIn(400); }
    function stop_editing(table){ section_id = -1; $("#input-"+table).val(""); $(".stop-editing").fadeOut(400); }
    
    function extra_form_save(table,field){
        if($("#input-"+table).val() != ""){
            $.ajax({
                url:"/ajax/extra-forms.php",
                cache:false,
                type:"post",
                data:{type:"save",table:table,id:section_id,field:field,value:$("#input-"+table).val()},                    
                success:function(data){                        
                    //alert(data);
                    if(data != 0) {                                                        
                        if(section_id == -1) { $("select[name="+table+"_id]").append("<option value='"+data+"'>"+$("#input-"+table).val()+"</option>"); $("#extra_form_content_"+table).append('<span id="'+table+'-option-'+data+'"><a class="del" href="" onclick="section_remove('+data+',\''+table+'\'); return false;">x</a> <a href="" id="'+table+'-label-'+data+'" onclick="section_edit('+data+'); return false;">'+$("#input-"+table).val()+'</a></span>'); $("#"+table+"-option-"+data).css("display","none").fadeIn(400,function(){ $("#input-"+table).val(""); }); }                            
                        else { $("select[name="+table+"_id] option[value="+section_id+"]").html($("#input-"+table).val()); $('#'+table+'-label-'+section_id).html($("#input-"+table).val()); $("#input-"+table).val(""); $("#stop-editing").fadeOut(400); }
                        section_id = -1;
                    } 
                }
            });    
        }        
    }
    function section_remove(id,table){
        if(confirm("REALLY? Do you want to delete this section? \nIf you remove this, all the areas related goint to be deleted.")){
            var section_label = $("#"+table+"-label-"+id).html();       
            $("#"+table+"-label-"+id).html("Deleting ...");
            $.ajax({ url:"/ajax/extra-forms.php", type:"post", cache:false, data:{id:id,type:"remove",table:table}, success:function(data){ if(data == 1) { $("#"+table+"-option-"+id).fadeOut(400, function(){ $("#"+table+"-option-"+id).remove(); }); $("select[name="+table+"_id] option[value="+id+"]").remove(); } else if(data == 0) $("#"+table+"-label-"+id).html(section_label); } });
            section_id = -1;
            $("#input-"+table).val("");
        }        
    }    
    
</script>
