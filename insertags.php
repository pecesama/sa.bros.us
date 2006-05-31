<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

if(esAdmin()){
	?>
	<div id="reltags">
	<?php
		$max_font = 25;
		$min_font = 10;
		$kw = array();
		$keys = array();
		$result = mysql_query("SELECT tags FROM ".$prefix."sabrosus WHERE tags <> ''");
		while ($row = mysql_fetch_array($result)){
			$art_keys = explode(" ",$row['tags']);
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
						/* color tags */ 
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
					
					 foreach($keys as $key){
					
					$colores[5][r] = (rand(5,40)) / 10; 
					$colores[5][g] = (rand(5,40)) / 10; 
					$colores[5][b] = (rand(5,40)) / 10; 
					 
					$selectedColor = $Sabrosus->tagsColor; 
					 
					$color = round(255 - ($prop * $kw[$key]),0); 
					$r = round(($color/$colores[$selectedColor][r]),0); 
					$g = round(($color/$colores[$selectedColor][g]),0); 
					$b = round(($color/$colores[$selectedColor][b]),0); 
					 
					$r = ($r>215)? 215 : $r; 
					$g = ($g>215)? 215 : $g; 
					$b = ($b>215)? 215 : $b; 
			
				if ($key!=":sab:privado") {
					$size = (($kw[$key] - $min)*$step) + $min_font;
					echo "<a style=\"font-size:".$size."px; color:rgb(".$r.",".$g.",".$b.");\" href=\"javascript:void(0)\" onclick=\"addTag('".$key."')\" title=\"".$idioma[click_tag]." '".$key."'\">".$key."</a> "; 
				}
			}
		}
	?>
	</div>
<?
}
?>