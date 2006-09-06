<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/functions.php");
include("include/config.php");
include("include/conex.php");
include("include/tags.php");

header("Content-type: text/html; charset=UTF-8");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title>sabros.us/<?=$Sabrosus->siteName?><? if((isset($_GET["tag"])) && (!eregi("$ *^",$_GET["tag"]))){ $tag=$_GET["tag"]; echo" - ".$tag; } ?></title>
	<meta name="generator" content="sabros.us <?=version();?>" />
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
			echo "<a title=\"".__("inicio sabros.us")."\" href=\"".$Sabrosus->sabrUrl."\">sabros.us</a>/";
			if(isset($tagtag)) {
				if(isset($_GET["pag"])) {
					echo "<a title=\"".$tagtag."\" href=\"".$Sabrosus->sabrUrl.chequearURLFriendly("/tag/","?tag=").urlencode($tagtag)."\">".htmlspecialchars($tagtag)."</a>/<span>".$_GET["pag"]."</span>";
				} else {
					echo "<span>".htmlspecialchars($tagtag)."</span>";
				}
			} else {
				echo "<span>".$_GET["pag"]."</span>";
			}
		} else {
			echo "<span>sabros.us</span>\n";
		}
		?>
		</h2>
		<p class="submenu_derecho">
			<a href="<?=$Sabrosus->sabrUrl;?>/sabrosus.php" title="<?=__("&iquest;qu&eacute; es sabros.us?");?>"><?=__("&iquest;qu&eacute; es sabros.us?");?></a> | <a href="<?=$Sabrosus->sabrUrl;?>/cpanel.php" title="<?=__("panel de control");?>"><?=__("panel de control");?></a>
		</p>
	</div>
	<? if($Sabrosus->estiloNube == "1")
	{
	?>
		<div id="tagsx_d">
		<?php getTags("html"); ?>
		</div>
	<?
	}
	?>
	
	<? if ($Sabrosus->soloNube=="1" && !isset($_GET["tag"])) { } else { ?>
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
			$pag_text = "<strong>" . __("No hay ning&uacute;n enlace en este sabros.us todav&iacute;a.") . "</strong>";
		}
		echo "<div id=\"indicador_pagina\">".$pag_text."</div>\n";
		
		if(esAdmin())
			$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit" : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit");
		else 
			$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus WHERE (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit" : "SELECT * FROM ".$prefix."sabrosus WHERE (tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag') AND (tags NOT LIKE '%:sab:privado%') ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit");
		etiquetasRelacionadas($tagtag);

		$result = mysql_query($sqlStr);
		if (!$result) {
			echo __("Error al ejecutar la consulta en la DB");
		} else {
			if(mysql_num_rows($result)>0) {
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
							$tags.= "<a title=\"".__("ordena por la etiqueta")." '".htmlspecialchars($etiqueta)."'\" href=\"".$Sabrosus->sabrUrl.chequearURLFriendly("/tag/","/index.php?tag=").urlencode($etiqueta)."\">".htmlspecialchars($etiqueta)."</a> ";
						}
					}
	
					if (!esAdmin() && $privado) { //Aqui no imprime nada por ser privado
					} else {
						if($privado){
							echo "\n\t\t<div class=\"enlace_privado\">\n";
						} else {
							echo "\n\t\t<div class=\"enlace\">\n";
						}
						// Thumbnails
						if($Sabrosus->multiCont=="1")
						{
							if(!ocupaReproduccionEspecial($row["enlace"])) {
								echo "\t\t<img class=\"preview\" src=\"http://www.webshotspro.com/thumb.php?url=".htmlspecialchars($row["enlace"])."\" alt=\"".htmlspecialchars($row["title"])."\" />";
							} else {
								/* Imagenes de Flickr */
								if (esFlickrPhoto($row["enlace"])) {
									echo "\t\t<img src=\"".getFlickrPhotoUrl($row["enlace"])."\" alt=\"".$row["title"]."\" class=\"preview\" />\n";
								}
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
							if (esMP3($row["enlace"]))
							{
								$playerUrl = $Sabrosus->sabrUrl."/include/player.swf?soundFile=".$row["enlace"];
								echo "\t\t\t<div class=\"enlacemp3\"><object type=\"application/x-shockwave-flash\" data=\"" . $playerUrl . "\" width=\"290\" height=\"24\"><param name=\"movie\" value=\"" . $playerUrl . "\" /><param name=\"quality\" value=\"high\" /><param name=\"menu\" value=\"false\" /><param name=\"wmode\" value=\"transparent\" /></object></div>\n";
							}
							
							/* Videos de YouTube */
							if (esYoutubeVideo($row["enlace"])) {
								$id_video = getYoutubeVideoUrl($row["enlace"]);
								echo "\t\t\t<div class=\"enlacevideo\"><object type=\"application/x-shockwave-flash\" style=\"width:400px;height:330px\" data=\"http://www.youtube.com/v/".$id_video."\"><param name=\"movie\" value=\"http://www.youtube.com/v/".$id_video."\" /></object></div>\n";
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
						if ($tags) {
							echo __("en")." <span class=\"link_tags\">".$tags."</span> ";
						}
						echo __("el")." ".date("d.m.y", strtotime($row["fecha"]))."</p>\n";
						echo "\t\t</div>\n";
					}
				}
			}
		}
		echo ($Sabrosus->compartir=="1") ? "<input type=\"submit\" name=\"enviar_links\" value=\"".__("exportar a mi sabros.us")."\" id=\"enviar_links\"/>
		</form>" : '';
		?>
	</div>
	<br class="clear"/>
	
	<div id="pagination">
	<? include "pagination.php"; /* Muestra el paginador */ ?>
	</div>

	<? 
	}
	if($Sabrosus->estiloNube == "0")
	{ ?>
		<div id="tagsx">
		<?php getTags("html"); ?>
		</div>
	<? } ?>
	<br class="clear"/> 
	<div id="pie">
		<p class="powered"><?=__("generado con:");?> <a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
		<? if (!isset($tagtag)) { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss','/rss.php');?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de sabros.us");?>" title="<?=__("RSS de sabros.us");?>" /></a></p>
		<? } else { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss/','/rss.php?tag=').htmlspecialchars($tagtag);?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=__("RSS de la etiqueta");?> '<?=htmlspecialchars($tagtag);?>'" title="<?=__("RSS de la etiqueta");?> '<?=htmlspecialchars($tagtag);?>'" /></a></p>
		<? } ?>
	</div>

</div>
</body>
</html>
