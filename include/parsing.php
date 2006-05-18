<?

function getCData($tag,$src) {
  $i1=strpos($src,"<".$tag." ");
  $i2=strpos($src,"<".$tag.">");
  $i=minid($i1,$i2);
  if (!$i) {
	  return false;
	}
  $i=strpos($src,">",$i);
  $f=strpos($src,"</".$tag.">",$i);
  if (!$f) {
    $f=strpos($src,"/>",$i)+2;
  }
  
  
  echo substr($src,$i+1,$f-$i-1);
  
  
}

function getTag($tag,$src) {
  $i1=strpos($src,"<".$tag." ");
  $i2=strpos($src,"<".$tag.">");
  $i=minid($i1,$i2);
  if (isset($i)) {
    $f=strpos($src,">",$i);
    if (!$f) {
      $f=strpos($src,"/>",$i)+2;
    }
    return substr($src,$i,$f-$i+1);
  } else {
    return null;
  }
} 


function getSubTree($tag,$src,$p=0) {
  if ($p>=0) {
    $i1=strpos($src,"<".$tag.">",$p);
	$i2=strpos($src,"<".$tag." ",$p);
	$i=minid($i1,$i2);
    $f1=strpos($src,"</".$tag.">",$i)+strlen($tag)+2;
    $i3=strpos($src,"<",$i+1);
    $f2=strpos($src,"/>",$i);
    if (minid($f2,$i3)==$f2) {
      $f=$f2+2;
    }else {
      $f=$f1;
    }
    return substr($src,$i,$f-$i+1);
    }
}

function findnext($tag,$src,$p) {
  if ($p<=strlen($src)) {
    $i1=strpos($src,"</".$tag.">",$p);
    $i2=strpos($src,"</".$tag." ",$p);
    $i=minid($i1,$i2);
    $i3=strpos($src,"/>",$p);
    $i=minid($i,$i3);
    $i=$i+strlen($tag)+3;
  
    $p1=strpos($src,"<".$tag." ",$i);
    $p2=strpos($src,"<".$tag.">",$i);
    $p=minid($p1,$p2);
    return $p;
  }else{
    return false;
  }
}  



function getAttrib($src,$attr) {
  if ($src) {
    $i=strpos($src,$attr."=");
    if ($i) {
      $i=$i+strlen($attr)+1;
      $i1=strpos($src,"\"",$i);
      $i2=strpos($src,"'",$i);
      $i=minid($i1,$i2);
      if ($i==$i1) {
        $f=strpos($src,"\"",$i+1); //Busca la segunda "
      } else {
        $f=strpos($src,"'",$i+1); //Busca la segunda '
      }
      return substr($src,$i+1,$f-$i-1);
    }
  }
 

}

function reptoHTML($src) {
  $src=str_replace(array("<",">"),array("&lt;","&gt;"),$src);
  return $src;
}

function htmlent($src) {
  $src=htmlentities($src); 
  return $src;
}

function minid($a,$b) {
  if ($a===false&&$b===false) {
    return null;
  }
  if ($a===false) {
    return $b;
  }
  if ($b===false) {
    return $a;
  }
  if ($a<$b) {
    return $a;
  } else {
    return $b;
  }
}


function xmlToArrAttrib($xmlString,$itemsTag,$itemTag,$attribs) {
    $items=getSubTree($itemsTag,$xmlString,0);
    $aux=array();
    while (true) {
      $item=getTag($itemTag,$items);
      $auxI=array();
      if (!$item) {break;}
      foreach ($attribs as $attrib) {
        $auxI[$attrib]=getAttrib($item,$attrib);
      }
      $aux[]=$auxI;
      $p=findnext($itemTag,$items,0);
      if (!$p) {
        break;
      }
      $items=substr($items,$p+1);
    }
    return $aux;
}
?>