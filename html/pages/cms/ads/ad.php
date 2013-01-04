<?php
    $table = "ads";
    $description = "Here we can create the best ad ever!";
    $id = $get;    
    
    $validate = array(
        "seccion"=>array("ignore"=>true),
        "archivos"=>array("ignore"=>true),
        "unlimited"=>array("type"=>"checkbox"),        
        "unlimited_date"=>array("type"=>"checkbox")
    );
    
    include_once 'modules/forms.php';
    
    $forms = new Forms($select_row,"ads",$id,$link);

    $forms->create(array("id"=>"ads-form", "data-form" => "ads"));    
    $forms->input("name",NULL,array("class"=>'required input-xlarge'));
    $forms->select("clients_id", "Client", null, null, array("link"=>$link,"table"=>"clients","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge',"style"=>"width:490px;"));
    $forms->select("ads_categories_id", "Categories", null, null, array("link"=>$link,"table"=>"ads_categories","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge',"style"=>"width:490px;"));

    $forms->form .= "<div class='control-group' style='padding-left:160px;'><strong>Impressions</strong></div>";

    $forms->input("impressions",NULL,array("class"=>'input-xlarge',"style"=>"width:70px;"));            
    $forms->input("unlimited",NULL,array("type"=>"checkbox","class"=>'',"checked"=>"checked", "value"=>"1"));            
    $forms->input("init_date","Start Date",array("class"=>'input-xlarge date'));    
    $forms->input("end_date","End Date",array("class"=>'input-xlarge date'));        
    $forms->input("unlimited_date","Unlimited",array("type"=>"checkbox","class"=>'',"checked"=>"checked","value"=>"1"));            
    $forms->input("url",NULL,array("class"=>'input-xlarge'));    
    $forms->select("target", "Clasification", array("_self"=>"Same Window","_blank"=>"Other window"), null, null,array("required"=>true,'class'=>'input-xlarge',"style"=>"width:490px;"));
    $forms->textarea("code", "Custom Code", null, array("style"=>"width:390px; height:100px;"));        
    
    $forms->input('archivos',null,array('type'=>'file'));
    $forms->input('seccion',null,array('type' => 'hidden', 'value' => $table));    
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
    $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->submit();

    $extra_forms = array(
            "ads_categories"=>array()
            );
            
    include 'modules/sidebar.php';    
?>


<script>
    var insert_id = $('#id').val();
    var global_data = 0;
    $(document).ready(function(){
        if($("#impressions").val().trim() != "" && $("#impressions").val().trim() != 0){
            <?php                  
                if(isset($select_row["unlimited"]) && $select_row["unlimited"]==0){
            ?>
            $("#unlimited").removeAttr("checked");
            <?php } ?>
        }        
        if($("#init_date").val().trim() == "0000-00-00") $("#init_date").val("");
        if($("#end_date").val().trim() == "0000-00-00") $("#end_date").val("");

        $(".date").kalendar();
    })
    $(function() {
            //$( ".media-grid" ).sortable();
            $(function() {
		$(".media-grid").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                    var order = $(this).sortable("serialize") + "&section=<?= $table ?>";
                    $.post("/ajax/reorder-images.php", order, function(theResponse){
                            $("#contentRight").html(theResponse);
                    });
		}
		});
            });
    });
</script>
<link rel="stylesheet" href="/css/kalendar.css" type="type/css" />
<script src="/js/libs/jquery.ui.core.js"></script>
<script src="/js/libs/jquery.ui.widget.js"></script>
<script src="/js/libs/jquery.ui.mouse.js"></script>
<script src="/js/libs/jquery.ui.sortable.js"></script>
<script src="/js/jquery.kalendar.min.js"></script>
<script src="/js/jquery-ui-1.7.1.custom.min.js"></script>
<script src="/js/libs/validate.js"></script>
<script src="/js/upload/vendor/jquery.ui.widget.js"></script>
<script src="/js/load-images.js"></script>
<script src="/js/bootstrap/bootstrap.min.js"></script>
<script src="/js/bootstrap/bootstrap-image-gallery.min.js"></script>
<script src="/js/upload/sections.js"></script>
<script src="/js/upload/jquery.iframe-transport.js"></script>
<script src="/js/upload/jquery.fileupload.js"></script>
<script src="/js/upload/jquery.fileupload-ui.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<script src="/js/upload/jquery.xdr-transport.js"></script>
<script>
    $(document).ready(function(){   
       $("#galleries_type_id").change(function(){
           $.ajax({
               url:"/ajax/select.php",
               cache:false,
               type:"post",
               data:{id:$(this).val(),table:"nightclubs",value_id:"galleries_type_id"},
               success:function(data){
                   $("#nightclubs_id").html(data);
               }
           });
       }); 
        
       $('.form').validate({
            errorElement   : 'span',
            errorPlacement : function(error, element){
                error.appendTo(element.next('.help-inline'));
            }
        });
        
        $('.preview .pop-over').live('mouseover', function(){
            $(this).find('.media-actions').css('display', 'block'); 
        });
        $('.preview .pop-over').live('mouseout', function(){
            $(this).find('.media-actions').css('display', 'none');
        });
               
        $('input[type=file]').change(function(){
            $('input.submit').val('Save & upload'); 
        });
        
        $('input.submit').click(function(event){
            if($('.form').valid()){
                if($('input.submit').val() != "Save & upload"){                    
                    $('.form').submit();
                } else {                    
                    event.preventDefault();
                    var form = $('.form').serializeArray();
                    var values = {};
                    for (var i in form){
                        values[form[i].name] = form[i].value;
                    }
                    
                    $.ajax({
                        url      : '/modules/forms.php',
                        type     : 'POST',
                        dataType : 'JSON',
                        data     : {
                            table    : 'ads',
                            validate : {                                                               
                                seccion           : { ignore  : true },
                                galleries_type_id : { ignore  : true }                                
                            },
                            form     : values
                        },
                        success  : function(result){                            
                            if($('input.submit').val() == "Save & upload"){
                                if(insert_id){                                    
                                    global_data.formData = {
                                        insert_id : insert_id,
                                        seccion   : 'ads'
                                    }
                                }else{      
                                    //alert(result.error);
                                    global_data.formData = {
                                        insert_id : result.insert_id,
                                        seccion   : 'ads'
                                    }
                                }
                                global_data.submit();
                            } 
                        }
                    });    
                }                
            }
        });
    });     
</script>
<script>
    var media_showed = false;
    function media_show(){
        if(!media_showed){
            $.ajax({
                url:"/ajax/media.php",
                type:"post",
                cache:false,
                beforeSend:function(){
                    
                },
                success:function(data){
                    //alert(data);
                    $("#media-library").html(data);
                    media_showed = true;
                }
            });
        } else {
            $("#media-library > a").fadeOut(400,function(){ $("#media-library a").remove(); media_showed = false; })
        }
    }
    
    function media_select_image(name){
        tinymce.execCommand('mceInsertContent', false, "<img style='margin-right:10px; margin-bottom:5px;' src='/img/cms/media/files/"+name+"' />")
    }
</script>