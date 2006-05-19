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
include("lang/".$Sabrosus->archivoIdioma);

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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><? echo $idioma[imp_titulo]; ?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>

<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[imp_titulo];?></span></h2>
		<p class="submenu">
			<a href="cpanel.php"><?=$idioma[panel_control];?></a> |
			<a href="importardelicious.php"><?=$idioma[imp_impor_delicious];?></a>
		</p>
	</div>

	<div id="contenido">
		<div id="bookmarks">
			<form id="import" enctype="multipart/form-data" action="importar.php" method="post">
				<fieldset>
					<legend><?=$idioma[imp_importar];?></legend>
					<label for="userfile"><?=$idioma[imp_archivo];?></label>
						<input class="no_style" type="hidden" name="MAX_FILE_SIZE" value="1024000" />
						<input class="input_morado" type="file" name="userfile" size="50" /><br />
					<label for="status"><? echo $idioma[imp_privacidad]; ?></label>
						<select name="status">
							<option value="0"><? echo $idioma[imp_publico]; ?></option>
							<option value="1"><? echo $idioma[imp_privado]; ?></option>
						</select><br />
					<input class="submit" type="submit" value="<? echo $idioma[imp_importar]; ?>" />
				</fieldset>
			</form>
		
			<h3><? echo $idioma[imp_instrucciones]; ?></h3>
			<ol>
				<li>
					<p><? echo $idioma[imp_desc]; ?>:</p>
					<ul>
						<li><? echo $idioma[imp_ie]; ?></li>
						<li><? echo $idioma[imp_fx]; ?></li>
						<li><? echo $idioma[imp_ns]; ?></li>
					</ul>
				</li>
				<li><? echo $idioma[imp_inst]; ?>.</li>
				<li><? echo $idioma[imp_selecc]; ?>.</li>
				<li><? echo $idioma[imp_daclic]; ?>.</li>
			</ol>
		</div>
	</div>
		<div id="pie">
			<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
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
