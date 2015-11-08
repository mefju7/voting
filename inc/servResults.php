<?php
 log2web(__FILE__);

 $stmt=$dbh->prepare('select motion,title,description from motion where poll=?;');
 $stmt->execute(array($poll));
 $motions=$stmt->fetchAll();

function sortCountedVotes($a,$b){
 if($a[1]==$b[1])
  return ($a[0]<$b[0]?-1:1);
 return ($a[1]<$b[1]?1:-1);
}

function print2DArray($arr){
	$rows=count($arr);
	$cols=count($arr[0]);
	echo '<table class="math">';
	for($i=0;$i<$rows;++$i){
		echo '<tr>';
		for($j=0;$j<$cols;++$j){
		echo '<td>'.$arr[$i][$j].'</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}

function sortRankedPairs($a,$b) {
	global $prefs;
	$x=$a[0];
	$y=$a[1];
	$z=$b[0];
	$w=$b[1];
	// majority?
	if($prefs[$x][$y]>$prefs[$z][$w])
		return -1;
	if($prefs[$x][$y]<$prefs[$z][$w])
		return 1;
	// less opposition
	if($prefs[$w][$z]>$prefs[$y][$x])
		return -1;
	if($prefs[$w][$z]<$prefs[$y][$x])
		return 1;
	// preference in setup
	return $x < $z ? -1: 1;
}

function findCycle($graph,$pCnt){
  global $bestVals;
	$vals=array_fill(0,$pCnt,0);
	for($again=2;$again>0;--$again)
	{
		foreach($graph as $pair){
			$s=$vals[$pair[0]]+1;
			$t=$vals[$pair[1]];
			if($t<$s)
			{
			 if($s>=$pCnt)
				 return true;
			 $vals[$pair[1]]=$s;
			 $again=2;
			}
		}
	}
	log2web($vals);
	$bestVals=$vals;
	return false;
}


function printCalculation($motion){
	global $dbh;
	global $poll;
	global $result2Print;
	global $prefs;
	global $bestVals;
	$result2Print=array();
	log2web(__FILE__);
	$stmt=$dbh->prepare('select motionOrElection from motion where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$row=$stmt->fetch();
	// log2web($row);
	$mOE=$row['motionOrElection'];
	$stmt=$dbh->prepare('select vote from vote where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$votes=$stmt->fetchAll();
	echo '<li>got '.count($votes).' votes</li>';
	$stmt=$dbh->prepare('select proposal,title from proposal where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$proposals=$stmt->fetchAll();
	echo '<li> for '.count($proposals).' options to chose from</li>';
	foreach($proposals as $prop) 
		$props[$prop['proposal']]=$prop['title'];
	$pCnt=count($props);
	if($mOE>0)
	{ 

		log2web('calculating election results');
		$voteCnt=array_fill(0,$pCnt,0);
		foreach($votes as $v){
			$vote=explode('|',$v[0]);
			foreach($vote as $c)
				if($c < $pCnt)
					++$voteCnt[$c];
		}
		echo'<li>votes counted:<table><tr><th>Candidate</th><th>votes</th></tr>';
		foreach($voteCnt as $i => $v)
			echo "<tr><td>$props[$i]</td><td>$v</td></tr>";
		echo '</table></li>';
		log2web($voteCnt);
		$result=array();
		foreach($voteCnt as $i => $v)
			$result[]=array($i,$v);
		usort($result,'sortCountedVotes');
		//log2web($result);
		$result2Print[]='<h3>Result</h3><ul>';
		foreach($result as $i => $v){
			$result2Print[]='<li>';
			if($i>=$mOE)
				$result2Print[]='<strike>';
			$result2Print[]=$props[$v[0]].' got '.$v[1].' votes as candidate #'.$v[0].': ';
			$result2Print[]=($i<$mOE)?' got elected': ' got not elected';
			$result2Print[]='</li>';
			if($i>=$mOE)
				$result2Print[]='</strike>';
		}
		$result2Print[]='</ul>';

	}else{

		log2web('calculating a motion using ranked pairs');
		$prefs=array_fill(0,$pCnt,array_fill(0,$pCnt,0));
		$noPrefs=array_fill(0,$pCnt,array_fill(0,$pCnt,0));
		foreach($votes as $v){
			$vote=explode('|',$v[0]);
			if(is_array($vote)){
				for($i=0;$i<$pCnt;++$i)
					for($j=$i+1;$j<$pCnt;++$j){
						if($vote[$i]<$vote[$j])
							++$prefs[$i][$j];
						else if($vote[$i]>$vote[$j])
							++$prefs[$j][$i];
						else ++$noPrefs[$i][$j];
					}
			}
		}
		// log2web($prefs);
		echo '<li>The available options were:<ul>';
		foreach($props as $i => $v)
			echo '<li>'.$i.'=='.$v.'</li>';
		echo '</ul></li>';
		echo '<li> The preferences (Tally) counted:';
		print2DArray($prefs);
		echo '</li>';
		echo '<li> The equal preferences:';
		print2DArray($noPrefs);
		echo '</li>';
		$pairs=array();
		for($i=0;$i<$pCnt;++$i)
			for($j=$i+1;$j<$pCnt;++$j){
				$pairs[]=array($i,$j);
				$pairs[]=array($j,$i);
			}
		usort($pairs,'sortRankedPairs');
		log2web($pairs);
		$graph=array();
		echo '<li><h4>Building Graph (Lock)</h4></li>';
		foreach($pairs as $pair){
			$graph[]=$pair;
			$cf=true;
			log2web('locking..');
			if($cf=findCycle($graph,$pCnt)) {
			 array_pop($graph);
			}
			$l=$pair[0];$r=$pair[1];
			echo '<li>';
			if($cf) echo '<strike>';
			echo $props[$l].' > '.$props[$r];
			if($cf) echo '</strike>';
			echo '</li>';
		}
		$result2Print[]='<h3>Result</h3>Identifying all nodes in the graph with number of hops from a source. First source wins due to preference at setup.<ul>';
		$gotWinner=false;
		foreach($props as $i => $val) {
			$v=$bestVals[$i];
			$result2Print[]= '<li><u>'.$val.'</u>';
			if(!$gotWinner && ($v==0))
			{ 
				$gotWinner=true;
				$result2Print[]='  (winner)';
				$winner=$i;
			}
			$result2Print[]=' is '.$v.' hops from a source</li>';
		}
		$result2Print[]='</ul>';
		$result2Print[]='<h4>The winner is</h4><u>'.$props[$winner].'</u>';
		
	}
}

function printResult(){
 global $result2Print;
 foreach($result2Print as $line)
	 echo $line;
}

 $sections[]='views/allResults.php';
