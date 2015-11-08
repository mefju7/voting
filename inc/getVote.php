<?php

log2web(__FILE__);

if(!isset($mOE)){
	$stmt=$dbh->prepare('select motionOrElection from motion where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$res=$stmt->fetch();
	$mOE=$res['motionOrElection'];
}

if (!isset($ops)) {
	$stmt=$dbh->prepare('select proposal,title from proposal where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$res=$stmt->fetchAll();
	$ops=array();
	foreach($res as $val){
		$ops[$val['proposal']]=$val['title'];
	}
}

if(!isset($vote)){
	// get the current vote
	$stmt=$dbh->prepare('select vote,motion from vote where poll=? and voter=? and (motion=? or motion=0);');
	$stmt->execute(array($poll,$voter,$motion));
	$rows=$stmt->fetchAll();
	log2web('got '.count($rows).' rows');
	foreach($rows as $row)
	{
		$validVoter=1;
		log2web('got a valid voter');
		if($row['motion']==$motion){
			$vote=$row['vote'];
			if(strlen($vote)>0)
				$votes=explode('|',$vote);
				break;
		}
	}
}
?>
