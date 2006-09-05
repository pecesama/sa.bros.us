<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("include/tags.php");

	header("Content-type: application/x-javascript");
	echo "document.write(\"<div id='badgetags'>\");\n";
	echo "document.write(\"<p><strong>".__("Mis etiquetas en sa.bro.sus")."</strong></p>\");\n";

	$max_font = (isset($_GET['max']) && eregi("^[0-9]+$",$_GET['max']))? $_GET['max'] : 25;
	$min_font = (isset($_GET['min']) && eregi("^[0-9]+$",$_GET['min']))? $_GET['min'] : 10;

	getTags("badge", $max_font, $min_font);

	echo "document.write(\"</div> \");\n";
?>
