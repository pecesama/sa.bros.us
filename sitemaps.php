<?
/* ===========================

  sabros.us monousuario versión 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)
  =========================== */
?>
<?

	/*
	Este archivo, debería ir junto al panel de control.
	Debería generar un archivo aparte .xml que pueda acceder google tranquilamente.
	¿Es necesario que esté en el raiz del sitio general, o puede estar dentro de la carpeta de sabros.us?
	*/
	
	/* EDITABLE */
	/* Estos datos podrían ir en el config.ini despues */
	$_maxPriority = 0.8;
	$_minPriority = 0.3;
	
	/* NO EDITABLE */
	$dif_abs = $_maxPriority - $_minPriority;	

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	$result = mysql_query("SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC LIMIT 1",$link);
	$principal = mysql_fetch_array($result);

	function cambiar_fecha($timestamp)
	{
		$fecha = str_replace(" ","T",$timestamp)."+00:00";
		return $fecha;
	}
	
	header("Content-type: text/xml; charset=utf-8");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?".">\n";
	echo "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
	echo "  <!-- Debug: Pagina principal -->\n";
	echo "	<url>\n";
	echo "		<loc>".$Sabrosus->sabrUrl."/</loc>\n";
	echo "		<lastmod>".cambiar_fecha($principal[fecha])."</lastmod>\n";
	echo "		<changefreq>daily</changefreq>\n";
	echo "		<priority>1</priority>\n";
	echo "	</url>\n";

	echo "  <!-- Debug: Empiezan los tags -->\n";
	
	$kw = array();
	$keys = array();
	$result = mysql_query("SELECT tags FROM ".$prefix."sabrosus WHERE tags NOT LIKE '%:sab:privado%'");
	while ($row = mysql_fetch_array($result))
	{
		/* Solucionado si hoy 2 espacios entre tags */
		$art_keys = str_replace("  "," ",$row['tags']);
		$art_keys = explode(" ",trim($art_keys));
		foreach($art_keys as $key)
		{
			if(isset($kw[$key]))
			{
				$kw[$key]++;
			} 
			else 
			{
				$kw[$key] = 1;
				$keys[count($keys)] = $key;
			}
		}
	}
	if($keys)
	{
		$total_tags = count($keys);
		sort($keys);
		foreach($keys as $key)
		{
			$sql_tag = "SELECT fecha FROM ".$prefix."sabrosus WHERE (tags LIKE '% $key %' OR tags LIKE '$key %' OR tags LIKE '% $key' OR tags = '$key') AND (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT 1";
			$result_tag = mysql_query($sql_tag,$link);
			$fetch_tag = mysql_fetch_array($result_tag);
			
			/* Formula para determinar la importancia entre tags */	
			/* Devuelve el numero de imporancia del tag entre el $_minPriority y $_maxPriority */
			$porc_real = ($kw[$key]*100)/$total_tags; 
			$prioridad = round((($porc_real*$dif_abs)/100)+$_minPriority,1);
			
			echo "	<!-- Debug: Tag: ".$key.". Repeticion: ".$kw[$key]." / ".$total_tags." -->\n";
			echo "	<url>\n";
			echo "		<loc>".$Sabrosus->sabrUrl."/".chequearURLFriendly('tag/','index.php?tag=').urlencode(trim($key))."</loc>\n";
			echo "		<lastmod>".cambiar_fecha($fetch_tag['fecha'])."</lastmod>\n";
			echo "		<changefreq>daily</changefreq>\n";
			echo "		<priority>".$prioridad."</priority>\n";
			echo "	</url>\n";
		}
	}
	echo "  <!-- Debug: Finalizan los tags -->\n";
	echo "</urlset>\n";
?>
