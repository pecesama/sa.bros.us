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
?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title>sa.bros.us/<?=$Sabrosus->siteName?><? if((isset($_GET["tag"])) && (!eregi("$ *^",$_GET["tag"]))){ $tag=$_GET["tag"]; echo" - ".$tag; } ?></title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?=$Sabrosus->sabrUrl?>/rss.php" />
	<link rel="alternate" type="application/rss+xml" title="RSS 0.92" href="<?=$Sabrosus->sabrUrl?>/rss92.php" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?=$Sabrosus->sabrUrl?>/atom.php" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/include/prototype.lite.js"></script>
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/include/moo.fx.js"></script>
	<script type="text/javascript">
		var contenedor;
		window.onload = function() {
			contenedor = new fx.Opacity('divContenedor', {duration: 5000, onComplete:
				function() {
					document.getElementById('divContenedor').style.display="none";
				}
			});
			contenedor.toggle();
		}
	</script>
</head>
<body>
<?
	/* PATCH Bug #1242025 */
	if (isset($_GET["tag"])) {
		$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		if (stristr($navegador, "opera") || stristr($navegador, "msie")) {
			/* PATCH Bug #1359231 */
			$tagtag=$_GET["tag"];
			if (isset($tagtag)) {
				$tagtag = utf8_decode($_GET["tag"]);
			}
			/* End PATCH Bug #1359231 */
		} else {
			$tagtag = $_GET["tag"];
		}
	}
	/* End PATCH Bug #1242025 */
