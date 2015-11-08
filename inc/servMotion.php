<?php
 log2web(__FILE__);
 include 'inc/getVote.php';

	$cntOps=count($ops);
	if(!isset($votes)){
		$votes=array_fill(0,$cntOps,$cntOps);
	}
	// sorting according to voted ranking
	$voteTable=array_fill(0,$cntOps+1,array());
	$opsTable=array();
	foreach($votes as $i => $val) {
		$voteTable[$val][]=array($val,$i,$ops[$i]);
		$opsTable[$i]=$i;
	}
	$nextOps=0;
	if(isset($rank))
		$nextOps=$rank+1;
	if($nextOps>=$cntOps)
		$nextOps=0;

function printVote(){
 global $voteTable;
 foreach($voteTable as $set)
 foreach($set as $line) { ?>
<tr class="choice" onclick="voteRP(<?php echo $line[1];?>)">
<td><?php echo $line[0]; ?></td>
<td><?php echo $line[2]; ?></td></tr>
 <?php }
}


$sections[]='views/motionAction.php';

