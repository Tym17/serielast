DROP TABLE IF EXISTS `serie`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`name`	TEXT,
	`pass`	TEXT
);

CREATE TABLE `serie` (
	`id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`OwnerId`	INTEGER,
	`Name`	TEXT,
	`AirDate`	TEXT,
	`LastSeason`	INTEGER,
	`LastEpisode`	INTEGER,
	`Color`	TEXT
);
