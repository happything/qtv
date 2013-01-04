<?php
    $success = 0;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include_once 'libs/connection.php';        
        
        $name = trim(utf8_decode($_POST["name"]));
        $lastname = trim(utf8_decode($_POST["lastname"]));
        $email = trim(utf8_decode($_POST["email"]));
        $reason = trim(utf8_decode($_POST["reason"]));
        
        if($_POST["more"] == "") {
            if($name != "" && $lastname != "" && $email != "" && $reason != ""){
                $query = "SELECT id FROM users WHERE email = '".  mysql_real_escape_string($email)."'";
                $result = mysql_query($query,$link);

                if(mysql_num_rows($result) == 0) {
                    $query = "INSERT INTO users SET name='".  mysql_real_escape_string($name)."', 
                                              lastname = '".  mysql_real_escape_string($lastname)."', 
                                              email = '".  mysql_real_escape_string($email)."', 
                                              reason = '".  mysql_real_escape_string($reason)."', 
                                              register_date = now()";

                    if(mysql_query($query,$link)){
                        $insert_id = mysql_insert_id($link);

                        //Share
                        $dir = "img/default-user.gif";
                        if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != ""){
                            //Create thumbnail
                            include_once 'libs/image.php';

                            $dir = "img/pics/".md5("user_".$insert_id);
                            if(!is_dir($dir)) mkdir($dir,0777);

                            $image = New Image($_FILES["image"]["tmp_name"],200000000,$_FILES["image"]["size"]);
                            $image->crop(300, 300, $dir."/".sha1("user_".$insert_id).".jpg");                               
                            
                        }

                        echo "<script>location.href='https://www.facebook.com/dialog/feed?app_id=223769791078507&link=https://www.facebook.com/checaloenintrnet/app_223769791078507?app_data=".$insert_id."&picture=https://www.hihappything.com/checalofbapp/".$dir."&name=Yo%20quiero%20ese%20iPod.&caption:checaloeninternet.com&description=Ayudame%20a%20ganarme%20un%20iPod,%20no%20seas%20gacho.&redirect_uri=https://www.hihappything.com/checalofbapp/&display=popup'</script>";    
                        
                        $success = 1;
                    } else {
                        mail("julio.inzunza@hihappything.com", "Error Checalo FB App: Registro", "Error: ".mysql_error());                
                        $msg = "<p>Hubo un error con el registro. Intentalo de nuevo, si vuelve a suceder espera unos minutos y vuelve a intentralo. Nuestro staff ya fué notificado del error, gracias por la comprensión.</p>";
                    }
                } else {
                    $msg = "<p>El email ya se registró antes. Intenta con otro.</p>";
                }    
            } else {
                $msg = "<p>Todos los datos son obligatorios y activa el soporte para Java Script en tu navegador.</p>";
            }    
        } else {
            header("location: /");
        }              
    }
    
    include_once 'facebook/facebook.php';
    $facebook = new Facebook(array(
      'appId'  => '223769791078507',
      'secret' => '14a80361b706f90f0075ca237a97020f',
    ));
    
    $user = $facebook->getUser();

    if ($user) {
      try {
        // Get the user profile data you have permission to view
        $user_profile = $facebook->api('/me');    
        //print_r($user_profile);
        $user_id = $user_profile["id"];

        if (isset($_GET['code']) || isset($_GET['error'])){                
            header("Location: https://www.facebook.com/checaloenintrnet/app_223769791078507");	   
            exit;        
        }

      } catch (FacebookApiException $e) {
        $user = null;
      }
    } else {    
            $params = array('scope' => 'email'); 
            die('<script>top.location.href="'.$facebook->getLoginUrl($param).'";</script>');
            //echo "<script>top.location.href='https://www.facebook.com/dialog/oauth/?client_id=".$app_id."&redirect_uri=https://www.facebook.com/SushiFactoryMx/app_328508577218686'</script>";  
    }
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>ChecaloEnInternet.com</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="author" content="HappyThing" />    
    <script src="/checalofbapp/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/checalofbapp/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
    <script src="/checalofbapp/js/html5validate.js"></script>
    
    <style>
        /* FONT-FACE */ 
        @font-face {
            font-family: 'ClaireHandRegular';
            src: url('css/fontface/clairehandregular-webfont.eot');
            src: url('css/fontface/clairehandregular-webfont.eot?#iefix') format('embedded-opentype'),
                 url('css/fontface/clairehandregular-webfont.woff') format('woff'),
                 url('css/fontface/clairehandregular-webfont.ttf') format('truetype'),
                 url('css/fontface/clairehandregular-webfont.svg#ClaireHandRegular') format('svg');
            font-weight: normal;
            font-style: normal;    
        }
        @font-face {
            font-family: 'CodeBoldRegular';
            src: url('css/fontface/code_bold-webfont.eot');
            src: url('css/fontface/code_bold-webfont.eot?#iefix') format('embedded-opentype'),
                 url('css/fontface/code_bold-webfont.woff') format('woff'),
                 url('css/fontface/code_bold-webfont.ttf') format('truetype'),
                 url('css/fontface/code_bold-webfont.svg#CodeBoldRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        
        @font-face {
            font-family: 'SignikaNegativeRegular';
            src: url('css/fontface/signikanegative-regular-webfont.eot');
            src: url('css/fontface/signikanegative-regular-webfont.eot?#iefix') format('embedded-opentype'),
                 url('css/fontface/signikanegative-regular-webfont.woff') format('woff'),
                 url('css/fontface/signikanegative-regular-webfont.ttf') format('truetype'),
                 url('css/fontface/signikanegative-regular-webfont.svg#SignikaNegativeRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        
        /* GENERAL */
        body { background: #f8f8f8 url(img/css/bg.png); text-align: center; padding: 0; margin: 0; }
        .text-description { font-family: 'SignikaNegativeRegular'; }    
        div.container { width: 810px; margin: 0 auto; text-align: left; }
        
        /* HEADER */
        header { position: relative; margin-top: 10px; overflow: hidden; }
            /* TITLE */
            header div.title { background: #ee3137; color:#fff; padding: 8px; box-shadow:0px 2px 3px #951c1f; width: 717px; }
            header div.title h1 { font-family: 'CodeBoldRegular'; margin: 0; font-weight: normal; border-bottom: 1px solid #cb282d; font-size: 42px; text-shadow:1px 1px 1px #666; }
            header div.title p { border-top:1px solid #fb474d; margin: 0; padding: 5px 0 0 0; font-family: 'ClaireHandRegular'; font-size: 22px; color:#6c0003; text-shadow:1px 1px 1px #e96e72; }
            header div.bg-title { position: absolute; right: 0; top:39px; background: url(img/css/title-right-bg.png) no-repeat; width: 115px; height: 97px; z-index: -1000; }
            /* MENU */ 
            header .menu { padding: 0; margin: 0; margin-top: 50px; }
            header .menu li { display: inline; margin: 0; padding: 0; float: left; }            
            header .menu li a { text-decoration: none; color:#393939; font-size: 14px; padding: 30px 12px 5px 12px; border-right: 1px solid #ccc; border-left: 1px solid #fff; letter-spacing: 1px; text-shadow:1px 1px 1px #fff; }
            header .menu li a:hover { color:#000; }
            header .menu li.register a { background: url(img/css/menu/register-menu-icon.png) no-repeat center top; border-left: none; }
            header .menu li.vote a { background: url(img/css/menu/vote-menu-icon.png) no-repeat center top; }
            header .menu li.ranking a { background: url(img/css/menu/ranking-menu-icon.png) no-repeat center top; }
            header .menu li.conditions a { background: url(img/css/menu/conditions-menu-icon.png) no-repeat center top; border-right: none; }
            
        /* CONTENT */        
        .main { margin-top: 30px; padding: 10px; }
        .main h2.title { font-family: 'CodeBoldRegular'; font-weight: normal; font-size: 30px; text-shadow:1px 1px 1px #fff; margin: 0 0 5px 0; }
        .main p.description { margin: 0 0 25px 0; color:#626262; font-size: 13px; }
            /* FORM */
            .main .response p { padding: 5px; margin: 3px 3px 10px 3px; background: #d77174; border-radius:5px; color:#fff; font-size: 13px; text-shadow:1px 1px 1px #bc4e52; box-shadow:0px 1px 1px #666; }
            .main .form { padding: 10px; background: rgba(255,255,255,0.6); width: 520px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; box-shadow:0px 1px 2px #bbb; overflow: hidden; }
            .main .form div { float:left; width: 250px; margin-right: 10px; margin-bottom: 10px; }
            .main .form div label { display: block; color:#6c6c6c; font-size: 13px; margin-bottom: 3px; text-shadow:1px 1px 1px #fff; }
            .main .form div input { width: 240px; padding: 5px; border:1px solid #ccc; border-radius:5px; border-top:1px solid #ededed; }
            .main .form div.email { width: 520px; }
            .main .form div.email input { width: 500px; }
            .main .form div.why { width: 520px; }
            .main .form div.why textarea { width: 500px; padding: 5px; border:1px solid #ccc; height: 50px; border-radius:5px; border-top:1px solid #ededed; }
            .main form { display: block; width: 540px; }
            .main form input.submit { display: block; height: 50px; text-shadow:1px 1px 1px #000; width: 171px; padding-right: 10px; font-family: 'CodeBoldRegular'; font-size: 20px; text-align: right; letter-spacing: 1px; background: url(img/css/register-form-button.png) no-repeat left top; border:none; color:#eee; margin-top: 8px; float: right; }            
            .main form input.submit:hover { background-position: left bottom; color:#ccc; }
            .main form p.description-bottom { float:left; width: 250px; font-size: 13px; color:#666; line-height: 15px; font-style: italic; }
        
        /* FOOTER */
        footer { background: #000; color:#fff; margin-top: 20px; padding-top: 1px; }
        footer .footer { padding: 5px 10px 7px 5px; border-top:1px solid #444; }
        footer .footer ul { padding: 0; margin: 0; float: left; list-style: none; }
        footer .footer ul li { float:left; border-right: 1px solid #333; padding: 0; }
        footer .footer ul li a { color:#999; padding: 0 8px; font-size: 12px; text-decoration: none; }
        footer .footer ul li a:hover { color:#ccc; }
        footer .footer .happything { float: right; font-size: 11px; color:#81cee7; text-decoration: none; margin-top: 2px; font-family: helvetica neue, helvetica; }
        footer .footer .happything:hover { color:#3c94c7; }
            
        /* CLEARFIX */
        .clearfix:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
        .clearfix { display: inline-table; }         
        * html .clearfix { height: 1%; }
        .clearfix { display: block; }        
    </style>
    
</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=223769791078507";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <div class="container">
        <header>            
            <? include_once 'snippets/header.php'; ?>
        </header>

        <div class="main clearfix text-description" role="main">
            <h2 class="title">REGISTRATE SI QUIERES GANAR EL IPOD.</h2>
            <p class="description">Llena tus datos y junta el mayor número de votos posibles, porque además del iPod Touch hay premios diariamente.</p>
            
            <form action="" enctype="multipart/form-data" id="form" method="post">
                <div class="response"><?= @$msg ?></div>
                <div class="form">
                    <div class="input name">
                        <label for="name">Nombre (*)</label>
                        <input type="text" name="name" title="nombre" maxlength="45" id="name" required value="<?= @$user_profile["first_name"] ?>" />
                    </div>
                    <div class="input lastname">
                        <label for="lastname">Apellidos (*)</label>
                        <input type="text" name="lastname" title="apellidos" maxlength="45" id="lastname" required value="<?= @stripslashes($user_profile["lastname"]) ?>"/>
                    </div>
                    <div class="input email">
                        <label for="email">Email (*)</label>
                        <input type="email" name="email" title="email" maxlength="100" id="email" required value="<?= @stripslashes($user_profile["email"]) ?>"/>
                    </div>
                    <div class="input file">
                        <label for="image">Sube tu foto</label>
                        <input type="file" name="image" id="image" />
                    </div>
                    <div class="input why">
                        <label for="reason">¿Porqué quieres el iPod Touch? (*) </label>
                        <textarea name="reason" id="reason" title="porque" maxlength="140" required><?= @stripslashes($_POST["reason"]) ?></textarea>
                    </div>
                    <input type="text" name="more" value="" style="visibility: hidden" />
                </div>       
                <p class="description-bottom">Todos los datos son confidenciales y su uso es exclusivo de esta aplicación.</p>
                <input type="submit" class="submit" value="Registrar" />
            </form>
        </div>

        <footer>
            <? include_once 'snippets/footer.php'; ?>
        </footer>
    </div>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="/js/plugins.js"></script>
    <script src="/js/script.js"></script>
    <script>
        $(document).ready(function(){
            $('#form').html5form({                  
                messages : 'es',
                async : false, // cancels the default submit method.
                method : 'POST', // changes the request method.                
                responseDiv : '.response', // a content div to get the callback function response.
                emailMessage: 'El email tiene que ser válido.'
            })
        });
        
        
            
//        FB.init({appId: "223769791078507", status: true, cookie: true});
//        var obj = {
//            method: 'feed',
//            link: 'https://www.facebook.com/checaloenintrnet/app_223769791078507?app_data=',
//            picture: 'https://www.hihappything.com/checalofbapp/juego.png',
//            name: 'Yo quiero ese iPod.',
//            caption: 'checaloeninternet.com',
//            description: 'Ayudame a ganarme un iPod, no seas gacho.',
//            redirect_uri: 'https://www.hihappything.com/checalofbapp/'                
//        };
//
//        function callback(response) {
//
//        }
//
//        FB.ui(obj, callback);
          
        
    </script>
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>