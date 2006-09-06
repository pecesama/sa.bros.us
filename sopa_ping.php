<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

include_once('include/xmlrpc.php');

$client = new IXR_Client('http://www.sopasabrosa.com.ar/autoping');

$xml = '<xml>
<sabrosus url="'.$Sabrosus->sabrUrl.'" site="'.$Sabrosus->siteName.'" web="'.$Sabrosus->siteUrl.'" />
<link>
	<titulo>'.$titulo.'</titulo>
	<descripcion>'.$descripcion.'</descripcion>
	<url>'.$enlace.'</url>
	<tags>'.$etiquetas.'</tags>
</link>

</xml>';

@$client->query('SSserver.addBookmark',array($xml));

?>