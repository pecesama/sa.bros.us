<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */
?>
<?
session_start();
ob_start();
include("include/config.php");
include("include/conex.php");
include("include/functions.php");
include("lang/".$Sabrosus->archivoIdioma);

if (esAdmin())
{
	if (isset($_POST["accion"]))
	{ 	  
	    $errores = 0;
		$sql = "UPDATE `".$prefix."config` SET
					`site_name` = '".$_POST['sname']."',
					`site_title` = '".$_POST['stitle']."',
					`site_url` = '".$_POST['surl']."',
					`sabrosus_url` = '".$_POST['saburl']."',
					`url_friendly` = '".$_POST['useFriendlyUrl']."',
					`idioma` = '".$_POST['selIdioma']."',
					`limite_enlaces` = '".$_POST['limit']."',
					`admin_email` = '".$_POST['email']."'";
		if ($_POST[pass1]!=$_POST[pass2]){
   		   	echo $idioma[op_pass_iguales];
			$errores += 1;
		} else {
	        if(($_POST[pass1])!=""){
				$encript = md5($_POST[pass1]);
				$sql .= ", `admin_pass` = '".$encript."'";
			}
		}
		$sql .= " WHERE (`sabrosus_url` = '".$Sabrosus->sabrUrl."') LIMIT 1";
			
		$cfg = new iniParser("include/config.ini");
			
		$multi = ((isset($_POST["contenidos_multi"])) ? "1" : "0");	
		$cfg->setValue("multimedia_content","allow", $multi);
		
		$cfg->setValue("tags_cloud","color", $_POST['color_tags']);
		
		$comp = ((isset($_POST["compartir"])) ? "1" : "0");	
		$cfg->setValue("exportar","compartir", $comp);
		
		if(!is_writeable("include/config.ini")){
			$errores +=1;
		}
		if(!$errores){
			$cfg->save();
			$result = mysql_query($sql);
			header("Location: opciones.php?ex=1");
		} else {
			if(!is_writeable("include/config.ini"))
			{
				header("Location: opciones.php?er=2");
			} else {
				header("Location: opciones.php?er=1");
			}
		}
		
		

	} else {
?>
<!-- Sa.bros.us monousuario version 1.7 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[op_opciones];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us 1.7" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/instalar.css" type="text/css" />
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
		<h2>sa.bros.us/<span><?=$idioma[op_opciones];?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=$idioma[panel_control];?></a> |
				<a href="index.php"><?=$idioma[ir_inicio];?></a>
			</p>
	</div>
	<div id="contenido">
    	<? if (isset($_GET["ex"])) { ?>
		<div id="divContenedor" class="exito">
			<p><?=$idioma[op_exito];?></p>
		</div>
		<? } ?>
		<? if (isset($_GET["er"])) { ?>
		<div id="divContenedor" class="error">
			<p><?=$idioma[op_error.$_GET["er"]]?></p>
		</div>
		<? } ?>
		<div id="formulario">
			<form name="config_form" id="config_form" action="opciones.php" method="post">
				<fieldset>
					<legend><?=$idioma[op_titulo_opciones];?></legend>
					<label for="sname"><?=$idioma[op_nombre];?></label><input type="text"  name="sname" id="sname" value="<?=$Sabrosus->siteName?>" /><br />
					<label for="stitle"><?=$idioma[op_titulo];?></label><input type="text"  name="stitle" id="stitle" value="<?=$Sabrosus->siteTitle?>" /><br />
					<label for="surl"><?=$idioma[op_siteurl];?></label><input type="text"  name="surl" id="surl" value="<?=$Sabrosus->siteUrl?>" /><br />
					<label for="saburl"><?=$idioma[op_sabrurl];?></label><input type="text"  name="saburl" id="saburl" value="<?=$Sabrosus->sabrUrl?>" /><br />
					<label for="useFriendlyUrl"><?=$idioma[op_urlfriend];?></label>
						<select name="useFriendlyUrl" id="useFriendlyUrl">
							<option value="1" <? if($Sabrosus->usefriendlyurl) echo "selected"; ?>><?=$idioma[op_activado];?></option>
							<option value="0" <? if(!$Sabrosus->usefriendlyurl) echo "selected"; ?>><?=$idioma[op_desactivado];?></option>
						</select><br />
					<label for="selIdioma"><?=$idioma[op_idioma];?></label>
						<select name="selIdioma">
<?
					$idiomas = obtenerIdiomas();
					$numelentos = count($idiomas);
					for ($i=0; $i < $numelentos; $i++)	
					{
						include("lang/".$idiomas[$i]);
						if ($idiomas[$i]==$Sabrosus->archivoIdioma)
							echo "<option value=\"".$idiomas[$i]."\" selected=\"true\">".$idioma[nombre]."</option>\n";	
						else
							echo "<option value=\"".$idiomas[$i]."\">".$idioma[nombre]."</option>\n";	
					}	
					include("lang/".$Sabrosus->archivoIdioma);
?>					
						</select><br />
				</fieldset>
				<fieldset>
					<legend><?=$idioma[op_conf_apariencia]?></legend>
					
					<label for="limit"><?=$idioma[op_limite_enlaces];?></label><input type="text"  name="limit" id="limit" value="<?=$Sabrosus->limit?>" /><br />
					<label for="color_tags"><?=$idioma[op_color_tags];?></label>
						<select name="color_tags" id="color_tags">
<?
					$i = 0;
					while(isset($idioma["op_color_{$i}"])){
						echo "<option value=\"{$i}\"";
						echo ($Sabrosus->tagsColor == $i)? " selected=\"selected\"" : "";
						echo ">{$idioma['op_color_'.$i]}</option>";
						$i++;
					}
?>
						</select><br />
					
					<? $multi = (($Sabrosus->multiCont=="1") ? "checked=\"true\"" : ""); ?>
					<? $compartir = (($Sabrosus->compartir=="1") ? "checked=\"true\"" : ""); ?>
					<label for="contenidos_multi"><?=$idioma[op_contenidos_multimedia];?></label><input name="contenidos_multi" type="checkbox" <? echo $multi; ?> id="contenidos_multi" /><br />
					<label for="compartir"><?=$idioma[op_compartir];?></label><input name="compartir" type="checkbox" <? echo $compartir; ?> id="compartir"/><br />	
				</fieldset>
				<fieldset>
					<legend><?=$idioma[op_conf_usuario]?></legend>
					<label for="pass1"><?=$idioma[op_pass];?></label><input type="password"  name="pass1" id="pass1" value=""/><br />
					<label for="pass2"><?=$idioma[op_repite_pass];?></label><input type="password"  name="pass2" id="pass2" value=""/><br /><div class="ejemplo"><?=$idioma[op_deje_blanco]?></div>
					<label for="email"><?=$idioma[op_emailadmin];?></label><input type="text"  name="email" id="email" value="<?=$Sabrosus->emailAdmin?>"/><br />
					<input class="submit" type="submit" name="accion" value="<?=$idioma[op_actualizar];?>" />
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
<?php
	} //POST[action]
  } else { //no es Admin
	  header("Location: login.php");
  }
?>