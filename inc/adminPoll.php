<?php

if(isset($newPollTitle)){
	$pollTitle=strip_tags($newPollTitle);
	$stmt=$dbh->prepare('update poll set title=? where poll=?;');
	$res=$stmt->execute(array($pollTitle,$poll));
}

$linkBase='http://';
$linkBase .= $_SERVER['SERVER_NAME'];
$linkBase .= explode('?',$_SERVER['PHP_SELF'])[0];

	if(isset($addVoters)) {
	 $voters=explode("\r\n",$addVoters);
	 $stmt=$dbh->prepare('insert into vote values(?,?,0,"");');
	 foreach($voters as $v) {
	   $v=strip_tags($v);
		 $v=trim($v);
		 if(strlen($v)==0)
			 continue;
		 $key=md5(rand().$v.'key');
		 // log2web('added voter '.$v.' with key '.$key);
		 $stmt->execute(array($poll,$key));
		 $voteLink=$linkBase.'?p='.$poll.'&v='.$key;
		 $msg='<html><body><h3>'.$pollTitle.'</h3>';
		 $msg.='You can now vote at <a href="'.$voteLink.'">'.$voteLink.'</a>. Enjoy voting!';
		 $msg.='</body></html>';
		 // To send HTML mail, the Content-type header must be set
		 $mailHeaders  = array();
		 $mailHeaders[]='MIME-Version: 1.0' ;
		 $mailHeaders[]= 'Content-type: text/html; charset=iso-8859-1';
		 $mailHeaders[]='X-Mailer: PHP/'.phpversion();
		 mail($v,'you are invited to vote',$msg,implode("\r\n",$mailHeaders));
	 }
	}

$editMotionLink="$linkBase?p=$poll&a=$admin&m=0";
$showResultsLink="$linkBase?p=$poll";


$sections[]='views/adminPoll.php';
