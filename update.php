<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	$a = explode(';',$GLOBALS[HTTP_ACCEPT_LANGUAGE]);
	if (preg_match('/es/',$a[0])) {
		$Sabrosus->archivoIdioma = "es-mx.php";
		$templocale = "es_MX";
	} else {
		$Sabrosus->archivoIdioma = "en.php";
		$templocale = "en";
	}

	if($Sabrosus->adminPass!="") {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
	<head>
		<title><?=__("actualizaci&oacute;n");?>/sabros.us</title>
		<meta name="generator" content="sabros.us <?=version();?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="refresh" content="10;URL=index.php" />
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/instalar.css" type="text/css" />
		<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	</head>
	<body>
	<div id="pagina">
		<div id="titulo">
			<h2>sabros.us/<span><?=__("actualizaci&oacute;n");?></span></h2>
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
					$result = mysql_query($sqlStr,$link);
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
					<p><?=__("la actualizaci&oacute;n de <strong>sabros.us</strong> se realiz&oacute; satisfactoriamente. puedes acceder al <a href=\"".$Sabrosus->sabrUrl."/cpanel.php\">panel de control</a> y comenzar a agregar enlaces o <a href=\"".$Sabrosus->sabrUrl."/index.php\">ver el sitio.</a>");?></p>
				<?
				} else { /* No se realiz la codificacin y no viene por POST -> Muestro el form para convertir */
				?>
					<p><?=__("si aparecen caracteres extra&ntilde;os en algunos enlaces, clic en el boton para solucionarlo.");?></p>
						<form method="post" action="update.php" id="config_form">
							<input class="submit" type="submit" id="btnconvertir" value="<?=__("actualizar");?>" />
						</form>
				<?
				}
			} else { /* Ya se realiz una vez la codificacin -> Muestro un mensaje y nada mas */
			?><p><?=__("<strong>atenci&oacute;n</strong>: la actualizaci&oacute;n ya fue realizada anteriormente. no es necesario volver a ejecutarla.");?></p>
			<?
			}
			?>
		</div>
		<div id="pie">
			<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
		</div>
	</div>
	</body>
	</html>
	<?
	}
?>