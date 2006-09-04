<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/lang.php");
include("include/functions.php");

if (isset($_GET['instalarlang'])) {
	initIdioma($_GET['instalarlang']);
} else if (isset($_POST['instalarlang'])) {
	initIdioma($_POST['instalarlang']);
} else {
	initIdioma();
}

$errors_d=array();
$errors_d[11]=__("Debes introducir el servidor de base de datos");
$errors_d[12]=__("Debes introducir el usuario para la base de datos");
$errors_d[13]=__("Debes introducir el password para la base de datos");
$errors_d[14]=__("Debes introducir el nombre de la base de datos a utilizar");
$errors_d[21]=__("Debes introducir el password para el usuario admin");
$errors_d[31]=__("Debes introducir la URL para sabros.us");
$errors_d[32]=__("Debes introducir la URL para el sitio");
$errors_d[101]=__("Los passwords introducidos no coinciden");
$errors_d[102]=__("Los passwords introducidos no coinciden");
$errors_d[201]=__("No fue posible conectarse a la base de datos. Ppor favor revisa los valores introducidos e intentalo nuevamente");
$errors_d[301]=__("No es posible escribir el archivo <code>include/config.php</code>. Debes cambiar los permisos de dicho archivo de modo de poder ser escrito por el instalador.");

$accion="";
$errors="";

if (isset($_POST['accion'])){
	$accion=$_POST['accion'];
}
if (filesize("include/config.php") < 100) {
	$mostrarform = true;
} else {
	$mostrarform = false;
}
if ($accion=="config") {
	//Validar entradas
	$server=$_POST['dbserver'];
	$dbUser=$_POST['dbuser'];
	$dbPass=$_POST['dbpass'];
	$dbPass2=$_POST['dbpass2'];
	$dbName=$_POST['dbname'];
	$limite=$_POST['limite'];

	$admPass=$_POST['admpass'];
	$admPass2=$_POST['admpass2'];
	$email=$_POST['email'];
	$sname=$_POST['sname'];
	$stitle=$_POST['stitle'];
	$sabrUrl=$_POST['sabrurl'];
	$siteUrl=$_POST['siteUrl'];
	$prefix=$_POST['prefix'];
	$useFriendlyUrl = $_POST['useFriendlyUrl'];
	$lang=$_POST['lang'];
	$sep_err="";
	if (!$server) {
		$errors=$errors.$sep_err."11";
		$sep_err="|";
	}
	if (!$dbUser) {
		$errors=$errors.$sep_err."12";
		$sep_err="|";
	}
	if (!$dbName) {
		$errors=$errors.$sep_err."14";
		$sep_err="|";
	}
	if ($dbPass!=$dbPass2) {
		$errors=$errors.$sep_err."101";
		$sep_err="|";
	}
	if (!$admPass) {
		$errors=$errors.$sep_err."21";
		$sep_err="|";
	}
	if ($admPass!=$admPass2) {
		$errors=$errors.$sep_err."102";
		$sep_err="|";
	}
	if (!$sabrUrl) {
		$errors=$errors.$sep_err."31";
		$sep_err="|";
	}
	if (!$siteUrl) {
		$errors=$errors.$sep_err."32";
		$sep_err="|";
	}
	if (!$errors) {
		$fname="include/config-sample.php";
		$f = fopen($fname, "r");
		$cfg=fread($f, filesize($fname));
		fclose($f);
		$cfg=str_replace("[server]",$server,$cfg);
		$cfg=str_replace("[dbuser]",$dbUser,$cfg);
		$cfg=str_replace("[dbpass]",$dbPass,$cfg);
		$cfg=str_replace("[database]",$dbName,$cfg);
		$cfg=str_replace("[prefix]",$prefix,$cfg);
		$fname="include/config.php";
		if (is_writable($fname)) {
			$f = fopen($fname, "w");
			fwrite($f,$cfg);
			//Instala la bd
			fclose($f);
			include("include/config.php");
			if (installdb($server, $dbUser, $dbPass, $dataBase, $prefix, $stitle, $sname, $siteUrl, $sabrUrl, $useFriendlyUrl, $lang, $limite, $email, $admPass)){
				$mostrarform=false;
			} else {
				$errors=$errors.$sep_err."201";
				$sep_err="|";
				$mostrarform=true;
			}
		} else {
			$errors=$errors.$sep_err."301";
			$sep_err="|";
			$mostrarform=true;
		}
	} else {
		$mostrarform=true;
	}
}

