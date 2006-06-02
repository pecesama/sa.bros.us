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

if (!esAdmin()) {
	header("Location: login.php");
	exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
	$titulo = htmlentities($_POST["title"]);
	$enlace = $_POST["enlace"];
	$etiquetas = normalizeTags($_POST["etiquetas"]);
	if (isset($_POST["privado"])) {
		$etiquetas = ":sab:privado ".$etiquetas;
	}
	if(!isInSabrosus($enlace)) {
		$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha) values ('".$titulo."','".$etiquetas."','".$enlace."','".$_POST["descripcion"]."', now())";
		mysql_query($Sql,$link);
	} else {
		// Link already exist in the DB, so let user edit that link.
		$sql = "SELECT id_enlace FROM ".$prefix."sabrosus WHERE enlace='".$enlace."' LIMIT 1";
		$result = mysql_query($sql, $link);
		$en = mysql_fetch_array($result);
		header("Location: editar.php?id=".$en['id_enlace']);
		die();
	}
	if (isset($_POST["regresa"])) {
		$url="Location: ".urldecode($_POST["regresa"]);
		header($url);
	} else {
		header("Location: cpanel.php");
	}
} else {
	header("Location: index.php");
}
?>
