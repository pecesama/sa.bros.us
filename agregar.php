<?
/* ===========================

  sabrosus monousuario versión 1.6
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?php
	include("include/config.php");
	include("include/functions.php");
	include("include/conex.php");

	if($_SERVER["REQUEST_METHOD"]=="POST") {
		if (esAdmin()) 
		{ 
 			$titulo = htmlentities($_POST["title"]);
			$enlace = $_POST["enlace"];
			if (isset($_POST["privado"])) {
				$etiquetas = ":sab:privado ".$_POST["etiquetas"];
			} else {
				$etiquetas = $_POST["etiquetas"];
			}
			if(!isInSabrosus($enlace))
			{
				$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha)  values ('".$titulo."','".$etiquetas."','".$enlace."','".$_POST["descripcion"]."', now())";
				mysql_query($Sql,$link);
			}
			if (isset($_POST["regresa"]))
			{
				$url="Location: ".urldecode($_POST["regresa"]);
				header($url);
			} else {
		   		header("Location: cpanel.php");
		   	}	
		} else {
			header("Location: login.php");
		}
	} else {
		header("Location: index.php");
	}	   
?>
