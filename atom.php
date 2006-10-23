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

if (isset($_GET["tag"])) {
	$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
	if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
		$tagtag = utf8_decode($_GET["tag"]);
	} else {
		$tagtag = $_GET["tag"];
	}
}

if(isset($cuantos)) {
	//Parametro $cuantos=todos para que devuelvas una sindicación completa de sabros.us.
	if($cuantos=='todos') {
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC " : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC");
	} else {
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit $cuantos" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit $cuantos");
	}
} else {
	$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC limit 10" : "SELECT * FROM ".$prefix."sabrosus where tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC limit 10");
}

$result = mysql_query($sqlStr,$link);

header("Content-type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";

?>

<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<?=strtolower(str_replace("_","-",$locale));?>">
	<title><?=$Sabrosus->siteName;?></title>
	<author><name><?=$Sabrosus->siteName;?></name></author>
	<id><?=$Sabrosus->sabrUrl;?></id>
	<updated><?=gmdate("Y-m-d\TH:i:s\Z");?></updated>
	<link rel="self" href="<?=$Sabrosus->sabrUrl;?>/atom.php" />
	<link href="<?=$Sabrosus->sabrUrl;?>" />
	<generator uri="http://sabros.us/wiki/" version="<?=version();?>">sabros.us</generator>
	<icon><?=$Sabrosus->sabrUrl;?>/images/sabrosus_icon.png</icon>

<?

while ($registro = mysql_fetch_array($result)) {
	$titulo=htmlspecialchars($registro["title"]);
	$desc=htmlspecialchars($registro["descripcion"]);
	$tags=htmlspecialchars($registro["tags"]);
	$url=htmlspecialchars($registro["enlace"]);

	$fecha = gmdate("Y-m-d\TH:i:s\Z", strtotime($registro["fecha"]));

	/* Control de Enlaces Privados */
	$privado=false;
	$etiquetas = explode(" ",$tags);
	foreach($etiquetas as $etiqueta) {
		if ($etiqueta==":sab:privado") {
			$privado=true;
		}
	}

	if (!$privado) {
		?>

		<entry>
			<title><?=$titulo;?></title>
			<link rel="alternate" href="<?=$Sabrosus->sabrUrl.chequearURLFriendly("/","/ir.php?id=").$registro["id_enlace"];?>" title="<?=$titulo." @ ".$Sabrosus->siteName;?>" />
			<link rel="related" href="<?=$url;?>" title="<?=$titulo;?>" />

			<id><?=strtolower($Sabrosus->sabrUrl."/".$registro["id_enlace"]);?></id>

			<content type="html">
				<?=htmlspecialchars("<div><a href=\"".$url."\">".$titulo."</a></div>");?>
				<? if ($desc) { ?>
					<?=htmlspecialchars("<div>".$desc."</div>");?>
				<? } ?>
			</content>

			<updated><?=$fecha;?></updated>

			<?
			foreach($etiquetas as $etiqueta) {
				if ($etiqueta) {
					?>
					<category term="<?=$etiqueta;?>" label="<?=$etiqueta;?>" />
					<?
				}
			}
			?>

		</entry>

		<?
	}
}

?>

</feed>
