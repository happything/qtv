# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.37)
# Database: quetevalga
# Generation Time: 2013-01-05 01:55:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table areas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `areas`;

CREATE TABLE `areas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `subtitle` text,
  `content` longtext,
  `sections_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;

INSERT INTO `areas` (`id`, `title`, `subtitle`, `content`, `sections_id`)
VALUES
	(1,'HEADER',', Grupo Premier y iFix!','<p>Te regalan un iPhone 5 este Halloween.</p>',1),
	(2,'INDEX','Gánate un iPod 5 | Grupo Premiere + Quetevalga.com','<p>G&aacute;nate un iPod 5 | Grupo Premiere + Quetevalga.com</p>',1),
	(3,'INDEX','¡GÁNATELO!','<p>&iexcl;G&Aacute;NATELO!</p>',1),
	(4,'INDEX','iPhone 5','<p>iPhone 5</p>',1),
	(5,'INDEX','www.apple.com/mx/iphone/','<p>www.apple.com/mx/iphone/</p>',1),
	(6,'INDEX','Lo más grande que le pasó al iPhone desde, el iPhone.','<p>Lo m&aacute;s grande que le pas&oacute; al iPhone desde, el iPhone.</p>',1),
	(7,'INDEX','¡Ser un monstruo este Halloween puede traerte un iPhone 5!','<p>&iexcl;Ser un monstruo este Halloween puede traerte un iPhone 5!</p>',1),
	(8,'INDEX','¿En que consiste?','<p>Asiste a cualquiera de las fiestas de Halloween en Culiac&aacute;n y busca a alguno de nuestros fot&oacute;grafos, pideles que te tomen una&nbsp;foto y espera a que se publique en Quetevalga.com.</p>\n<p>Cuando tu fotografia sea publicada, da clic en el boton \"Participar por el iPhone 5\" y LISTO. Invita a todos tus amigos a votar por ti para que consigas este maravilloso gadget.</p>',1),
	(9,'INDEX','Nota','<p>* Nota: Para participar, tienes que aparecer en la foto, deber&aacute;s utilizar tu disfraz al recoger el premio, en fotos con m&uacute;ltiples personas, el ganador es el que registre la foto dentro de la aplicaci&oacute;n.</p>',1),
	(10,'INDEX','¿Dudas?','<p>Para dudas o aclaraciones env&iacute;anos un inbox a nuestra fanpage.</p>',1),
	(11,'VOTA','Busca a tu amigo','<p>Por aqui posiblemente esta alguno de tus amigos asi que, &iquest;Porqu&eacute; no los buscas y le regalas un voto?</p>',1),
	(12,'VOTA','Tú tambien puedes estar participando.','<p>T&uacute; tambien puedes estar participando. Solo da clic al bot&oacute;n de abajo y busca tu foto de halloween en el sitio web de quetevalga.com.</p>',1),
	(13,'RANKING','Y así van las cosas hasta ahorita.','<p>Y as&iacute; van las cosas hasta ahorita.</p>',1),
	(14,'RANKING','Tú tambien puedes estar participando.','<p>T&uacute; tambien puedes estar participando. Solo da clic al bot&oacute;n de abajo y busca tu foto de halloween en el sitio web de quetevalga.com.</p>',1),
	(15,'CONDICIONES','Estas son las reglas y condiciones de uso de la aplicación. Deben cumplirse al pie de la letra.','<ul>\n<li>El concurso termina el 5 de Noviembre del 2012 a las 00hrs.</li>\n<li>Para ganar el iPhone 5, se deben conseguir el mayor n&uacute;mero de votos posibles.</li>\n<li>No intentes hacer trampa o ser&aacute;s descalificado de la aplicaci&oacute;n inmediatamente. Mejor, usa esa energ&iacute;a para juntar m&aacute;s votos.</li>\n<li>Ser&aacute; concider&aacute;do trampa comprar votos por cualquier medio.</li>\n</ul>',1),
	(16,'CONDICIONES','Tú tambien puedes estar participando.','<p>T&uacute; tambien puedes estar participando. Solo da clic al bot&oacute;n de abajo y busca tu foto de halloween en el sitio web de quetevalga.com.</p>',1);

/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
