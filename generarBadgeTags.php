<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if (esAdmin())
{

$show_code 	= false;
$min_font 	= 12;
$max_font 	= 30;
$color_font	= 0;

if(isset($_POST['code_gen'])){
	$min_font 	= (eregi("^[0-9]+$",$_POST['min_font']))? $_POST['min_font'] : $min_font;
	$max_font 	= (eregi("^[0-9]+$",$_POST['max_font']))? $_POST['max_font'] : $max_font;
		if($max_font <= $min_font) $max_font = ($min_font+1);
	$color_font	= $_POST['color_tags'];
	$show_code 	= true;
	$code_base 	= ' 
<!-- Inicio de sa.bros.us Badge -->
	<style type="text/css">
		#badgetags ol{
			list-style-type:none;
		}
		#badgetags li{
			display:inline;
			text-align:center;
			padding:0 2px;
		}
	</style>
<!-- Fin de sa.bros.us Badge -->
	
<script type="text/javascript" src="'.$Sabrosus->sabrUrl.'/badgeTags.php?color='.$color_font.'&min='.$min_font.'&max='.$max_font.'"> </script>
	';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("generar badge de la nube de etiquetas");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>	
<body>
<div id="pagina">
	<div id="titulo">
	
		<h2>sa.bros.us/<span><?=__("generar badge de los enlaces");?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=__("Panel de control");?></a> |
				<a href="generarBadge.php"><?=__("generar badge de los enlaces");?></a>
			</p>
	</div>

	<div id="contenido">
		
		<div id="formulario">
			<form name="frmBadge" id="frmBagde" action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<fieldset>
					<legend><?=__("Agrega las Etiquetas de sa.bros.us a t&uacute; sitio.");?></legend>		
					<p><?=__("Si tienes un sitio web o un blog, puedes mostrar las Etiquetas ingresadas en tu sa.bros.us dispuestas de manera que la Etiqueta m&aacute;s relevante se muestre m&aacute;s grande.");?></p>
				</fieldset>
				<fieldset>
					<legend><?=__("Personalice la nube de Etiquetas:");?></legend>
					<p><?=__("Seleccione sus preferencias para desplegar su nube de Etiquetas de sa.bros.us:");?></p><br />
					
					<label for=""><?=__("Tama&ntilde;o de fuente m&iacute;nimo:");?></label>
					<input name="min_font" id="txtFMin" value="<?=$min_font?>" /><br />
					<label for="txtFMax"><?=__("Tama&ntilde;o de fuente m&aacute;ximo:");?></label>
					<input name="max_font" id="txtFMax" value="<?=$max_font?>" /><br />

					<label for="color_tags"><?=__("Color para la nube de etiquetas:");?></label>
					<select name="color_tags" id="color_tags">

					<?
					$colors = array(__("Naranja"), __("Azul"), __("Verde"), __("Rojo"), __("Gris"), __("Aleatorio"));
					foreach ($colors as $i => $color) {
						echo "<option value=\"{$i}\"";
						echo ($color_font == $i)? " selected=\"selected\"" : "";
						echo ">{$color}</option>";
					}
					?>
					
					</select><br />	
					<input type="submit" name="code_gen" value="<?=__("Generar C&oacute;digo");?>"/>

				</fieldset>
				
				<? if ($show_code){ ?>
				<fieldset>
					<legend><?=__("Nube de ejemplo");?></legend>
						<?='					
<!-- Inicio de sa.bros.us Badge -->
	<style type="text/css">
		#badgetags { text-align:center; margin:0 auto;  padding:5px; width:600px; border:1px solid #ccc; }
		#badgetags ol{list-style-type:none}

#badgetags li{
			display:inline;
			text-align:center;
			padding:0 2px;
		}	</style>
<!-- Fin de sa.bros.us Badge -->
<script type="text/javascript" src="'.$Sabrosus->sabrUrl.'/badgeTags.php?color='.$color_font.'&min='.$min_font.'&max='.$max_font.'"> </script>'
						?>
				</fieldset>
				<fieldset>
					<legend><?=__("Copiar el c&oacute;digo fuente");?></legend>
					<p><?=__("Para mostrar los URLs m&aacute;s recientes lo &uacute;nico que se tiene que hacer es colocar el siguiente c&oacute;digo en cualquier parte de un weblog o una p&aacute;gina HTML para que se muestren los enlaces que se tienen en tu sa.bros.us.");?></p><br />
					<textarea class="textarea_oscuro" rows="16" cols="90" name="txtBadge" id="txtBadge">
<?=trim($code_base)?>
					</textarea>
				</fieldset>
				<fieldset>
					<legend><?=__("Hoja de estilo de Mi sa.bros.us");?></legend>
					<p><?=__("Si deseas personalizar el estilo de despliegue de tu sa.bros.us, este es la estructura del XHTML generado por sa.bros.us badge.");?></p>
					<br />
					<div id="ejemploHtml" style="margin-left:30px;color:#888;">
					&lt;div id=&quot;badgetags&quot;&gt;
					<div id="ejemploHtmlInterno">&lt;p&gt;&lt;strong&gt;<?=__("Mis etiquetas en sa.bros.us");?>&lt;/strong&gt;&lt;/p&gt;&lt;br /&gt;<br />
					&lt;ol&gt;<br />
					&lt;li&gt;&lt;a title=&quot;&quot; style=&quot;&quot; href=&quot;&quot;&gt;#&lt;/a&gt;&lt;/li&gt;<br />
					&lt;/ol&gt;<br />
					</div>
					&lt;/div&gt;
					
				</fieldset>
				<? } ?>
			</form>
		</div>		
	</div>
	
	<div id="pie">
		<p class="powered"><?=__("Generado con:");?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>

</div>
</body>
</html>
<?
} else {
   header("Location: login.php");
}
?> 
