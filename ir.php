<?
/* ===========================

  sabrosus monousuario versi�n 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	
	if(isset($_GET[id])&&is_numeric($_GET[id]))
	{
		$sql = "SELECT enlace FROM ".$prefix."sabrosus WHERE id_enlace=".$_GET[id]." LIMIT 1";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		if($row)
		{
			$enlace = $row[enlace];
			header("Location: ".$enlace);
		} else {
			header("Location: index.php");
		}
	} else {
		header("Location: index.php");
	}
?>