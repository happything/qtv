<?php
    if(!isset($_SESSION["qtvusrid"])) header("location:/login");
    $query = "SELECT name FROM users WHERE id = ".$_SESSION["qtvusrid"];
    $result = mysql_query($query,$link);
    $row = mysql_fetch_assoc($result);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>Quetevalga.com | <?= $title ?></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
    <script>
        $(document).ready(function(){
            $("#logout").click(function(e){$.ajax({ url:"/ajax/lg.php",type:"post",data:{tp:"lt"},beforeSend:function(){$(this).html("Cerrando Sesion ...");},success:function(d){location.href = "/login";}});});
            $(".list_Fotos a.element-link").attr("href","/fotos"); 
            
            // Fix the a/img problem for any images contained within a div with class "linkFix"
            $("ul.sub_menu_Fotos").mouseover(function(){$("li.list_Fotos a.element-link").css('background-color', 'rgba(0,0,0,0.5)');});
            $("ul.sub_menu_Fotos").mouseout(function(){$("li.list_Fotos a.element-link").css('background-color', '');});
        });
    </script>
</head>
<body style="background: url(/css/img/header-banner.png) no-repeat center top;">
    <div class="container">
        <header> 
            <div class="top">
                <div class="top-center center">
                    <div class="user-info">
                        Hola <span class="user-name"><?= utf8_encode($row["name"]) ?></span>, bienvenido(a)
                        <a id="logout" class="logout">Cerrar Sesión</a>
                    </div>    
                </div>                       
            </div>
        </header>

        <div class="header-shadow"></div>    

        <div class="main" role="main">            
            <div class="sub-top group">
                <div class="sub-top-center center">
                    <a href="/" class="logo"><img src="/img/logo.png" alt="Quetevalga.com" title="Quetevalga.com" /></a>
                    <nav>                <!-- Main menú -->
                        <?= $menu->show("main"); ?>
                    </nav>
                </div>                
            </div>
            <div class="main-center center">
                <!-- Main content -->
                <?= $content ?>
            </div>            
        </div>

        <footer>  
            <div class="footer-center center">
                <span class="copy">QueTeValga.com ® es una marca registrada de KTV Network S. de R.L. de C.V.</span>                
            </div>
        </footer>
    </div>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>