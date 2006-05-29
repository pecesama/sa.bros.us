<?
/* ===========================

  sabrosus monousuario version 1.7
  http://sabrosus.sourceforge.net/

  sabrosus is a free software licensed under GPL (General public license)

  =========================== */

	include("include/config.php");
	include("include/conex.php");
	include("include/functions.php");
	include("lang/".$Sabrosus->archivoIdioma);


	$toFile = '<!DOCTYPE NETSCAPE-Bookmark-file-1>
				<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
				<TITLE>Bookmarks</TITLE>
				<H1>Bookmarks</H1>

				<DL><p>
   					<DT><H3>Enlaces de Sa.Bros.us</H3>
    				<DL><p>
					';
		
	$sqlStr = 'SELECT title, enlace FROM '.$prefix.'sabrosus  ';
		
	if(!isset($_POST['links_sel']) || (count($_POST['links_sel']) == 0)){
		if (!esAdmin()) {
			header("Location: login.php");
		}
	}else{
		$link_id = $_POST['links_sel'];
		$sqlStr .=	'WHERE id_enlace = '.$link_id[0];
		for($i = 1; $i < count($link_id); $i++){
			$sqlStr .= ' OR id_enlace ='.$link_id[$i];
		}
	}
	
	
	$result = mysql_query($sqlStr);
	while ($row = mysql_fetch_array($result)){
		$toFile .= '<DT><A HREF="'.$row['enlace'].'" ADD_DATE="'.date("U").'" LAST_CHARSET="UTF-8">'.$row['title'].'</A>';
	}
	$toFile .= '    </DL><p>
				</DL><p>';
				
	$archivoSalida = "lastExport.html";
	if (!is_writeable("tmp/".$archivoSalida)) {
		$_SESSION['error_exporting'] = '1';
		if(!isset($_POST['links_sel']) || (count($_POST['links_sel']) == 0)){
			header("Location: cpanel.php?er=1");
		}else{
			header("Location: index.php?er=1");
		}
	}
	if($fp = fopen('tmp/'.$archivoSalida,"w+")){
		fwrite($fp, $toFile);
		fclose($fp);
		header ("Content-Disposition: attachment; filename=\"".$archivoSalida."\"");
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize('tmp/'.$archivoSalida));
		$fp = fopen('tmp/'.$archivoSalida,"r");
		fpassthru($fp);
	}else{
		if(!isset($_POST['links_sel']) || (count($_POST['links_sel']) == 0)){
			header("Location: cpanel.php");
		}else{
			header("Location: index.php");
		}
	}
?>