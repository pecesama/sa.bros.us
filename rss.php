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
		$tagtag = utf8_decode($_GET["tag"]);
	} else {
		$tagtag = $_GET["tag"];
	}
}

$sqlStr = "SELECT * FROM ".$prefix."sabrosus WHERE";
if(isset($tagtag)){
	$sqlStr .= " ((tags NOT LIKE '%:sab:privado%')";
	$sqlStr .= " AND (tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag'))";
} else {
	$sqlStr .= " (tags NOT LIKE '%:sab:privado%')";
}
$sqlStr .= " ORDER BY fecha DESC";
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

<rss version="2.0">
	<channel>
		<title>sabros.us/<?=$Sabrosus->siteName;?></title>
		<link><?=$Sabrosus->sabrUrl;?></link>
		<description><?=__("Enlaces de")." ".$Sabrosus->siteName;?></description>
		<language><?=strtolower(str_replace("_","-",$locale));?></language>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
		<generator>sabros.us <?=version();?></generator>
		<image>
			<url><?=$Sabrosus->sabrUrl;?>/images/sabrosus_icon.png</url>
			<title><?=__("Enlaces de")." ".$Sabrosus->siteName;?></title>
			<link><?=$Sabrosus->sabrUrl;?></link>
		</image>

		<?
		while ($registro = mysql_fetch_array($result)) {
			$titulo = htmlspecialchars($registro["title"]);
			$desc = htmlspecialchars($registro["descripcion"]);
			$url = htmlspecialchars($registro["enlace"]);
			$fecha = gmdate("D, d M Y H:i:s \G\M\T", strtotime($registro["fecha"]));
			?>
			<item>
				<title><?=$titulo;?></title>
				<link><?=$url;?></link>
				<description><?=$desc;?></description>
				<pubDate><?=$fecha;?></pubDate>
				<category><?=$tags;?></category>
				<guid isPermaLink="true"><?=$Sabrosus->sabrUrl."/ir.php?id=".$registro['id_enlace'];?></guid>
			</item>
			<?
		}
		?>
	</channel>
</rss>
