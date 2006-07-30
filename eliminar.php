<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	if (!esAdmin()) {
		header("Location: login.php");
	} else {

		// $_GET['id'] must be set, and must be a number
		if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			header("Location: cpanel.php");
		}

		if (isset($_GET['confirm']) && $_GET['confirm']=='0') {
			$Sql="DELETE FROM ".$prefix."sabrosus WHERE id_enlace=".$_GET['id'];
			mysql_query($Sql,$link);
			header("Location: cpanel.php");
		} else {
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("eliminar enlace");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("eliminar enlace");?></span></h2>
		<p class="submenu"><a href="cpanel.php"><?=__("panel de control");?></a></p>
	</div>

	<div id="contenido">
		<div id="formulario">
			<form method="get" action="eliminar.php">
				<p><?=__("&iquest;Realmente desea eliminar este enlace de su sa.bros.us?");?></p>
				<p><?=__("Esta acci&oacute;n no se puede deshacer!");?></p>
				<input type="hidden" class="no_style" name="confirm" value="0" />
				<input type="hidden" class="no_style" name="id" value="<?=$_GET['id'];?>" />
				<input class="submit" type="submit" name="accion" value="<?=__("eliminar");?>" />
			</form>
		</div>
	</div>

	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>

<?
		} //end confirmation
	} //esAdmin
?>
