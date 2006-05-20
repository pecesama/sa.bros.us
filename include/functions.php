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

function tiempospanish($tiempo) {
	// Reemplazar los meses
	$tiempo = str_replace("January", "Enero", $tiempo);
	$tiempo = str_replace("February", "Febrero", $tiempo);
	$tiempo = str_replace("March", "Marzo", $tiempo);
	$tiempo = str_replace("April", "Abril", $tiempo);
	$tiempo = str_replace("May", "Mayo", $tiempo);
	$tiempo = str_replace("June", "Junio", $tiempo);
	$tiempo = str_replace("July", "Julio", $tiempo);
	$tiempo = str_replace("August", "Agosto", $tiempo);
	$tiempo = str_replace("September", "Septiembre", $tiempo);
	$tiempo = str_replace("October", "Octubre", $tiempo);
	$tiempo = str_replace("November", "Noviembre", $tiempo);
	$tiempo = str_replace("December", "Diciembre", $tiempo);
	// Reemplazar los días
	$tiempo = str_replace("Sunday", "Domingo", $tiempo);
	$tiempo = str_replace("Monday", "Lunes", $tiempo);
	$tiempo = str_replace("Tuesday", "Martes", $tiempo);
	$tiempo = str_replace("Wednesday", "Miércoles", $tiempo);
	$tiempo = str_replace("Thursday", "Jueves", $tiempo);
	$tiempo = str_replace("Friday", "Viernes", $tiempo);
	$tiempo = str_replace("Saturday", "Sabado", $tiempo);
	return $tiempo;
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
		echo "<div class=\"tags_relacionados\"> &nbsp; &nbsp; <strong>$idioma[etiquetas_relacionadas]</strong> &nbsp; \n";
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
			echo chequearURLFriendly("<a title=\"$idioma[etiquetas_relacionadas_buscar] '$tag'\" href=\"".$Sabrosus->sabrUrl."/tag/".$tag."\">".$tag."</a> ", "<a title=\"$idioma[etiquetas_relacionadas_buscar] '$tag'\" href=\"".$Sabrosus->sabrUrl."/index.php?tag=".$tag."\">".$tag."</a> ");
		}
	echo "</div>";
	}
}

function obtenerIdiomas() {
	$lang_dir="lang"; // Directorio de los idiomas
	// Extension valida para idiomas
	$exts['php']=true;
	$files=array();
	$ruta = getcwd();
	$dire = $ruta."/".$lang_dir;
	$handle = opendir($dire);
	$i=0;
	while ($filename = readdir($handle)) {
		$ext=explode(".", $filename);
		$ext=$ext[count($ext)-1]; $ext=strtolower($ext);
		if ($filename != "." && $filename != ".." && isset($exts[$ext])) {
			$files[$i]=trim($filename);
			$i++;
		}
	}
	closedir($handle);
	return $files;
}

function comasxespacios($text) {
	$text = str_replace(",", " ", $text);
	return $text;
}

function beginsWith($str, $sub) {
	return (substr($str, 0, strlen($sub)) === $sub);
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

function isPhotoFlickr($photoUrl) {
	$params = explode("/", $photoUrl);
	if (count($params)<6 || !is_numeric($params[5])) {
		return false;
	} else {
		return true;
	}
}

//Para usar esta funcion se debe llamar primero a isPhotoFlickr()
function getFlickrPhotoUrl($photoUrl) {
	$params = explode("/", $photoUrl);
	return "http://flickr.com/delicious_thumb.gne?id=".$params[5];
}

function getYoutubeVideoUrl($videoUrl) {
	$params = explode("?v=", $videoUrl);
	$params2 = explode("&search=",$params[1]);
	return $params2[0];
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
