<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */
define('ABSPATH', str_replace('/include','',dirname(__FILE__).'/'));
include('lang.php');

session_start();

$link = Conectarse($server, $dbUser, $dbPass, $dataBase);

function Conectarse($server, $dbUser, $dbPass, $dataBase)
{
	if ($link=@mysql_connect($server, $dbUser, $dbPass))
	{
		if (mysql_select_db($dataBase,$link))
		{
			return $link;
		} else {
			$mensaje = "
			<h3 class=\"important\">Can't select database</h3>
			<p>We were able to connect to the database server (which means your username and password is okay) but not able to select the <code>".$dataBase."</code> database.</p>
			<ul>
				<li>Are you sure it exists?</li>
				<li>On some systems the name of your database is prefixed with your username, so it would be like username_wordpress. Could that be the problem?</li>
			</ul>";
			MostrarErrorConexion($mensaje);
		}
	} else {
		$mensaje = "
		<h3 class=\"important\">Error establishing a database connection</h3>
		<p>This either means that the username and password information in your <code>config.php</code> file is incorrect or we can't contact the database server at localhost. This could mean your host's database server is down.</p>
		<ul>
			<li>Are you sure you have the correct username and password?</li>
			<li>Are you sure that you have typed the correct hostname?</li>
			<li>Are you sure that the database server is running?</li>
		</ul>";
		MostrarErrorConexion($mensaje);
	}
}

function MostrarErrorConexion($mensaje)
{
	header('Content-Type: text/html;');
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<title>error/sabros.us</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style media="screen" type="text/css">
		<!--
		body {
			background-color: #FCFCFC;
			color: #333333;
			font-family: "Trebuchet MS", Vendana, Arial, sans-serif;
			font-size: 10pt;
			font-weight: normal;
			margin: auto;
		}
		#pagina {
			background-color: #FCFCFC;
		}
		#titulo {
			background-color: #F7F7F7;
			border-bottom: 1px solid #CCCCCC;
			margin-top: 0;
			padding-top: 0;
			width: 100%;
		}
		#titulo span {
			color: #0066CC;
		}
		#titulo h2 {
			color: #CC6600;
			font: normal 20pt georgia, "times new roman", serif;
			margin-bottom: 10px;
			margin-left: 10px;
			margin-top: 0px;
			padding-bottom: 0;
			padding-top: 10px;
		}
		#contenido {
			margin-left: 10px;
			margin-top: 10px;
			padding-bottom: 10px;
			padding-left: 10px;
			width: 700px;
		}
		#contenido h3 {
			font: normal 17.5px/17px georgia, "times new roman", serif;
			margin-bottom: 0;
			padding-bottom: 0;
		}
		#contenido h3.important {
			font: normal 17.5px/17px georgia, "times new roman", serif;
			color:#CC6600;
			margin-bottom: 0;
			padding-bottom: 7px;
		}
		#contenido p {
			margin-bottom: 0;
			margin-top: 0;
			padding-bottom: 0;
			padding-top: 0;
		}
		-->
		</style>
	</head>
	<body>
		<div id="pagina">
			<div id="titulo">
				<h2>sabros.us/<span>error</span></h2>
			</div>
			<div id="contenido">
				<?=$mensaje;?>
			</div>
		</div>
	</body></html>

	<?
	die();
}

class clsSabrosus
{
	var $siteName;
	var $siteTitle;
	var $sabrUrl;
	var $siteUrl;
	var $usefriendlyurl;
	var $archivoIdioma;
	var $limit;
	var $emailAdmin;
	var $adminPass;
	var $multiCont;
	var $tagsColor;
	var $compartir;
	var $desc_badge;

	function clsSabrosus()
	{
		global $link,$prefix,$locale,$feeds,$idiomas;
		$sql = "SELECT * FROM ".$prefix."config LIMIT 1";
		$result = @mysql_query($sql);
		if(!$result)
		{
			if(isset($feeds))
			{
				header("HTTP/1.0 503 Service Unavailable"); 
				header("Retry-After: 60"); 
				exit();
			} else {
				MostrarErrorConexion("<p>Imposible obtener los datos de configuraci&oacute;n de sabros.us</p>");
			}
		}
		$row = @mysql_fetch_array($result);
		$this->siteName       = $row['site_name'];
		$this->siteTitle      = $row['site_title'];
		$this->sabrUrl        = $row['sabrosus_url'];
		$this->siteUrl        = $row['site_url'];
		$this->usefriendlyurl = $row['url_friendly'];
		$this->archivoIdioma  = $row['idioma'];
		$this->limit          = $row['limite_enlaces'];
		$this->emailAdmin     = $row['admin_email'];
		$this->adminPass      = $row['admin_pass'];

		$cfg = parse_ini_file("include/config.ini", true);
		$this->multiCont = (isset($cfg['multimedia_content']['allow']))?$cfg['multimedia_content']['allow']:"0";
		$this->tagsColor = (isset($cfg['tags_cloud']['color']))?$cfg['tags_cloud']['color']:"0";
		$this->compartir = (isset($cfg['exportar']['compartir']))?$cfg['exportar']['compartir']:"0";
		$this->desc_badge = (isset($cfg['links_badge']['descripciones']))?$cfg['links_badge']['descripciones']:"0";
		$this->ping = (isset($cfg['sopasabrosa']['ping']))?$cfg['sopasabrosa']['ping']:"0";
		$this->soloNube = (isset($cfg['tags_cloud']['alone_index']))?$cfg['tags_cloud']['alone_index']:"0";
		$this->estiloNube = (isset($cfg['tags_cloud']['posicion']))?$cfg['tags_cloud']['posicion']:"0";
		
		get_laguajes();
		
		if (!isset($locale)) {
			if ($this->archivoIdioma == "en.php") {
				$locale = "en";
			} else if ($this->archivoIdioma == "es-mx.php") {
				$locale = "es_MX";
			} else if (esIdioma($this->archivoIdioma)) {
				$locale = $this->archivoIdioma;
			} else {
				$locale = "es_MX";
			}

			initIdioma($locale);
		}
	}
}

$Sabrosus = new clsSabrosus;
?>
