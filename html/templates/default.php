<?php       
    if(!isset($_SESSION["qtvusrid"]) && (($_SERVER["REQUEST_URI"] == "/") || ($_SESSION["first-time"]==2))) header("location:/login");         
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
    <title><?= $title ?> | Quetevalga.com </title>
    <meta charset="utf-8" />
    <meta property="fb:admins" content="100002119753022,511869665"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />    
    <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="/js/jquery-1.8.2.js"></script>    
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
<body style="background: url(/css/img/banner-sections.png) no-repeat center top; position: relative; z-index: -1000000;">
    
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
          appId      : '127488900729513', // App ID from the App Dashboard            
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true,  // parse XFBML
          oauth      : true
        });
      };

      // Load the SDK's source Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));
    </script>  
    
    <div class="container">
        <header> 
            <div class="top" style="height: 26px; padding: 5px 0;">
                <div class="top-center center">
                    <div class="user-info">
                        <?php  
                            if(isset($row["name"])){
                        ?>
                        Hola <span class="user-name"><?= utf8_encode($row["name"]) ?></span>, bienvenido(a)
                        <a id="logout" class="logout">Cerrar Sesión</a>
                        <?php  
                            } else {
                        ?>
                        <a id="fb-login-btn">Entra usando facebook</a>
                        <?php } ?>
                    </div>    
                </div>                       
            </div>
        </header>

        <div class="header-shadow"></div>
        <div class="main" role="main">                        
            <div class="sub-top group" style="margin-bottom: 100px;">
                <div class="sub-top-center center default-center">
                    <a href="/" class="logo"><img src="/img/logo.png" alt="Quetevalga.com" title="Quetevalga.com" /></a>
                    <nav>                <!-- Main menú -->
                        <?= $menu->show("main"); ?>
                    </nav>
                </div>                
            </div>
            <div class="main-center center">
                <div class="content-banner"></div>
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
    <script src="/js/plugins.js"></script>
    <script src="/js/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#fb-login-btn").click(function(e){
                if($(this).attr("attr-clicked")==undefined){
                    FB.login(function(response) {                        
                        if (response.authResponse) {                        
                            FB.api('/me', function(response) {
                                //var access_token =   FB.getAuthResponse()['accessToken'];                                
                                $.ajax({
                                    url:"/ajax/fblgn.php",
                                    type:"post",
                                    cache:false,
                                    data:{
                                        fbid:response.id,
                                        name:response.name,
                                        gender:response.gender,
                                        email:response.email,
                                        login:true                                    
                                    },
                                    beforeSend:function(){
                                        $("#fb-login-btn").attr("attr-clicked",true);
                                    },
                                    success:function(d){
                                        if(d=="1") location.href=location.href;
                                        $("#fb-login-btn").removeAttr("attr-clicked");
                                    }
                                });
                            });
                        } else {
                            // cancelled
                        }
                    }, {scope: 'email,publish_actions,user_about_me,user_activities,user_birthday,user_checkins,user_education_history,user_events,user_groups,user_hometown,user_likes,user_interests,user_location,user_photos,user_questions,user_relationships,user_relationship_details,user_religion_politics,user_status,user_subscriptions,user_videos,user_website,user_work_history,read_friendlists,user_online_presence,friends_online_presence'});         
                }                
            });    
        });
    </script>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-6636048-1']);
      _gaq.push(['_setDomainName', 'quetevalga.com']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
    <!-- end scripts-->


    <!--[if lt IE 7 ]>
            <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
            <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
    <![endif]-->
</body>
</html>