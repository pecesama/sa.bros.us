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
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
	$titulo = htmlentities($_POST["title"]);
	$enlace = $_POST["enlace"];
	if (isset($_POST["privado"])) {
		$etiquetas = ":sab:privado ".$_POST["etiquetas"];
	} else {
		$etiquetas = $_POST["etiquetas"];
	}
	if(!isInSabrosus($enlace)) {
		$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha) values ('".$titulo."','".$etiquetas."','".$enlace."','".$_POST["descripcion"]."', now())";
		mysql_query($Sql,$link);
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
