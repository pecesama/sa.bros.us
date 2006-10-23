<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

$feeds = true;
include("include/config.php");
include("include/conex.php");
include("include/functions.php");

header("Content-type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\""." encoding=\"UTF-8\"?>\n";

if (isset($_GET["tag"])) {
	$navegador = strtolower($_SERVER['HTTP_USER_AGENT']);
	if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
		$tagtag = utf8_decode($_GET["tag"]);
	} else {
		$tagtag = $_GET["tag"];
	}
}

if (isset($cuantos)) {
	//Parametro $cuantos=todos para que devuelvas una sindicación completa de sabros.us.
	if($cuantos=='todos')
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC " : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC");
	else
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit $cuantos" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit $cuantos");
} else {
	$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit 10" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit 10");
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
			/* Control de Enlaces Privados */
			$tags=htmlspecialchars($registro["tags"]);
			$privado=false;
			$etiquetas = explode(" ", $tags);
			foreach ($etiquetas as $etiqueta) {
				if ($etiqueta==":sab:privado") {
					$privado=true;
				}
			}

			if (!$privado) {
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
		}
		?>

	</channel>
</rss>
