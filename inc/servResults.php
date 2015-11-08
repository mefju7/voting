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

$result2Print=array();

function printCalculation($motion){
 global $dbh;
 global $poll;
 global $result2Print;
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
 log2web($votes);
 log2web($proposals);
 foreach($proposals as $prop) 
	 $props[$prop['proposal']]=$prop['title'];
 $pCnt=count($props);
 if($mOE>0)
 { 
  
  $voteCnt=array_fill(0,$pCnt,0);
  log2web('calculating election results');
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
	log2web($result);
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

 }
}

function printResult(){
 global $result2Print;
 foreach($result2Print as $line)
	 echo $line;
}

 $sections[]='views/allResults.php';