?>
<div id="pagina">

	<div id="titulo">
		<h2>
		<?
		echo "\t<a title=\"".$Sabrosus->siteTitle."\" href=\"".$Sabrosus->siteUrl."\">".$Sabrosus->siteName."</a>/";
		if (isset($tagtag) || isset($_GET["pag"])) {
			echo "<a title=\"".__("Inicio Sa.bros.us")."\" href=\"".$Sabrosus->sabrUrl."\">sa.bros.us</a>/";
			if(isset($tagtag)) {
				if(isset($_GET["pag"])) {
					echo "<a title=\"".$tagtag."\" href=\"".$Sabrosus->sabrUrl.chequearURLFriendly("/".$tagtag,"?tag=".$tagtag)."\">".$tagtag."</a>/<span>".$_GET["pag"]."</span>";
				} else {
					echo "<span>".$tagtag."</span>";
				}
			} else {
				echo "<span>".$_GET["pag"]."</span>";
			}
		} else {
			echo "<span>sa.bros.us</span>\n";
		}
		?>
		</h2>
		<p class="submenu_derecho">
			<a href="<?=$Sabrosus->sabrUrl;?>/sabrosus.php" title="<?=__("&iquest;Qu&eacute; es sa.bros.us?");?>"><?=__("&iquest;Qu&eacute; es sa.bros.us?");?></a> | <a href="<?=$Sabrosus->sabrUrl;?>/cpanel.php" title="<?=__("Panel de control");?>"><?=__("Panel de control");?></a>
		</p>
	</div>

	<div id="contenido">
		<? if (isset($_GET["er"])) { ?>
			<div id="divContenedor" class="error">
				<p><?=__("No es posible exportar enlaces, debido a que el directorio <code>tmp</code> no cuenta con permisos de escritura.");?></p>
			</div>
		<? } ?>

		<?
		echo ($Sabrosus->compartir=="1")? "<form action=\"".$Sabrosus->sabrUrl."/exportar.php\" method=\"post\" >" : '';

		if (isset($_GET["pag"])) {
			$pag=$_GET["pag"];
		} else {
			$pag=1; //Si $pag no esta definido la transformo en 0
		}

		$desde=($pag-1)*$Sabrosus->limit;

		$nenlaces=(isset($tagtag) ? contarenlaces($tagtag) : contarenlaces());
		$desde=(($desde<$nenlaces) ? $desde : 0);

		$pag_text = str_replace("%no_enlaces%",$nenlaces,__("Hay <strong>%no_enlaces%</strong> enlaces. Est&aacute;s viendo desde el <strong>%desde%</strong> hasta el <strong>%total%</strong>"));
		$pag_text = str_replace("%desde%",($desde+1),$pag_text);
		$pag_text = str_replace("%total%",(($desde+$Sabrosus->limit>=$nenlaces)?$nenlaces:$desde+$Sabrosus->limit),$pag_text);

		if (!$nenlaces) {
			$pag_text = "<strong>" . __("No hay ning&uacute;n enlace en este sa.bros.us todav&iacute;a.") . "</strong>";
		}
		echo "<div id=\"indicador_pagina\">".$pag_text."</div>\n";

		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit" : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit");

		etiquetasRelacionadas($tagtag);

		$result = mysql_query($sqlStr);
		while ($row = mysql_fetch_array($result)) {
			$privado=false;
			$etiquetas = explode(" ",$row["tags"]);
			$tags="";
			foreach ($etiquetas as $etiqueta) {
				if ($etiqueta==":sab:privado") {
					$etiqueta="";
					$privado=true;
				}
				if ($etiqueta!=="") {
					$tags.= "<a title=\"".__("Ordena por la etiqueta")." '".$etiqueta."'\" href=\"".chequearURLFriendly($Sabrosus->sabrUrl."/tag/".$etiqueta,$Sabrosus->sabrUrl."/index.php?tag=".$etiqueta)."\">".$etiqueta."</a> ";
				}
			}

			if (!esAdmin() && $privado) { //Aqui no imprime nada por ser privado
			} else {
				if($privado){
					echo "\n\t\t<div class=\"enlace privado\">\n";
				} else {
					echo "\n\t\t<div class=\"enlace\">\n";
				}
				if ($Sabrosus->multiCont=="1") {
					/* Imagenes de Flickr */
					if (esFlickrPhoto($row["enlace"])) {
						echo "\t\t\t<img src=\"".getFlickrPhotoUrl($row["enlace"])."\" alt=\"".$row["title"]."\" class=\"preview\" />\n";
					}
				}

				echo "\t\t\t<h3>";
				echo ($Sabrosus->compartir=="1")? '<input type="checkbox" name="links_sel[]" value="'.$row["id_enlace"].'" />' : '';
				echo "<a title=\"".htmlspecialchars($row["title"])."\" href=\"".htmlspecialchars($row["enlace"])."\">".htmlspecialchars($row['title'])."</a>";

				if (esAdmin()) {
					echo " | <a href=\"".$Sabrosus->sabrUrl."/editar.php?id=".$row['id_enlace']."\" title=\" ".__("Editar")." - ".htmlspecialchars($row['title'])."\">".__("Editar")." &raquo;</a>";
				}
				echo "</h3>\n";
				if ($Sabrosus->multiCont=="1") {
					/* Reproductor MP3 */
					if (endsWith($row["enlace"], ".mp3"))
					{
						$playerUrl = $Sabrosus->sabrUrl."/include/player.swf?soundFile=".$row["enlace"];
						echo "\t\t\t<div class=\"enlacemp3\"><object type=\"application/x-shockwave-flash\" data=\"" . $playerUrl . "\" width=\"290\" height=\"24\"><param name=\"movie\" value=\"" . $playerUrl . "\" /><param name=\"quality\" value=\"high\" /><param name=\"menu\" value=\"false\" /><param name=\"wmode\" value=\"transparent\" /></object></div>\n";
					}
					/* Videos de YouTube */
					if (esYoutubeVideo($row["enlace"])) {
						$id_video = getYoutubeVideoUrl($row["enlace"]);
						echo "\t\t\t<div class=\"enlacevideo\"><object type=\"application/x-shockwave-flash\" style=\"width:400px;height:330px\" data=\"http://www.youtube.com/v/".$id_video."\"><param name=\"movie\" value=\"http://www.youtube.com/v/".$id_video."\" /></object></div>\n";
					}
					/* Videos de Google */
					if (esGoogleVideo($row["enlace"])) {
						$html = trim(file_get_contents($row["enlace"]));
						$inicio = strpos($html, "var flashObj =\n            \"");
						$fin = strpos($html, "\";\n          flashObj = flashObj.replace");
						$inicio = $inicio + strlen("var flashObj =\n            \"");
						$codigo_video = substr($html, $inicio, $fin - $inicio);
						$codigo_video = str_replace("\u003d", "=", $codigo_video);
						$codigo_video = str_replace("\\\"", "\"", $codigo_video);
						$codigo_video = str_replace("width:100%; height:100%;", "width:400px; height:326px;", $codigo_video);
						$codigo_video = str_replace("/googleplayer.swf", "http://video.google.com/googleplayer.swf", $codigo_video);
						$codigo_video = str_replace("FlashVars=\"playerMode=normal&playerId=gvuniqueid&clickUrl=\"", "FlashVars=\"playerMode=embedded\"", $codigo_video);
						$codigo_video = str_replace("embed", "object", $codigo_video);
						$codigo_video = str_replace("src=", "data=", $codigo_video);
						$codigo_video = str_replace("&", "&amp;", $codigo_video);
						$codigo_video = str_replace("allowScriptAccess=\"sameDomain\" quality=\"best\" bgcolor=\"#ffffff\" scale=\"noScale\" wmode=\"window\" salign=\"TL\"  FlashVars=\"playerMode=objectded\"", "", $codigo_video);
						$codigo_video = str_replace("id=\"VideoPlayback\"", "", $codigo_video);
						$codigo_video = str_replace("&amp;autoPlay=true", "", $codigo_video);
						echo "\t\t\t<div class=\"enlacevideo\">".$codigo_video."</div>\n";
					}
					/* Videos de Vimeo */
					if (esVimeoVideo($row["enlace"])) {
						$id_video = getVimeoVideoUrl($row["enlace"]);
						echo "\t\t\t<div class=\"enlacevideo\"><object type=\"application/x-shockwave-flash\" style=\"width:400px;height:300px\" data=\"http://www.vimeo.com/moogaloop.swf?clip_id=".$id_video."\"><param name=\"movie\" value=\"http://www.vimeo.com/moogaloop.swf?clip_id=".$id_video."\" /></object></div>\n";
					}
				}
				if ($row['descripcion']) {
					echo "\t\t\t<p>".$row['descripcion']."</p>\n";
				}
				echo "\t\t\t<p class=\"pie\">";
				if ($row['tags']) {
					echo __("en")." <span class=\"link_tags\">".$tags."</span> ";
				}
				echo __("el")." ".date("d.m.y", strtotime($row["fecha"]))."</p>\n";
				echo "\t\t</div>\n";
			}
		}

		echo ($Sabrosus->compartir=="1") ? "<input type=\"submit\" name=\"enviar_links\" value=\"".__("Exportar a mi Sa.bros.us")."\" id=\"enviar_links\"/>
		</form>" : '';
		?>
	</div>

	<div id="pagination">
	<? include "pagination.php"; /* Muestra el paginador */ ?>
	</div>

	<div id="tagsx">
	<? include("tags.php"); /* Muestra los tags */ ?>
	</div>

	<div id="pie">
		<p class="powered"><?=__("Generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		<? if (!isset($tagtag)) { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss','/rss.php');?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de sa.bros.us");?>" title="<?=__("RSS de sa.bros.us");?>" /></a></p>
		<? } else { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss/','/rss.php?tag=').$tagtag;?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de la etiqueta");?> '<?=$tagtag?>'" title="<?=__("RSS de la etiqueta");?> '<?=$tagtag?>'" /></a></p>
		<? } ?>
	</div>

</div>
</body>
</html>
