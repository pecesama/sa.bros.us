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
	exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
	$etiquetas = normalizeTags($_POST["etiquetas"]);
	if (isset($_POST["privado"])) {
		$etiquetas = ":sab:privado ".$etiquetas;
	}
	$Sql="UPDATE ".$prefix."sabrosus SET title='".$_POST["title"]."', tags='".$etiquetas."', enlace='".$_POST["enlace"]."', descripcion='".$_POST["descripcion"]."' where id_enlace=".$_POST["id_enlace"];
	mysql_query($Sql,$link);
	header("Location: cpanel.php");
} else {
	header("Location: index.php");
}
?>
