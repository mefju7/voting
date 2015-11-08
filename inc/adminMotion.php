<?php

log2web(__FILE__);
$Scripts[]='/tinymce/js/tinymce/tinymce.min.js';


if(isset($newMotionTitle)){
	require_once 'inc/htmlpurify.php';  
	$nmt=$purifier->purify($newMotionTitle);
	$nmoe=intval($newMotionOrElection);
	$nmd=$purifier->purify($newMotionDescription);
	$stmt=$dbh->prepare('insert into motion values(?,?,?,?,?);');
	$stmt->execute(array($poll,$motion,$nmt,$nmoe,$nmd));
}

if(isset($newMotionProposals)){
	$props=strip_tags($newMotionProposals);
	$props=explode("\r\n",$props);
	if(isset($newMotionShuffle)){
		if(boolval($newMotionShuffle))
			shuffle($props);
	}
	$stmt=$dbh->prepare('delete from proposal where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$propNr=0;
	$stmt=$dbh->prepare('insert into proposal values(?,?,?,?);');
	foreach($props as $prop){
		$prop=trim($prop);
		if(strlen($prop)==0)
			continue;
		$stmt->execute(array($poll,$motion,$propNr,$prop));
		++$propNr;
	}
}


	$stmt=$dbh->prepare('select * from motion where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$row=$stmt->fetch();
	if($row){
		$motionTitle=$row['title'];
		$motionDesc=$row['description'];
		$moe=$row['motionOrElection'];
	}else{
		$moe=0;
	}

	$stmt=$dbh->prepare('select proposal, title from proposal where poll=? and motion=?');
	$stmt->execute(array($poll,$motion));
	$rows=$stmt->fetchAll();
	$proposals=array();
	foreach($rows as $row) {
		$proposals[$row['proposal']]=$row['title'];
	}
	$motionProposals=implode("\r\n",$proposals);

	$motionSelectOptions=array();
	$motionSelectOptions[0]='Motion';
	$maxOpt=2*$moe+5;
	if($maxOpt<20)
		$maxOpt=20;
	for($i=1;$i<$maxOpt;++$i)
		$motionSelectOptions[$i]='Elect '.$i;

	$motionHiddenFields=array('p','a','m');

 $stmt=$dbh->prepare('select motion,title from motion where poll=?;');
 $stmt->execute(array($poll));
 $res=$stmt->fetchAll();
 $motionTitles=array();
 foreach($res as $entries)
  $motionTitles[$entries['motion']]=$entries['title'];
 $motionTitles[]='--new motion--';
 $selArray=array('p','a');

$sections[]='views/adminMotion.php';
$sections[]='views/motionSelect.php';

