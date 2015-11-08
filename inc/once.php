<?php
log2web(__FILE__);

$requestVariables = array(
		'a' => 'admin',
		'e' => 'candidate',
		'm' => 'motion',
		'o' => 'option',
		'p' => 'poll',
		'v' => 'voter',
		'r' => 'rank',
		's' => 'state',
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


