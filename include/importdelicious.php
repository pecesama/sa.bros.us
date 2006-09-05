<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */
  
	include_once("include/parsing.php");
	include_once("include/get.php");

	function importdelicious($user,$pass)
	{
		global $prefix;
		global $link;
		
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
				$post = getTag("post",$posts);
				$url = getAttrib($post,$urlAttrib);
				$title = getAttrib($post,$titleAttrib);
				$description = utf8_decode(getAttrib($post,$descAttrib));
				$tags = getAttrib($post,$tagAttrib);
				$time = getAttrib($post,$timeAttrib);
				
				$bookmark=array();
				$bookmark["title"] = trim($title);
				$bookmark["tags"] = $tags;
				$bookmark["enlace"] = $url;
				$bookmark["descripcion"] = $description;
				$bookmark["fecha"] = getGMTDate($time,"Y-m-d H:i:s");
				if ($bookmark["enlace"])
				{
					if(!isInSabrosus($bookmark["enlace"]))
					{
						$Sql="insert into ".$prefix."sabrosus (title,tags,enlace,descripcion,fecha)  values ('".$bookmark["title"]."','".$bookmark["tags"]."','".$bookmark["enlace"]."','".$bookmark["descripcion"]."', '".$bookmark["fecha"]."');";
						mysql_query($Sql,$link);
						$imported++;
					}
					$total++;
				}
				$p=findnext("post",$posts,$p);
				if (!$p)
				{
					break;
				}
				$posts=substr($posts,$p+1);
			}
			return array("responseCode"=>$src_obj->responseCode(),"total"=>$total,"imported"=>$imported);
		} else {
			return array("responseCode"=>$src_obj->responseCode());
		}
	}
        
		function getGMTDate($time,$format){
			if (substr($time,strlen($time)-1,1)!="Z") {
				$difh=substr(($time),strpos($time,"Z")+1,3);
			} else {
				$difh=0;
			}
			$timeLoc=substr(($time),0,10)." ".substr(($time),11,8);
			$timeGMT=strtotime($timeLoc)-($difh*60*60);
			$pDGMT=date ($format,$timeGMT);
			return $pDGMT;
		}        
?>