<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if (esAdmin())
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale;?>" lang="<?=$locale;?>">
<head>
	<title><?=__("generar badge de los enlaces");?>/sabros.us</title>
	<meta name="generator" content="sabros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
					if( cuantos == null || cuantos == "") cuantos = 10;
			var tag = document.getElementById('txtTag').value;		
			
			
			var badge = "<!-- Inicio de sabros.us Badge -->\n";
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
			
			
			badge += "<!-- Fin de sabros.us Badge -->";
			
		
			document.getElementById('txtBadge').value = strReplace(badge,'<//','</');
			
			//document.frmBagde.txtBadge.value=badge;
		}
	
	</script>
</head>	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sabros.us/<span><?=__("generar badge de los enlaces");?></span></h2>
			<p class="submenu">
				<a href="cpanel.php"><?=__("panel de control");?></a> |
				<a href="generarBadgeTags.php"><?=__("generar badge de la nube de etiquetas");?></a>
			</p>
	</div>

	<div id="contenido">	
		<div id="formulario">
			<form name="frmBadge" id="frmBagde" action="#" method="post">
				<fieldset>
					<legend><?=__("Agrega los URLs de sabros.us a t&uacute; sitio.");?></legend>		
					<p><?=__("Si tienes un sitio web o un blog, puedes mostrar los URLs m&aacute;s recientes ingresados en tu sabros.us");?></p>
				</fieldset>
				<fieldset>
					<legend><?=__("Copiar el c&oacute;digo fuente");?></legend>
					<p><?=__("Para mostrar los URLs m&aacute;s recientes lo &uacute;nico que se tiene que hacer es colocar el siguiente c&oacute;digo en cualquier parte de un weblog o una p&aacute;gina HTML para que se muestren los enlaces que se tienen en tu sabros.us.");?></p><br />
					<textarea class="textarea_oscuro" rows="10" cols="90" name="txtBadge" id="txtBadge">
<!-- Inicio de sabros.us Badge -->
<style type="text/css">
	#mi_sabrosus strong {
		font-size: 13px;
}
</style>
<script src="<?=$Sabrosus->sabrUrl?>/badge.php?cuantos=10" type="text/javascript"></script>
<!-- Fin de sabros.us Badge -->
					</textarea>
				</fieldset>
				<fieldset>
					<legend><?=__("Agregue sus preferencias al c&oacute;digo generado.");?></legend>
					<p><?=__("Seleccione sus preferencias para desplegar su sabros.us:");?></p><br />
					<label><?=__("N&uacute;mero de enlaces:");?></label><br />
					<input name="txtCuantos" id="txtCuantos" onKeypress="if (event.keyCode < 45 || event.keyCode > 58) event.returnValue = false;" onKeyUp="generaBadge()" /><br />
					<label><?=__("Filtrar por etiqueta:");?></label><br />
					<input name="txtTag" id="txtTag" onKeyUp="generaBadge()" />
				</fieldset>
				<fieldset>
					<legend><?=__("Hoja de estilo de mi sabros.us");?></legend>
					<p><?=__("Si deseas personalizar el estilo de despliegue de tu sabros.us, este es la estructura del XHTML generado por sabros.us badge.");?></p>
					<br />
					<div id="ejemploHtml" style="margin-left:30px;color:#888;">
					&lt;div id=&quot;mi_sabrosus&quot;&gt;<br />
					<div id="ejemploHtmlInterno">&lt;strong&gt;Mi sabros.us&lt;/strong&gt;<br />
					  &lt;ul&gt;<br />
					  &nbsp;&nbsp;&nbsp;&lt;li&gt;&lt;a title=&quot;&quot; href=&quot;&quot;&gt;#&lt;/a&gt;&lt;/li&gt;<br />
					&nbsp;&nbsp;&nbsp;&lt;li&gt;M&aacute;s en &lt;a title=&quot;Mi sabros.us&quot; href=&quot;&quot;&gt;mi sabros.us&lt;/a&gt;&lt;/li&gt;<br />
					&lt;/ul&gt;</div>
					&lt;/div&gt;
					</div>
				</fieldset>
			</form>
		</div>		
	</div>
	
	<div id="pie">
		<p class="powered"><?=__("generado con:");?>&nbsp;&nbsp;<a title="sabros.us" href="http://sourceforge.net/projects/sabrosus/">sabros.us</a></p>
	</div>

</div>
</body>
</html>
<?
} else {
   header("Location: login.php");
}
?> 
