<?
	/* ===========================
	
	  sabros.us monousuario versión 1.8
	  http://sabros.us/
	
	  sabros.us is a free software licensed under GPL (General public license)	  
	
	  =========================== */
	  
	// Script adaptado a sabros.us del encontrado en:
	// 		http://www.strangerstudios.com/sandbox/pagination/diggstyle.php?page=1
			
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	$total_pages = contarenlaces(substr($sqlStr,9,strpos($sqlStr,"ORDER")-9)); 
	if($q!="")
			if($Sabrosus->usefriendlyurl==0)
					$q="&busqueda=".$q;
				else
					$q="/busqueda/".$q;
		else
			$q="";
	
	/* Setup vars for query. */
	$limit = $Sabrosus->limit; 								//how many items to show per page
	if($_GET["pag"]) 
		$start = ($_GET["pag"] - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
			
	/* Setup page vars for display. */
	if ($_GET["pag"] == 0) $_GET["pag"] = 1;					//if no page var is given, default to 1.
	$prev = $_GET["pag"] - 1;							//previous page is page - 1
	$next = $_GET["pag"] + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($_GET["pag"] > 1) 
		{			
			if (isset($tagtag))
			{
				$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/tag/'.$tagtag.'/pag/'.$prev , '/?tag='.$tagtag.'&amp;pag='.$prev ) .$q."\">" . __("&laquo; Anterior") . "</a>";
			} 
			else 
			{
				$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/pag/'.$prev , '/?pag='.$prev ) .$q. "\">" . __("&laquo; Anterior") ."</a>";
			}
		}
		else
		{
			$pagination.= "<span class=\"disabled\">". __("&laquo; Anterior")."</span>";
		}
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $_GET["pag"]) 
				{
					$pagination.= "<span class=\"current\">$counter</span>";
				} 
				else 
				{						
					if (isset($tagtag))
					{
						$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$counter,'/?tag='.$tagtag.'&amp;pag='.$counter).$q. "\">".$counter."</a>";
					} 
					else 
					{
						$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$counter,'/?pag='.$counter).$q. "\">".$counter."</a>";
					}
				}
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($_GET["pag"] < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $_GET["pag"])
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{							
						if (isset($tagtag))
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$counter,'/?tag='.$tagtag.'&amp;pag='.$counter).$q. "\">".$counter."</a>";
						} 
						else 
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$counter,'/?pag='.$counter).$q. "\">".$counter."</a>";
						}
					}
				}
				$pagination.= "...";					
				if (isset($tagtag))
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$lpm1,'/?tag='.$tagtag.'&amp;pag='.$lpm1).$q. "\">".$lpm1."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$lastpage,'/?tag='.$tagtag.'&amp;pag='.$lastpage).$q. "\">".$lastpage."</a>";
				} 
				else 
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$lpm1,'/?pag='.$lpm1).$q. "\">".$lpm1."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$lastpage,'/?pag='.$lastpage).$q. "\">".$lastpage."</a>";
				}
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $_GET["pag"] && $_GET["pag"] > ($adjacents * 2))
			{					
				$uno=1;
				$dos=2;
				if (isset($tagtag))
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$uno,'/?tag='.$tagtag.'&amp;pag='.$uno).$q. "\">".$uno."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$dos,'/?tag='.$tagtag.'&amp;pag='.$dos).$q. "\">".$dos."</a>";
				} 
				else 
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$uno,'/?pag='.$uno).$q. "\">".$uno."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$dos,'/?pag='.$dos).$q. "\">".$dos."</a>";
				}
				$pagination.= "...";
				for ($counter = $_GET["pag"] - $adjacents; $counter <= $_GET["pag"] + $adjacents; $counter++)
				{
					if ($counter == $_GET["pag"])
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{							
						if (isset($tagtag))
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$counter,'/?tag='.$tagtag.'&amp;pag='.$counter).$q. "\">".$counter."</a>";
						} 
						else 
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$counter,'/?pag='.$counter).$q. "\">".$counter."</a>";
						}
					}
				}
				$pagination.= "...";					
				if (isset($tagtag))
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$lpm1,'/?tag='.$tagtag.'&amp;pag='.$lpm1).$q. "\">".$lpm1."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$lastpage,'/?tag='.$tagtag.'&amp;pag='.$lastpage).$q. "\">".$lastpage."</a>";
				} 
				else 
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$lpm1,'/?pag='.$lpm1).$q. "\">".$lpm1."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$lastpage,'/?pag='.$lastpage).$q. "\">".$lastpage."</a>";
				}
			}
			//close to end; only hide early pages
			else
			{					
				$uno=1;
				$dos=2;
				if (isset($tagtag))
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$uno,'/?tag='.$tagtag.'&amp;pag='.$uno).$q. "\">".$uno."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$dos,'/?tag='.$tagtag.'&amp;pag='.$dos).$q. "\">".$dos."</a>";
				} 
				else 
				{
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$uno,'/?pag='.$uno).$q. "\">".$uno."</a>";
					$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$dos,'/?pag='.$dos).$q. "\">".$dos."</a>";
				}
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $_GET["pag"])
					{
						$pagination.= "<span class=\"current\">$counter</span>";
					}
					else
					{							
						if (isset($tagtag))
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/tag/'.$tagtag.'/pag/'.$counter,'/?tag='.$tagtag.'&amp;pag='.$counter).$q. "\">".$counter."</a>";
						} 
						else 
						{
							$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly('/pag/'.$counter,'/?pag='.$counter).$q. "\">".$counter."</a>";
						}
					}
				}
			}
		}
		
		//next button
		if ($_GET["pag"] < $counter - 1)
		{				
			if (isset($tagtag))
			{
				$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/tag/'.$tagtag.'/pag/'.$next , '/?tag='.$tagtag.'&amp;pag='.$next ) .$q."\">" . __("Siguiente &raquo;") . "</a>";
			} 
			else 
			{
				$pagination.= "<a href=\"".$Sabrosus->sabrUrl . chequearURLFriendly( '/pag/'.$next , '/?pag='.$next ) .$q. "\">" . __("Siguiente &raquo;") ."</a>";
			}
		}
		else
		{
			$pagination.= "<span class=\"disabled\">Siguiente &raquo;</span>";
		}
		$pagination.= "</div>\n";		
	}
		
	echo $pagination;
?>