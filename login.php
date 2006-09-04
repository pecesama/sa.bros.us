<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if (esAdmin()) {
	header("Location: cpanel.php");
}

if ((isset($_POST["pass"]) && md5($_POST["pass"])==$Sabrosus->adminPass)) {
	$_SESSION["sabrosus"]["usuario"]="Si";
		if (isset($_POST['guardar_pass'])) {
			// Asigna el valor de una semana a las cookie del password
			$cookie_vida = 7*24*3600;
			setcookie("pass_sabrosus_cookie",md5($_POST["pass"]),time()+$cookie_vida);
	}
	if (isset($_POST['dirigir'])) {
		header("Location: ".urldecode($_POST['dirigir']));
	} else {
		header("Location: cpanel.php");
	}
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("ingreso");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>
<body onload="document.valida.pass.focus();">
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=__("ingreso");?></span></h2>
	</div>
	<div id="contenido">
		<div id="formulario">
			<form action="login.php" method="post" name="valida">
				<fieldset>
					<legend><?=__("Introduzca su contrase&ntilde;a");?></legend>
					<label><?=__("Contrase&ntilde;a:");?></label>
					<input class="input_rojo" name="pass" type="password" /><br />
					<input name="guardar_pass" type="checkbox" /> <label><?=__("guardar contrase&ntilde;a");?></label><br />
					<? if (isset($_GET['dirigir']) || isset($_POST['dirigir'])) { ?>
						<input class="no_style" type="hidden" name="dirigir" value="<?=urlencode(isset($_GET['dirigir']) ? $_GET['dirigir'] : $_POST['dirigir']);?>" />
					<? } ?>
					<p><a href="recordar.php" title="<?=__("&iquest;Olvidaste tu contrase&ntilde;a?");?>"><?=__("&iquest;olvidaste tu contrase&ntilde;a?");?></a></p>
					<input class="submit" name="btnEntrar" type="submit" value="<?=__("ingresar");?>" />

				</fieldset>
			</form>
		</div>
	</div>
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
	</div>
</div>
</body>
</html>
<?
}
?>
