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

	header("Content-type: application/x-javascript" );
    /* PATCH Bug #1242025 */
	if (isset($_GET["tag"]))
	{
		$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		if (stristr($navegador, "opera") || stristr($navegador, "msie"))
		{
			/* PATCH Bug #1359231 */
    		$tagtag=$_GET["tag"];
			if (isset($tagtag)) {
    			$tagtag = utf8_decode($_GET["tag"]);
    		}
    		/* End PATCH Bug #1359231 */
		}
		else
		{
			$tagtag = $_GET["tag"];
		}
	}
	/* End PATCH Bug #1242025 */
	
	if (isset($_GET["cuantos"])) {		
		$limite=$_GET["cuantos"];
		$sqlStr = (!isset($tagtag) ? "select * from ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $limite" : "select * from ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC LIMIT $limite");
		$result = mysql_query($sqlStr);
		
		echo "document.write(\"<div id='mi_sabrosus'>\");\n";
		echo "	document.write(\"<strong>".$idioma[mi_sabrosus]."</strong><br />\");\n";
		while ($row = mysql_fetch_array($result))
		{
			$row["descripcion"]=eregi_replace(chr(13)," ",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\n"," ",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\"","",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\'","",$row["descripcion"]);
			echo "		document.write(\"<a title='".strip_tags($row["descripcion"])."' href='".$row["enlace"]."'>".htmlentities($row["title"])."</a><br />\");\n";			
			/* Si deseas incluir la descripcion en el badge descomenta esta linea siguiente y comenta la anterior. */
			//echo "          document.write(\"<a title='".strip_tags($row["descripcion"])."' href='".$row["enlace"]."'>".htmlentities($row["title"])."</a><br/>".htmlentities($row["descripcion"])."<br />\");\n";
		}
		echo "		document.write(\"".$idioma[ver_mas]."<a title='".$idioma[mi_sabrosus]."' href='".$Sabrosus->sabrUrl."'>".strtolower($idioma[mi_sabrosus])."</a><br /><br />\");\n";
		echo "document.write(\"</div>\");\n";	
	}	
?>
