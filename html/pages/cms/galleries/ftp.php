<?php
    $table = "galleries";
    $description = "Add all the pictures that you want using FTP files.";
    $id = $get;
    
    $validate = array(
        "seccion"=>array("ignore"=>true),
        "archivos"=>array("ignore"=>true),        
        "nightclubs_id"=>array("type"=>"number"),
        "galleries_type_id"=>array("type"=>"number"),
        "url"=>array("ignore"=>true)
    );
    
    include_once 'modules/forms.php';
    
    $forms = new Forms($select_row,"galleries",$id,$link);

    $forms->create(array("id"=>"galleries-form", "data-form" => "galleries")); 
    $forms->input("url","Folder Name",array("class"=>'required input-xlarge'));
    $forms->form .= "<div class='control-group'><a id='load-images-lnk'>+ Cargar imágenes</a></div>";   
    $forms->form .= "<div class='control-group' id='ftp-images'></div>";

    $forms->form .= "<div id='gallery-form-ftp' style='display:none'>";
    $forms->form .= "<div class='control-group'><strong style='padding-left:160px;'>Gallery Info</strong></div>";
    $forms->input("title",NULL,array("class"=>'required input-xlarge'));
    $forms->select("galleries_type_id", "Clasification", array("-1"=>"Selecciona una clasificación"), null, array("link"=>$link,"table"=>"galleries_type","value_field"=>"id","show_field"=>"name"),array("required"=>true,'class'=>'required input-xlarge',"style"=>"width:490px;"));        
    $forms->select("nightclubs_id", "Night Club", array("-1"=>"Selecciona un lugar"), null, array("link"=>$link,"table"=>"nightclubs","value_field"=>"id","show_field"=>"name","parent_id"=>"galleries_type_id"),array('class'=>'input-xlarge',"style"=>"width:490px;"));         
    $forms->textarea("description", "Description", null, array("style"=>"width:390px; height:100px;"));        
    $forms->input("banner", "Home Banner", array("type"=>"checkbox","value"=>"1"));                
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));
    $forms->input('enabled',null,array('type' => 'hidden', 'value' => '1'));
    $forms->input('orden', null, array('type' => 'hidden', 'value' => '10000'));
    $forms->input('date', null, array('type' => 'hidden', 'value' => date('Y-m-d')));
    $forms->form .= "</div>";
    $forms->submit();
        
    //Extra forms on sidebar
    $extra_forms = null;
    
    include 'modules/sidebar.php';
?>

<script src="/js/libs/validate.js"></script>
<script type="text/javascript">    
    var submit_form = false;
    var total_images = 0;
    var imgs = new Array();
    var currimg = 1;
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

        $('input.submit').click(function(e){
            if($('.form').valid() && submit_form){ 
                var form = $('.form').serializeArray();
                var values = {};
                for (var i in form){
                    values[form[i].name] = form[i].value;
                }
                values["date"] = "<?= date('Y-m-d') ?>";
                $.ajax({
                    url:"/modules/forms.php",
                    type:"post",
                    cache:false,
                    dataType:"json",
                    data:{table:"galleries",form:values,validate:{url:{ignore:true},banner:{type:"checkbox"},date:{type:"string"}}},
                    success:function(d){
                        if(d.error=="0"){
                            var album_id = d.insert_id;                                                                                    
                            for(i=1;i<=total_images;i++){
                                if(currimg <= total_images){
                                    imgs[i-1] = $("#images-table #img-name-"+i).html();                                                                    
                                }                                
                            }
                            create_thumbs(album_id);
                                                                                    
                        } else {
                            alert("No pudo crearse el album. Intentalo de nuevo.");
                        }
                    }
                });
                e.preventDefault();
            }
        });

        $("#url").focus();

        $("#load-images-lnk").click(function(){
            var fld = $("#url").val();
            if(fld.trim() != ""){
                $.ajax({
                    url:"/ajax/loadif.php",
                    type:"post",
                    cache:false,
                    data:{fld:fld,type:"get"},
                    dataType:"json",
                    beforeSend:function(){
                        $("#load-images-lnk").html("Cargando ...");
                    },
                    success:function(d){
                        if(d.error == "1") {
                            alert("La carpeta seleccionada no existe. Intenta con otra :)");
                        } else if(d.error == "0"){
                            //Show list of images 
                            var img_i = 1;
                            //Creating table
                            $("#ftp-images").append("<table id='images-table'><thead><tr><td><input type='checkbox' value='1' class='imgs_all_chk' /></td><td>#</td><td>Images</td><td>Status</td></tr></thead><tbody></tbody></table>");
                            $.each(d.images,function(index,value){
                                //Creating row
                                $("#images-table tbody").append("<tr id='r"+img_i+"'><td><input type='checkbox' class='imgs-chkbox' value='1' id='img-"+img_i+"' /></td><td><strong>"+img_i+"</strong></td><td id='img-name-"+img_i+"'>"+value+"</td><td id='status-"+img_i+"'></td></tr>");    
                                img_i++;
                            });
                            $("#images-table").append("<tfoot><tr><td><input type='checkbox' value='1' class='imgs_all_chk' /></td><td>#</td><td>Images</td></tr></tfoot>");                                                                                   

                            //Show the album form
                            $("#gallery-form-ftp").fadeIn(400);
                            $("#title").focus();
                            total_images = img_i;
                            submit_form = true;
                        }
                        $("#load-images-lnk").html("+ Cargar imágenes");
                    }
                });    
            } else {
                alert("Escribe la carpeta donde se encuentran las imágenes a guardar.");
            }            
        });

        $(".imgs_all_chk").live("click",function(){
            if($(this).is(":checked")) $(".imgs-chkbox").attr("checked","checked");
            else $(".imgs-chkbox").removeAttr("checked");
        });
    });

    function create_thumbs(albid){
        var total_images = imgs.length;
        if(currimg <= total_images){
            var tmp_imgs = new Array();
            for(i=0; i<5; i++){                        
                tmp_imgs[i] = imgs[(currimg-1)+i];
            } 
            $.ajax({
                url:"/ajax/loadif.php",
                type:"post",
                dataType:"json",
                cache:false,
                data:{type:"upload",albid:albid,imgs:tmp_imgs,fld:$("#url").val()},
                beforeSend:function(){                         
                    for(i=currimg; i<=(currimg+5); i++){
                        if(i<=total_images) $("#images-table #status-"+i).html("Uploading ...");                     
                    }                                    
                },
                success:function(di){
                    for(i=currimg; i<=(currimg+5); i++){
                        if(i<=total_images) $("#images-table #status-"+i).html("Terminado!");                     
                    } 
                    currimg+=5;
                    location.href="/happycms/galleries/ftp#r"+(currimg-1);
                    create_thumbs(albid);
                }
            });    
        } else {
            location.href = "/happycms/galleries";
        }        
    }
</script>