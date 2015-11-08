<?php
 include 'inc/logger.php';
 include 'inc/once.php';


 // testing if database exists
 $stmt=$dbh->prepare('select status,title,email from poll where poll=?;');
 if($stmt) {
	 // have database
	 if(isset($poll)) {
		 // have a poll
		 $stmt=$dbh->prepare('select title from poll where poll=?;');
		 $stmt->execute(array($poll));
		 $row=$stmt->fetch();
		 $pollTitle=$row['title'];
		 log2web('Poll: '.$pollTitle);

		 if(isset($admin)) {
			 if(isset($motion)) 
				 include 'inc/adminMotion.php';
			 else
				 include 'inc/adminPoll.php';

		 }else{
			 if(isset($voter))
				 include 'inc/servVoter.php';
			 else
				 include 'inc/servResults.php';
		 }
	 }else{
		 include 'inc/newPoll.php';
	 }
 }else {
	 log2web('installing database');
	 include 'inc/install.php';
 }

// calling the default view
 include 'views/site.php';
