<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?php

function version() {
	return "1.7";
}

function normalizeTags($etiquetas) {
	foreach (explode(" ", $etiquetas) as $etiqueta) {
		if ($etiqueta!="") {
			$tags = $tags . " " . $etiqueta;
		}
	}
	return trim($tags);
}

function saveIni($fileName, $configOpts) {
	$file = fopen($fileName, 'wb');
	foreach ($configOpts as $section => $configLine) {
		fwrite($file, "[".$section."]\n");
		foreach ($configLine as $key => $value) {
			fwrite($file, $key." = \"".$value."\"\n");
		}
	}
	fclose($file);
}

function contarenlaces($tag="") {
	global $prefix;
	if ($tag){
		$recordCount = "select count(*) from ".$prefix."sabrosus where tags LIKE '% $tag %' OR tags LIKE '$tag %' OR tags LIKE '% $tag' OR tags = '$tag'";
	} else {
		$recordCount = "select count(*) from ".$prefix."sabrosus";
	}
	$totalRowsResult = mysql_query($recordCount);
	$totalRows = mysql_fetch_row($totalRowsResult);
	$rows = $totalRows[0];
	return $rows;
}

function chequearURLFriendly ($friendlyurl, $nofriendlyurl) {
	global $Sabrosus;
	if ($Sabrosus->usefriendlyurl) {
		return $friendlyurl;
	} else {
		return $nofriendlyurl;
	}
}

// Verificamos si el usuario es Admin
function esAdmin() {
	global $Sabrosus;
	session_start();
	if (isset($_COOKIE["pass_sabrosus_cookie"]) && $_COOKIE["pass_sabrosus_cookie"] && $_COOKIE["pass_sabrosus_cookie"]==$Sabrosus->adminPass) {
		$_SESSION["sabrosus"]["usuario"]="Si";
	}
	if (isset($_SESSION["sabrosus"]["usuario"])) {
		return true;
	}
	return false;
}

function etiquetasRelacionadas ($tags) {
	# codigo basado en el propuesto en http://hellojoseph.com/tags-howto.php
	global $Sabrosus;
	global $prefix;
	global $idioma;

	if (empty($tags)) {
		return;
	}

	# Hacemos una copia de la etiqueta original
	$tags_orig = urlencode($tags);

	# Busqueda para encontrar todas las etiquetas que se relacionan con la etiqueta actual
	$tags_explode = preg_match("/,/", $tags) ? "," : " ";
	$tags = explode($tags_explode, $tags);
	foreach ($tags as $tag) {
		$query .= $i++ > 0 ? " or " : "";
		$query .= "tags REGEXP '[[:<:]]".$tag."[[:>:]]'";
	}
	unset($i);
	$result = mysql_query("select tags from ".$prefix."sabrosus where $query");

	# buscar en todas las entradas para encontrar las etiquetas que no sean la que tenemos.
	# se crea un erreglo con la etiqueta como llave y el numero de "hits" como valor.
	# despues hacemos un arsort() con el que se hara un ordenamiento inverso basado en los valores (hits),
	# lo cual nos dara las etiquetas relacionadas mas populares/comunes primero.
	while ($t = mysql_fetch_array($result)) {
		$tags_explode = preg_match("/,/", $t['tags']) ? "," : " ";
		$tags = explode($tags_explode, $t['tags']);
		foreach ($tags as $tag) {
			if ($tag == $tags_orig) {
				continue;
			}
			if (!empty($tag)) {
				$tag = strtolower($tag);
				if (isset($pop[$tag])) {
					$pop[$tag]++;
				} else {
					$pop[$tag] = 1;
				}
			}
		}
	}

	if (!empty($pop)) {
		echo "<div class=\"tags_relacionados\"><strong>$idioma[etiquetas_relacionadas]</strong>";
		arsort ($pop);
		foreach ($pop as $tag => $num) {
			# Asegurarse que no sea la misma etiqueta
			$tag_match = str_replace("+", "\+", urlencode($tag));
			if (preg_match("/$tag_match/i", $tags_orig)) {
				continue;
			}
			# solo mostramos 5.
			if ($i++ > 4) {
				continue;
			}
			echo chequearURLFriendly("<a title=\"$idioma[etiquetas_relacionadas_buscar] 'htmlentities($tag)'\" href=\"".$Sabrosus->sabrUrl."/tag/".urlencode($tag)."\">".htmlentities($tag)."</a> ", "<a title=\"$idioma[etiquetas_relacionadas_buscar] 'htmlentities($tag)'\" href=\"".$Sabrosus->sabrUrl."/index.php?tag=".urlencode($tag)."\">".htmlentities($tag)."</a> ");
		}
	echo "</div>";
	}
}

