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

/*
PASOS
CASO 1: No ingreso nunca el email del Administrador -> Imposible emplear este metodo.

CASA 2:Existe el email del Admin.
	1. Se solicita el email en un form.
	2. Se lo compara con el guardado en el DB.
	3. Si son iguales ->
		1. Se envia una nuevo password al email del admin
		2. Se cambia el pass el la DB para que pueda hacer el login
	4. Si no son iguales -> Mensaje de error. 
*/
if($_SERVER[REQUEST_METHOD]=="POST"){

	if($Sabrosus->emailAdmin=="")
	{
		header("Location: recordar.php?er=1");
	} else {
		if($_POST[email]==$Sabrosus->emailAdmin)
		{
			$nuevo_password = generar_password();
			$sqlStr = "UPDATE ".$prefix."config SET `admin_pass`='".md5($nuevo_password)."' WHERE (`sabrosus_url` = '".$Sabrosus->sabrUrl."') LIMIT 1";
			
			/* Armamos el email */
			$msg = $idioma[rec_msg_email]. $nuevo_password;
			$asunto = $idioma[rec_email_asunto];
			if(enviaMail($Sabrosus->emailAdmin, $asunto, $msg, $Sabrosus->emailAdmin))
			{
				mysql_query($sqlStr);
				header("Location: recordar.php?ex=1");
			} else {
				header("Location: recordar.php?er=3");
			}
		} else {
			header("Location: recordar.php?er=2");
		}
	}
} else {
?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[rec_titulo];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl?>/include/prototype.lite.js"></script>
    <script type="text/javascript" src="<?=$Sabrosus->sabrUrl?>/include/moo.fx.js"></script>
	<script type="text/javascript">
			var contenedor;           
			
			window.onload = function() {
					contenedor = new fx.Opacity('divContenedor', {duration: 5000, onComplete: function()
									  {
										document.getElementById('divContenedor').style.display="none";
									  }});
					contenedor.toggle();
					
			}
	</script>
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[rec_titulo];?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=$idioma[panel_control];?></a> |
				<a href="index.php"><?=$idioma[ir_inicio];?></a>
			</p>
	</div>
	<div id="contenido">
    	<? if (isset($_GET["ex"])) { ?>
		<div id="divContenedor" class="exito">
			<p><?=$idioma[rec_exito];?></p>
		</div>
		<? } ?>
		<? if (isset($_GET["er"])) { ?>
		<div id="divContenedor" class="error">
			<p><?=$idioma[rec_error.$_GET["er"]]?></p>
		</div>
		<? } ?>
		<div id="formulario">
			<form name="form" id="form" action="recordar.php" method="post">
				<fieldset>
					<legend><?=$idioma[rec_legend];?></legend>
					<p><?=$idioma[rec_descrip]?></p>
					<label for="email"><?=$idioma[rec_email]?></label><input type="text" name="email" id="email" /><br />
					<input class="submit" type="submit" name="btnsubmit" value="<?=$idioma[rec_solicitar]?>" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id="pie">
		<p class="powered"><?=$idioma["generado_con"]?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>
</div>
</body>
</html>
<? } ?>
