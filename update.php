<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	$a = explode(';',$GLOBALS[HTTP_ACCEPT_LANGUAGE]);
	if (preg_match('/es/',$a[0])) {
		$archivoIdioma = "es-mx.php";
		$templocale = "es_MX"
	} else {
		$archivoIdioma = "en.php";
		$templocale = "en";
	}

	if($Sabrosus->adminPass!="") {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
	<head>
		<title><?=__("actualizaci&oacute;n");?>/sa.bros.us</title>
		<meta name="generator" content="Sa.bros.us <?=version();?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="refresh" content="10;URL=index.php" />
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/instalar.css" type="text/css" />
		<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	</head>
	<body>
	<div id="pagina">
		<div id="titulo">
			<h2>sa.bros.us/<span><?=__("actualizaci&oacute;n");?></span></h2>
		</div>
		<div id="contenido">
			<?
			/* Aqui se convirten los enlaces a utf-8 */
			$cfg = parse_ini_file("include/config.ini", true);
			$aux_codificado = $cfg['codificacion']['utf'];
			if($aux_codificado=="0")
			{
				if($_SERVER["REQUEST_METHOD"]=="POST"){
					$sqlStr = "SELECT * FROM ".$prefix."sabrosus";
					$result = mysql_query($sqlStr);
					while ($row = mysql_fetch_array($result))
					{
						$id = $row["id_enlace"];
						$titulo_temp  = utf8_encode($row["title"]);
						$descrip_temp = utf8_encode($row["descripcion"]);
						$tag_temp     = utf8_encode($row["tags"]);
						$sql_update = "UPDATE ".$prefix."sabrosus SET title='".$titulo_temp."', descripcion='".$descrip_temp."', tags = '".$tag_temp."'	WHERE `id_enlace` = ".$id." LIMIT 1";
						mysql_query($sql_update);
					}
					$cfg['codificacion']['utf'] = 1;
					saveIni("include/config.ini",$cfg);
					?>
					<p><?=__("la actualizaci&oacute;n de <strong>sa.bros.us</strong> se realiz&oacute; satisfactoriamente. puedes acceder al <a href=\"/cpanel.php\">panel de control</a> y comenzar a agregar enlaces o <a href=\"/index.php\">ver el sitio.</a>");?></p>
				<?
				} else { /* No se realizó la codificación y no viene por POST -> Muestro el form para convertir */
				?>
					<p><?=__("si aparecen caracteres extra&ntilde;os en algunos enlaces, clic en el boton para solucionarlo.");?></p>
						<form method="post" action="update.php" id="config_form">
							<input class="submit" type="submit" id="btnconvertir" value="<?=__("actualizar");?>" />
						</form>
				<?
				}
			} else { /* Ya se realizó una vez la codificación -> Muestro un mensaje y nada mas */
			?><p><?=__("<strong>atenci&oacute;n</strong>: la actualizaci&oacute;n ya fue realizada anteriormente. no es necesario volver a ejecutarla.");?></p>
			<?
			}
			?>
		</div>
		<div id="pie">
			<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		</div>
	</div>
	</body>
	</html>
	<?
	die();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("actualizaci&oacute;n");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$sabrUrl?>/sabor.css" type="text/css" />
	<link rel="stylesheet" href="<?=$sabrUrl?>/instalar.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$sabrUrl?>/images/sabrosus_icon.png" />
</head>
<body>
<div id="pagina">

	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("actualizaci&oacute;n");?></span></h2>
	</div>
	<div id="contenido">
	<?
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($adminPass)){
				$fname="include/config-sample.php";
				$f = fopen($fname, "r");
				$cfg=fread($f, filesize($fname));
				fclose($f);
				$cfg=str_replace("[server]",$server,$cfg);
				$cfg=str_replace("[dbuser]",$dbUser,$cfg);
				$cfg=str_replace("[dbpass]",$dbPass,$cfg);
				$cfg=str_replace("[database]",$dataBase,$cfg);
				$cfg=str_replace("[prefix]",$prefix,$cfg);
				$fname="include/config.php";
				if (is_writable($fname)) {
					$f = fopen($fname, "w");
					fwrite($f,$cfg);
					fclose($f);
					//Actualiza la DB.
					if(updatedb()){
						echo "<p>".__("la actualizaci&oacute;n de sa.bros.us se realiz&oacute; satisfactoriamente. puedes acceder al <a href=\"/cpanel.php\">panel de control</a> y comenzar a agregar enlaces o <a href=\"/index.php\">ver el sitio.</a>")."</p>";
					}
				} else {
					echo "<p>".__("<strong>error</strong>: el archivo <code>include/config.php</code> no tiene permiso de escritura. c&aacute;mbie los atributos del archivo y vuelva a ejecutar &eacute;sta actualizaci&oacute;n.")."</p>";
				}
			}
		} else {
			//Form de Bienvenida a la Instalación.
			//No es necesario que llene ningun dato escencial para poder realizar la instalción.
			//Aunque podría ser un form parecido a la Instalación, solo que los datos, aparezcan completados automaticamente y solo tenga que apretar el boton "Actualizar" y listo.

			//Antes de mostrar el form, se debería controlar que el archivo config tenga permiso de escritura.
			?>
			<form method="post" action="update.php" id="config_form">
				<fieldset>
					<legend><?=__("actualizaci&oacute;n de sabrosus");?></legend>
					<div>
						<?
						if(!isset($adminPass)){
							echo "<p>".__("<strong>atenci&oacute;n</strong>: no se puede acceder a la informaci&oacute;n necesaria para realizar la actualizaci&oacute;n. por favor, asegurese de que el archivo <code>include/config.php</code> no haya sido reemplazado y tengas los datos de su antig&uuml;a versi&oacute;n.")."</p>";
						} else {
							echo "<p>".__("se proceder&aacute; a realizar la actualizaci&oacute;n de versiones. solo tiene que presionar el boton 'actualizar' y el proceso se realizar&aacute; automaticamente.")."</p>";
							echo "<p><input type=\"submit\" name=\"btnsubmit\" id=\"btnsubmit\" value=\"".__("actualizar")."\" class=\"submit\"/><p>";
						}
						?>
					</div>
				</fieldset>
			<?
		}
	?>
	</div>
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>
<?
	function updatedb()
	{
		global $server,$dbUser,$dbPass,$dataBase,$prefix,$limit;
		global $adminPass,$siteName,$siteTitle,$sabrUrl,$siteUrl,$usefriendlyurl,$archivoIdioma;
		global $link;
		if (!$link) {
			return false;
		}
		$sqlStr = "ALTER TABLE `".$prefix."sabrosus` CHANGE `id_enlace` `id_enlace` INT( 11 ) NOT NULL AUTO_INCREMENT";
		$result = mysql_query($sqlStr);

		$sqlStr = "CREATE TABLE `".$prefix."config` (
			`site_name` varchar(250) NOT NULL default '',
			`site_title` varchar(250) NOT NULL default '',
			`site_url` varchar(250) NOT NULL default '',
			`sabrosus_url` varchar(250) NOT NULL default '',
			`url_friendly` tinyint(1) NOT NULL default '0',
			`idioma` varchar(10) NOT NULL default '',
			`limite_enlaces` int(3) NOT NULL default '0',
			`admin_email` varchar(250) NOT NULL default '',
			`admin_pass` varchar(250) NOT NULL default '',
			PRIMARY KEY (`sabrosus_url`)
		) TYPE=MyISAM;";
		$result = mysql_query($sqlStr);
		$sqlStr = "INSERT INTO `".$prefix."config` VALUES ('".$siteName."','".$siteTitle."','".$siteUrl."','".$sabrUrl."','".$usefriendlyurl."','".$templocale."','".$limit."','','".md5($adminPass)."');";
		$result = mysql_query($sqlStr);
		return true;
	}
?>
