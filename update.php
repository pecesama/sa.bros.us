<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?
	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	$a=explode(';',$GLOBALS[HTTP_ACCEPT_LANGUAGE]);
	if (preg_match('/es/',$a[0]))
	{
		$archivoIdioma = "es-mx.php";
	} else {
		$archivoIdioma = "en.php";
	}
	include("lang/".$archivoIdioma);
?>
<?
	if($Sabrosus->adminPass!="")
	{
		include("lang/".$Sabrosus->archivoIdioma);
	?>
	<!-- Sa.bros.us monousuario version <?=version();?> -->
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
	<head>
		<title><?=$idioma[up_titulo]?>/sa.bros.us</title>
		<meta name="generator" content="Sa.bros.us <?=version();?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />	
		<meta http-equiv="refresh" content="10;URL=index.php" />
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />		
		<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/instalar.css" type="text/css" />
		<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />		
	</head>
	<body>
	<div id="pagina">
		<div id="titulo">
			<h2>sa.bros.us/<span><?=$idioma[up_titulo]?></span></h2>
		</div>
		<div id="contenido">
			<?
			/* Aqui se convirten los enlaces a utf-8 */
			$cfg = new iniParser("include/config.ini");
			$aux_codificado = $cfg->get("codificacion","utf");
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
					$cfg->setValue("codificacion","utf", "1");
					$cfg->save();
					?>
					<p><?=$idioma[up_act_correcta2]?></p>
				<?
				} else { /* No se realizó la codificación y no viene por POST -> Muestro el form para convertir */
				?>
					<p><?=$idioma[up_caracteres_utf]?></p>
						<form method="post" action="update.php" id="config_form">
							<input class="submit" type="submit" id="btnconvertir" value="<?=$idioma[up_form_boton]?>" />
						</form>
				<?
				}
			} else { /* Ya se realizó una vez la codificación -> Muestro un mensaje y nada mas */
			?><p><?=$idioma[up_act_hecha]?></p>
			<?
			}
			?>
		</div>
		<div id="pie">
			<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
		</div>
	</div>
	</body>
	</html>
	<?
	die();
	}
?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[up_titulo]?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />	
	<link rel="stylesheet" href="<?=$sabrUrl?>/sabor.css" type="text/css" />
	<link rel="stylesheet" href="<?=$sabrUrl?>/instalar.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$sabrUrl?>/images/sabrosus_icon.png" />		
</head>
<body>
<div id="pagina">

	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[up_titulo]?></span></h2>
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
						echo "<p>".$idioma[up_act_correcta]."</p>";
					}
				} else {
					echo "<p>".$idioma[up_error_config]."</p>";
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
					<legend><?=$idioma[up_form_leyenda]?></legend>
					  <div>
						<?
						if(!isset($adminPass)){
							echo "<p>".$idioma[up_error_config2]."</p>";
						} else {
							echo "<p>".$idioma[up_form_descr]."</p>";
							echo "<p><input type=\"submit\" name=\"btnsubmit\" id=\"btnsubmit\" value=\"".$idioma[up_form_boton]."\" class=\"submit\"/><p>";
						}
						?>
					  </div>
				</fieldset>
			<?
		}
	?>
	</div>
	<div id="pie">
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
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
		if (!$link)  {
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
			PRIMARY KEY  (`sabrosus_url`)
		) TYPE=MyISAM;";
	  	$result = mysql_query($sqlStr);    
		$sqlStr = "INSERT INTO `".$prefix."config` VALUES ('".$siteName."','".$siteTitle."','".$siteUrl."','".$sabrUrl."','".$usefriendlyurl."','".$archivoIdioma."','".$limit."','','".md5($adminPass)."');";
		$result = mysql_query($sqlStr);   
		return true;
	}
?>
