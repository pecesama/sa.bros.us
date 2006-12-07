<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

class tags
{
	function tags(){
	}
	
	function addTags($tags, $link_id){
		// Relaciona los tags con los enlaces, si los tags son nuevos los ingresa
		global $link, $prefix, $Sabrosus;
		$tagsArray = array();
		if(get_magic_quotes_gpc()){
			$tags = stripslashes($tags);
		}
		$s = split('"',$tags);
		$cant = count($s);
		for($i = 1; $i<$cant;$i+=2){
			$tt = $s[$i];
			if($tt != ' ' && $tt != ''){
				array_push($tagsArray,trim($tt));
			}
		}
		for($i = 0; $i<$cant;$i+=2){
			$eachTag = split(' ',$s[$i]);
			foreach($eachTag as $tt){
				if($tt != ' ' && $tt != ''){
					array_push($tagsArray,trim($tt));
				}
			}
		}
		foreach($tagsArray as $tag){
			$query = "SELECT id FROM ".$prefix."tags WHERE tag LIKE '".$tag."'";
			$result = mysql_query($query, $link) or die(mysql_error().$query);
			if(mysql_num_rows($result) == 0){
				$query = "INSERT INTO ".$prefix."tags (tag) VALUES ('".$tag."')";
				$result = mysql_query($query, $link);
				$query = "SELECT LAST_INSERT_ID() as tag_id";
				$result = mysql_query($query, $link) or die(mysql_error().$query);
			}
			list($tag_id) = mysql_fetch_array($result);
			$query = "SELECT * FROM ".$prefix."linktags WHERE tag_id = ".$tag_id." AND link_id = ".$link_id;
			$result = mysql_query($query, $link) or die(mysql_error().$query);
			if(mysql_num_rows($result) == 0){
				$query = "INSERT INTO ".$prefix."linktags (tag_id, link_id) VALUES ('".$tag_id."','".$link_id."')";
				$result = mysql_query($query, $link);
			}
		}
	
	}
	
	function linkTags($link_id, $href = false){
		// Genera una lista con todo lo tags del link, href determina si se muestra como un vinculo o no
		global $link, $prefix, $Sabrosus;

		$query = "SELECT tags.tag 
					FROM ".$prefix."tags as tags,
						 ".$prefix."linktags as linktags 
					WHERE tags.id = linktags.tag_id 
						  AND linktags.link_id = ".$link_id;
		$query .= (!esAdmin())? " AND link_id NOT IN (SELECT id_enlace FROM ".$prefix."sabrosus WHERE privado = 1)" : '';
		$res = mysql_query($query,$link) or die(mysql_error().$query);
		$tags = '';
		if(mysql_num_rows($res) > 0){
			if($href){
				while(list($tag) = mysql_fetch_array($res)){
					$tags .= "<a title=\"".__("ordena por la etiqueta")." '".htmlspecialchars($tag)."'\" href=\"".$Sabrosus->sabrUrl.chequearURLFriendly("/tag/","/index.php?tag=").urlencode($tag)."\">".htmlspecialchars($tag)."</a> " ;
				}
			}else{
				while(list($tag) = mysql_fetch_array($res)){
					$tag  = (strpos($tag, ' ') != false)? '"'.$tag.'"' : $tag;
					$tags .= (esAdmin() && $tag == ':sab:privado')? '': htmlentities(utf8_decode($tag)).' ';
				}
			}
		}
		return $tags;
		
	}
	
