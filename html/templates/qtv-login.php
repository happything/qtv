<?php     
    if(isset($_SESSION["qtvusrid"])) header("location:/");   
    /*$fb_enter = false;    
    //echo $_REQUEST["code"];

    //Get info using facebook
    if((@$get == "fb") || (@$get[0] == "fb")){        
        $app_id = '127488900729513';
        $app_secret = 'f2b25c9e83a233e89104202f8ad98df3';
        $fb_url = "http://quetevalga.com/login/fb";


        include_once 'facebook/facebook.php';
        $facebook = new Facebook(array(
           'appId'  => $app_id,
           'secret' => $app_secret,
           'cookie' => true
        ));

        $code = $_REQUEST["code"];

        //Facebook login url ...
        if(empty($code)) {
            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
                          . $app_id . "&redirect_uri=" . urlencode($fb_url) . "&state="
                          . $_SESSION['state'] . "&scope=email,publish_actions";
            
            echo("<script> top.location.href='" . $dialog_url . "'</script>");    
        }

        //Processing facebook login ...
        if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
            $token_url = "https://graph.facebook.com/oauth/access_token?"
                        . "client_id=" . $app_id . "&redirect_uri=" . urlencode($fb_url)
                        . "&client_secret=" . $app_secret . "&code=" . $code;

            //echo $token_url;

            $response = file_get_contents($token_url);            
            $params = null;
            parse_str($response, $params);

            $_SESSION['access_token'] = $params['access_token'];

            $graph_url = "https://graph.facebook.com/me?access_token=" 
                         . $params['access_token'];

            $user = json_decode(file_get_contents($graph_url));            
            $fb_id = $user->id;
            
            $fb_enter = true;
            if($user->gender == 'male') $gender_id = 1; else $gender_id = 2;
        } else {
          //echo("The state does not match. You may be a victim of CSRF.");
        }
    }
    
    if((isset($_POST["login-user"])) || ($fb_enter)){
        if(isset($_POST["normal"])){
            //User&Password Login
            $query = "SELECT id FROM users 
                               WHERE email = '".mysql_real_escape_string(utf8_decode($_POST["login-user"]))."' 
                                 AND password = '".mysql_real_escape_string(utf8_decode(md5($_POST["login-password"])))."' 
                                 AND user_types_id = 4";            
            $result = mysql_query($query,$link);
            $row = mysql_fetch_assoc($result);
            if(mysql_num_rows($result) > 0) {
                $_SESSION["qtvusrid"] = $row["id"];
                header("location:/");
            }
            //else echo 0;
        } else {            
            //Facebook Login
            if($fb_id!=""){
                $query = "SELECT id FROM users
                                   WHERE facebook_id = '".$fb_id."'";
                //echo $query." -";                     
                $result = mysql_query($query,$link);
                $row = mysql_fetch_assoc($result);
                if(mysql_num_rows($result)>0) {
                    $_SESSION["qtvusrid"] = $row["id"];
                    $_SESSION["fbid"] = $fb_id;
                    header("location:/");
                } else {
                    echo -1;
                    $query = "INSERT INTO users
                                  SET name = '".mysql_real_escape_string(utf8_decode($user->name))."',                                      
                                      password = '0000',
                                      gender = ".mysql_real_escape_string(utf8_decode($gender_id)).",
                                      email = '".mysql_real_escape_string(utf8_decode($user->email))."',
                                      facebook_id = '".mysql_real_escape_string(utf8_decode($fb_id))."',    
                                      user_types_id = 4,     
                                      date = now(),
                                      orden = 1,
                                      enabled = 1";
                if(mysql_query($query,$link)) { $_SESSION["qtvusrid"] = mysql_insert_id(); $_SESSION["fbid"] = $fb_id; header("location:/"); }
                }    
            }
        }
    }    */
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title><?= $title ?> | Quetevalga.com </title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />    
    <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.6.2.min.js"><\/script>')</script>
    <script src="/js/html5validate.js"></script>
    <script src="/js/cookies.js"></script>
