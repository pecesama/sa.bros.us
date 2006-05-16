<?
/* ===========================

  sabrosus monousuario versión 1.6
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?
	session_start();
	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);
?>	
<!-- Sa.bros.us monousuario version 1.6 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title>sa.bros.us/<?=$Sabrosus->siteName?><? if((isset($_GET["tag"])) && (!eregi("$ *^",$_GET["tag"]))){ $tag=$_GET["tag"]; echo" - ".$tag; } ?></title>
	<meta name="generator" content="Sa.bros.us 1.6" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?=$Sabrosus->sabrUrl?>/rss.php" />
	<link rel="alternate" type="application/rss+xml" title="RSS 0.92" href="<?=$Sabrosus->sabrUrl?>/rss92.php" />
	<link rel="alternate" type="application/rss+xml" title="ATOM 1.0" href="<?=$Sabrosus->sabrUrl?>/atom.php" />
	
</head>
<body>
<?
    /* PATCH Bug #1242025 */
	if (isset($_GET["tag"]))
	{
		$navegador = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		if (stristr($navegador, "opera") || stristr($navegador, "msie"))
		{
			/* PATCH Bug #1359231 */
    		$tagtag=$_GET["tag"];
			if (isset($tagtag)) {
    			$tagtag = utf8_decode($_GET["tag"]);
    		}
    		/* End PATCH Bug #1359231 */
		}
		else
		{
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
		if (isset($tagtag) || isset($_GET["pag"]))
		{
			echo "<a title=\"$idioma[inicio_sabrosus]\" href=\"".$Sabrosus->sabrUrl."\">sa.bros.us</a>/";
			if(isset($tagtag))
			{
				if(isset($_GET["pag"]))
				{
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
			<a href="<?=$Sabrosus->sabrUrl;?>/sabrosus.php" title="<?=$idioma[que_es_sabrosus]?>"><?=$idioma[que_es_sabrosus]?></a> | <a href="<?=$Sabrosus->sabrUrl;?>/cpanel.php" title="<?=$idioma[panel_control]?>"><?=$idioma[panel_control]?></a>
		</p>
	</div>

	<div id="contenido">
		<?
		echo ($Sabrosus->compartir=="1")? "<form action=\"".$Sabrosus->sabrUrl."/exportar.php\" method=\"post\" >" : '';
		
		if (isset($_GET["pag"])) {
			$pag=$_GET["pag"];
		} else {
			$pag = 1; //Si $pag no esta definido la transformo en 0
		} 
				
		$desde=($pag-1)*$Sabrosus->limit;
                               
		$nenlaces=(isset($tagtag) ? contarenlaces($tagtag) : contarenlaces());   
		$desde=(($desde<$nenlaces) ? $desde : 0);

		$pag_text = str_replace("%no_enlaces%",$nenlaces,$idioma[numero_enlaces_index]);
		$pag_text = str_replace("%desde%",($desde+1),$pag_text);
		$pag_text = str_replace("%total%",(($desde+$Sabrosus->limit>=$nenlaces)?$nenlaces:$desde+$Sabrosus->limit),$pag_text);
                
		if(!$nenlaces){
			$pag_text = $idioma[no_hay_enlaces];
		}
		echo "<div id=\"indicador_pagina\">".$pag_text."</div>\n";				

		
		$sqlStr = (!isset($tagtag) ? "SELECT * FROM ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit" : "SELECT * FROM ".$prefix."sabrosus WHERE tags LIKE '% $tagtag %' OR tags LIKE '$tagtag %' OR tags LIKE '% $tagtag' OR tags = '$tagtag' ORDER BY fecha DESC LIMIT $desde,$Sabrosus->limit");
					
		etiquetasRelacionadas($tagtag);			
		                        
		$result = mysql_query($sqlStr);
		while ($row = mysql_fetch_array($result))
		{	
			$privado=false;
			$etiquetas = explode(" ",$row["tags"]);
			$tags="";
			foreach($etiquetas as $etiqueta){
				if ($etiqueta==":sab:privado") { 
					$etiqueta="";
					$privado=true;
				}
				if($etiqueta !==""){
					$tags.= "<a title=\"$idioma[ordenar_por_etiqueta] '".$etiqueta."'\" href=\"".chequearURLFriendly($Sabrosus->sabrUrl."/tag/".$etiqueta,$Sabrosus->sabrUrl."/index.php?tag=".$etiqueta)."\">".$etiqueta."</a> ";
				}
			}
			
			if (!esAdmin() && $privado) { //Aqui no imprime nada por ser privado
			} else {			
				echo "\n\t\t<div class=\"enlace\">\n";
				
				if ($Sabrosus->multiCont=="1") {
					/* Imagenes de Flickr */
					if (beginsWith($row["enlace"], "http://www.flickr.com/photos")) {	
						if (isPhotoFlickr($row["enlace"])) {
							echo "\t\t\t<img src=\"".getFlickrPhotoUrl($row["enlace"])."\" alt=\"".$row["title"]."\" class=\"preview\" />\n";
						} 
					}
				}				
				
				echo "\t\t\t<h3>";
				echo ($Sabrosus->compartir=="1")? '<input type="checkbox" name="links_sel[]" value="'.$row["id_enlace"].'" />' : '';
				echo "<a title=\"".htmlspecialchars($row["title"])."\" href=\"".htmlspecialchars($row["enlace"])."\">".htmlspecialchars($row['title'])."</a>";
				
				if(esAdmin()){
					echo " | <a href=\"".$Sabrosus->sabrUrl."/editar.php?id=".$row['id_enlace']."\" title=\" ".$idioma[editar]." - ".htmlspecialchars($row['title'])."\">".$idioma[editar]." &raquo;</a>";
					}
				echo "</h3>\n";
				if ($Sabrosus->multiCont=="1") {
					/* Reproductor MP3 */
					if (endsWith($row["enlace"], ".mp3"))
					{
						$playerUrl = $Sabrosus->sabrUrl."/include/player.swf?soundFile=".$row["enlace"];
						echo "\t\t\t<div id=\"enlacemp3\"><object type=\"application/x-shockwave-flash\" data=\"" . $playerUrl . "\" width=\"290\" height=\"24\"><param name=\"movie\" value=\"" . $playerUrl . "\" /><param name=\"quality\" value=\"high\" /><param name=\"menu\" value=\"false\" /><param name=\"wmode\" value=\"transparent\" /></object></div>\n";
					}
				}		
				if($row['descripcion']) {
					echo "\t\t\t<p>".$row['descripcion']."</p>\n";
				}
				echo "\t\t\t<p class=\"pie\">";
				if($row['tags']){
					echo $idioma[etiquetas_contenidas]." <span class=\"link_tags\">".$tags."</span> ";
				}
				echo $idioma[fecha_agregado]." ".date("d.m.y", strtotime($row["fecha"]))."</p>\n";
				echo "\t\t</div>\n";
			}
		}
		
		echo ($Sabrosus->compartir=="1")? "<input type=\"submit\" name=\"enviar_links\" value=\"".$idioma[exportar_al_mio]."\" id=\"enviar_links\"/>
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
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		<? if (!isset($tagtag)) { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss','/rss.php');?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=$idioma[sabrosus_rss]?>" title="<?=$idioma[sabrosus_rss]?>" /></a></p>
		<? } else { ?>
				<p><a href="<? echo $Sabrosus->sabrUrl.chequearURLFriendly('/rss/','/rss.php?tag=').$tagtag;?>"><img src="<?=$Sabrosus->sabrUrl?>/images/feed-icon.png" alt="<?=$idioma[etiqueta_rss]?> '<?=$tagtag?>'" title="<?=$idioma[etiqueta_rss]?> '<?=$tagtag?>'" /></a></p>
		<? } ?>
	</div>
	
</div>
</body>
</html>