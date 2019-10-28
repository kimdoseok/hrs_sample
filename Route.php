<?php
class Route {
  
  public function __call($name,$args) {
    list($path,$func) = $args;
    $paths = explode(".",trim($path,"/"));
    $pathuri = explode("/",trim($_SERVER["REQUEST_URI"],"/"));
    $numpaths = count($paths);
    $numpathuri = count($pathuri);
    $matched = true;
    for ($i=0;$i<count($paths);$i++) {
      if ($i*2<$numpathuri && $paths[$i]!=$pathuri[$i*2]) {
        $matched = false;
        break;
      }
    }
    
    if ($matched && $numpaths == ceil($numpathuri/2)) {      
      $func($pathuri);
    }
  }
}
