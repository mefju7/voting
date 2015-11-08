<?php
require_once '../htmlpurifier/HTMLPurifier.auto.php';  
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
unset($config);
?>
