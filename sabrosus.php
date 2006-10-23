<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("&iquest;qu&eacute; es sabros.us?");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?=$Sabrosus->sabrUrl?>/rss.php" />

</head>
<body>

<div id="pagina">

	<div id="titulo">
		<h2>sabros.us/<span><?=__("&iquest;qu&eacute; es sabros.us?");?></span></h2>
		<p class="submenu_derecho">
		<a title="<?=__("inicio sabros.us");?>" href="<?=$Sabrosus->sabrUrl?>"><?=__("regresar a sabros.us");?></a>
		</p>
	</div>

	<div id="contenido">
		<p><?=__("sabros.us es un sistema para organizar los bookmarks o enlaces favoritos que insertas en tu sitio web. Al igual que con el servicio del.icio.us puedes gestionar bookmarks, pero a trav&eacute;s de p&aacute;ginas alojadas en otro servidor, con sabros.us haces lo mismo pero las p&aacute;ginas est&aacute;n en tu propio sitio web.");?></p>
		<p>&nbsp;</p>
		<p><?=__("El proyecto sabros.us es 'open source' (puedes utilizar y modificar el c&oacute;digo libremente) y funciona con PHP y MySQL. La p&aacute;gina oficial del proyecto es <a href=\"http://sabros.us/\" title=\"sabros.us\">esta</a> y te lo puedes descargar desde <a href=\"http://sourceforge.net/projects/sabrosus/\" title=\"proyecto sabros.us\">SourceForge.net</a>.");?></p>
		<p>&nbsp;</p>
		<p><?=__("El proyecto fue iniciado por <a href=\"http://www.stanmx.com/\" title=\"StanMX\">Estanislao Vizcarra</a> y por <a href=\"http://www.pecesama.net/\" title=\"Pedro Santana\">Pedro Santana</a> en 2005, y adem&aacute;s cuenta con la colaboraci&oacute;n de <a href=\"http://sourceforge.net/project/memberlist.php?group_id=143603\" title=\"equipo de sabros.us\">otros miembros</a>.");?></p>
		<p>&nbsp;</p>
		<p><strong><?=__("FUNCIONALIDADES:");?></strong></p>
		<p>
		:: <?=__("Permite gestionar los bookmarks a trav&eacute;s de un panel de control.");?><br />
		:: <?=__("Permite crear bookmarks r&aacute;pidamente mediante un bot&oacute;n que se puede a&ntilde;adir a tu navegador.");?><br />
		:: <?=__("Permite insertar 'tags' de cada bookmark, para que posteriormente pueda servir de ayuda para encontrar otros bookmarks de la misma tem&aacute;tica.");?><br />
		:: <?=__("Permite crear un feed RSS de todos los bookmarks o de un tag en especial.");?><br />
		:: <?=__("Permite crear una 'nube de tags' de todas las etiquetas insertadas.");?><br />
		:: <?=__("Es sencillo y r&aacute;pido de instalar.");?><br />
		:: <?=__("Tiene un atractivo dise&ntilde;o.");?><br />
		:: <?=__("Es 'open source'.");?><br />
		</p>
	</div>
	
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
		<p><a href="<?=$Sabrosus->sabrUrl.chequearURLFriendly('rss','rss.php')?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de sabros.us");?>" title="<?=__("RSS de sabros.us");?>" /></a></p>
	</div>
</div>
</body>
</html>
