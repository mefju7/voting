<?php
 include 'inc/logger.php';
 include 'inc/once.php';
 log2web(__FILE__);
 if(!isset($poll) || !isset($voter) )
	die('not a voting call');
 $stmt=$dbh->prepare('select status from poll where poll=?');
 $stmt->execute(array($poll));
 $pollRow=$stmt->fetch();
 if(!$pollRow)
  die('no such poll');

include 'inc/getVote.php';

 if(!isset($validVoter) || ($validVoter!=1) )
  die('no such voter');

if($mOE>0) { // voting for an election
 if(!isset($candidate) || !isset($state))
	 die('not voting for a candidate');
	$state=filter_var($state,FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
 if(!isset($votes)) 
	 $votes=array();
 if($state) {
	 $votes[]=$candidate;
 }else{
	 $i=array_search($candidate,$votes);
	 if($i!==false)
	  unset($votes[$i]);
 }
 $votes=array_unique($votes);

} else { // voting for a motion

	if(!isset($option) || !isset($rank))
		die('not voting for a motion');
	if(!isset($votes)){
		$cntOps=count($ops);
		$votes=array_fill(0,$cntOps,$cntOps);
	}
	$votes[$option]=$rank;
}
$vote=implode('|',$votes);
$stmt=$dbh->prepare('insert or replace into vote values(?,?,?,?);');
$stmt->execute(array($poll,$voter,$motion,$vote));

if($mOE>0)
 include 'inc/servElection.php';
else
 include 'inc/servMotion.php';

require_once 'inc/display.php';
$noActionDiv=1;
if(isset($sections) && is_array($sections)){
 foreach($sections as $sec)
  include $sec;
	}
?>
