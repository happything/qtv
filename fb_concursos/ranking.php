<?php
    include_once 'libs/connection.php';    
    $facebook_id = 5555434;
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
    <script src="/js/html5validate.js"></script>
    
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
            /* USERS */ 
            .main div.users-container { padding: 10px; background: rgba(255,255,255,0.6); border-radius:5px; overflow: hidden; width: 540px; box-shadow:0px 1px 1px #666; float:left; margin-right: 10px; }
            .main div.users-container div.top5 h3 { margin: 0 0 10px 0; padding: 0; font-weight: normal; font-family: 'CodeBoldRegular'; font-size: 24px; }
            .main div.users-container div.top5 h3 span { font-family: 'SignikaNegativeRegular'; font-size: 14px; color:#999; font-style: italic; }
            .main div.users-container ul.users5 { margin: 0; padding: 0; list-style: none; float:left; margin-right: 30px; }
            .main div.users-container ul.users5 li.user { width:290px; padding: 7px 0; border-bottom: 1px solid #eee; border-top: 1px solid #fff; }
            .main div.users-container ul.users5 li.first { border-top: none; text-shadow:1px 1px 1px #333; }
            .main div.users-container ul.users5 li.last { border-bottom: none; }
            .main div.users-container ul.users5 li.user img { width: 60px; height: 60px; padding: 5px; background: #fff; box-shadow:0 1px 2px #bbb; float:left; margin-right: 5px; }
            .main div.users-container ul.users5 li.user strong { font-family: helvetica neue,helvetica; font-size: 40px; color:#fff; text-shadow:1px 1px 1px #999; float:left; margin-right: 5px; }
            .main div.users-container ul.users5 li.user strong.first { color:#ffd800; text-shadow:1px 1px 1px #333;}
            .main div.users-container ul.users5 li.user span { display: block; }
            .main div.users-container ul.users5 li.user span.name { font-size: 14px; font-family: 'CodeBoldRegular'; letter-spacing: 1px; padding-top: 10px; color:#333; text-shadow:1px 1px 1px #fff; }
            .main div.users-container ul.users5 li.user span.votes { color:#00a2ff; font-size: 16px; font-style: italic; text-shadow:1px 1px 1px #fff; }
            
            .main div.users-container div.top10 h3 { margin: 0 0 10px 0; padding: 0; font-weight: normal; font-family: 'CodeBoldRegular'; font-size: 24px; }
            .main div.users-container div.top10 h3 span { font-family: 'SignikaNegativeRegular'; font-size: 14px; color:#999; font-style: italic; }
            .main div.users-container ul.users10 { margin: 0; padding: 0; list-style: none; float:left; }
            .main div.users-container ul.users10 li.user { width: 220px; padding: 2px 0; }            
            .main div.users-container ul.users10 li.user img { width: 30px; height: 30px; padding: 2px; background: #fff; box-shadow:0 1px 2px #bbb; float:left; margin-right: 5px; }
            .main div.users-container ul.users10 li.user strong { font-family: helvetica neue,helvetica; font-size: 32px; color:#fff; text-shadow:1px 1px 1px #999; float:left; margin-right: 5px; }
            .main div.users-container ul.users10 li.user strong.first { color:#ffd800; text-shadow:1px 1px 1px #333;}
            .main div.users-container ul.users10 li.user span { display: block; }
            .main div.users-container ul.users10 li.user span.name { font-size: 11px; font-family: 'CodeBoldRegular'; letter-spacing: 1px; padding-top: 10px; color:#333; text-shadow:1px 1px 1px #fff; }
            .main div.users-container ul.users10 li.user span.votes { color:#00a2ff; font-size: 12px; font-style: italic; text-shadow:1px 1px 1px #fff; }
            
            /* RIGHT */
            .main div.right { float:left; width: 210px; }
            .main div.right p.description { margin: 5px; padding: 0; color:#000; text-shadow:1px 1px 1px #fff; font-size: 15px; }
            .main div.right .register-button { float: left; display: block; width: 163px; height: 59px; padding: 10px 0 0 60px; background: url(img/css/register-button.png) no-repeat left top; color:#fff; text-decoration: none; letter-spacing: 2px; }
            .main div.right .register-button:hover { background-position: left bottom; } 
            .main div.right .register-button:hover > span.register { color:#fff2d1 !important; }
            .main div.right .register-button span { display: block; } 
            .main div.right .register-button span.register { font-family: 'CodeBoldRegular'; font-size: 24px; text-shadow:1px 1px 1px #ae830d; }
            .main div.right .register-button span.want { font-size: 13px; letter-spacing: 0; color:#856100 !important; text-shadow:1px 1px 1px #f4dfa5; }
            
            
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

        <div class="main clearfix text-description" role="main">
            <h2 class="title">RANKING</h2>
            <p class="description">Y asi van las cosas hasta ahorita.</p>
            
            <div class="users-container">
                <div class="top5">
                    <h3 class="title">TOP #3 <span>(General)</span></h3>
                    <ul class="users5">
                        <?php
                            $query = "SELECT users.id,name,lastname,count(votes.id) as votes 
                                      FROM users 
                                      LEFT JOIN votes ON votes.users_id = users.id  AND votes.date <= '2012-09-30'                                   
                                      WHERE banned = 0 
                                      GROUP BY users.id 
                                      ORDER BY votes DESC 
                                      LIMIT 3";
                            $result = mysql_query($query,$link);   
                            $i = 1;
                            while($row = mysql_fetch_assoc($result)):
                                $class = "";
                                $first = "";
                                if($i == 1) { $class = "first"; $first = "first"; }
                                else if($i == 3) $class = "last";
                        ?>
                        <li class="user clearfix <?= $class ?>">
                            <?php
                                //Search user image
                                $img_src = "img/pics/".md5("user_".$row["id"])."/".sha1("user_".$row["id"]).".jpg";
                                if(!is_file($img_src)) $img_src = "img/default-user.gif";
                            ?>
                            <img src="<?= $img_src ?>" alt="" title="" />
                            <strong class="<?= $first ?>"><?= $i++ ?></strong>
                            <span class="name"><?= utf8_encode(stripslashes($row["name"]." ".$row["lastname"])) ?></span>
                            <span class="votes"><?= $row["votes"] ?> Votos</span>
                        </li>
                        <?php
                            endwhile;
                        ?>
                    </ul>
                </div>
                <div class="top10">
                    <h3 class="title">TOP #10 <span>(Diario)</span></h3>
                    <ul class="users10">
                        <?php
                            $query = "SELECT users.id,name,lastname,count(votes.id) as votes 
                                      FROM users 
                                      LEFT JOIN votes ON votes.users_id = users.id AND votes.date = '".date('Y-m-d')."'                                   
                                      WHERE banned = 0 
                                      GROUP BY users.id 
                                      ORDER BY votes DESC 
                                      LIMIT 10";
                            $result = mysql_query($query,$link);   
                            $i = 1;
                            while($row = mysql_fetch_assoc($result)):
                                $first = "";
                                if($i == 1) $first = "first";                               
                        ?>
                        <li class="user clearfix">
                            <?php
                                //Search user image
                                $img_src = "img/pics/".md5("user_".$row["id"])."/".sha1("user_".$row["id"]).".jpg";
                                if(!is_file($img_src)) $img_src = "img/default-user.gif";
                            ?>
                            <img src="<?= $img_src ?>" alt="" title="" />
                            <strong class="<?= $first ?>"><?= $i++ ?></strong>
                            <span class="name"><?= utf8_encode(stripslashes($row["name"]." ".$row["lastname"])) ?></span>
                            <span class="votes"><?= $row["votes"] ?> Votos</span>
                        </li>
                        <?php
                            endwhile;
                        ?>
                    </ul>
                </div>
            </div>
            <div class="right">
                <p class="description">Tú tambien puedes estar participando. Solo da clic al botón de abajo y registrate muy fácilmente.</p>
                <a href="registro.php" class="register-button text-description">
                    <span class="register">Regístrate</span>
                    <span class="want">¡Si quieres ganar el ipod!</span>
                </a>
            </div>
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
            
        });
    </script>
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>