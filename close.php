<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

$_SESSION = array();
setcookie("pass_sabrosus_cookie","",time()-1);
unset($_COOKIE[session_name()]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
	<head>
	<title><?=__("terminar sesi&oacute;n");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="refresh" content="3;URL=index.php" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>
<body>
	<div id="pagina">
		<div id="titulo">
			<h2>sabros.us/<span><?=__("terminar sesi&oacute;n");?></span></h2>
		</div>
		<div id="contenido">
			<? if (session_destroy()) { ?>
				<h3><?=__("Terminando sesi&oacute;n...");?></h3>
			<? } else { ?>
				<h3><?=__("Ha ocurrido un error.");?></h3>
			<? } ?>
		</div>
	</div>
	</body>
</html>
