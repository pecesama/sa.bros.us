<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");
include("include/tags.php");

header("Content-type: text/html; charset=UTF-8");

if (!esAdmin()) {
	if (isset($_GET['id'])) {
		header("Location: login.php?dirigir=".urlencode("editar.php?id=".$_GET['id']));
		exit();
	} elseif (isset($_GET['url'])) {
		if (isset($_GET['titulo'])) {
			if (get_magic_quotes_gpc()) {
				$titulo = stripslashes($_GET['titulo']);
			} else {
				$titulo = $_GET['titulo'];
			}
		}
		header("Location: login.php?dirigir=" . urlencode("editar.php?url=".urlencode($_GET['url']) . (isset($titulo) ? "&titulo=".urlencode($titulo) : "") . (isset($_GET['ret'])? "&ret=".$_GET['ret'] : "")));
		exit();
	} else {
		header("Location: login.php");
		exit();
	}
}

if (isset($_GET["id"])) {
	$result = mysql_query("select * from ".$prefix."sabrosus where id_enlace = ".$_GET["id"], $link);
	if (mysql_num_rows($result)>0) {
		$row = mysql_fetch_array($result);
		$titulo = htmlspecialchars($row['title']);
		$enlace = htmlspecialchars($row['enlace']);
		$descripcion = htmlspecialchars($row['descripcion']);
		$tags = htmlspecialchars($row['tags']);
	} else {
		header("Location: cpanel.php");
	}
} elseif (isset($_GET["url"])) {
	$etiquetas = @get_meta_tags($_GET['url']);

	if (isset($_GET['titulo'])) {
		if (get_magic_quotes_gpc()) {
			$titulo = htmlspecialchars(stripslashes($_GET['titulo']));
		} else {
			$titulo = htmlspecialchars($_GET['titulo']);
		}
	} else {
		$titulo = "";
	}
	$enlace = $_GET['url'];
	$descripcion = $etiquetas['description'];
	$tags = comasxespacios($etiquetas['keywords']);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=(isset($_GET["id"]) ? __("editar enlace") : __("agregar enlace")); ?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl?>/include/addtags.js"></script>
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=(isset($_GET["id"]) ? __("editar enlace") : __("agregar enlace")); ?></span></h2>
		<p class="submenu"><a href="cpanel.php"><?=__("panel de control");?></a> | <a href="editar.php"><?=__("agregar enlace");?></a></p>
	</div>

	<div id="contenido">
		<div id="formulario">
			<form method="post" action="<? echo (isset($_GET["id"]) ? "modifica.php" : "agregar.php"); ?>">

			<? if (!isset($_GET["id"]) && (isset($_GET["titulo"]) && isset($_GET["url"]))) { ?>
				<input class="no_style" type="hidden" name="regresa" value="<?=(isset($_GET['ret']))? urlencode($_GET['ret']) : urlencode($_GET['url'])?>" />
			<? } ?>

			<? if (isset($_GET["id"])) { ?>
				<input class="no_style" type="hidden" name="id_enlace" value="<?=$_GET["id"];?>" />
			<? } ?>

			<fieldset>
				<legend><?=(isset($_GET["id"]) ? __("Edita los datos de tu enlace.") : __("Escribe los datos de tu enlace."));?></legend>
				<label for="title"><?=__("t&iacute;tulo:");?></label><br />
				<input class="input_morado" type="text" name="title" value="<?=$titulo;?>" size="86" /><br />

				<label for="enlace"><?=__("enlace:");?></label><br />
				<input class="input_morado" type="text" name="enlace" value="<? echo $enlace; ?>" size="86" /><br />

				<label for="descripcion"><?=__("descripci&oacute;n:");?></label>
				<textarea class="textarea_oscuro" rows="3" cols="84" name="descripcion"><? echo $descripcion; ?></textarea><br />

				<label for="privado"><?=__("enlace privado:");?></label>
				<? $esPrivado = ((strpos($tags, ":sab:privado")>-1) ? "checked=\"true\"" : ""); ?>
				<input name="privado" type="checkbox" <? echo $esPrivado; ?> id="privado"/><br />

				<label for="etiquetas"><?=__("etiquetas:");?></label><br />
				<input class="input_naranja" type="text" name="etiquetas" id="etiquetas" value="<? $tags_temp=str_replace(":sab:privado", "", $tags); echo trim($tags_temp); ?>" size="86" /><br />
				<p><?=__("escribe las etiquetas separadas por un espacio en blanco (ej: xhtml css php).");?></p>
				<fieldset>
					<legend><?=__("Agregar etiquetas");?></legend>
					<?php getTags("javascript"); ?>
				</fieldset>

				<input class="submit" type="submit" name="accion" value="<?=(isset($_GET['id']) ? __("editar") : __("agregar")); ?>" /><br /> <?=(isset($_GET['id']) ? "<a href=\"".$Sabrosus->sabrUrl."/eliminar.php?id=".$row['id_enlace']."\" title=\" ".__("Eliminar enlace")."\">".__("Eliminar enlace")." &raquo;</a>" : ""); ?><br />

			</fieldset>
			</form>
		</div>
		<fieldset>
			<legend><?=__("Instalar el bookmarklet.");?></legend>
			<label><?=__("Arrastar a la \"Bookmarks Toolbar\" el siguiente recuadro:");?><a href="javascript:location.href='<?=$Sabrosus->sabrUrl?>/editar.php?url='+encodeURIComponent(location.href)+'&titulo='+encodeURIComponent(document.title)" title="<?=__("agregar a sabros.us");?>" class="bookmarklet"><?=__("agregar a sabros.us");?></a></label>
		</fieldset>
	</div>

	<div id="pie">
		<p class="powered"><?=__("generado con:")?>&nbsp;&nbsp;<a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
	</div>
</div>
</body>
</html>
