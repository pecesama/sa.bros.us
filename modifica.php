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

if($_SERVER["REQUEST_METHOD"]=="POST") {
	$etiquetas = normalizeTags($_POST["etiquetas"]);
	if (isset($_POST["privado"])) {
		$etiquetas = ":sab:privado ".$etiquetas;
	}
	$Sql="UPDATE ".$prefix."sabrosus SET title='".$_POST["title"]."', tags='".$etiquetas."', enlace='".$_POST["enlace"]."', descripcion='".$_POST["descripcion"]."' WHERE (id_enlace=".$_POST["id_enlace"].") LIMIT 1";
	mysql_query($Sql,$link);
	header("Location: cpanel.php");
	exit();
} else {
	header("Location: index.php");
	exit();
}
?>
