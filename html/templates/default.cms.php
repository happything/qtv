<?php
    $_SESSION["redirect"] = $_SERVER["REQUEST_URI"];
    if(!isset($_SESSION["user_id"])) header("location:/happycms/login");
    
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $browser = substr("$browser", 25, 8);
    $username = "";
    if(isset($_SESSION["user_name"])) $username = $_SESSION["user_name"];
    
    if($browser == "MSIE 6.0" || $browser == "MSIE 7.0" || $browser == "MSIE 8.0"){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /happycms/noie");
        exit();
    }
?>
<!DOCTYPE html>
<!--[if gt IE 8]> <html class="no-js" lang="en"> <![endif]-->
<head>
    <title>HappyCMS - <?= $title ?></title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="author" content="" />        
    <link rel="stylesheet" href="/css/set.css" />
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/bootstrap/css/bootstrap-image-gallery.min.css" />
    <link rel="stylesheet" href="/css/cms-style.css" />
    <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    <script src="/js/jquery-1.8.2.js"></script>
    <script src="/js/tiny_mce/tiny_mce.js"></script>
    <script>
        tinyMCE.init({
            // General options
            mode : "specific_textareas",
            editor_selector : "tiny",
            theme : "advanced",    
            plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,formatselect,|,bullist,numlist,|,forecolor,backcolor",
            theme_advanced_buttons2 : "tablecontrols,|,code,pastetext,pasteword,anchor,image,|,link,unlink",                        
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "bottom",
            theme_advanced_toolbar_align : "left",
            theme_advanced_resize_vertical : true
        });
        $(document).ready(function(){
            var sidebar_height = $(".sidebar").height() + 81;
            var real_height = screen.availHeight;
            
            if(sidebar_height > real_height) $(".sidebar").css("position","absolute");
        });
    </script>
</head>
<body>
    <div class="top-bar clearfix">
        <div class="main-menu clearfix">
            <span class="logo sep">
                <a href="/happycms/"><img src="/img/cms-logo.png" alt=""/></a>
            </span>
            <?= $menu->show("cms"); ?>            
        </div>
        <div class="general-tools">
            <div class="tools sep">
                <a class="img-tool" id="img-tool"> Sub-menu</a>
                <div class="sub-menu hidden">
                    <ul>                        
                        <li><i class="icon-book"></i><a href="/happycms/pages"> Pages</a></li>
                        <li>
                            <i class="icon-user"></i> 
                            Users
                            <ul class="level2">
                                <li><i class="icon-search"></i><a href="/happycms/users"> View</a></li>
                                <li><i class="icon-user"></i> <a href="/happycms/users/user"> New User</a></li>
                                <li><i class="icon-pencil"></i><a href="/happycms/users/password"> Change Password</a></li>
                            </ul>
                        </li>                        
                        <li><i class="icon-picture"></i><a href="/happycms/media"> Media</a></li>
                        <li><i class="icon-question-sign"></i><a href="/happycms/help"> Help</a></li>                        
                        <li><i class="icon-ban-circle"></i><a href="/happycms/logout"> Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="prof-info">
                <span>                    
                    <span>Hi,</span>
                    <span class="us-prof-name"><?= utf8_encode($username) ?></span>
                </span>
            </div>
        </div>
    </div>
    <div class="main-content container-fluid">
        <?= $content; ?>
    </div>
    <div class="main-footer">
        <span>Developed by Happy Thing.</span>
        <ul>
            <li><a href="/happycms">Home</a></li>
            <li><a href="/happycms/media">Media</a></li>
            <li><a href="/happycms/pages">Pages</a></li>
            <li><a href="/happycms/users">Users</a></li>            
            <li><a href="/happycms/help">Help</a></li>
        </ul>
    </div>
    
    <script charset="utf-8">
        var sub_menu_selected = false;
        $(document).ready(function(){
            $(".lnk_list_blog").attr("href","/happycms/blog");
            $(".list_Places a.element-link").attr("href","/happycms/places");
            $(".list_Galleries a.element-link").attr("href","/happycms/galleries");
            $(".list_Ads a.element-link").attr("href","/happycms/ads");
        });
        $("#img-tool").click(function(){
            if(!sub_menu_selected) { $(this).addClass("selected"); $(".sub-menu").removeClass("hidden"); sub_menu_selected = true; } else { $(this).removeClass("selected"); $(".sub-menu").addClass("hidden"); sub_menu_selected = false; }            
        });
    </script>
</body>
</html>