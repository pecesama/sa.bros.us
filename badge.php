<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

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
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus WHERE (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT $limite" : "SELECT * FROM ".$prefix."sabrosus WHERE (tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag') AND (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT $limite");
		$result = mysql_query($sqlStr);
		
		echo "document.write(\"<div id='mi_sabrosus'>\");\n";
		echo "	document.write(\"<strong>".__("Mi sabros.us")."</strong><br />\");\n";
		echo "	document.write(\"<ul>\");\n";
		while ($row = mysql_fetch_array($result))
		{
			$row["descripcion"]=eregi_replace(chr(13)," ",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\n"," ",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\"","",$row["descripcion"]);
			$row["descripcion"]=eregi_replace("\'","",$row["descripcion"]);
			$row["descripcion"]=utf8_decode($row["descripcion"]);
			$row["title"]=utf8_decode($row["title"]);
			if ($Sabrosus->desc_badge=="1") {
				echo "          document.write(\"<li><a title='".strip_tags($row["descripcion"])."' href='".$row["enlace"]."'>".htmlentities($row["title"])."</a><ul><li>".htmlentities($row["descripcion"])."</li></ul></li>\");\n";				
			} else {
				echo "		document.write(\"<li><a title='".strip_tags($row["descripcion"])."' href='".$row["enlace"]."'>".htmlentities($row["title"])."</a></li>\");\n";
			}
		}
		echo "		document.write(\"<li>".__("M&aacute;s en")."<a title='".__("Mi sabros.us")."' href='".$Sabrosus->sabrUrl."'>".strtolower(__("Mi sabros.us"))."</a></li>\");\n";
		echo "	document.write(\"</ul>\");\n";
		echo "document.write(\"</div>\");\n";	
	}	
?>
