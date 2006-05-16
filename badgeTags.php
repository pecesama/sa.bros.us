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

	header("Content-type: application/x-javascript" );
	echo "document.write(\"<div id='badgetags'> \");\n";
	echo "document.write(\"<strong>".$idioma[mis_etiquetas]."</strong><br />\");\n";

	$max_font = 25;
	$min_font = 10;
	$kw = array();
	$keys = array();
	$result = mysql_query("select tags from ".$prefix."sabrosus where tags <> ''");
	while ($row = mysql_fetch_array($result))
	{
		/* Solucionado si hoy 2 espacios entre tags */
		$art_keys = str_replace("  "," ",$row['tags']);
		$art_keys = explode(" ",trim($art_keys));
		foreach($art_keys as $key){
			if(isset($kw[$key])){
				$kw[$key]++;
			}else{
				$kw[$key] = 1;
				$keys[count($keys)] = $key;
			}
		}
	}
	//solucionado el problema para cuando no hay tags.
	if($keys){
		//se ordena alfabeticamente el arreglo de nombres de llaves
		sort($keys);
		//se determina la maxima y minima repeticion de tags
		$max = max($kw);
		$min = min($kw);
		//se determina el paso de cada fuente
		 if($max!=$min){
			$step = round(($max_font - $min_font)/($max - $min),4);
		}else{
			$step=1;
		}
		$i = 0;
		echo "document.write('<span class=\"link_tags\">')\n";
		foreach($keys as $key){
			$size = (($kw[$key] - $min)*$step) + $min_font;
	        echo ("document.write ('".chequearURLFriendly('<a title="'.$kw[$key].$idioma[enlaces_con_etiqueta].'" style="font-size:'.$size.'px" href="'.$Sabrosus->sabrUrl.'/tag/'.$key.'">'.$key.'</a>','<a title="'.$kw[$key].$idioma[enlaces_con_etiqueta].'" style="font-size:'.$size.'px" href="'.$Sabrosus->sabrUrl.'/index.php?tag='.$key.'">'.$key.'</a> ')."');\n");
		}
	    echo "document.write('</span>')\n";
	}
	echo "document.write(\"</div> \");\n";
?>