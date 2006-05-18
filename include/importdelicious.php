<?php

	include_once("include/config.php");
	include_once("include/conex.php");	
	include_once("include/functions.php");
	include_once("include/parsing.php");
	include_once("include/get.php");

	function importdelicious($user,$pass)
	{
		global $prefix;
		$xml="http://del.icio.us/api/posts/all?";
		$get=new Get();
		$src_obj=$get->getContent($xml,$user,$pass);
		$src=$src_obj->response();
		$urlAttrib="href";
		$titleAttrib="description";
		$descAttrib="extended";
		$tagAttrib="tag";
		$timeAttrib="time";
		if ($src_obj->responseCode()==200)
		{  
			$posts=getSubTree("posts",$src,0);
    
			$p=-1;
			$k=0;
  
			$imported=0;
			$total=0;
			while (true)
			{
				$p++;
				$post=getTag("post",$posts);
				$url=getAttrib($post,$urlAttrib);
				$title=getAttrib($post,$titleAttrib);
				$description=utf8_decode(getAttrib($post,$descAttrib));
				$tags=getAttrib($post,$tagAttrib);
				$time=getAttrib($post,$timeAttrib);
				
				$bookmark=array();
				$bookmark["title"]=utf8_decode($title);
				$bookmark["tags"]=$tags; /* Aqui hay que solucionar el Feature #1436022 */
				$bookmark["enlace"]=$url;
				$bookmark["descripcion"]=$description;
				$bookmark["fecha"] = date("Y-m-d H:i:s"); /* Aqui tambien el Feature #1436022 */
				$Sql="select enlace from ".$prefix."sabrosus where enlace='".$bookmark["enlace"]."'";
				$result = mysql_query($Sql,$link);
				if(mysql_num_rows($result)==0)
				{
					$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha)  values ('".$bookmark["title"]."','".$bookmark["tags"]."','".$bookmark["enlace"]."','".$bookmark["descripcion"]."', '".$bookmark["fecha"]."');";
					mysql_query($Sql,$link);
					$imported++;
				}
				$total++;
				$p=findnext("post",$posts,$p);
				if (!$p)
				{
					break;
				}
				$posts=substr($posts,$p+1);
			}
			return array("responseCode"=>$src_obj->responseCode(),"total"=>$total,"imported"=>$imported-2);
		} else {
			return array("responseCode"=>$src_obj->responseCode());
		}
	}
?>