<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

  /* Este archivo debería ser llamado por el update.php o incluido en él */
  
header("Content-type: text/html; charset=UTF-8");

include("include/functions.php");
include("include/config.php");
include("include/conex.php");
include("include/tags.php");


$tabla = "CREATE TABLE `".$prefix."opciones` (
  `nombre` varchar(100) NOT NULL,
  `valor` varchar(255) NOT NULL,
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=MyISAM";

/* Control para verificar que la tabla existe */
$res = mysql_query("SHOW TABLE STATUS LIKE '".$prefix."opciones'",$link);
if(mysql_num_rows($res) == 0){
	mysql_query($tabla);
}


function exportarini($opcion,$valor)
{
	global $link,$prefix;
	$sql = "SELECT * FROM ".$prefix."opciones WHERE (nombre='".$opcion."') LIMIT 1";
	$result = mysql_query($sql,$link);
	if(mysql_num_rows($result)==0) {
		$sql2 = "INSERT INTO ".$prefix."opciones VALUES ('".$opcion."','".$valor."')";
		if(mysql_query($sql2,$link))
			return true;
		else
			return false;
	} else {
		return true;
	}
}

$cfg = parse_ini_file("include/config.ini", true);
$multiCont = (isset($cfg['multimedia_content']['allow']))?$cfg['multimedia_content']['allow']:"0";
$tagsColor = (isset($cfg['tags_cloud']['color']))?$cfg['tags_cloud']['color']:"0";
$compartir = (isset($cfg['exportar']['compartir']))?$cfg['exportar']['compartir']:"0";
$desc_badge = (isset($cfg['links_badge']['descripciones']))?$cfg['links_badge']['descripciones']:"0";
$ping = (isset($cfg['sopasabrosa']['ping']))?$cfg['sopasabrosa']['ping']:"0";
$soloNube = (isset($cfg['tags_cloud']['alone_index']))?$cfg['tags_cloud']['alone_index']:"0";
$estiloNube = (isset($cfg['tags_cloud']['posicion']))?$cfg['tags_cloud']['posicion']:"0";

exportarini(multiCont,$multiCont);
exportarini(tagsColor,$tagsColor);
exportarini(compartir,$compartir);
exportarini(desc_badge,$desc_badge);
exportarini(ping,$ping);
exportarini(soloNube,$soloNube);
exportarini(estiloNube,$estiloNube);

header("Location: index.php");
?>