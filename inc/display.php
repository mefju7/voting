<?php

function e(&$var) {
 if(isset($var))
  print($var);
 }

function printScripts() {
	global $Scripts;
	if(is_array($Scripts)){
		foreach($Scripts as $script){
			echo '<script type="text/javascript" src="'.$script.'"></script>';
		}
	}
}

function printHidden($val2hidden) {
 global $requestVariables;
 foreach($val2hidden as $v) {
 $val=$GLOBALS[$requestVariables[$v]]; ?>
<input type="hidden" name="<?php echo $v;?>" value="<?php echo $val;?>"></input>
 <?php }
}


function printOptions($arr,$cur){
 foreach($arr as $i => $str) {
  echo '<option value="'.$i.'" ';
	if($i == $cur)
	echo 'selected="1"';
	echo '>'.$str.'</option>';
 }
}



