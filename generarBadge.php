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
?>
<!-- Sa.bros.us monousuario version <?=version();?> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$idioma[nombre_estandar]?>" lang="<?=$idioma[nombre_estandar]?>">
<head>
	<title><?=$idioma[generar_badge];?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$idioma[codificacion]?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
		<script type="text/javascript">
        
		function strReplace(s, r, w){
			 return s.split(r).join(w);
		}
		
		//Este código se encarga de generar el sabrosus badge.
		function generaBadge()
		{
			var cuantos = document.getElementById('txtCuantos').value;	
			var tag = document.getElementById('txtTag').value;		
			
			
			var badge = "<!-- Inicio de sa.bros.us Badge -->\n";
			badge += "<style type=\"text/css\">\n";
			badge += "	#mi_sabrosus strong {\n";
			badge += "		font-size: 13px;\n";
			badge += "}\n";
			badge += '</style>' + "\n";
			
			if (tag != "")
			{
				badge += "<script src=\"<?=$Sabrosus->sabrUrl?>/badge.php?cuantos=" + cuantos + "&tag=" + tag + "\" type=\"text/javascript\">" + '<//script>' + "\n";
			}
			else
			{
				badge += "<script src=\"<?=$Sabrosus->sabrUrl?>/badge.php?cuantos=" + cuantos + "\" type=\"text/javascript\">" + '<//script>' + "\n";
			}
			
			
			badge += "<!-- Fin de sa.bros.us Badge -->";
			
		
			document.getElementById('txtBadge').value = strReplace(badge,'<//','</');
			
			//document.frmBagde.txtBadge.value=badge;
		}
	
	</script>
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=$idioma[generar_badge];?></span></h2>
			<p class="submenu"><a href="cpanel.php"><?=$idioma[panel_control];?></a></p>
	</div>

	<div id="contenido">	
		<div id="formulario">
			<form name="frmBadge" id="frmBagde" action="#" method="post">
				<fieldset>
					<legend><?=$idioma[titulo_badge];?></legend>		
					<p><?=$idioma[descripcion_badge];?></p>
				</fieldset>
				<fieldset>
					<legend><?=$idioma[copiar_fuente];?></legend>
					<p><?=$idioma[descripcion_funcionalidad];?></p><br />
					<textarea class="textarea_oscuro" rows="10" cols="90" name="txtBadge" id="txtBadge">
<!-- Inicio de sa.bros.us Badge -->
<style type="text/css">
	#mi_sabrosus strong {
		font-size: 13px;
}
</style>
<script src="<?=$Sabrosus->sabrUrl?>/badge.php?cuantos=10" type="text/javascript"></script>
<!-- Fin de sa.bros.us Badge -->
					</textarea>
				</fieldset>
				<fieldset>
					<legend><?=$idioma[preferencias_titulo];?></legend>
					<p><?=$idioma[seleccionar_preferencias];?></p><br />
					<label><?=$idioma[numero_enlaces];?></label><br />
					<input name="txtCuantos" id="txtCuantos" onKeypress="if (event.keyCode < 45 || event.keyCode > 58) event.returnValue = false;" onKeyUp="generaBadge()" /><br />
					<label><?=$idioma[filtrar_etiqueta];?></label><br />
					<input name="txtTag" id="txtTag" onKeyUp="generaBadge()" />
				</fieldset>
				<fieldset>
					<legend><?=$idioma[estilo_titulo];?></legend>
					<p><?=$idioma[personalizar_estilo];?></p>				
					<br />
					<div id="ejemploHtml" style="margin-left:30px;color:#888;">
					&lt;div id=&quot;mi_sabrosus&quot;&gt;<br />
					<div id="ejemploHtmlInterno">&lt;strong&gt;Mi sa.bros.us&lt;/strong&gt;<br />
					&lt;a title=&quot;&quot; href=&quot;&quot;&gt;#&lt;/a&gt;<br />
					M&aacute;s en &lt;a title=&quot;Mi sa.bros.us&quot; href=&quot;&quot;&gt;mi sa.bros.us&lt;/a&gt;</div>
					&lt;/div&gt;
					</div>
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
<?
} else {
   header("Location: login.php");
}
?> 
