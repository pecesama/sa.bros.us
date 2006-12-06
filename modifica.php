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
	$etiquetas = $_POST["etiquetas"];
		$privado = (isset($_POST["privado"]))? 1 : 0;
	$Sql="UPDATE ".$prefix."sabrosus SET title='".$_POST["title"]."',  enlace='".$_POST["enlace"]."', descripcion='".$_POST["descripcion"]."', privado='".$privado."' WHERE (id_enlace=".$_POST["id_enlace"].") LIMIT 1";
	mysql_query($Sql,$link);
	$tags = new tags;
	$tags->deleteLinkTags($_POST['id_enlace']);
	$tags->addTags($etiquetas, $_POST['id_enlace']);
	header("Location: cpanel.php");
	exit();
} else {
	header("Location: index.php");
	exit();
}
?>
