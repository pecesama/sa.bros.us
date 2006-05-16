<?
/* ===========================

  sabrosus monousuario versión 1.6
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?	
	session_start();
	include("include/config.php");
	include("include/conex.php");	
    include("lang/".$Sabrosus->archivoIdioma);
	$_SESSION = array();
	setcookie("pass_sabrosus_cookie","",time()-1);
	unset($_COOKIE[session_name()]);	
	if (session_destroy())
	{
?>
<!-- Sa.bros.us monousuario version 1.6 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[terminar_sesion];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us 1.5" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<meta http-equiv="refresh" content="3;URL=index.php" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[terminar_sesion];?></span></h2>
	</div>

	<div id="contenido">
		<h3><?=$idioma[terminando_sesion];?></h3>
<?
	} else {
?>
		<h3><?=$idioma[ocurrio_error];?></h3>
<?	}	?> 
	</div>
</div>
</body>
</html>
