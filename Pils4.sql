DROP TABLE IF EXISTS `user_groups`;
DROP TABLE IF EXISTS `group_access`;
DROP TABLE IF EXISTS `memberships`;
DROP TABLE IF EXISTS `attendance`;
DROP TABLE IF EXISTS `blocked`;
DROP TABLE IF EXISTS `karaoke_queue`;
DROP TABLE IF EXISTS `log`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `poll_alternatives`;
DROP TABLE IF EXISTS `voters`;
DROP TABLE IF EXISTS `polls`;
DROP TABLE IF EXISTS `user_settings`;
DROP TABLE IF EXISTS `accesses`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
	`user_id` int unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(16) NOT NULL,
	`first_name` varchar(64) NOT NULL,
	`sex` enum('male','female') NOT NULL,
	`birthdate` date NOT NULL,
	`person_id_number` varchar(4),
	`surname` varchar(64) NOT NULL,
	`email` varchar(64) DEFAULT '',
	`phone1` varchar(16) NOT NULL,
	`phone2` varchar(16) DEFAULT '',
	`street_address` varchar(64) NOT NULL,
	`area_code` int(6) unsigned NOT NULL,
	`area` varchar(64) NOT NULL,
	`password` varchar(70) DEFAULT NULL,
	`nthash` varchar(34) DEFAULT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `settings` (
	`setting_id` int(10) unsigned not null AUTO_INCREMENT,
	`name` varchar(100) not null unique,
	`code_name` varchar(20) not null unique,
	PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_settings` (
	`user_id` int unsigned not null,
	`setting_id` int unsigned not null,
	`value` boolean not null,
	PRIMARY KEY(`user_id`, `setting_id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	FOREIGN KEY (`setting_id`) REFERENCES `settings` (`setting_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `accesses` (
	`access_id` int unsigned not null AUTO_INCREMENT,
	`name` varchar(100) not null unique,
	`code_name` varchar(20) not null unique,
	PRIMARY KEY(`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `groups` (
	`group_id` int unsigned not null auto_increment,
	`name` varchar(100) not null unique,
	`access_id` int(10) unsigned NOT NULL,
	FOREIGN KEY (`access_id`) REFERENCES `accesses` (`access_id`),
	PRIMARY KEY(`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_groups` (
	`user_id` int(10) unsigned not null,
	`group_id` int(10) unsigned not null,
	`valid_until` datetime default '0000-00-00',
	`permanent` boolean not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
	PRIMARY KEY(`group_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `group_access` (
	`access_id` int(10) unsigned not null,
	`group_id` int(10) unsigned not null,
	`valid_until` datetime default '0000-00-00',
	`permanent` boolean not null,
	FOREIGN KEY (`access_id`) REFERENCES `accesses` (`access_id`) ON DELETE CASCADE,
	FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
	PRIMARY KEY(`group_id`, `access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `memberships` (
	`user_id` int(10) unsigned not null,
	`start` date not null,
	`end` date not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY(`user_id`, `start`, `end`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `attendance` (
	`user_id` int(10) unsigned not null,
	`day` date not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`, `day`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `blocked` (
	`user_id` int(10) unsigned not null,
	`admin` int(10) unsigned not null,
	`until` datetime not null,
	`reason` text not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	FOREIGN KEY (`admin`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `karaoke_queue` (
	`user_id` int(10) unsigned NOT NULL,
	`queued` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `log` (
	`log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`admin` int(10) unsigned DEFAULT NULL,
	`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`description` text,
	`action` varchar(10) NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	FOREIGN KEY (`admin`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `sessions` (
	`session_id` int(10) unsigned NOT NULL,
	`user_id` int(10) unsigned NOT NULL,
	`mac` varchar(17) NOT NULL,
	`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`internet` boolean NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `polls` (
	`poll_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`question` text,
	`description` text,
	`creator` int(10) unsigned NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`vote_until` timestamp NOT NULL,
	FOREIGN KEY (`creator`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `poll_alternatives` (
	`poll_alternative_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`poll_id` int(10) unsigned NOT NULL,
	`num_votes` int(10) unsigned NOT NULL DEFAULT '0',
	`text` text,
	PRIMARY KEY (`poll_alternative_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `voters` (
	`user_id` int(10) unsigned NOT NULL,
	`poll_id` int(10) unsigned NOT NULL,
	PRIMARY KEY (`user_id`, `poll_id`),
	FOREIGN KEY (`poll_id`) REFERENCES `polls` (`poll_id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

