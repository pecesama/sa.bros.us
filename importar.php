<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

//Script basado parcialmente en el del proyecto Scuttle [http://sourceforge.net/projects/scuttle/]
include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if (esAdmin())
{
	if (sizeof($_FILES) > 0 && $_FILES['userfile']['size'] > 0) {
	
		if (isset($_POST["status"]) && $_POST["status"]=="1") {
			$status = ":sab:privado";
		} else {
			$status = "";
		}
		
		// Manejador del archivo
		$html = file_get_contents($_FILES['userfile']['tmp_name']);
		
		// Crear el arreglo de enlaces
		preg_match_all('/<a\s+(.*?)\s*\/*>([^<]*)/si', $html, $matches);
		$links = $matches[1];
		$titles = $matches[2];
		
		$size = count($links);
		for ($i = 0; $i < $size; $i++) {
			$attributes = preg_split('/\s+/s', $links[$i]);
			foreach ($attributes as $attribute) {
				$att = preg_split('/\s*=\s*/s', $attribute, 2);
				$attrTitle = $att[0];
				$attrVal = eregi_replace('"', '&quot;', preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]));
				switch ($attrTitle) {
					case "HREF":
						$bAddress = $attrVal;
						break;
					case "ADD_DATE":
						$bDatetime = gmdate('Y-m-d H:i:s', $attrVal);
						break;
				}
			}
			$bTitle = eregi_replace('"', '&quot;', trim($titles[$i]));
		   
			// Si el enlace dice ser del futuro, le asigna la fecha a hoy
			if (strtotime($bDatetime) > time()) {
				$bDatetime = gmdate('Y-m-d H:i:s');
			}
	
			// Esto es por si tiene almacenados bookmarlets (claro no funcionaran, pero no tiene caso)
			$bAddress=eregi_replace("\"","",$bAddress);
			$bAddress=eregi_replace("\'","",$bAddress);
			if(!isInSabrosus($bAddress))
			{
				$Sql="INSERT INTO ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha)  values ('".$bTitle."','".$status."','".$bAddress."','', '".$bDatetime."')";
				mysql_query($Sql,$link);
			}
		}
		
		header("Location: cpanel.php");
	} else {
	?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("importar marcadores");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("importar marcadores");?></span></h2>
		<p class="submenu">
			<a href="cpanel.php"><?=__("Panel de control");?></a> |
			<a href="importardelicious.php"><?=__("importar de del.icio.us");?></a>
		</p>
	</div>

	<div id="contenido">
		<div id="bookmarks">
			<form id="import" enctype="multipart/form-data" action="importar.php" method="post">
				<fieldset>
					<legend><?=__("Importar");?></legend>
					<label for="userfile"><?=__("Archivo:");?></label>
						<input class="no_style" type="hidden" name="MAX_FILE_SIZE" value="1024000" />
						<input class="input_morado" type="file" name="userfile" size="50" /><br />
					<label for="status"><?=__("Privacidad:");?></label>
						<select name="status">
							<option value="0"><?=__("P&uacute;blico");?></option>
							<option value="1"><?=__("Privado");?></option>
						</select><br />
					<input class="submit" type="submit" value="<?__("Importar");?>" />
				</fieldset>
			</form>
		
			<h3><?=__("Instrucciones");?></h3>
			<ol>
				<li>
					<p><?=__("Exportar tus marcadores de tu navegador a un archivo");?>:</p>
					<ul>
						<li><?=__("Internet Explorer: <kbd>Archivo &gt; Importar y Exportar... &gt; Exportar Favoritos</kbd>");?></li>
						<li><?=__("Mozilla Firefox: <kbd>Marcadores &gt; Administrar Marcadores... &gt; Archivo &gt; Exportar...</kbd>");?></li>
						<li><?=__("Netscape: <kbd>Marcadores &gt; Administrar Marcadores... &gt; Herramientas &gt; Exportar...</kbd>");?></li>
					</ul>
				</li>
				<li><?__("Clic <kbd>Examinar...</kbd> para encontrar el archivo de marcadores guardado en la computadora. El tama&ntilde;o m&aacute;ximo del archivo puede ser de 1MB");?>.</li>
				<li><?__("Seleccionar la privacidad por defecto asignada a los marcadores importados");?>.</li>
				<li><?__("Clic <kbd>Importar</kbd> para iniciar la importaci&oacute;n de marcadores; esto puede llevar algo de tiempo");?>.</li>
			</ol>
		</div>
	</div>
		<div id="pie">
			<p class="powered"><?=__("Generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		</div>
	</div>
</body>
</html>
<?
	}
} else {
	header("Location: login.php");
}
?>
