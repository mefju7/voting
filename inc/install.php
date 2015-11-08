<?php


$installSQL= <<<EOD

create table if not exists poll (poll char(32) primary key , 
	adminCode char(32), title char(255), status unsigned tinyint, email char(255),created integer);

create table if not exists motion (poll char(32), motion unsigned tinyint, 
  title char(255), motionOrElection unsigned tinyint,   
	description text, primary key (poll,motion) on conflict replace,
	foreign key(poll) references poll(poll) on update cascade on delete cascade);

create table if not exists proposal (poll char(32), motion unsigned tinyint, 
	proposal unsigned tinyint, title varchar(255),
	primary key(poll, motion, proposal) on conflict replace,
	foreign key(poll, motion) references motion(poll, motion) on update cascade on delete cascade);

create table if not exists vote(poll char(32), voter char(32), motion unsigned tinyint,
	vote text, 
	primary key(poll, voter, motion) on conflict replace,
	foreign key(poll, motion) references motion(poll, motion) on update cascade on delete cascade);

 insert into poll values ("poll","admin","test poll",0,"me@me",0);
 insert into motion values ("poll", 0, "first motion", 0, "you know what...");
 insert into motion values ("poll", 1, "second motion", 3, "elect the board...");
 insert into proposal values ("poll", 0, 0, "nothing");
 insert into proposal values ("poll", 0, 1, "something");
 insert into proposal values ("poll", 0, 2, "only a few");
 insert into proposal values ("poll", 0, 3, "everything");
 insert into proposal values ("poll", 1, 0, "Donald Duck");
 insert into proposal values ("poll", 1, 1, "Superman");
 insert into proposal values ("poll", 1, 2, "Ironman");
 insert into proposal values ("poll", 1, 3, "Aquaman");
 insert into proposal values ("poll", 1, 4, "Tarzan");
 insert into proposal values ("poll", 1, 5, "Einstein");
 insert into proposal values ("poll", 1, 6, "Dr. Who");
 insert into proposal values ("poll", 1, 7, "Sheldon Cooper");
 insert into vote values("poll","me",0,"");



EOD;

foreach(explode(";",$installSQL) as $stmt)
{
	$stmt=trim($stmt);
	if(strlen($stmt)==0) 
		continue;
	$stmt .=';';
	log2web($stmt);
	$stmt=$dbh->prepare($stmt);
	if($stmt)
		$stmt->execute();
}


