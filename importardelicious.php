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
	include("lang/".$Sabrosus->archivoIdioma);

if (esAdmin())
{
	$accion=$_POST["accion"];
	if ($accion=="import") {
		include "include/importdelicious.php";
		$respImport=importdelicious($_POST["username"],$_POST["password"]);
	} 
?>
<!-- Sa.bros.us monousuario version 1.7 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[deli_titulo]?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us 1.7" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[deli_titulo];?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=$idioma[panel_control];?></a> |
				<a href="importar.php"><?=$idioma[deli_imp_archivo];?></a>
			</p>
	</div>
	<div id="contenido">
<?
	if ($accion=="import")
	{
		if ($respImport["responseCode"]=="200")
		{
        ?>
        <div class="ok">
        <p>
		<?=str_replace("%no_importados%",$respImport["imported"],$idioma[deli_act_correcta])?> 
        <?=str_replace("%no_noimportadosrepetidos%",$respImport["total"]-$respImport["imported"],$idioma[deli_enlaces_repe])?>
		</p>
        </div>
		<?
		} else { 
			switch (true)
			{
				case ($respImport["responseCode"]=="401"):
				?>
					<div class="error"><?=$idioma[deli_e401];?></div>
				<?
				break;
				default:
				?>
				<div class="error"><?=str_replace("%no_error%",$respImport["responseCode"],$idioma[deli_error_desc]);?></div>
				<?
			}
			$mostrarform=true;
		}
	}
    if ($mostrarform||!isset($accion))
	{
	?>
		<div id="formulario">
			<p><?=$idioma[deli_instruc]?></p>
			<form action="importardelicious.php" method="post">
				<fieldset>
					<legend><?=$idioma[deli_legend];?></legend>
					<label for="username"><?=$idioma[deli_usuario];?></label><br />
					<input type="text" name="username" /><br />	
					<label for="password"><?=$idioma[deli_pass];?></label><br />
					<input type="password" name="password" /><br />
					<input class="no_style" type="hidden" name="accion" value="import" />
					<input class="submit" type="submit" name="accion" value="<?=$idioma[deli_boton];?>" />
				</fieldset>
			</form>	
		</div>
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
	} else {
		header("Location: login.php");
	}	
    ?>