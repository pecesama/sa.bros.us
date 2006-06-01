<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");
include("lang/".$Sabrosus->archivoIdioma);

header("Content-type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\""." encoding=\"UTF-8\"?>\n";

if (isset($_GET["tag"])) {
	$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
	if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
		$tagtag = utf8_decode($_GET["tag"]);
	} else {
		$tagtag = $_GET["tag"];
	}
}

if (isset($cuantos)) {
	//Parametro $cuantos=todos para que devuelvas una sindicación completa de Sabrosus.
	if($cuantos=='todos')
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC" : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC");
	else
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit $cuantos" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit $cuantos");
} else {
	$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit 10" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit 10");
}
$result = mysql_query($sqlStr,$link);

?>

<rss version="0.92">
	<channel>
		<title>sa.bros.us/<?=$Sabrosus->siteName;?></title>
		<link><?=$Sabrosus->sabrUrl;?></link>
		<description><?=__("Enlaces de")." ".$Sabrosus->siteName;?></description>
		<language><?=$locale;?></language>
		<docs>http://backend.userland.com/rss092</docs>

		<?
		while ($registro = mysql_fetch_array($result)) {
			/* Control de Enlaces Privados */
			$tags = htmlspecialchars($registro["tags"]);
			$privado = false;
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
				?>

				<item>
					<title><?=$titulo;?></title>
					<description><?=$desc;?></description>
					<category><?=$tags;?></category>
					<link><?=$url;?></link>
				</item>

				<?
			}
		}
		?>
	</channel>
</rss>
