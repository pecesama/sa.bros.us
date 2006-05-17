<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?
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
			foreach($keys as $key){
				if ($key!=":sab:privado") {
					$size = (($kw[$key] - $min)*$step) + $min_font;
					echo "<a style=\"font-size:".$size."px\" href=\"javascript:void(0)\" onclick=\"addTag('".$key."')\" title=\"".$idioma[click_tag]." '".$key."'\">".$key."</a> ";
				}
			}
		}
	?>
	</div>
<?
}
?>