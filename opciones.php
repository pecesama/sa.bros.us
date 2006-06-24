<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

ob_start();
include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if (esAdmin()) {
	if (isset($_POST["accion"])) {
		$errores = 0;
		$sql = "UPDATE `".$prefix."config` SET
					`site_name` = '".$_POST['sname']."',
					`site_title` = '".$_POST['stitle']."',
					`site_url` = '".$_POST['surl']."',
					`sabrosus_url` = '".$_POST['saburl']."',
					`url_friendly` = '".$_POST['useFriendlyUrl']."',
					`idioma` = '".$_POST['selIdioma']."',
					`limite_enlaces` = '".$_POST['limit']."',
					`admin_email` = '".$_POST['email']."'";
		if ($_POST[pass1]!=$_POST[pass2]){
			echo __("Las contrase&ntilde;as deben ser iguales");
			$errores += 1;
		} else {
			if ($_POST[pass1] != "") {
				$encript = md5($_POST[pass1]);
				$sql .= ", `admin_pass` = '".$encript."'";
			}
		}
		$sql .= " WHERE (`sabrosus_url` = '".$Sabrosus->sabrUrl."') LIMIT 1";

		$cfg = parse_ini_file("include/config.ini", true);

		$multi = (isset($_POST["contenidos_multi"]) ? "1" : "0");
		$comp = (isset($_POST['compartir']) ? "1" : "0");
		$descrip = (isset($_POST['descripciones']) ? "1" : "0");
		$cfg['tags_cloud']['color'] = $_POST['color_tags'];
		$cfg['multimedia_content']['allow'] = $multi;
		$cfg['exportar']['compartir'] = $comp;
		$cfg['links_badge']['descripciones'] = $descrip;

		if (!is_writeable("include/config.ini")) {
			$errores +=1;
		}
		if (!$errores) {
			saveIni("include/config.ini", $cfg);
			$result = mysql_query($sql);
			header("Location: opciones.php?ex=1");
		} else {
			if (!is_writeable("include/config.ini")) {
				header("Location: opciones.php?er=2");
			} else {
				header("Location: opciones.php?er=1");
			}
		}
	} else {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("opciones");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl;?>/instalar.css" type="text/css" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl;?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl;?>/images/sabrosus_icon.png" />
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
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("opciones");?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=__("Panel de control");?></a> |
				<a href="index.php"><?=__("ir a sa.bros.us");?></a>
			</p>
	</div>
	<div id="contenido">
		<? if (isset($_GET["ex"])) { ?>
			<div id="divContenedor" class="exito">
				<p><?=__("Los cambios se han almacenado con &eacute;xito");?></p>
			</div>
		<? } ?>
		<? if (isset($_GET["er"]) && $_GET["er"] == "1") { ?>
			<div id="divContenedor" class="error">
				<p><?=__("Ha ocurrido un error al almacenar los cambios");?></p>
			</div>
		<? } ?>
		<? if (isset($_GET["er"]) && $_GET["er"] == "2") { ?>
			<div id="divContenedor" class="error">
				<p><?=__("El archivo <code>include/config.ini</code> no tiene permisos de escritura");?></p>
			</div>
		<? } ?>
		<div id="formulario">
			<form name="config_form" id="config_form" action="opciones.php" method="post">
				<fieldset>
					<legend><?=__("Configuraci&oacute;n de sa.bros.us");?></legend>
					<label for="sname"><?=__("Nombre del sitio:");?></label><input type="text" name="sname" id="sname" value="<?=$Sabrosus->siteName?>" /><br />
					<label for="stitle"><?=__("Descripci&oacute;n del sitio:");?></label><input type="text" name="stitle" id="stitle" value="<?=$Sabrosus->siteTitle?>" /><br />
					<label for="surl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> del sitio principal:");?></label><input type="text" name="surl" id="surl" value="<?=$Sabrosus->siteUrl?>" /><br />
					<label for="saburl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> de sa.bros.us:");?></label><input type="text" name="saburl" id="saburl" value="<?=$Sabrosus->sabrUrl?>" /><br />
					<label for="useFriendlyUrl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> Amigable:");?></label>
						<select name="useFriendlyUrl" id="useFriendlyUrl">
							<option value="1" <? if($Sabrosus->usefriendlyurl) echo "selected"; ?>><?=__("Activado");?></option>
							<option value="0" <? if(!$Sabrosus->usefriendlyurl) echo "selected"; ?>><?=__("Desactivado");?></option>
						</select><br />
					<label for="selIdioma"><?=__("Idioma:");?></label>
						<select name="selIdioma">
						<?
						foreach ($idiomas as $idioma => $nombre) {
							if ($idioma==$Sabrosus->archivoIdioma) {
								echo "<option value=\"".$idioma."\" selected=\"true\">".$nombre."</option>\n";
							} else {
								echo "<option value=\"".$idioma."\">".$nombre."</option>\n";
							}
						}
						?>
						</select><br />
				</fieldset>
				<fieldset>
					<legend><?=__("Configuraci&oacute;n de la apariencia");?></legend>

					<label for="limit"><?=__("Enlaces por p&aacute;gina:");?></label><input type="text" name="limit" id="limit" value="<?=$Sabrosus->limit?>" /><br />
					<label for="color_tags"><?=__("Color para la nube de etiquetas:");?></label>
					<select name="color_tags" id="color_tags">

					<?
					$colors = array(__("Naranja"), __("Azul"), __("Verde"), __("Rojo"), __("Gris"), __("Aleatorio"));

					foreach ($colors as $i => $color) {
						echo "<option value=\"{$i}\"";
						echo ($Sabrosus->tagsColor == $i)? " selected=\"selected\"" : "";
						echo ">{$color}</option>";
						$i++;
					}
					?>

					</select><br />

					<? $multi = (($Sabrosus->multiCont=="1") ? "checked=\"true\"" : ""); ?>
					<? $compartir = (($Sabrosus->compartir=="1") ? "checked=\"true\"" : ""); ?>
					<? $descripciones = (($Sabrosus->desc_badge=="1") ? "checked=\"true\"" : ""); ?>
					<label for="contenidos_multi"><?=__("Mostrar contenidos multimedia:");?></label><input name="contenidos_multi" type="checkbox" <? echo $multi; ?> id="contenidos_multi" /><br />
					<label for="compartir"><?=__("Permitir que se exporten los enlaces:");?></label><input name="compartir" type="checkbox" <? echo $compartir; ?> id="compartir" /><br />
					<label for="descripciones"><?=__("Mostrar descripciones en el badge de enlaces:");?></label><input name="descripciones" type="checkbox" <? echo $descripciones; ?> id="descripciones"/><br />
				</fieldset>
				<fieldset>
					<legend><?=__("Configuraci&oacute;n del Administrador")?></legend>
					<label for="pass1"><?=__("Contrase&ntilde;a para el <strong>panel de control</strong>:");?></label><input type="password" name="pass1" id="pass1" value=""/><br />
					<label for="pass2"><?=__("Reescribe la contrase&ntilde;a:");?></label><input type="password" name="pass2" id="pass2" value=""/><br /><div class="ejemplo"><?=__("Deje en blanco para no cambiar la contrase&ntilde;a");?></div>
					<label for="email"><?=__("E-mail:");?></label><input type="text" name="email" id="email" value="<?=$Sabrosus->emailAdmin?>"/><br />
					<input class="submit" type="submit" name="accion" value="<?=__("actualizar");?>" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id="pie">
		<p class="powered"><?=__("Generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>
<?php
	} //POST[action]
} else { //no es Admin
	header("Location: login.php");
}
?>