function comasxespacios($text) {
	$text = str_replace(",", " ", $text);
	return $text;
}

function beginsWith($str, $sub) {
	return (strpos($str, $sub) === 0);
}

function endsWith($str, $sub) {
	return (substr($str, strlen($str) - strlen($sub)) == $sub);
}

function isInSabrosus($url) {
	global $prefix, $link;
	$sql = "SELECT id_enlace FROM ".$prefix."sabrosus WHERE enlace='$url' LIMIT 1";
	$result = mysql_query($sql, $link);
	if (mysql_num_rows($result)>0) {
		return true;
	} else {
		return false;
	}
}

function esFlickrPhoto($photoUrl) {
	if (beginsWith($photoUrl, "http://www.flickr.com/photos") || beginsWith($photoUrl, "http://flickr.com/photos")) {
		$params = explode("/", $photoUrl);
		if (count($params)==7 && is_numeric($params[5])) {
			return true;
		}
	}
	return false;
}

function getFlickrPhotoUrl($photoUrl) {
	$params = explode("/", $photoUrl);
	return "http://flickr.com/delicious_thumb.gne?id=".$params[5];
}

function esVimeoVideo($videoUrl) {
	if (beginsWith($videoUrl, "http://vimeo.com/clip:") || beginsWith($videoUrl, "http://www.vimeo.com/clip:"))
		return true;
	else
		return false;
}

function getVimeoVideoUrl($videoUrl) {
	return array_pop(explode("clip:",$videoUrl));
}

function esYoutubeVideo($videoUrl) {
	if (beginsWith($videoUrl, "http://youtube.com/watch?v=") || beginsWith($videoUrl, "http://www.youtube.com/watch?v="))
		return true;
	else
		return false;
}

function getYoutubeVideoUrl($videoUrl) {
	$params = explode("?v=", $videoUrl);
	$params2 = explode("&",$params[1]);
	return $params2[0];
}

function esGoogleVideo($videoUrl) {
	if (beginsWith($videoUrl, "http://video.google.com/videoplay?docid="))
		return true;
	else
		return false;
}

function generar_password($largo = 10) {
	$caracteres_permitidos = "abcdefgijlmnoprtu1234567890ABCDEFGHIJLMNOPRTU";
	$ps_len = strlen($caracteres_permitidos);
	mt_srand((double)microtime()*1000000);
	$pass = "";
	for($i = 0; $i < $largo; $i++) {
		$pass .= $caracteres_permitidos[mt_rand(0, $ps_len-1)];
	}
	return $pass;
}

function enviaMail($to, $title, $body, $from) {
	$rp     = trim($from);
	$org    = "Sa.bros.us";
	$mailer = "Sa.bros.us Mailer";

	$head   = '';
	$head  .= "Content-Type: text/html \r\n";
	$head  .= "Date: ". date('r'). " \r\n";
	$head  .= "Return-Path: $rp \r\n";
	$head  .= "From: $from \r\n";
	$head  .= "Sender: $from \r\n";
	$head  .= "Reply-To: $from \r\n";
	$head  .= "Organization: $org \r\n";
	$head  .= "X-Sender: $from \r\n";
	$head  .= "X-Priority: 3 \r\n";
	$head  .= "X-Mailer: $mailer \r\n";

	$body   = str_replace("\r\n", "\n", $body);
	$body   = str_replace("\n", "\r\n", $body);

	return @mail($to, $title, $body, $head);
}
?>
