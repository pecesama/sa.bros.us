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
	$titulo = htmlspecialchars($_POST["title"]);
	$enlace = $_POST["enlace"];
	$descripcion = $_POST["descripcion"];
	$etiquetas = normalizeTags($_POST["etiquetas"]);
	if (isset($_POST["privado"])) {
		$etiquetas = ":sab:privado ".$etiquetas;
	}else{
		if($Sabrosus->ping){
			include("sopa_ping.php");
		}
	}
	
	
	
	if(!isInSabrosus($enlace)) {
		$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha) values ('".$titulo."','".$etiquetas."','".$enlace."','".$descripcion."', now())";
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
