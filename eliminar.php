<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?
	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);

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
<!-- Sa.bros.us monousuario version 1.7 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[eli_eliminar_enlace];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us 1.7" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[eli_eliminar_enlace];?></span></h2>
		<p class="submenu"><a href="cpanel.php"><?=$idioma[panel_control];?></a></p>
	</div>

	<div id="contenido">
		<div id="formulario">
			<form method="get" action="eliminar.php">
				<p><?=$idioma[eli_desea_eliminar1];?></p>
				<p><?=$idioma[eli_desea_eliminar2];?></p>
				<input type="hidden" class="no_style" name="confirm" value="0" />
				<input type="hidden" class="no_style" name="id" value="<?=$_GET['id'];?>" />
				<input class="submit" type="submit" name="accion" value="<?=$idioma[eliminar];?>" />
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
		} //end confirmation 
	} //esAdmin
?>
