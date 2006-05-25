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
echo "document.write(\"<div id='badgetags'> \");\n";
	echo "document.write(\"<p><strong>".$idioma[mis_etiquetas]."</strong></p>\");\n";
	$max_font = (isset($_GET['max']) && eregi("^[0-9]+$",$_GET['max']))? $_GET['max'] : 25;
	$min_font = (isset($_GET['min']) && eregi("^[0-9]+$",$_GET['min']))? $_GET['min'] : 10;
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
		$prop = 255 / $max;
		//se determina el paso de cada fuente
		 if($max!=$min){
			$step = round(($max_font - $min_font)/($max - $min),4);
		}else{
			$step=1;
		}
		$i = 0;
		echo "document.write(\"<ol>\");\n";
		foreach($keys as $key){
		
					/*  color tags */
			$colores[0][r] = 0.1;
			$colores[0][g] = 2;
			$colores[0][b] = 4;
		
			$colores[1][r] = 8;
			$colores[1][g] = 2;
			$colores[1][b] = 0.8;
		
			$colores[2][r] = 5;
			$colores[2][g] = 1.6;
			$colores[2][b] = 5;
		
			$colores[3][r] = 1;
			$colores[3][g] = 5.5;
			$colores[3][b] = 5.5;
		
			$colores[4][r] = 1.5;
			$colores[4][g] = 1.5;
			$colores[4][b] = 1.5;
		
			$colores[5][r] = (rand(5,40)) / 10;
			$colores[5][g] = (rand(5,40)) / 10;
			$colores[5][b] = (rand(5,40)) / 10;
		
			$selectedColor = (isset($_GET['color']) && eregi("^[0-9]+$",$_GET['color']))? $_GET['color'] : 0;
		
			$color = round(255 - ($prop * $kw[$key]),0);
			$r = round(($color/$colores[$selectedColor][r]),0);
			$g = round(($color/$colores[$selectedColor][g]),0);
			$b = round(($color/$colores[$selectedColor][b]),0);
		
			$r = ($r>215)? 215 : $r;
			$g = ($g>215)? 215 : $g;
			$b = ($b>215)? 215 : $b;
		
			/* color tags */

		
			$size = round((($kw[$key] - $min)*$step) + $min_font,0);
			echo "document.write (\"<li><a title='".$kw[$key].$idioma[enlaces_con_etiqueta]."' style='font-size:".$size."px; color:rgb(".$r.",".$g.",".$b.");' href='".$Sabrosus->sabrUrl.chequearURLFriendly('/tag/','/index.php?tag=').$key."'>".$key."</a></li> \");\n";
		}	    
		echo "document.write(\"</ol>\");\n";
	}
	echo "document.write(\"</div> \");\n";
?>