require_once("include/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title>sabros.us/<?=__("instalaci&oacute;n");?></title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="sabor.css" type="text/css" />
	<link rel="stylesheet" href="instalar.css" type="text/css" />
	<link rel="shortcut icon" href="images/sabrosus_icon.png" />
</head>
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=__("instalaci&oacute;n");?></span></h2>
	</div>
	<div id="instalarlang">
		<?php
			foreach ($idiomas as $idioma => $nombre) {
				echo "<a href=\"instalar.php?instalarlang=".$idioma."\">".$nombre."</a> ";
			}
		?>
	</div>

	<div id="contenido">

<?php
if ($mostrarform) {
	if (mostrarerror($errors,$errors_d,"201")) {
		echo "<div class=\"error\">".mostrarerror($errors,$errors_d,"201")."</div>";
	}?>
	<?php if (mostrarerror($errors,$errors_d,"301")) {
		echo "<div class=\"error\">".mostrarerror($errors,$errors_d,"301")."</div>";
	}?>
	<form method="post" action="instalar.php" id="config_form">
		<?php if (isset($_GET['instalarlang']) || isset($_POST['instalarlang'])) {
			$setLang=isset($_GET['instalarlang'])?$_GET['instalarlang']:$_POST['instalarlang'];
			echo "<input style=\"display:none;\" type=\"hidden\" name=\"instalarlang\" value=\"".$setLang."\" />";
		} ?>
		<fieldset>
			<legend><?=__("Configuraci&oacute;n de la base de datos");?></legend>
			<div>
				<label for="dbserver"><?=__("servidor:");?></label><input type="text" name="dbserver" id="dbserver" value="<?=$server?>"/><?=mostrarerror($errors,$errors_d,"11")?><br/>
				<label for="dbuser"><?=__("usuario:");?></label><input type="text" name="dbuser" id="dbuser" value="<?=$dbUser?>"/><?=mostrarerror($errors,$errors_d,"12")?><br/>
				<label for="dbpass"><?=__("password:");?></label><input type="password" name="dbpass" id="dbpass" value=""/><?=mostrarerror($errors,$errors_d,"13")?><br/>
				<label for="dbpass2"><?=__("reescribe el password:");?></label><input type="password" name="dbpass2" id="dbpass2" value=""/><?=mostrarerror($errors,$errors_d,"101")?><br/>
				<label for="dbname"><?=__("base de datos:");?></label><input type="text" name="dbname" id="dbname" value="<?=$dataBase?>"/><?=mostrarerror($errors,$errors_d,"14")?><br/>
				<label for="prefix"><?=__("prefijo para las tablas:");?></label><input type="text" name="prefix" id="prefix" value="<?=$prefix?>"/>
			</div>
		</fieldset>
		<fieldset>
			<legend><?=__("Configuraci&oacute;n de sabros.us");?></legend>
			<div>
				<label for="admpass"><?=__("password para el control panel:");?></label><input type="password" name="admpass" id="admpass" value=""/><?=mostrarerror($errors,$errors_d,"21")?><br/>
				<label for="admpass2"><?=__("reescribe el password:");?></label><input type="password" name="admpass2" id="admpass2" value=""/><?=mostrarerror($errors,$errors_d,"102")?><br/>
				<label for="email"><?=__("email:");?></label><input type="text" name="email" id="email" value=""/><br/>
				<label for="sname"><?=__("nombre de tu sitio:");?></label><input type="text" name="sname" id="sname" value="<?=$siteName?>"/><br/>
				<label for="stitle"><?=__("descripci&oacute;n del sitio:");?></label><input type="text" name="stitle" id="stitle" value="<?=$siteTitle?>"/><br/>
				<label for="sabrurl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> de sabros.us:");?><br/><?=__("(sin <q>/</q> al final)");?></label><input type="text" name="sabrurl" id="sabrurl" value="<?=$sabrUrl?>"/><?=mostrarerror($errors,$errors_d,"31")?><br/>
				<label for="siteUrl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> del sitio principal:");?><br/><?=__("(sin <q>/</q> al final)");?></label><input type="text" name="siteUrl" id="siteUrl" value="<?=$siteUrl?>"/><?=mostrarerror($errors,$errors_d,"32")?><br/>
				<label for="limite"><?=__("n&uacute;mero de enlaces por p&aacute;gina:");?></label><input type="text" name="limite" id="limite" value="10"/><br/>
				<label for="useFriendlyUrl"><?=__("<abbr title=\"Uniform Resource Locator\">URL</abbr> amigable:");?></label>
				<select name="useFriendlyUrl" id="useFriendlyUrl">
					<option value="1"><?=__("activado");?></option>
					<option value="0" selected="selected"><?=__("desactivado");?></option>
				</select><br/>
				<label for="lang"><?=__("idioma");?></label>
				<select id="lang" name="lang">
					<?php
						foreach ($idiomas as $idioma => $nombre) {
							if($idioma=="es_MX") {
								echo "<option value=\"".$idioma."\" selected=\"selected\">".$nombre."</option>\n";
							} else {
								echo "<option value=\"".$idioma."\">".$nombre."</option>\n";
							}
						}
					?>
				</select>
			</div>
		</fieldset>
		<p>
			<input type="hidden" name="accion" id="accion" value="config" style="display:none;"/>
			<input type="submit" name="btnsubmit" id="btnsubmit" value="<?=__("configurar");?>" class="submit"/>
		</p>
	</form>
