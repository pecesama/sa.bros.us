<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");
include("lang/".$Sabrosus->archivoIdioma);

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
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[generar_badge_tags];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
</head>	
<body>
<div id="pagina">
	<div id="titulo">
	
		<h2>sa.bros.us/<span><?=$idioma[generar_badge];?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=$idioma[panel_control];?></a> |
				<a href="generarBadge.php"><?=$idioma[generar_badge];?></a>
			</p>
	</div>

	<div id="contenido">
		
		<div id="formulario">
			<form name="frmBadge" id="frmBagde" action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<fieldset>
					<legend><?=$idioma[titulo_badge_tags];?></legend>		
					<p><?=$idioma[descripcion_badge_tags];?></p>
				</fieldset>
				<fieldset>
					<legend><?=$idioma[preferencias_titulo_tags];?></legend>
					<p><?=$idioma[seleccionar_preferencias_tags];?></p><br />
					
					<label for=""><?=$idioma[min_size_tags];?></label>
					<input name="min_font" id="txtFMin" value="<?=$min_font?>" /><br />
					<label for="txtFMax"><?=$idioma[max_size_tags];?></label>
					<input name="max_font" id="txtFMax" value="<?=$max_font?>" /><br />

					<label for="color_tags"><?=$idioma[op_color_tags];?></label>
					<select name="color_tags" id="color_tags">

					<?
					$i = 0;
					while (isset($idioma["op_color_{$i}"])) {
						echo "<option value=\"{$i}\"";
						echo ($color_font == $i)? " selected=\"selected\"" : "";
						echo ">{$idioma['op_color_'.$i]}</option>";
						$i++;
					}
					?>
					
					</select><br />	
					<input type="submit" name="code_gen" value="<?=$idioma[generar_codigo_tags];?>"/>

				</fieldset>
				
				<? if ($show_code){ ?>
				<fieldset>
					<legend><?=$idioma[ejemplo_tags];?></legend>
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
					<legend><?=$idioma[copiar_fuente];?></legend>
					<p><?=$idioma[descripcion_funcionalidad_tags];?></p><br />
					<textarea class="textarea_oscuro" rows="16" cols="90" name="txtBadge" id="txtBadge">
<?=trim($code_base)?>
					</textarea>
				</fieldset>
				<fieldset>
					<legend><?=$idioma[estilo_titulo];?></legend>
					<p><?=$idioma[personalizar_estilo_tags];?></p>				
					<br />
					<div id="ejemploHtml" style="margin-left:30px;color:#888;">
					&lt;div id=&quot;badgetags&quot;&gt;
					<div id="ejemploHtmlInterno">&lt;p&gt;&lt;strong&gt;Mis etiquetas en sa.bro.sus&lt;/strong&gt;&lt;/p&gt;&lt;br /&gt;<br />
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
