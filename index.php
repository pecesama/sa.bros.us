<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */
header("Content-type: text/html; charset=UTF-8");

include("include/functions.php");
include("include/config.php");
include("include/conex.php");
include("include/tags.class.php");

$tagoo = new tags;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title>sabros.us/<?=$Sabrosus->siteName?><? if((isset($_GET["tag"])) && (!empty($_GET["tag"]))){ $tag=$_GET["tag"]; echo" - ".htmlentities($tag); } ?></title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?=$Sabrosus->sabrUrl?>/rss.php" />
	<link rel="alternate" type="application/rss+xml" title="RSS 0.92" href="<?=$Sabrosus->sabrUrl?>/rss92.php" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?=$Sabrosus->sabrUrl?>/atom.php" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/include/mootools.js"></script>
	<script type="text/javascript">
		var contenedor;
		var efectoEnlaceCancelar;
		var efectoEnlaceGuardar;
		
		function addToSearch(tag){
			var s  = document.getElementById('busqueda');
			s.value = s.value+"::"+tag;
			return false;
		}
		
		window.onload = function() {
			contenedor = new Fx.Style('divContenedor', 'opacity', {duration: 5000, onComplete:
				function() {
					document.getElementById('divContenedor').style.display="none";
				}
			});
			contenedor.custom(1,0);	
			
		}
	</script>
	<?php if(esAdmin()){?>
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/editar_ajax.js.php"></script>
	<?php }?>
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
		$tagtag = urldecode($tagtag);
	}
	/* End PATCH Bug #1242025 */
?>
<div id="pagina">

	<div id="titulo">
		<div id="buscador">
			<fieldset>
				<form action="<?=$Sabrosus->sabrUrl?>" method="get">
					<input type="text" value="<?=isset($_GET['busqueda'])?htmlentities($_GET['busqueda']):"";?>" name="busqueda" id="busqueda"/>
					<input type="submit" value="Buscar"/>
				</form>
			</fieldset>
		</div>
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
		<?php 
		$tagoo->showTags();
		 ?>
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

		if (isset($_GET["pag"])) {
			$pag=$_GET["pag"];
		} else {
			$pag=1; //Si $pag no esta definido la transformo en 0
		}

		$desde=($pag-1)*$Sabrosus->limit;
		
		$where = array();
		if($tagoo->checkMultiTag($_GET['busqueda'])){
			// Busqueda por multiples tags
			$multitag = $tagoo->multitagQuery($_GET['busqueda'], esAdmin());
		}else{
				if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
					// Busqueda normal
					$q = mysql_real_escape_string(trim($_GET['busqueda']));
					if(eregi(chr(32),$busqueda))
						$where['busqueda']=" (MATCH(link.title,link.enlace,link.descripcion) AGAINST('$q')) ";
						else
						$where['busqueda']=" (link.title LIKE '%$q%' OR link.enlace LIKE '%$q%' OR link.descripcion LIKE '%$q%')";
				}else{
					$q="";
				}
				if(isset($tagtag)){
				// Busqueda por tags simples
				$where['busquedaTags'] =  "( tag.tag LIKE '%".$tagtag."%') AND ( tag.id = rel.tag_id AND rel.link_id = link.id_enlace)";
				}
		}
		if(!esAdmin()){
		$where['privados'] =  " link.privado= 0";
		}
		$wheresql = implode (" AND ",$where);
		
				$sqlStr ="SELECT DISTINCT link.* FROM ".$prefix."sabrosus AS link";
				$sqlStr .= (isset($multitag))? " WHERE ".$multitag: ", ".$prefix."tags AS tag, ".$prefix."linktags AS rel".((!empty($wheresql))? " WHERE ".$wheresql: '');
				$sqlStr .=	" ORDER BY fecha DESC LIMIT ".$desde.",".$Sabrosus->limit;
				

		$noLimit = explode("LIMIT",$sqlStr);
		$nenlaces=contarenlaces($noLimit[0]);
		$desde=(($desde<$nenlaces) ? $desde : 0);

		$pag_text = str_replace("%no_enlaces%",$nenlaces,__("Hay <strong>%no_enlaces%</strong> enlaces. Est&aacute;s viendo desde el <strong>%desde%</strong> hasta el <strong>%total%</strong>"));
		$pag_text = str_replace("%desde%",($desde+1),$pag_text);
		$pag_text = str_replace("%total%",(($desde+$Sabrosus->limit>=$nenlaces)?$nenlaces:$desde+$Sabrosus->limit),$pag_text);
		
		
		if (!$nenlaces){
			if(isset($_GET['busqueda'])){
				$pag_text = "<strong>" . __("No hay ning&uacute;n enlace que concuerde con la busqueda") . "</strong>";
			}elseif(isset($tagtag)){
				$pag_text = "<strong>" . __("No hay ning&uacute;n enlace con esta etiqueta") . "</strong>";
			}else{
				$pag_text = "<strong>" . __("No hay ning&uacute;n enlace en este sabros.us todav&iacute;a.") . "</strong>";
			}
		}
		echo "<div id=\"indicador_pagina\">".$pag_text."</div>\n";

		if(isset($tagtag))
			$tagoo->showRelateds($tagtag);
			
		$result = mysql_query($sqlStr, $link);
		if (!$result) {
			echo __("Error al ejecutar la consulta en la DB");
		} else {
			if(mysql_num_rows($result)>0) {
				echo ($Sabrosus->compartir=="1")? "<form action=\"".$Sabrosus->sabrUrl."/exportar.php\" method=\"post\" >" : '';
				while ($row = mysql_fetch_array($result)) {
					$privado = $tagoo->isPrivate($row['id_enlace']);
					$tags = $tagoo->linkTags($row['id_enlace'],1);	
					if (!esAdmin() && $privado) { 
						//Aqui no imprime nada por ser privado
					} else {
						echo"\n\t\t<div id=\"editar".$row['id_enlace']."\"></div>";
						if($privado){
							echo "\n\t\t<div class=\"enlace_privado\" style=\"background-color: rgb(247, 247, 247);\" id=\"enlace".$row['id_enlace']."\">\n";
						} else {
							echo "\n\t\t<div class=\"enlace\" style=\"background-color: rgb(252, 252, 252);\" id=\"enlace".$row['id_enlace']."\">\n";
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
							echo " | <a href=\"".$Sabrosus->sabrUrl."/editar.php?id=".$row['id_enlace']."\" title=\" ".__("Editar")." - ".htmlspecialchars($row['title'])."\" onClick=\"return editar_ajax(".$row['id_enlace'].");\">".__("Editar")." &raquo;</a>";
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
				echo ($Sabrosus->compartir=="1") ? "<br class=\"clear\"/><input type=\"submit\" name=\"enviar_links\" value=\"".__("exportar a mi sabros.us")."\" id=\"enviar_links\"/>
				</form>" : '';
			}
		}
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
		<?php
			$tagoo->showTags();
 		?>
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
<img src="images/ajax-loading.gif" alt="loading.gif" style="display:none;"/>
</body>
</html>