</head>
<body>  
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
                        <a id="fb-login-btn">Entra usando facebook</a> <!--<a id="login-btn">Iniciar Sesión</a>-->
                        <div class="login-form" id="login-form-container">
                            <form action="" method="post" id="login-form" onsubmit="return cookies();">
                                <div class="input user">
                                    <label>Email</label>
                                    <input type="text" id="login-user" name="login-user" />
                                </div>
                                <div class="input password">
                                    <label>Contraseña</label>
                                    <input type="password" id="login-password" name="login-password" />
                                </div>
                                <div class="remember">                                        
                                    <input type="checkbox" value="1" name="remember" id="remember" />
                                    <label for="remember">Recordar</label>
                                </div>                                
                                <input type="submit" class="submit" value="ENTRAR" name="normal" />                                
                            </form>
                        </div>
                    </div>    
                </div>                       
            </div>
        </header>

        <div class="header-shadow"></div>
        <div class="main" role="main">                        
            <div class="sub-top group" style="margin-bottom: 30px;">
                <div class="sub-top-center center default-center">
                    <a href="/" class="logo"><img src="/img/logo.png" alt="Quetevalga.com" title="Quetevalga.com" /></a>                                        
                </div>                
            </div>
            <div class="main-center center">                
                <!-- Main content -->
                <?= $content ?>
            </div>            
        </div>

        <footer>  
            <div class="footer-center center">
                <span class="copy">Quetevalga.com ® es una marca registrada de KTV Network S. de R.L. de C.V.</span>                
            </div>
        </footer>
    </div>

    <!-- scripts concatenated and minified via ant build script-->
    <script src="/js/plugins.js"></script>
    <script src="/js/script.js"></script>
    <script>
        $(document).ready(function(){
            if($.cookie("data") != undefined){
                var cookie = $.cookie("data");
                var cookie_arr = cookie.split(",");
                $("#login-user").val(cookie_arr[0]);
                $("#login-password").val(cookie_arr[1]);
                $("#remember").attr("checked","checked");
            }
            // Old Register     
            //$("#fb-register").click(function(e){ window.location.href = "/login/fb"; });
            //$("#fb-login-btn").click(function(e){ $("#login-form").attr("action","/login/fb").submit(); });

            $("#fb-login-btn").click(function(e){
                if($(this).attr("attr-clicked")==undefined){
                    FB.login(function(response) {                        
                        if (response.authResponse) {                        
                            FB.api('/me', function(response) {
                                var access_token =   FB.getAuthResponse()['accessToken'];
                                console.log('Access Token = '+ access_token);
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
                                        if(d=="1") location.href="/";
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

            $("#fb-register").click(function(e){
                /*FB.login(function(response) {                        
                    if (response.authResponse) {                        
                        FB.api('/me', function(response) {
                            $("#name").val(response.name);    
                            $("#email").val(response.email);
                            $("#fbid").val(response.id);
                            var gender = -1;
                            if(response.gender == "male") gender = 1;
                            else gender = 2;
                            $('#gender option[value="'+gender+'"]').attr("selected","selected");
                            $("#password").focus();
                        });
                    } else {
                        // cancelled
                    }
                }, {scope: 'email,publish_actions'});   */
                if($(this).attr("attr-clicked")==undefined){
                    FB.login(function(response) {                        
                        if (response.authResponse) {                        
                            FB.api('/me', function(response) {
                                var access_token =   FB.getAuthResponse()['accessToken'];                                
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
                                        if(d=="1") location.href="/";
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

            $("#login-btn").click(function(e){
                if($("#login-form-container").css("display")=="block") $("#login-form-container").fadeOut(400);
                else $("#login-form-container").fadeIn(400);
            });

            $('#form').html5form({                  
                messages : 'es',
                async : false, // cancels the default submit method.
                method : 'POST', // changes the request method.                
                responseDiv : '.response', // a content div to get the callback function response.
                emailMessage: 'El email tiene que ser válido.'
            });
            if($(".response").html() != "") $(".response").fadeIn(400).animate({top:'-10px'},400);
        });
        
        function cookies(){
           var usr = $("#login-user").val();
           var pwd = $("#login-password").val();
           if((usr != "" && pwd != "") && ($("#remember:checked").val() == "1")){
               var data = new Array();
               data[0] = usr;
               data[1] = pwd;
               $.cookie("data", data);               
           }
           return true;
        }

        function pwd(){ return false; }
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