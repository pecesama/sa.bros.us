<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");
include("include/tags.class.php");


if (!esAdmin()) {
	header("Location: login.php");
	exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST") {
	$titulo = htmlspecialchars($_POST["title"]);
	$enlace = $_POST["enlace"];
	$descripcion = $_POST["descripcion"];
	$etiquetas = $_POST["etiquetas"];
	$privado = 0;
	if (isset($_POST["privado"])) {
		$privado = 1;
	}else{
		if($Sabrosus->ping=="1"){
			include("sopa_ping.php");
		}
	}
	
	
	
	if(!isInSabrosus($enlace)) {
		$Sql="insert into ".$prefix."sabrosus (title,enlace,descripcion,fecha,privado) values ('".$titulo."','".$enlace."','".$descripcion."', now(),".$privado.")";
		mysql_query($Sql,$link);
		$Sql = "SELECT LAST_INSERT_ID() as last_id";
		$res = mysql_query($Sql,$link);
		list($link_id) = mysql_fetch_array($res);
		$tags = new tags;
		$tags->addTags($etiquetas,$link_id);
	} else {
		// Link already exist in the DB, so let user edit that link.
		$sql = "SELECT id_enlace FROM ".$prefix."sabrosus WHERE enlace='".$enlace."' LIMIT 1";
		$result = mysql_query($sql, $link);
		$en = mysql_fetch_array($result);
		header("Location: editar.php?id=".$en['id_enlace']);
		exit();
	}
	if (isset($_POST["regresa"])) {
		$url="Location: ".urldecode($_POST["regresa"]);
		header($url);
		exit();
	} else {
		header("Location: cpanel.php");
		exit();
	}
} else {
	header("Location: index.php");
	exit();
}
?>
