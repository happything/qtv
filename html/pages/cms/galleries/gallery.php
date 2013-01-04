<?php
    $table = "galleries";
    $description = "Add all the pictures that you want.";
    $id = $get;
    
    $validate = array(
        "seccion"=>array("ignore"=>true),
        "archivos"=>array("ignore"=>true),        
        "nightclubs_id"=>array("number"=>true),
        "galleries_type_id"=>array("number"=>true),
    );
    
    include_once 'modules/forms.php';
    
    $forms = new Forms($select_row,"galleries",$id,$link);

    $forms->create(array("id"=>"galleries-form", "data-form" => "galleries"));    
    $forms->input("title",NULL,array("class"=>'required input-xlarge'));
    $forms->select("galleries_type_id", "Clasification", array("-1"=>"Selecciona una clasificación"), null, array("link"=>$link,"table"=>"galleries_type","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge',"style"=>"width:490px;"));        
    $forms->select("nightclubs_id", "Night Club", array("-1"=>"Selecciona un lugar"), null, array("link"=>$link,"table"=>"nightclubs","value_field"=>"id","show_field"=>"name","parent_id"=>"galleries_type_id"),array('class'=>'input-xlarge',"style"=>"width:490px;"));         
    $forms->textarea("description", "Description", null, array("style"=>"width:390px; height:100px;"));    
    $forms->input("banner", "Home Banner", array("type"=>"checkbox","value"=>"1"));        
    $forms->input('archivos',null,array('type'=>'file'));
    $forms->input('seccion',null,array('type' => 'hidden', 'value' => $table));
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '1'));
    if($id == "") $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->submit();
        
        //Extra forms on sidebar
        $extra_forms = null;
    
    include 'modules/sidebar.php';
?>


<script>
    var insert_id = $('#id').val();
    var global_data = 0; 

    $(function() {
        $(".media-grid").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable("serialize") + "&section=<?= $table ?>";
                $.post("/ajax/reorder-images.php", order, function(theResponse){
                        $("#contentRight").html(theResponse);
                });
            }
        });
    });

    
	
</script>

<script type="text/javascript" src="/js/jquery-ui-1.9.1.custom.js"></script>
    <!--<script src="/js/libs/jquery.ui.core.js"></script>
    <script src="/js/libs/jquery.ui.widget.js"></script>
    <script src="/js/libs/jquery.ui.mouse.js"></script>
    <script src="/js/libs/jquery.ui.sortable.js"></script>-->
<script src="/js/libs/validate.js"></script>
<!--<script src="/js/upload/vendor/jquery.ui.widget.js"></script>-->
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
                            table    : 'galleries',
                            validate : {                                                               
                                seccion           : { ignore  : true }                                
                            },
                            form     : values
                        },
                        success  : function(result){                            
                            if($('input.submit').val() == "Save & upload"){
                                if(insert_id){                                    
                                    global_data.formData = {
                                        insert_id : insert_id,
                                        seccion   : 'galleries'
                                    }
                                }else{      
                                    //alert(result.error);
                                    global_data.formData = {
                                        insert_id : result.insert_id,
                                        seccion   : 'galleries'
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