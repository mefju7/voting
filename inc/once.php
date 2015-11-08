<?php
log2web(__FILE__);

$requestVariables = array(
		'a' => 'admin',
		'm' => 'motion',
		'p' => 'poll',
		'v' => 'voter',
		'av' => 'addVoters',
		'md' => 'newMotionDescription',
		'mp' => 'newMotionProposals',
		'mr' => 'newMotionShuffle',
		'mt' => 'newMotionTitle',
		'pt' => 'newPollTitle',
		'moe' => 'newMotionOrElection',

);

log2web('opening database');
try {
	$dbh=new PDO('sqlite:data/voting.db');
	$stmt=$dbh->prepare('PRAGMA foreign_keys = ON;');
	$stmt->execute();
}catch(PDOException $e) {
	log2web($e->getMessage());
}

// putting certain values from requests into global variables;
foreach($_REQUEST as $k => $v)
{
	if(array_key_exists($k, $requestVariables))
	{
	log2web('request variable '.$k.':'.$v.' => '.$requestVariables[$k]);
		$GLOBALS[$requestVariables[$k]]=$v;
	}
}


