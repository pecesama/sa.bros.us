<?
/* ===========================

  sabrosus monousuario versión 1.6
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?php
	include("include/config.php");
	include("include/conex.php");		
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);

	header("Content-type: text/xml; charset=utf-8");
	echo "<?xml version=\"1.0\""." encoding=\"".$idioma[codificacion]."\"?>\n";

 	/* PATCH Bug #1242025 */
	if (isset($_GET["tag"]))
	{
		$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		if (stristr($navegador, "opera") || stristr($navegador, "msie"))
			/* PATCH Bug #1359231 */
    		$tagtag=$_GET["tag"];
			if (isset($tagtag)) {
    			$tagtag = utf8_decode($_GET["tag"]);
    		}
    		/* End PATCH Bug #1359231 */
		else
			$tagtag = $_GET["tag"];
	}
	/* End PATCH Bug #1242025 */

	if(isset($cuantos))
	{
		//Parametro $cuantos=todos para que devuelvas una sindicación completa de Sabrosus.
		if($cuantos=='todos')
			$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC " : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC");		
		else
			$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit $cuantos" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit $cuantos");
	} else {
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit 10" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit 10");
	}
	$result = mysql_query($sqlStr,$link);	

	echo "<rss version=\"2.0\">\n";
	echo "	<channel>\n";
	echo "		<title>sa.bros.us/".$Sabrosus->siteName."</title>\n";
	echo "		<link>".$Sabrosus->sabrUrl."</link>\n";
	echo "		<description>".$idioma[enlaces_de]." ".$Sabrosus->siteName."</description>\n";
	echo "		<language>".$idioma[nombre_estandar]."</language>\n";
	echo "		<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
	echo "		<generator>Sa.bros.us v1.6</generator>\n";
	echo "		<image>\n";
	echo "			<url>".$Sabrosus->sabrUrl."/images/sabrosus_icon.png</url>\n";
	echo "			<title>".$idioma[enlaces_de]." ".$Sabrosus->siteName."</title>\n";
	echo "			<link>".$Sabrosus->sabrUrl."</link>\n";
	echo "		</image>\n";
	while ($registro = mysql_fetch_array($result))
	{
		$titulo=limpiaHTML($registro["title"]);			
		$desc=limpiaHTML($registro["descripcion"]);
		$tags=limpiaHTML($registro["tags"]);
		$url=limpiaHTML($registro["enlace"]);
		
		$fecha = gmdate("D, d M Y H:i:s \G\M\T", strtotime($registro["fecha"]));
		
		/* Control de Enlaces Privados */
		$privado=false;
		$etiquetas = explode(" ",$tags);
		foreach($etiquetas as $etiqueta){
			if ($etiqueta==":sab:privado") { 
				$privado=true;
			}
		}
		if(!$privado)
		{
			echo "		  <item>\n";
			echo "			 <title>".$titulo."</title>\n";
			echo "		     <link>".$url."</link>\n";
			echo "		     <description>".$desc."</description>\n";
			echo "		     <pubDate>".$fecha."</pubDate>\n";
			echo "			 <category>".$tags."</category>\n";
			echo "           <guid isPermaLink=\"true\">".$Sabrosus->sabrUrl . "/ir.php?id=" . $registro['id_enlace'] ."</guid>";
			echo "		  </item>\n";
		}
	}
	echo "	</channel>";
	echo "</rss>";
?>
