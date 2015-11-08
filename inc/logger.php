<?php
if(true){ // change it to false to skip logging
 $LogLines[]='logging...';
 function log2web($str){
	global $LogLines;
	if(is_string($str))
		$LogLines[]=$str;
	else
		$LogLines[]='<pre>'.print_r($str,true).'</pre>';
 }
 function ShutDownPrintLogged(){
   function reallyLateShutDownLog(){
	 global $LogLines;
	 echo '<div id="LogOutput"><h3>Log output</h3><ul>';
	 foreach($LogLines as $line)
		 echo '<li>'.$line.'</li>';
	 echo '</ul></div>';
	 }
	 register_shutdown_function('reallyLateShutDownLog');
 }
 register_shutdown_function('ShutDownPrintLogged');
}else
{
	function log2web($str){};
}
