<?
require_once "Request.php";
class Get{
  var $response;
  function getContent($url,$user="",$pass="") {
    
    $req =& new HTTP_Request($url);
    if ($user) {
      $req->setBasicAuth($user, $pass);
    }
    $req->sendRequest();
    $this->responseCode=$req->getResponseCode();
    $this->responseHeader=$req->getResponseHeader();
    $this->responseCode=$req->getResponseCode();
    if ($req->getResponseCode()=='200') {
      $this->response=$req->getResponseBody();
    }
    return $this;
  }     
  function response() { 
    return $this->response;
  }
  function responseCode() { 
    return $this->responseCode;
  }
  function responseHeader() { 
    return $this->responseHeader;
  }
}
     
?>