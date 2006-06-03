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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$locale?>" lang="<?=$locale?>">
<head>
	<title><?=__("Panel de control");?>/sa.bros.us</title>
	<meta name="generator" content="Sa.bros.us <?=version();?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8?>" />
	<link rel="stylesheet" href="<?=$Sabrosus->sabrUrl?>/sabor.css" type="text/css" />
	<link rel="shortcut icon" href="<?=$Sabrosus->sabrUrl?>/images/sabrosus_icon.png" />
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/include/prototype.lite.js"></script>
	<script type="text/javascript" src="<?=$Sabrosus->sabrUrl;?>/include/moo.fx.js"></script>

	<script language="JavaScript" type="text/javascript">
		<!--			
			function elimina(id_enlace)
			{	// Algo de JavaScript para aquello de que no se quiera borrar.
				var x;
				x=window.confirm("<?=__("&iquest;Realmente desea eliminar este enlace de su sa.bros.us?");?>\n\n<?=__("Esta acci&oacute;n no se puede deshacer!");?>");				 
				if (x) { location="eliminar.php?id="+id_enlace+"&confirm=0"; }
			}
				
			var contenedor;
			window.onload = function() {
				contenedor = new fx.Opacity('divContenedor', {duration: 5000, onComplete:
					function() {
						document.getElementById('divContenedor').style.display="none";
					}
				});
				contenedor.toggle();
			}

		-->
		</script>
</head>
	
<body>
<div id="pagina">
	<div id="titulo">
		<h2>sa.bros.us/<span><?=__("Panel de control");?></span></h2>
		<p class="submenu">
			<a href="editar.php"><?=__("agregar enlace");?></a> | 
			<a href="generarBadge.php"><?=__("generar badge");?></a> | 
			<a href="importar.php"><?=__("Importar");?></a> |
			<a href="exportar.php"><?=__("Exportar");?></a> | 
			<a href="opciones.php"><?=__("ir a opciones");?></a> | 
			<a href="index.php"><?=__("ir a sa.bros.us");?></a> | 
			<a href="close.php"><?=__("terminar la sesi&oacute;n");?></a>
		</p>
	</div>
	
	<div id="contenido">
		<? if (isset($_GET["er"])) { ?>
			<div id="divContenedor" class="error">
				<p><?=__("No es posible exportar enlaces, debido a que el directorio <code>tmp</code> no cuenta con permisos de escritura.");?></p>
			</div>
		<? } ?>

		<div id="formulario">
			<form action="cpanel.php" method="get" name="buscar">
				<fieldset>
					<label for="buscar"><?=__("Buscar:");?></label>				
					<input class="input_naranja" id="buscar" name="buscar" type="text" />				
					<input class="submit_normal" type="submit" value="<?=__("buscar");?>" name="btnBuscar" />
				</fieldset>
			</form>
		</div>
<?		
		$page = $pag;
		if(isset($pag)) $begin=$page*$Sabrosus->limit; else $begin=0;
		$aux = $begin+$Sabrosus->limit;
		if (isset($_GET["buscar"]))
		{
			$keywords = explode(" ", $_GET["buscar"]);
			$query = "SELECT id_enlace,title,enlace,descripcion FROM ".$prefix."sabrosus "."WHERE title LIKE '%".$keywords['0']."%' OR descripcion LIKE '%".$keywords['0']."%'";		
			for ($i=1; $i<count($keywords); $i++) 
			{
				$query .= " OR title LIKE '%".$keywords[$i]."%' OR descripcion LIKE '%".$keywords[$i]."%'";
			}	
			
			$query_next = $query." LIMIT $aux,$Sabrosus->limit";
			$query .= " LIMIT $begin,$Sabrosus->limit";
			
			$result = mysql_query($query,$link);
			$result_next = mysql_query($query_next,$link);
		}
		else
		{			
			$result = mysql_query("select * from ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $begin,$Sabrosus->limit",$link);
			$result_next = mysql_query("select * from ".$prefix."sabrosus ORDER BY fecha DESC LIMIT $aux,$Sabrosus->limit");
		}
?>
		<table cellspacing="0">
			<thead>
				<th><?=__("Control de Contenidos");?></th>
				<th colspan="3">&nbsp;</th>
			</thead>
			
<?			while ($row = mysql_fetch_array($result))
				{	?>					
			<tr>
				<td class="objeto"><?=$row["title"]?></td>
				<td class="ver"><a href="ir.php?id=<? echo $row["id_enlace"]; ?>"><?=__("Ver");?></a></td>
				<td class="edita"><a href="editar.php?id=<? echo $row["id_enlace"]; ?>"><?=__("Editar");?></a></td>
				<td class="elimina"><a href="eliminar.php?id=<?=$row["id_enlace"];?>&amp;confirm=1" onclick="elimina(<?=$row["id_enlace"];?>);return false;"><?=__("Eliminar");?></a></td>
			</tr>
<?				}	?>
			<tr>
				<td colspan="4" class="paginator">
				<?
					if(isset($pag)&&$pag>0)
					{
						if(isset($_GET['buscar']))
							echo "<a class=\"alignleft\" href=\"cpanel.php?pag=".($page-1)."&amp;buscar=".$_GET['buscar']."\">&laquo; ".__("Anterior")."</a>";				
						else
							echo "<a class=\"alignleft\" href=\"cpanel.php?pag=".($page-1)."\">&laquo; ".__("Anterior")."</a>";
					}
					if(mysql_num_rows($result_next)>0)
					{
						if(isset($_GET['buscar']))
							echo "<a class=\"alignright\" href=\"cpanel.php?pag=".($page+1)."&amp;buscar=".$_GET['buscar']."\">".__("Siguiente")." &raquo;</a> ";
						else
							echo "<a class=\"alignright\" href=\"cpanel.php?pag=".($page+1)."\">".__("Siguiente")." &raquo;</a>";
					}
				?>
				</td>
			</tr>
		</table>
	</div>
	
	<div id="pie">
		<p class="powered"><?=__("Generado con:")?>&nbsp;&nbsp;<a title="Sa.bros.us" href="https://sourceforge.net/projects/sabrosus/">sa.bros.us</a></p>
	</div>

</div>
</body>
</html>
<?	
	} else { // !esAdmin
		header("Location: login.php");
	}
?>
