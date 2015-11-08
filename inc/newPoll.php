<?php
 log2web('creating new poll');
 if(isset($_POST['email'])){
  log2web('sending email');
	$email=$_POST['email'];
	$email=strip_tags($email);
	log2web('got email:'.$email);
	$poll=md5(rand().$email.'poll');
	$admin=md5(rand().$email.'admin');
	$stmt=$dbh->prepare('insert into poll values(?,?,null,0,?,?);');
	$stmt->execute(array($poll,$admin,$email,time()));
	$script=$_SERVER['PHP_SELF'];
	$script=explode('?',$script)[0];
	$adminLink="http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?p='.$poll.'&a='.$admin;
	$msg='<html><body>';
	$msg.='You can now administer the poll by using the link <a href="';
	$msg.=$adminLink;
	$msg.='">'.$adminLink.'</a>. Enjoy the poll!';
	$msg.='</body></html>';
	// To send HTML mail, the Content-type header must be set
	$mailHeaders  = array();
	$mailHeaders[]='MIME-Version: 1.0' ;
	$mailHeaders[]= 'Content-type: text/html; charset=iso-8859-1';
	$mailHeaders[]='X-Mailer: PHP/'.phpversion();
	mail($email,'poll created',$msg,implode("\r\n",$mailHeaders));
	$sections[]='views/pollCreated.php';
 }else{
 	$sections[]='views/newPoll.php';
 }
