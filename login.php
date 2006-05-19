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

if(esAdmin()){
	header("Location: cpanel.php");
}

if ((isset($_POST["pass"]) && md5($_POST["pass"])==$Sabrosus->adminPass))
{  
    $_SESSION["sabrosus"]["usuario"]="Si";
	if (isset($_POST['guardar_pass']))
	{
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
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[login];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[login];?></span></h2>
	</div>
	<div id="contenido">
		<div id="formulario">
			<form action="login.php" method="post" name="valida">
				<fieldset>
					<legend><?=$idioma[intro_pass];?></legend>
					<label><?=$idioma[pass];?></label>
					<input class="input_rojo" name="pass" type="password" /><br />
					<input name="guardar_pass" type="checkbox" /> <label><?=$idioma[guardar_pass];?></label><br />
					<? if (isset($_GET['dirigir']) || isset($_POST['dirigir'])) { ?>
						<input type="hidden" name="dirigir" value="<?=urlencode(isset($_GET['dirigir']) ? $_GET['dirigir'] : $_POST['dirigir']);?>" />
					<? } ?>
					<p><a href="recordar.php" title="<?=$idioma[log_recordar]?>"><?=$idioma[log_recordar]?></a></p>
					<input class="submit" name="btnEntrar" type="submit" value="<?=$idioma[ingresar];?>" />
					
				</fieldset>
			</form>		
		</div>	
	</div>
	<div id="pie">
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>
<?
}
?>