	function showTags($output="html", $max_font=30, $min_font=12){
		// $output = ("html" | "javascript" | "badge")
		// Muestra la nube de tags en diferentes formatos
		global $link, $prefix, $Sabrosus;
		$keys = array();
		if(esAdmin()){
		$query = "SELECT tag_id, COUNT(*) AS cnt FROM ".$prefix."linktags GROUP BY tag_id ORDER BY cnt DESC";
		}else{  
		$query = " SELECT tag_id, COUNT(*) AS cnt FROM 
					(SELECT * FROM ".$prefix."linktags AS lt WHERE NOT EXISTS 
						(SELECT * FROM ".$prefix."sabrosus AS s WHERE s.id_enlace = lt.link_id AND s.privado = 1))
					AS links GROUP BY tag_id ORDER BY cnt DESC";
		}
		$result = mysql_query($query, $link) or die(mysql_error().$query);
		while(list($id, $value) = mysql_fetch_array($result)){
			$q2 = "SELECT tag FROM ".$prefix."tags WHERE id = ".$id;
			$r2 = mysql_query($q2) or die(mysql_error());
			list($tag) = mysql_fetch_array($r2);
			$keys[$tag] = $value;
		}
		if(count($keys) > 0){
			ksort($keys);
			$max = max($keys);
			$min = min($keys);
			$prop = 255 / $max;
			if($max!=$min){
				$step = round(($max_font - $min_font)/($max - $min),4);
			}else{
				$step=1;
			}
			$i = 0;
	
			if ($output=="html") {
				echo "\t<ol id=\"cloud\">\n";
			} else if ($output=="javascript") {
				echo "<div id=\"reltags\">";
			} else if ($output=="badge") {
				echo "document.write(\"<ol>\");\n";
			}
	
			/* color tags */
			$colores[0]['r'] = 0.1;
			$colores[0]['g'] = 2;
			$colores[0]['b'] = 4;
	
			$colores[1]['r'] = 8;
			$colores[1]['g'] = 2;
			$colores[1]['b'] = 0.8;
	
			$colores[2]['r'] = 5;
			$colores[2]['g'] = 1.6;
			$colores[2]['b'] = 5;
	
			$colores[3]['r'] = 1;
			$colores[3]['g'] = 5.5;
			$colores[3]['b'] = 5.5;
	
			$colores[4]['r'] = 1.5;
			$colores[4]['g'] = 1.5;
			$colores[4]['b'] = 1.5;
	
			foreach($keys as $key => $value) {
				$colores[5]['r'] = (rand(5,40)) / 10;
				$colores[5]['g'] = (rand(5,40)) / 10;
				$colores[5]['b'] = (rand(5,40)) / 10;
	
				if ($output=="badge") {
					$selectedColor = (isset($_GET['color']) && isset($colores[$_GET['color']]))? $_GET['color'] : 0;
				} else {
					$selectedColor = $Sabrosus->tagsColor;
				}
	
				$color = round(255 - ($prop * $value),0);
				$r = round(($color/$colores[$selectedColor]['r']),0);
				$g = round(($color/$colores[$selectedColor]['g']),0);
				$b = round(($color/$colores[$selectedColor]['b']),0);
	
				$r = ($r>215)? 215 : $r;
				$g = ($g>215)? 215 : $g;
				$b = ($b>215)? 215 : $b;
	
				$size = (($value - $min)*$step) + $min_font;
				if ($output=="html") {
					echo "\t\t\t<li><a title=\"".$value." ".__("enlaces con esta etiqueta")."\" style=\"font-size:".$size."px; color:rgb(".$r.",".$g.",".$b.");\" href=\"".$Sabrosus->sabrUrl.chequearURLFriendly('/tag/','/index.php?tag=').urlencode($key)."\"> ".htmlspecialchars($key)."</a><img src=\"".$Sabrosus->sabrUrl."/images/icon_add.gif\" onclick=\"addToSearch('".$key."');\" title=\"".__("Agregar esta etiqueta a la busqueda")."\"/></li>\n 
					";
				} else if ($output=="javascript") {
					echo "<a style=\"font-size:".$size."px; color:rgb(".$r.",".$g.",".$b.");\" href=\"javascript:void(0)\" onclick=\"addTag('".htmlentities(utf8_decode($key))."')\" title=\"".__("Da clic para etiquetar esta entrada con")." '".urlencode($key)."'\">".htmlspecialchars($key)."</a> 
					";
				} else if ($output=="badge") {
					echo "document.write(\"<li><a title='".$value." ".__("enlaces con esta etiqueta")."' style='font-size:".$size."px; color:rgb(".$r.",".$g.",".$b.");' href='".$Sabrosus->sabrUrl.chequearURLFriendly('/tag/','/index.php?tag=').urlencode($key)."'>".htmlspecialchars($key)."</a></li> \");\n
					";
				}
				
			}
			if ($output=="html") {
				echo "\t\t</ol>\n";
			} else if ($output=="javascript") {
				echo "</div>";
			} else if ($output=="badge") {
				echo "document.write(\"</ol>\");\n";
			}
		}

	}
	
	function editTag(){
		// Edita un tag en todas sus ocurrencias (Para futuras implementaciones)
	}
	
	function deleteTag(){
		// Borra un tag, a menos que un enlace quede sin ninguno (Para futuras implementaciones)
	}
	
	function deleteLinkTags($link_id){
		// Borra todo los tags de un link, los tags se quedan solo borra las relaciones
		global $prefix, $link;
		$query = "DELETE FROM ".$prefix."linktags WHERE link_id = ".$link_id;
		$result = mysql_query($query) or die(mysql_error().$query);
	}

	function search($tag){
		// (Para futuras implementaciones)
	}
	
