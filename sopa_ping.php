<?php

/**
*	SopaSabrosa.com.ar Ping XmlRpc Client
*/

include ('include/xmlrpc.php');

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