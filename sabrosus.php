<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);
?>	
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("&iquest;Qu&eacute; es sa.bros.us?");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?=$Sabrosus->sabrUrl?>/rss.php" />

</head>
<body>

<div id="pagina">

	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("&iquest;Qu&eacute; es sa.bros.us?");?></span></h2>
		<p class="submenu_derecho">
		<a title="<?=__("Inicio Sa.bros.us");?>" href="<?=$Sabrosus->sabrUrl?>"><?=__("Regresar a sa.bros.us");?></a>
		</p>
	</div>

	<div id="contenido">
		<p><?=__("sa.bros.us es un sistema para organizar los bookmarks o enlaces favoritos que insertas en tu sitio web. Al igual que con el servicio del.icio.us puedes gestionar bookmarks, pero a trav&eacute;s de p&aacute;ginas alojadas en otro servidor, con sa.bros.us haces lo mismo pero las p&aacute;ginas est&aacute;n en tu propio sitio web.");?></p>
		<p>&nbsp;</p>
		<p><?=__("El proyecto sa.bros.us es 'Open Source' (puedes utilizar y modificar el c&oacute;digo libremente) y funciona con PHP y MySQL. La p&aacute;gina oficial del proyecto es <a href=\"http://sabrosus.sourceforge.net/\" title=\"Sa.bros.us\">esta</a> y te lo puedes descargar desde <a href=\"https://sourceforge.net/projects/sabrosus/\" title=\"Proyecto sa.bros.us\">SourceForge.net</a>.");?></p>
		<p>&nbsp;</p>
		<p><?=__("El proyecto fue iniciado por <a href=\"http://www.stanmx.com/\" title=\"StanMX\">Estanislao Vizcarra</a> y por <a href=\"http://www.pecesama.net/\" title=\"Pedro Santana\">Pedro Santana</a> en 2005, y adem&aacute;s cuenta con la colaboraci&oacute;n de <a href=\"https://sourceforge.net/project/memberlist.php?group_id=143603\" title=\"Equipo de sa.bros.us\">otros miembros</a>.");?></p>
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
		:: <?=__("Es 'Open Source'.");?><br />
		</p>
	</div>
	
	<div id="pie">
		<p class="powered"><?=__("Generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">Sa.bros.us</a></p>
		<p><a href="<?=$Sabrosus->sabrUrl.chequearURLFriendly('rss','rss.php')?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de sa.bros.us");?>" title="<?=__("RSS de sa.bros.us");?>" /></a></p>
	</div>
</div>
</body>
</html>
