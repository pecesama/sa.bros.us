<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

function version() {
	return "1.8";
}


function esPrivado($id){
		global $prefix,$link;
		$sqlStr=mysql_query("SELECT privado FROM ".$prefix."sabrosus WHERE id_enlace=".$id,$link) or die(mysql_error());
		if($row=mysql_fetch_assoc($sqlStr))
				return $row['privado']; 
			else
				return 0;
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

function contarenlaces($sql) {
	global $link, $prefix;
	$totalRowsResult = mysql_query($sql,$link) or die(mysql_error()."<h2>$sql</h2>");
	if (!$totalRowsResult) {
		echo __("Error al ejecutar la consulta en la DB");
	} else {
		return mysql_num_rows($totalRowsResult);
	}
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
	if (isset($_COOKIE["pass_sabrosus_cookie"]) && $_COOKIE["pass_sabrosus_cookie"] && $_COOKIE["pass_sabrosus_cookie"]==$Sabrosus->adminPass) {
		$_SESSION["sabrosus"]["usuario"]="Si";
	}
	if (isset($_SESSION["sabrosus"]["usuario"])) {
		return true;
	}
	return false;
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
	return "&#104;&#116;&#116;&#112;://&#102;&#108;&#105;&#99;&#107;&#114;&#46;&#99;&#111;&#109;/&#100;&#101;&#108;&#105;&#99;&#105;&#111;&#117;&#115;_&#116;&#104;&#117;&#109;&#98;&#46;&#103;&#110;&#101;?&#105;&#100;=".$params[5];
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

function esMP3($archivoUrl) {
	if (endsWith($archivoUrl, ".mp3"))
		return true;
	else
		return false;
}

function getYoutubeVideoUrl($videoUrl) {
	$params = explode("?v=", $videoUrl);
	$params2 = explode("&",$params[1]);
	return $params2[0];
}

//Actualizar esta funcion cada que se agregue un tipo especial
//de reproduccion
function ocupaReproduccionEspecial($url) {
if (esFlickrPhoto($url)) { return true; }
elseif (esMP3($url)) { return true; }
elseif (esYoutubeVideo($url)) { return true; }
elseif (esVimeoVideo($url)) { return true; }
else { return false; }
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
	$org    = "sabros.us";
	$mailer = "sabros.us Mailer";

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

//usada por GPL de wordpress-mobile-edition
function esMovil() {
	if (!isset($_SERVER["HTTP_USER_AGENT"]) ) {
        return false;
    }
    $whitelist = array(
        'Stand Alone/QNws'
    );
    foreach ($whitelist as $browser) {
        if (strstr($_SERVER["HTTP_USER_AGENT"], $browser)) {
            return false;
        }
    }
	$small_browsers = array(
		'2.0 MMP'
		,'240x320'
		,'AvantGo'
		,'BlackBerry'
		,'Blazer'
		,'Cellphone'
		,'Danger'
		,'DoCoMo'
		,'Elaine/3.0'
		,'EudoraWeb'
		,'hiptop'
		,'MIDP-2.0'
		,'MMEF20'
		,'MOT-V'
		,'NetFront'
		,'Newt'
		,'Nintendo Wii'
		,'Nitro' // Nintendo DS
		,'Nokia'
		,'Opera Mini'
		,'Palm'
		,'portalmmm'
		,'Proxinet'
		,'ProxiNet'
		,'SHARP-TQ-GX10'
		,'Small'
		,'SonyEricsson'
		,'Symbian OS'
		,'SymbianOS'
		,'TS21i-10'
		,'UP.Browser'
		,'UP.Link'
		,'Windows CE'
		,'WinWAP'
		,'psp'
        ,'PlayStation'
		,'playstation'
	);

	foreach ($small_browsers as $browser) {
        if (strstr($_SERVER["HTTP_USER_AGENT"], $browser)) {
           return true;
        }
    }
    return false;
}
?>
