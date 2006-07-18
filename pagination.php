<?
/* ===========================

  sabrosus monousuario versión 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

$page=1;
$rows = (isset($tagtag) ? contarenlaces($tagtag) : contarenlaces());   
if($rows)
{
	$since = 0;
	?>
	<p id="paginator">
	<? 
		echo "\t\t".__("Ir a la p&aacute;gina:")."\n";
	
		if ($pag!=1)
		{
			if (isset($tagtag))
			{
				echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/tag/'.$tagtag.'/pag/'.($pag-1) , '/?tag='.$tagtag.'&amp;pag='.($pag-1) ) ."\">" . __("Anterior") . "</a>\n ";
			} else {
				echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/pag/'.($pag-1) , '/?pag='.($pag-1) ) . "\">" . __("Anterior") ."</a>\n ";
			}
		}

	while ($since < $rows)
	{
		if ($page==$pag)
		{
			$act_open="<span class=\"pag_actual\">";
	  		$act_close="</span>";
		} else {
	  		$act_open="";
	  		$act_close="";
		}
		if (isset($tagtag))
		{
	  		echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$page,'/?tag='.$tagtag.'&amp;pag='.$page). "\">". $act_open . $page . $act_close . "</a>\n ";
		} else {
	  		echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$page,'/?pag='.$page). "\">" . $act_open . $page . $act_close . "</a>\n ";
		}
  		$since = $since + $Sabrosus->limit;
  		$page++;
	}

	
	if ($pag!=$page-1)
	{
  		if (isset($tagtag))
		{
        	echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl.chequearURLFriendly( '/tag/'.$tagtag.'/pag/'.($pag+1),'/?tag='.$tagtag.'&amp;pag='.($pag+1)). "\">" . __("Siguiente") ." </a>\n ";
        } else {
        	echo "\t\t\t<a href=\"".$Sabrosus->sabrUrl.chequearURLFriendly( '/pag/'.($pag+1) , '/?pag='.($pag+1) ). "\">" . __("Siguiente") ."</a>\n ";
        }
	}
	?>
		</p>
	<?
}
?>
