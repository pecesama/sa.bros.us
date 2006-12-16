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

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
if (isset($_GET["tag"])) {
	$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
	if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
		$tagtag = utf8_decode($_GET["tag"]);
	} else {
		$tagtag = $_GET["tag"];
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

<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<?=strtolower(str_replace("_","-",$locale));?>">
	<title>sabros.us/<?=$Sabrosus->siteName;?></title>
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
	$url=htmlspecialchars($registro["enlace"]);

	$fecha = gmdate("Y-m-d\TH:i:s\Z", strtotime($registro["fecha"]));
	
	$sql = "SELECT tag FROM ".$prefix."tags AS t, ".$prefix."linktags AS rel WHERE rel.link_id = ".$registro['id_enlace']." AND t.id = rel.tag_id";
	$res = mysql_query($sql,$link);
	$tags = array();
	if(mysql_num_rows($res) > 0){
		while(list($tag) = mysql_fetch_array($res)){
			array_push($tags,$tag);
		}
	}
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
		foreach($tags as $etiqueta) {
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


?>

</feed>
