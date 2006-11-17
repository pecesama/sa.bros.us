<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	if (!esAdmin()) {
		header("Location: login.php");
		exit();
	}
	// $_GET['id'] must be set, and must be a number
	if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		header("Location: cpanel.php");
		exit();
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
	<title><?=__("eliminar enlace");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=__("eliminar enlace");?></span></h2>
		<p class="submenu"><a href="cpanel.php"><?=__("panel de control");?></a></p>
	</div>

	<div id="contenido">
		<div id="formulario">
			<form method="get" action="eliminar.php">
				<p><?=__("&iquest;Realmente desea eliminar este enlace de su sabros.us?");?></p>
				<p><?=__("Esta acci&oacute;n no se puede deshacer!");?></p>
				<input type="hidden" class="no_style" name="confirm" value="0" />
				<input type="hidden" class="no_style" name="id" value="<?=$_GET['id'];?>" />
				<input class="submit" type="submit" name="accion" value="<?=__("eliminar");?>" />
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
	} //end confirmation
?>
