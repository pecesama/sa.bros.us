<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	if (!esAdmin())
	{
		header("Location: login.php");
		exit();
	}
	if (isset($_POST["username"])){
		$isImporting=true;
	}else{
		$isImporting=false;
	}
	if ($isImporting) {
		include "include/importdelicious.php";
       	$respImport=importdelicious($_POST["username"],$_POST["password"]);
	} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("importar de delicious");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=__("importar de delicious");?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=__("panel de control");?></a> |
				<a href="importar.php"><?=__("importar desde un archivo");?></a>
			</p>
	</div>
	<div id="contenido">
<?
	if ($isImporting)
	{
		if ($respImport["responseCode"]=="200")
		{
        ?>
        <div class="ok">
        <p>
		<?=str_replace("%no_importados%",$respImport["imported"],__("Se complet&oacute; exitosamente la importaci&oacute;n de tus enlaces desde del.icio.us. En total se importaron <strong>%no_importados%</strong> enlaces."))?> 
        <?=str_replace("%no_noimportadosrepetidos%",$respImport["total"]-$respImport["imported"],__("No se importaron <strong>%no_noimportadosrepetidos%</strong> enlaces por ya estar incluidos en sabros.us."))?>
		</p>
        </div>
		<?
		} else { 
			switch (true)
			{
				case ($respImport["responseCode"]=="401"):
				?>
					<div class="error"><?=__("El usuario o la contrase&ntilde;a introducidos no son correctos, por favor verificalos e intenta nuevamente.");?></div>
				<?
				break;
				default:
				?>
				<div class="error"><?=str_replace("%no_error%",$respImport["responseCode"],__("Ha ocurrido un error no especificado (error  <strong>%no_error%</strong>). Por favor intenta nuevamente en unos instantes."));?></div>
				<?
			}
			$mostrarform=true;
		}
	}
    if ($mostrarform||!isset($accion))
	{
	?>
		<div id="formulario">
			<p><?=__("Para importar los enlaces desde del.icio.us, ingrese los datos de su cuenta.");?></p>
			<form action="importardelicious.php" method="post">
				<fieldset>
					<legend><?=__("Datos de del.icio.us");?></legend>
					<label for="username"><?=__("usuario:");?></label><br />
					<input type="text" name="username" /><br />	
					<label for="password"><?=__("contrase&ntilde;a:");?></label><br />
					<input type="password" name="password" /><br />
					<input class="submit" type="submit" name="accion" value="<?=__("importar");?>" />
				</fieldset>
			</form>	
		</div>
	<?
	}
	?>	
	</div>
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sabros.us/">sabros.us</a></p>
	</div>
</div>
</body>
</html>
