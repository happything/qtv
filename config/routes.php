<?php

/*
 Example:
 * 
 *  "file's url"                "link's href"
 *  "comida/single"=>array('spa'=>'comida/*'),          
 */

    $routes = array(                        
        "cms/login-processing"=>array("spa"=>"happycms/login/processing"),
        "cms/index"=>array("spa"=>"happycms"),
        "cms/login"=>array("spa"=>"happycms/login/*"),
        "cms/logout"=>array("spa"=>"happycms/logout"),
        "cms/pages"=>array("spa"=>"happycms/pages"),
        "cms/media" => array("spa"=>"happycms/media"),                
        "cms/users/password"=>array("spa"=>"happycms/users/password"),
        "cms/users/user"=>array("spa"=>"happycms/users/user/*"),
        "cms/users/index"=>array("spa"=>"happycms/users/*"),
        "cms/no-ie" => array("spa" => "happycms/no-ie"),
        "cms/help" => array("spa" => "happycms/help"),
        "cms/galleries/nightclubs/nightclub" => array("spa" => "happycms/galleries/nightclubs/nightclub/*"),
        "cms/galleries/nightclubs/index" => array("spa" => "happycms/galleries/nightclubs/*"),        
        "cms/galleries/ftp" => array("spa" => "happycms/galleries/ftp"),        
        "cms/galleries/gallery" => array("spa" => "happycms/galleries/gallery/*"),        
        "cms/galleries/index" => array("spa" => "happycms/galleries/*"),    
        "cms/blog/post" => array("spa" => "happycms/blog/post/*"),        
        "cms/blog/index" => array("spa" => "happycms/blog/*"),    
        "cms/events/event" => array("spa" => "happycms/events/event/*"),        
        "cms/events/index" => array("spa" => "happycms/events/*"),    
        "cms/places/places-types/place-type" => array("spa" => "happycms/places/places-types/place-type/*"),        
        "cms/places/places-types/index" => array("spa" => "happycms/places/places-types/*"),    
        "cms/places/place" => array("spa" => "happycms/places/place/*"),        
        "cms/places/index" => array("spa" => "happycms/places/*"),            
        "cms/ads/ad" => array("spa" => "happycms/ads/ad/*"),        
        "cms/ads/client" => array("spa" => "happycms/ads/clients/client/*"),            
        "cms/ads/clients" => array("spa" => "happycms/ads/clients/*"),            
        "cms/ads/index" => array("spa" => "happycms/ads/*"),            
        "cms/qtv-users/index" => array("spa" => "happycms/qtv-users/*"),            
        "events/event"=>array("spa"=>"eventos/evento/*"),
        "events/index"=>array("spa"=>"eventos/*"),        
        "blog/post"=>array("spa"=>"blog/entrada/*"),
        "blog/index"=>array("spa"=>"blog/*/*"),        
        "places/index"=>array("spa"=>"lugares/*/*"),
        "fotos/index"=>array("spa"=>"fotos/*/*"),        
        "login"=>array("spa"=>"login/*")
    );
?>