	function showRelateds($tag_original){
		// Muestra los tags relacionados a una etiqueta en particular
		global $prefix, $link, $Sabrosus;
		$query = "SELECT id FROM ".$prefix."tags WHERE tag LIKE '".$tag_original."' LIMIT 1";
		$result = mysql_query($query, $link) or die(mysql_error().$query);
		list($tag_id) = mysql_fetch_array($result);
		
		if(esAdmin()){
			$query = "SELECT tag , COUNT(*) AS cnt FROM (SELECT tag FROM ".$prefix."linktags as rel, ".$prefix."tags AS t WHERE t.id = rel.tag_id AND rel.link_id IN (SELECT link_id FROM ".$prefix."linktags  AS lt WHERE lt.tag_id = ".$tag_id.") AND tag_id != ".$tag_id.") as related GROUP BY tag";
		}else{
		$query = "SELECT tag , COUNT(*) AS cnt FROM (SELECT tag FROM ".$prefix."linktags as rel, ".$prefix."tags AS t WHERE t.id = rel.tag_id AND rel.link_id IN(SELECT link_id FROM ".$prefix."linktags  AS lt, ".$prefix."sabrosus AS links WHERE lt.link_id = links.id_enlace AND links.privado != 1 AND lt.tag_id = ".$tag_id.") AND tag != ".$tag_id.") as related GROUP BY tag";
		}
		$result = mysql_query($query, $link) or die(mysql_error().$query);
		$pop = array();
		while ($t = mysql_fetch_array($result)) {
			$pop[$t['tag']] = $t['cnt'];
		}
	

	if (!empty($pop)) {
		echo "<div class=\"tags_relacionados\"><strong>".__("Etiquetas relacionadas:")."</strong> ";
		arsort ($pop);
		$i=0;
		foreach ($pop as $tag => $num) {
			# Asegurarse que no sea la misma etiqueta
			$tag_match = str_replace("+", "\+", urlencode($tag));
			if (preg_match("/$tag_match/i", $tag_original)) {
				continue;
			}
			# solo mostramos 5.
			if ($i++ > 4) {
				continue;
			}
			echo chequearURLFriendly("<a title=\"".__("Buscar enlaces con")." '".htmlspecialchars($tag)."'\" href=\"".$Sabrosus->sabrUrl."/tag/".urlencode($tag)."\">".htmlspecialchars($tag)."</a> ", "<a title=\"".__("Buscar enlaces con")." '".htmlspecialchars($tag)."'\" href=\"".$Sabrosus->sabrUrl."/index.php?tag=".urlencode($tag)."\">".htmlspecialchars($tag)."</a> ");
			}
			echo "</div>";
		}

	}
	
	function isPrivate($link_id){
		// Determina si un enlace es privado o no
		global $link, $prefix;
		$query = "SELECT privado FROM ".$prefix."sabrosus WHERE id_enlace = ".$link_id;
		$result = mysql_query($query, $link) or die(mysql_error().$query);
		if(mysql_num_rows($result)){
			list($private) = mysql_fetch_array($result);
			return $private;	
		}else{
			return 0;
		}
	}
	
	function checkQuotes($tags){
		// Determina si se ingreso un tag compuesto ("tag compuesto")
		if(get_magic_quotes_gpc()){
			$tags =  stripslashes($tags);
		}
		$s = split('"',stripslashes($tags));
		$cant = count($s);
		return ($cant % 2 == 0);
	}
	
	function checkMultiTag($search){
		// Determina si la busqueda contiene tags
		return eregi("^(\:{2}(.+))",trim($search));
	}
	
	function multiTagQuery($busqueda,$admin){
		// Genera la consulta para buscar varios tags a la vez
			global $link, $prefix;
			$busqueda = trim($busqueda);
			$mTags = explode("::",$busqueda);
				if(count($mTags) <= 2){
					header("Location: index.php/tag/".urlencode($mTags[1]));
					exit();
				}else{
				unset($mTags[0]);
				foreach($mTags as $k=>$tag){
				$tag = trim($tag);
				$mTags[$k] = " (tag LIKE '%".$tag."%') ";
				}
				
				$sql = "SELECT id FROM ".$prefix."tags WHERE ".implode(" OR ",$mTags);
				$res = mysql_query($sql) or die(mysql_error().$sql);
				if(mysql_num_rows($res) > 0){
					$tags_id = array();
					while(list($t_id) = mysql_fetch_array($res)){
						array_push($tags_id,$t_id);
					}
					$multitag = "SELECT link_id FROM ".$prefix."linktags WHERE tag_id = ".$tags_id[0];
					for($i = 1; $i < count($tags_id); $i++){
						$multitag .= " AND link_id IN (SELECT link_id FROM ".$prefix."linktags WHERE tag_id = ".$tags_id[$i];
					};
					for($i = 1; $i < count($tags_id); $i++){
						$multitag .= ")";
					};
						$multitag .= (!$admin)? " AND link_id NOT IN (SELECT id_enlace FROM ".$prefix."sabrosus WHERE privado = 1)" : '';
						$res = mysql_query($multitag) or die(mysql_error().$multitag);
						if(mysql_num_rows($res) > 0){
								$links_id = array();
								while(list($l_id) = mysql_fetch_array($res)){
									array_push($links_id,$l_id);
								}
								$links_id = "link.id_enlace = ". implode(" OR link.id_enlace = ",$links_id);
								return $links_id;
						}else{
							echo "<strong>" . __("No hay ning&uacute;n enlace que concuerde con la busqueda") . "</strong>";
						}
				}else{
						echo "<strong>" . __("No hay ning&uacute;n enlace que concuerde con la busqueda") . "</strong>";
					}
			}

	}
}