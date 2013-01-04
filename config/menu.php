<?php

/*
 * Example:
 *                    Link's text   Link's href
 * array("spa"=>array("Contacto"=>"/contacto"))       
 */

$menus = array(
    "main"=>array(
        array("spa"=>array("Inicio"=>"/")),
        array("spa"=>array("Fotos"=>array(
            "Antros"=>"/fotos/antros",
            "Eventos"=>"/fotos/eventos",
            "Fiestas"=>"/fotos/fiestas",
            "Escuelas"=>"/fotos/escuelas",
        ))),
        array("spa"=>array("Eventos"=>"/eventos")),
        array("spa"=>array("Blog"=>"/blog")),
        array("spa"=>array("Lugares"=>"/lugares")),
    ),
    "cms"=>array(
        array("spa"=>array("Galleries"=>array("See all"=>"/happycms/galleries",
                                              "Nightclubs"=>"/happycms/galleries/nightclubs",
                                              "FTP"=>"/happycms/galleries/ftp"))),
        array("spa"=>array("Blog"=>"/happycms/blog")),
        array("spa"=>array("Events"=>"/happycms/events")),
        array("spa"=>array("Places"=>array("See all"=>"/happycms/places","Places Types"=>"/happycms/places/places-types"))),
        array("spa"=>array("QTV Users"=>"/happycms/qtv-users")),
        array("spa"=>array("Ads"=>array("See all"=>"/happycms/ads",
                                        "Clients"=>"/happycms/ads/clients",
                                        "Reports"=>"/happycms/ads/reports"))),
        array("spa"=>array("Themes"=>"/happycms/themes"))        
    )
);

?>
