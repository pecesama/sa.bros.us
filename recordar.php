<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");

	
	if($_SERVER[REQUEST_METHOD]=="POST")
	{
		if($Sabrosus->emailAdmin=="")
		{
			header("Location: recordar.php?er=1");
			exit();
		} else {
			if($_POST[email]==$Sabrosus->emailAdmin)
			{
				$nuevo_password = generar_password();
				$sqlStr = "UPDATE ".$prefix."config SET `admin_pass`='".md5($nuevo_password)."' WHERE (`sabrosus_url` = '".$Sabrosus->sabrUrl."') LIMIT 1";
			
				/* Armamos el email */
				$msg = __("La nueva contrase&ntilde;a fue generada de manera autom&aacute;tica - Deber&iacute;a cambiarla por algo m&aacute;s sencillo de recordar -.<br />La nueva contrasea para ingresar al panel de sabros.us es:") . $nuevo_password;
				$asunto = $idioma[rec_email_asunto];
				if(enviaMail($Sabrosus->emailAdmin, $asunto, $msg, $Sabrosus->emailAdmin))
				{
					mysql_query($sqlStr);
					header("Location: recordar.php?ex=1");
					exit();
				} else {
					header("Location: recordar.php?er=3");
					exit();
				}
			} else {
				header("Location: recordar.php?er=2");
				exit();
			}
		}
	} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("recordar contrase&ntilde;a");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
		<h2>sabros.us/<span><?=__("recordar contrase&ntilde;a");?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=__("panel de control");?></a> |
				<a href="index.php"><?=__("ir a sabros.us");?></a>
			</p>
	</div>
	<div id="contenido">
    	<? if (isset($_GET["ex"])) { ?>
		<div id="divContenedor" class="exito">
			<p><?=__("La nueva contrase&ntilde;a fue enviada al correo electr&oacute;nico. Revise su bandeja de entrada donde encontrar&aacute; m&aacute;s indicaciones");?></p>
		</div>
		<? } ?>
		<? if (isset($_GET["er"])) { ?>
		<div id="divContenedor" class="error">
			<? if ($_GET["er"] == "1") { ?>
				<p><?=__("Imposible enviar su contrase&ntilde;a por correo electr&oacute;nico, debido a que nunca ingres&oacute; el email del administrador");?></p>
			<? } else if ($_GET["er"] == "2") { ?>
				<p><?=__("El email ingresado en el formulario es distinto al que esta guardado en la base de datos");?></p>
			<? } else if ($_GET["er"] == "3") { ?>
				<p><?=__("Se produjo un error al intentar enviar el correo electr&oacute;nico. Vuelva a intentarlo m&aacute;s tarde");?></p>
			<? } ?>
		</div>
		<? } ?>
		<div id="formulario">
			<form name="form" id="form" action="recordar.php" method="post">
				<fieldset>
					<legend><?=__("Nueva contrase&ntilde;a");?></legend>
					<p><?=__("Si olvid&oacute; su contrase&ntilde;a, ingrese el correo electr&oacute;nico del administrador de sabros.us en el siguiente formulario y le enviaremos una nueva contrase&ntilde;a a su cuenta de correo.");?></p>
					<label for="email"><?=__("email:");?></label><input type="text" name="email" id="email" /><br />
					<input class="submit" type="submit" name="btnsubmit" value="<?=__("solicitar nueva");?>" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sabros.us/">sabros.us</a></p>
	</div>
</div>
</body>
</html>
<? 	} ?>
