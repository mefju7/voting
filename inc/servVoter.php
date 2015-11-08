<?php
log2web(__FILE__);
$Scripts[]='inc/vote.js';

// getting description of motion
if(!isset($motion))
	$motion=0;
	$stmt=$dbh->prepare('select title, description from motion where poll=? and motion=?;');
	$stmt->execute(array($poll,$motion));
	$res=$stmt->fetch();
	if(!$res) {
		include 'inc/servResults.php';
		return;
	}

$motionTitle=$res['title'];
$motionDescription=$res['description'];
$sections[]='views/showMotion.php';



 $stmt=$dbh->prepare('select motion,title from motion where poll=?;');
 $stmt->execute(array($poll));
 $res=$stmt->fetchAll();
 $motionTitles=array();
 foreach($res as $entries)
  $motionTitles[$entries['motion']]=$entries['title'];
 $selArray=array('p','v');
$sections[]='views/motionSelect.php';



