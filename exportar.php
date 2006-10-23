<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include("include/config.php");
include("include/conex.php");
include("include/functions.php");

if(!esAdmin())
{
	if($Sabrosus->compartir!="1"){
		header("Location: index.php");
		exit();
	}
}

if(substr($_SERVER['HTTP_REFERER'],0,strlen($Sabrosus->sabrUrl))!=$Sabrosus->sabrUrl)
{
	header("Location: index.php");
	exit();
}

$toFile = '
<!DOCTYPE NETSCAPE-Bookmark-file-1>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<TITLE>Bookmarks</TITLE>
<H1>Bookmarks</H1>

<DL><p>
	<DT><H3>Enlaces de sabros.us</H3>
	<DL><p>
';
	
$sqlStr = "SELECT title, enlace FROM ".$prefix."sabrosus";

if(!isset($_POST['links_sel']) || (count($_POST['links_sel']) == 0)){
	if (!esAdmin()) {
		header("Location: login.php");
		exit();
	}
}else{
	$i=0;
	foreach($_POST['links_sel'] as $key => $value)
	{
		if(!is_numeric($value)){ continue; }
		if(esPrivado($value) && !esAdmin()){ continue; }
			if($i==0){ 
				$sqlStr .=	" WHERE id_enlace = ".$value; 
				$i++;
			} else {
				$sqlStr .= " OR id_enlace = ".$value;
			}
	}
}
if($i==0 && !esAdmin()){
	header("Location: login.php");
	exit();
}

$result = mysql_query($sqlStr);
while ($row = mysql_fetch_array($result)){
	$toFile .= '<DT><A HREF="'.$row['enlace'].'" ADD_DATE="'.date("U").'" LAST_CHARSET="UTF-8">'.$row['title'].'</A>';
}
$toFile .= '</DL><p></DL><p>';
			
header ("Content-Disposition: attachment; filename=\"lastExport.html\"");
header ("Content-Type: text/html");
header ("Content-Length: ".strlen($toFile));
echo $toFile;

?>
