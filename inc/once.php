<?php
log2web(__FILE__);

log2web('opening database');
try {
	$dbh=new PDO('sqlite:data/voting.db');
	$stmt=$dbh->prepare('PRAGMA foreign_keys = ON;');
	$stmt->execute();
}catch(PDOException $e) {
	log2web($e->getMessage());
}
