<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>	
<?php
	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);
?>	
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[que_es];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?=$Sabrosus->sabrUrl?>/rss.php" />

</head>
<body>

<div id="pagina">

	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[que_es];?></span></h2>
		<p class="submenu_derecho">
		<a title="<?=$idioma[inicio_sabrosus]?>" href="<?=$Sabrosus->sabrUrl?>"><?=$idioma[regresar_a];?></a>
		</p>
	</div>

	<div id="contenido">
		<p><?=$idioma[sab_descripcion];?></p>
		<p>&nbsp;</p>
		<p><?=$idioma[proyecto_sab];?></p>
		<p>&nbsp;</p>
		<p><?=$idioma[creadores_sab];?></p>
		<p>&nbsp;</p>
		<p><strong><?=$idioma[funcionalidades];?></strong></p>
		<p>&nbsp;</p>
		:: <?=$idioma[func_1];?><br />
		:: <?=$idioma[func_2];?><br />
		:: <?=$idioma[func_3];?><br />
		:: <?=$idioma[func_4];?><br />
		:: <?=$idioma[func_5];?><br />
		:: <?=$idioma[func_6];?><br />
		:: <?=$idioma[func_7];?><br />
		:: <?=$idioma[func_8];?><br />
		:: <?=$idioma[func_9];?>
		</p>
	</div>
	
	<div id="pie">
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		<p><? echo chequearURLFriendly('<a href="'.$Sabrosus->sabrUrl.'/rss">','<a href="'.$Sabrosus->sabrUrl.'/rss.php">');?><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=$idioma[sabrosus_rss]?>" title="<?=$idioma[sabrosus_rss]?>" /></a></p>
	</div>
	
</div>
</body>
</html>
