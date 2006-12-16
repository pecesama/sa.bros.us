<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

$feeds = true;
header("Content-type: text/xml; charset=utf-8");

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

echo "<?xml version=\"1.0\""." encoding=\"UTF-8\"?>\n";

if (isset($_GET["tag"])) {
	$navegador = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
		$tagtag = urldecode($_GET["tag"]);
	} else {
		$tagtag = utf8_encode($_GET["tag"]);
	}
}

$sqlStr = "SELECT DISTINCT link.* FROM ".$prefix."sabrosus as link, ".$prefix."tags as tag, ".$prefix."linktags as rel WHERE";

if(isset($tagtag)){
	$sqlStr .= " (tag.tag LIKE '$tagtag') AND ";
}

$sqlStr .= " (tag.id = rel.tag_id AND rel.link_id = link.id_enlace) AND link.privado = 0 ORDER BY link.fecha DESC";

if(isset($cuantos)){
	if($cuantos!='todos' && is_numeric($cuantos)){
		$sqlStr .= " LIMIT $cuantos";
	}
	if($cuantos!='todos' && !is_numeric($cuantos)){
		$sqlStr .= " LIMIT 10";
	}
} else {
	$sqlStr .= " LIMIT 10";
}
$result = mysql_query($sqlStr,$link);
?>

<rss version="0.92">
	<channel>
		<title>sabros.us/<?=$Sabrosus->siteName;?></title>
		<link><?=$Sabrosus->sabrUrl;?></link>
		<description><?=__("Enlaces de")." ".$Sabrosus->siteName;?></description>
		<language><?=strtolower(str_replace("_","-",$locale))?></language>
		<docs>http://backend.userland.com/rss092</docs>

		<?
		while ($registro = mysql_fetch_array($result)) {
			$titulo = htmlspecialchars($registro["title"]);
			$desc = htmlspecialchars($registro["descripcion"]);
			$url = htmlspecialchars($registro["enlace"]);
			?>
			<item>
				<title><?=$titulo;?></title>
				<description><?=$desc;?></description>
				<category><?=$tags;?></category>
				<link><?=$url;?></link>
			</item>
			<?
		}
		?>
	</channel>
</rss>
