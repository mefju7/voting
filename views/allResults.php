<?php
 log2web(__FILE__);

$linkBase='http://';
$linkBase .= $_SERVER['SERVER_NAME'];
$linkBase .= explode('?',$_SERVER['PHP_SELF'])[0];
$srcLinkBase=$linkBase."?p=$poll&m=";
 foreach($motions as $m) {
 $title=$m['title'];
 $desc=$m['description'];
 $motion=$m['motion'];
?>
<div><fieldset>
<legend><?php e($title);?></legend>
<?php e($desc);?>
<div class="calculation">
<ul>
<?php printCalculation($motion); ?>
</ul>
</div>
<div class="result">
<?php printResult(); ?>
</fieldset>
</div>
<?php } 

