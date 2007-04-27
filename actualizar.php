<?
header("Content-type: text/html; charset=UTF-8");

include("include/functions.php");
include("include/config.php");
include("include/conex.php");
include("include/tags.class.php");

global $link,$prefix;

// Crear tablas Tags y LinkHasTags

$Error = __("Se ha producido un error mientras se actualizaban las estructuras");
	
$res = mysql_query("SHOW TABLE STATUS LIKE '".$prefix."tags'",$link);
if(mysql_num_rows($res) == 0){
	$query = "CREATE TABLE ".$prefix."tags (id INT NOT NULL AUTO_INCREMENT ,tag VARCHAR(100) NOT NULL ,PRIMARY KEY (id) ,FULLTEXT (tag));";
	$result = mysql_query($query, $link) or die($Error);
}

$res = mysql_query("SHOW TABLE STATUS LIKE '".$prefix."linktags'",$link);
if(mysql_num_rows($res) == 0){
	$query = "CREATE TABLE ".$prefix."linktags (link_id INT NOT NULL ,tag_id INT NOT NULL , INDEX ( link_id , tag_id ));";
	$result = mysql_query($query, $link) or die($Error);
}


// Se agrega la columna PRIVADO para los links
$query = "ALTER TABLE ".$prefix."sabrosus ADD privado INT( 1 ) DEFAULT '0' NOT NULL";
$result = mysql_query($query, $link) or die($Error);

// Se agregan todos los tags existentes relacionandolos con las entradas
$query = "SELECT id_enlace, tags FROM ".$prefix."sabrosus WHERE tags != ''";
$result = mysql_query($query, $link) or die($Error);
if(mysql_num_rows($result)>0){
	$t = new tags;
		while ($row = mysql_fetch_array($result)){
		if(eregi("\:sab\:privado",$row['tags'])){
			$row['tags'] = str_replace(":sab:privado","",$row['tags']);
			$update = "UPDATE ".$prefix."sabrosus SET privado=1 WHERE (id_enlace=".$row["id_enlace"].") LIMIT 1";
			$res = mysql_query($update, $link) or die($Error);
		}
			$t->addTags($row['tags'], $row['id_enlace']);
	}
}

// Se elimina la columna TAGS de los links
$query = "ALTER TABLE ".$prefix."sabrosus DROP tags";
$result = mysql_query($query, $link) or die($Error);

?>