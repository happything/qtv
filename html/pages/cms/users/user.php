<?php
    $table = "users";
    $description = "In this section you may create the users you want whenever you want.\n Don't forget create them with love!";
    $id = $get;
    $validate = array(
        "password"=>array("encrypt" => true),
        "confirmPassword"=>array("ignore" => true),
        "archivos"=>array("ignore"=>true),
        "seccion"=>array("ignore"=>true)
    );

    include_once 'modules/forms.php';

    $forms = new Forms($select_row);

    $forms->create(array("id"=>"user-form", "data-form" => "users"));
    $forms->input("name",null,array("class"=>'required input-xlarge'));
    $forms->input("lastname","Last Name",array("class"=>"required input-xlarge"));
    $forms->input('email','Email',array('type'=>'email','class'=>'email required input-xlarge'));
    $forms->input("user",null,array('class'=>'input-xlarge required user'));
    if(!$id){
        $forms->input('password','Password',array('type'=>'password','class'=>'required input-xlarge'));
        $forms->input('confirmPassword', 'Confirm password', array('type' => 'password', 'class' => 'input-xlarge'));
    }    
    $forms->select("user_types_id", "User type", null, null, array("link"=>$link,"table"=>"user_types","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'input-xlarge'));    
    $forms->input('seccion',null,array('type' => 'hidden', 'value' => $table));
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
    $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->submit();
            
    include 'modules/sidebar.php';
?>


<script>
    var insert_id = $('#id').val();
    var global_data = 0;
</script>

<script src="/js/libs/validate.js"></script>
<script>
    $(document).ready(function(){
        jQuery.validator.addMethod('user', function(value, element){
            return this.optional(element) || /^[a-zA-Z0-9-_]+$/.test(value);
        }, "The user is not allowed");
       $('.form').validate({
            errorElement   : 'span',
            errorPlacement : function(error, element){
                error.appendTo(element.next('.help-inline'));
            },
            rules          : {
                confirmPassword : {
                    equalTo : '#password'
                }
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
                            table    : '<?= $table ?>',
                            validate : {
                                password        : { encrypt : true },
                                confirmPassword : { ignore  : true },
                                archivos        : { ignore  : true },
                                seccion         : { ignore  : true }
                            },
                            form     : values
                        },
                        success  : function(result){
                            if($('input.submit').val() == "Save & upload"){
                                if(insert_id){
                                    global_data.formData = {
                                        insert_id : insert_id,
                                        seccion   : '<?= $table ?>'
                                    }
                                }else{
                                    global_data.formData = {
                                        insert_id : result.insert_id,
                                        seccion   : '<?= $table ?>'
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
<script src="/js/upload/vendor/jquery.ui.widget.js"></script>
<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
<script src="/js/bootstrap/bootstrap.min.js"></script>
<script src="/js/bootstrap/bootstrap-image-gallery.min.js"></script>
<script src="/js/upload/sections.js"></script>
<script src="/js/upload/jquery.iframe-transport.js"></script>
<script src="/js/upload/jquery.fileupload.js"></script>
<script src="/js/upload/jquery.fileupload-ui.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE >= 8 -->
<script src="/js/upload/jquery.xdr-transport.js"></script>
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