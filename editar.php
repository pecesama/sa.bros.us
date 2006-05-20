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

	if (!esAdmin()) {
		if (isset($_GET['id'])) {
			header("Location: login.php?dirigir=".urlencode("editar.php?id=".$_GET['id']));
		} elseif (isset($_GET['url'])) {
			if (isset($_GET['titulo'])) {
				if (get_magic_quotes_gpc()) {
					$titulo = stripslashes($_GET['titulo']);
				} else {
					$titulo = $_GET['titulo'];
				}
			}
			header("Location: login.php?dirigir=" . urlencode("editar.php?url=".urlencode($_GET['url']) . (isset($titulo) ? "&titulo=".urlencode($titulo) : "")));
		} else {
			header("Location: login.php");
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
	
		if ($_GET['titulo']) {
			if (get_magic_quotes_gpc()) {
				$titulo = stripslashes($_GET['titulo']);
			} else {
				$titulo = $_GET['titulo'];
			}
		} else {
			$titulo = "";
		}
		$enlace = $_GET['url'];
		$descripcion = $etiquetas['description'];
		$tags = comasxespacios($etiquetas['keywords']);
	}

	$titulo = htmlentities($titulo);
?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><? echo (isset($_GET["id"]) ? $idioma[editar_enlace] : $idioma[agregar_enlace]); ?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl?>/include/addtags.js"></script>
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><? echo (isset($_GET["id"]) ? $idioma[editar_enlace] : $idioma[agregar_enlace]); ?></span></h2>
		<p class="submenu"><a href="cpanel.php"><?=$idioma[panel_control];?></a> | <a href="editar.php"><?=$idioma[agregar_enlace];?></a></p>
	</div>

	<div id="contenido">
		<div id="formulario">
			<form method="post" action="<? echo (isset($_GET["id"]) ? "modifica.php" : "agregar.php"); ?>">

			<? if (!isset($_GET["id"]) && (isset($_GET["titulo"]) && isset($_GET["url"]))) { ?>
				<input class="no_style" type="hidden" name="regresa" value="<?=urlencode($_GET['url'])?>" />
			<? } ?>

			<? if (isset($_GET["id"])) { ?>
				<input class="no_style" type="hidden" name="id_enlace" value="<?=$_GET["id"];?>" />
			<? } ?>

			<fieldset>
				<legend><? echo (isset($_GET["id"]) ? $idioma[titulo_editar] : $idioma[titulo_agregar]); ?></legend>
				<label for="title"><?=$idioma[titulo];?></label><br />
				<input class="input_morado" type="text" name="title" value="<? echo $titulo; ?>" size="86" /><br />

				<label for="enlace"><?=$idioma[enlace];?></label><br />
				<input class="input_morado" type="text" name="enlace" value="<? echo $enlace; ?>" size="86" /><br />

				<label for="descripcion"><?=$idioma[descripcion];?></label>
				<textarea class="textarea_oscuro" rows="3" cols="84" name="descripcion"><? echo $descripcion; ?></textarea><br />

				<label for="etiquetas"><?=$idioma[etiquetas];?></label><br />
				<input class="input_naranja" type="text" name="etiquetas" id="etiquetas" value="<? $tags_temp=str_replace(":sab:privado", "", $tags); echo trim($tags_temp); ?>" size="86" /><br />
				<p><?=$idioma[ayuda_editar];?></p>
				<fieldset>
					<legend><?=$idioma[agregar_etiquetas];?></legend>
					<?php include("insertags.php");?>
				</fieldset>

				<label for="privado"><?=$idioma[enlaces_privados];?></label>
				<? $esPrivado = ((strpos($tags, ":sab:privado")>-1) ? "checked=\"true\"" : ""); ?>
				<input name="privado" type="checkbox" <? echo $esPrivado; ?> id="privado"/><br />

				<input class="submit" type="submit" name="accion" value="<? echo (isset($_GET['id']) ? $idioma[boton_editar] : $idioma[boton_agregar]); ?>" /><br />

			</fieldset>
			</form>
		</div>
		<fieldset>
			<legend><?=$idioma[titulo_bookmarklet];?></legend>
			<label><?=$idioma[descripcion_bookmarklet];?><a href="javascript:location.href='<?=$Sabrosus->sabrUrl?>/editar.php?url='+encodeURIComponent(location.href)+'&titulo='+encodeURIComponent(document.title)" title="<?=$idioma[agregar_a_sabrosus];?>" class="bookmarklet"><?=$idioma[agregar_a_sabrosus];?></a></label>
		</fieldset>
	</div>

	<div id="pie">
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>
