<?php
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

	include("include/functions.php");
	include("include/config.php");
	include("include/conex.php");
	include("include/tags.class.php");
	
	if(!isset($_GET['id']) || !esAdmin() || !is_numeric($_GET['id'])){
		header("location: index.php");
		exit();
	}
	$id = intval($_GET['id']);
	$sqlStr="SELECT * FROM ".$prefix."sabrosus WHERE (id_enlace=".$id.") LIMIT 1";

	if(!$row=mysql_fetch_assoc(mysql_query($sqlStr,$link))){
		header("location: index.php");
		exit();
	}
$tags = new tags;
/* De donde viene el $_GET['enlace'] ?? */
if(!isset($_GET['enlace'])){

?>
<div id="formulario_ajax">
	<fieldset>
		<legend><?=__("Editar enlace")?></legend>
			<label for="_title<?=$row['id_enlace']?>"><?=__("Titulo")?>:</label><br />
			<input type="text" name="title" id="_title<?=$row['id_enlace']?>" value="<?=$row['title']?>"><br />
			
			<label for="_enlace<?=$row['id_enlace']?>"><?=__("Enlace")?>:</label><br />
			<input type="text" name="enlace" id="_enlace<?=$row['id_enlace']?>" value="<?=$row['enlace']?>"><br />
				
			<label for="_descripcion<?=$row['id_enlace']?>"><?=__("Descripci&oacute;n")?>:</label><br />
			<textarea name="descripcion" id="_descripcion<?=$row['id_enlace']?>" rows="3" cols="60"><?=$row['descripcion']?></textarea><br />

			<label for="tags"><?=__("Tags")?>:</label><br />
			<input type="text" name="tags" id="_tags<?=$row['id_enlace']?>" value="<?=$tags->linkTags($row['id_enlace'])?>"><br />
	</fieldset>
</div>
<?php return;}else{?>
<?
		$result = mysql_query($sqlStr);
		if (!$result) {
			echo __("Error al ejecutar la consulta en la DB");
		} else {
			if(mysql_num_rows($result)>0) {
				while ($row = mysql_fetch_array($result)) {
					$privado=false;
	
					if (!esAdmin() && $row['privado']) { //Aqui no imprime nada por ser privado
					} else {
						// Thumbnails
						if($Sabrosus->multiCont=="1")
						{
							if(!ocupaReproduccionEspecial($row["enlace"])) {
								echo "\t\t<img class=\"preview\" src=\"http://sabros.us/thumbs/?url=".htmlspecialchars($row["enlace"])."\" alt=\"".htmlspecialchars($row["title"])."\" />";
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
						$etiquetas = $tags->linkTags($row['id_enlace']);
						if ($etiquetas) {
							echo __("en")." <span class=\"link_tags\">".$etiquetas."</span> ";
						}
						echo __("el")." ".date("d.m.y", strtotime($row["fecha"]))."</p>\n";
					}
				}
			}
		}
	}
?>