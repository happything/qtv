<?php
    $table = "blog";
    $description = "What's new?";
    $id = $get;
    
    $validate = array(
        "seccion"=>array("ignore"=>true),
        "archivos"=>array("ignore"=>true),                
    );
    
    include_once 'modules/forms.php';
    
    $forms = new Forms($select_row,"blog",$id,$link);

    $forms->create(array("id"=>"blog-form", "data-form" => "blog"));    
    $forms->input("title",NULL,array("class"=>'required input-xlarge',"style"=>"width:690px;"));
    $forms->input("tags",NULL,array("class"=>'input-xlarge'));
    $forms->select("blog_categories_id", "Clasification", array("-1"=>"Selecciona una categoria"), null, array("link"=>$link,"table"=>"blog_categories","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge',"style"=>"width:490px;"));            
        
    $forms->textarea("content", "Nota", true, array("style"=>"width:700px; height:800px;"));    
    $forms->input('archivos',null,array('type'=>'file'));
    $forms->input('users_id',null,array("type"=>"hidden","value"=> $_SESSION["user_id"]));
    $forms->input('seccion',null,array('type' => 'hidden', 'value' => $table));
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
    $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->submit();
        
        //Extra forms on sidebar
        $extra_forms = array(
            "blog_categories"=>array()
            );
    
    include 'modules/sidebar.php';
?>


<script>
    var insert_id = $('#id').val();
    var global_data = 0;
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

<script src="/js/libs/jquery.ui.core.js"></script>
<script src="/js/libs/jquery.ui.widget.js"></script>
<script src="/js/libs/jquery.ui.mouse.js"></script>
<script src="/js/libs/jquery.ui.sortable.js"></script>
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
                            table    : 'blog',
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
                                        seccion   : 'blog'
                                    }
                                }else{      
                                    //alert(result.error);
                                    global_data.formData = {
                                        insert_id : result.insert_id,
                                        seccion   : 'blog'
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