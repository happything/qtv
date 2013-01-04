<?php
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
            $param = array("redirect_uri" => "https://www.facebook.com/checaloenintrnet/app_223769791078507");    
            die('<script>top.location.href="'.$facebook->getLoginUrl().'";</script>');
            //echo "<script>top.location.href='https://www.facebook.com/dialog/oauth/?client_id=".$app_id."&redirect_uri=https://www.facebook.com/SushiFactoryMx/app_328508577218686'</script>";  
    }
    
    $signedRequest = $facebook->getSignedRequest();
    
    if($signedRequest["page"]["liked"] != 1 && isset($signedRequest["page"]["liked"])) header("location:non-like.php");    
    else if(isset($signedRequest["app_data"])){
        $app_data = $signedRequest["app_data"];
        switch ($app_data) {
            case "vota":
                    echo "<script>location.href = 'vota.php'</script>";
                    break;
            case "ranking":
                    echo "<script>location.href = 'ranking.php'</script>";
                    break;    
            case "registro":
                    echo "<script>location.href = 'registro.php'</script>";
                    break;        
            default:
                    echo "<script>location.href = 'user.php?u=".$app_data."'</script>";
                    break;
        }
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
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
    
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
            header .menu li a { text-decoration: none; color:#393939; font-size: 14px; padding: 30px 12px 5px 12px; border-right: 1px solid #ccc; border-left: 1px solid #fff; letter-spacing: 1px; }
            header .menu li a:hover { color:#000; }
            header .menu li.register a { background: url(img/css/menu/register-menu-icon.png) no-repeat center top; border-left: none; }
            header .menu li.vote a { background: url(img/css/menu/vote-menu-icon.png) no-repeat center top; }
            header .menu li.ranking a { background: url(img/css/menu/ranking-menu-icon.png) no-repeat center top; }
            header .menu li.conditions a { background: url(img/css/menu/conditions-menu-icon.png) no-repeat center top; border-right: none; }
            
        /* CONTENT */        
            /* LINE */
            .main div.line { width: 790px; padding: 10px; margin: 25px 0; background: rgba(0,0,0,0.2); color:#fff; box-shadow:0 1px 2px #666; }
                /* LEFT */
                .main div.line h2.question { font-family: 'CodeBoldRegular'; padding: 0; margin: 0 0 20px 0; text-shadow:1px 1px 1px #333; font-size: 40px; }
                .main div.line .register-button { float: left; display: block; width: 163px; height: 59px; padding: 10px 0 0 60px; background: url(img/css/register-button.png) no-repeat left top; color:#fff; text-decoration: none; letter-spacing: 2px; }
                .main div.line .register-button:hover { background-position: left bottom; } 
                .main div.line .register-button:hover > span.register { color:#fff2d1 !important; }
                .main div.line .register-button span { display: block; } 
                .main div.line .register-button span.register { font-family: 'CodeBoldRegular'; font-size: 24px; text-shadow:1px 1px 1px #ae830d; }
                .main div.line .register-button span.want { font-size: 13px; letter-spacing: 0; color:#856100 !important; text-shadow:1px 1px 1px #f4dfa5; }
                /* RIGHT */  
                .main div.line .ipod { float: right; margin-top: -55px; width: 230px; text-align: center; margin-left: 15px; }
                .main div.line .ipod span.label { color:#4a4a4a; font-size: 20px; text-shadow:1px 1px 1px #fff; padding-bottom: 5px; display: block; }
                .main div.line .ipod p { margin: 0; }
                .main div.line .ipod p span,.main div.line .ipod p a { display: block; }
                .main div.line .ipod p span.name { font-family: 'CodeBoldRegular'; font-size: 16px; text-shadow:1px 1px 1px #666; }
                .main div.line .ipod p a.website { font-size: 12px; color:#094266; margin-bottom: 3px; }
                .main div.line .ipod p a.website:hover { color:#1c5d86; text-decoration: none; }
                .main div.line .ipod p span.phrase { font-size: 14px; text-shadow:1px 1px 1px #666;}
                
            /* INFO */        
                .main .info { width: 520px; float: left; padding: 10px; color:#4a4a4a; line-height: 20px; border-right: 1px solid #ccc; }
                .main .info h2 { font-family: 'CodeBoldRegular'; font-size: 30px; color:#2e2e2e; font-weight: normal; letter-spacing: 1px; padding-left: 10px; text-shadow:1px 1px 1px #fff; margin: 0 0 10px 0;  }
                .main .info p { text-shadow:1px 1px 1px #fff; font-size: 13px; }
                .main .info p.restictions { color:#ee3137; font-style: italic; font-size: 12px; }
            /* HELP */     
                .main .help { float: left; width: 240px; line-height: 20px; padding: 10px; }
                .main .help h2 { font-family: 'CodeBoldRegular'; font-size: 30px; color:#2e2e2e; font-weight: normal; letter-spacing: 1px; padding-left: 10px; text-shadow:1px 1px 1px #fff; margin: 0 0 10px 0; }
                .main .help p { text-shadow:1px 1px 1px #fff; font-size: 13px; }  
                .main .help a { display: block; width: 98px; height: 26px; padding: 6px 0 0 40px; background: url(img/css/checalo-fb-button.png) no-repeat left top; text-decoration: none; color:#3c94c7; text-shadow:1px 1px 1px #fff; font-size: 13px; }
                .main .help a:hover { background-position: left bottom; }
        
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
    <div class="container">
        <header>            
            <? include_once 'snippets/header.php'; ?>
        </header>

        <div class="main clearfix" role="main">
            <div class="line clearfix">
                <div class="ipod text-description">
                    <span class="label">¡GÁNATELO!</span>
                    <img src="img/ipod-touch.png" alt="" title="" />
                    <p class="description text-description">
                        <span class="name">iPod touch 8gb</span>
                        <a href="https://www.apple.com/mx/ipodtouch/" class="website" target="_blank">www.apple.com/mx/ipodtouch/</a>
                        <span class="phrase">El mensaje es claro, diviértete.</span>
                    </p>
                </div>
                
                <h2 class="question">¡Tener muchos amigos te puede ayudar a ganar un ipod!</h2>
                <a href="registro.php" class="register-button text-description">
                    <span class="register">Regístrate</span>
                    <span class="want">¡Si quieres ganar el ipod!</span>
                </a>
            </div>
            
            <div class="info text-description">
                <h2>¿En que consiste?</h2>
                <p> 
                    Regístrate y demuestra que realmente quieres el iPod. Invita a tus amigos, familia, compañeros, vecinos y hasta al perro a que voten por ti 
                    para que puedas ganar este fabuloso iPod Touch. El que acumule más like para el 30 de Septiembre será el ganador. 
                </p>    

                <p> Además, estaremos regalando pases al cine, comidas gratis en restaurantes e idas a divertirte a los lugares que checaloeninternet.com trae para tí. </p>    

                <p class="restictions"> *Necesitas juntar un mínimo de 200 votos para ganar el ipod. </p>
            </div>
            
            <div class="help text-description">
                <h2>¿Dudas?</h2>
                <p> Para dudas o aclaraciones envíanos un inbox a nuestra fanpage. </p>
                <a href="https://www.facebook.com/checaloenintrnet" alt="Checaloeninternet.com Fanpage" title="Checaloeninternet.com Fanpage" target="_blank">Checo en red</a>
            </div>
        </div>

        <footer>
            <? include_once 'snippets/footer.php'; ?>
        </footer>
    </div>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="/js/plugins.js"></script>
    <script src="/js/script.js"></script>
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>