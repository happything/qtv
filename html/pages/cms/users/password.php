<?php
    $sended = false;
    $eq = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $sended = true;
        $pwd = $_POST["password"];
        $con_pwd = $_POST["confirmPassword"];
        $old_pwd = $_POST["password_old"];
        
        if(trim($pwd) == trim($con_pwd)) $eq = true; else $eq = false;
    }
        
    $table = "users";
    $description = "Change your password, if you dare!";
    $id = $_SESSION["user_id"];

    $validate = array(
        "password"=>array("encrypt" => true),
        "confirmPassword"=>array("ignore" => true),
        "password_old"=>array("ignore" => true)        
    );

    if((!$sended) || ($sended && $eq)){
        if($sended && $eq){
            $sql = "SELECT id FROM users WHERE id = ".$id." AND password = '".substr(sha1($old_pwd),0,13)."'";
            $result = mysql_query($sql,$link);
            if(mysql_num_rows($result)>=1){
                include_once 'modules/forms.php';
            } else {
                echo '<div class="alert-message-info alert alert-block alert-error fade in">The old password is invalid. Try again</div>';
                include_once 'libs/forms.php';
                $select_row = null;
            }
        } else if(!$sended) include_once 'modules/forms.php';                
    } else {
        include_once 'libs/forms.php';
        $select_row = null;
        echo '<div class="alert-message-info alert alert-block alert-error fade in">The password don\'t match. Try again.</div>';
    }

    $forms = new Forms($select_row);

    $forms->create(array("id"=>"user-form", "data-form" => "users"));    

    $forms->input('password_old','Old Password',array('type'=>'password','class'=>'required input-xlarge'));
    $forms->input('password','New Password',array('type'=>'password','class'=>'required input-xlarge',"value"=>''));
    $forms->input('confirmPassword', 'Confirm password', array('type' => 'password', 'class' => 'required input-xlarge'));
    $forms->input('id', null, array('type' => 'hidden', 'value' => $id));        

    $forms->submit();            
    
    
    include 'modules/sidebar.php';
?>
<script src="/js/libs/validate.js"></script>
<script>
    $(document).ready(function(){
        jQuery.validator.addMethod('password', function(value, element){
            return this.optional(element) || /^[a-zA-Z0-9-_]+$/.test(value);
        }, "The password is not allowed");
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
    });   
</script>