<?php
} else {
	echo "<p>".__("La instalaci&oacute;n de <strong>sabros.us</strong> se realiz&oacute; satisfactoriamente. Puedes acceder al <a href=\"cpanel.php\">Panel de control</a> y comenzar a agregar enlaces o <a href=\"index.php\">ver el sitio</a>.")."</p>";
}
?>
	</div>
	<div id="pie">
		<p class="powered"><?=__("generado con:");?> <a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
	</div>
</div>
</body>
</html>

<?
function installdb($server, $dbUser, $dbPass, $dataBase, $prefix, $stitle, $sname, $siteUrl, $sabrUrl, $useFriendlyUrl, $lang, $limite, $email, $admPass){
		if (!($link=mysql_connect($server, $dbUser, $dbPass))) {
			return false;
		}
		if (!mysql_select_db($dataBase,$link)) {
			return false;
		}

		$sqlStr = "CREATE TABLE `".$prefix."sabrosus` (
			`id_enlace` int(3) NOT NULL auto_increment,
			`title` varchar(100) NOT NULL default '',
			`enlace` varchar(100) NOT NULL default '',
			`descripcion` text NOT NULL,
			`tags` varchar(75) NOT NULL default '',
			`fecha` datetime default NULL,
			PRIMARY KEY (`id_enlace`)
			) TYPE=MyISAM;";
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

		$sqlStr = "INSERT INTO `".$prefix."sabrosus` VALUES (1,'Stanmx.com - Buscando la accesibilidad','http://www.stanmx.com','P&aacute;gina de Estanislao Vizcarra, autor de sa.bro.sus.','css xhtml dise&ntilde;o web estandares cine php','2005-07-10 00:41:06');";
		$result = mysql_query($sqlStr);
		$sqlStr = "INSERT INTO `".$prefix."sabrosus` VALUES (2,'Pecesama.Net [developing the future]','http://www.pecesama.net','P&aacute;gina de Pedro Santana, co-autor de sabros.us','php programaci&oacute;n web java javascript','2005-07-10 00:42:04');";
		$result = mysql_query($sqlStr);

		$sqlStr = "INSERT INTO `".$prefix."config` VALUES ('".$sname."','".$stitle."','".$siteUrl."','".$sabrUrl."','".$useFriendlyUrl."','".$lang."','".$limite."','".$email."','".md5($admPass)."');";
		$result = mysql_query($sqlStr);

		return true;
}

function inerrors($errors,$n) {
	if (strpos($errors,$n)===false)
		return false;
	else
		return true;
}

function mostrarerror($errors,$errors_d,$n) {
	if (inerrors($errors,$n))
		return $errors_d[$n];
	else
		return "";
}

?>
