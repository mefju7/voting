<?php
 log2web(__FILE__);
 include 'inc/getVote.php';
 
 if(!isset($votes))
 $votes=array(); // nobody selected

function printVote($id,$name,$checked,$disabled){
?>
	<tr class="choice" ><td><input type="checkbox" value="1" 
	onchange="electing(<?php echo $id;?>,this.checked)" 
	<?php if($checked) echo ' checked="1"'; if($disabled) echo ' disabled="1"' ?>>
	<?php if($disabled) echo "<strike>$name</strike"; else echo $name;?>
	</input></td></tr>
<?php
}

function showVotes() {
	global $Log, $votes, $mOE,$ops;
	$votedSoFar=count($votes);
	$showAllCand=$votedSoFar<$mOE;
	foreach($votes as $v) {
		printVote($v,$ops[$v],1,0);
	}
	foreach($ops as $id => $can) { 
		if(!in_array($id,$votes))
			printVote($id,$can,0,!$showAllCand); 
	}
}

$sections[]='views/electionAction.php';
