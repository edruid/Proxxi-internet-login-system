SELECT "dropping user_groups";
DROP TABLE IF EXISTS `user_groups`;
SELECT "dropping group_access";
DROP TABLE IF EXISTS `group_access`;
SELECT "dropping memberships";
DROP TABLE IF EXISTS `memberships`;
SELECT "dropping attendance";
DROP TABLE IF EXISTS `attendance`;
SELECT "dropping blocked";
DROP TABLE IF EXISTS `blocked`;
SELECT "dropping karaoke_queue";
DROP TABLE IF EXISTS `karaoke_queue`;
SELECT "dropping log";
DROP TABLE IF EXISTS `log`;
SELECT "dropping sessions";
DROP TABLE IF EXISTS `sessions`;
SELECT "dropping poll_alternatives";
DROP TABLE IF EXISTS `poll_alternatives`;
SELECT "dropping voters";
DROP TABLE IF EXISTS `voters`;
SELECT "dropping polls";
DROP TABLE IF EXISTS `polls`;
SELECT "dropping user_settings";
DROP TABLE IF EXISTS `user_settings`;
SELECT "dropping group_access";
DROP TABLE IF EXISTS `groups`;
SELECT "dropping accesses";
DROP TABLE IF EXISTS `accesses`;
SELECT "dropping settings";
DROP TABLE IF EXISTS `settings`;
SELECT "dropping persistant_users";
DROP TABLE IF EXISTS `persistant_users`;
SELECT "dropping users";
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
	`co` varchar(64) NOT NULL,
	`street_address` varchar(64) NOT NULL,
	`area_code` int(6) unsigned NOT NULL,
	`area` varchar(64) NOT NULL,
	`password` varchar(70) DEFAULT NULL,
	`nthash` varchar(34) DEFAULT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `persistant_users` (
	`_persistant_user_id` int unsigned not null AUTO_INCREMENT,
	`_modified_time` timestamp DEFAULT CURRENT_TIMESTAMP,
	`user_id` int unsigned NOT NULL,
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
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	PRIMARY KEY (`_persistant_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `avatars` (
	`user_id` int unsigned not null,
	`avatar` longblob not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `settings` (
	`setting_id` int(10) unsigned not null AUTO_INCREMENT,
	`name` varchar(100) not null unique,
	`code_name` varchar(20) not null unique,
	PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_settings` (
	`user_id` int unsigned not null,
	`setting_id` int unsigned not null,
	`value` boolean not null,
	PRIMARY KEY(`user_id`, `setting_id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	FOREIGN KEY (`setting_id`) REFERENCES `settings` (`setting_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `accesses` (
	`access_id` int unsigned not null AUTO_INCREMENT,
	`name` varchar(100) not null unique,
	`code_name` varchar(20) not null unique,
	PRIMARY KEY(`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `groups` (
	`group_id` int unsigned not null auto_increment,
	`name` varchar(100) not null unique,
	`access_id` int(10) unsigned NOT NULL,
	FOREIGN KEY (`access_id`) REFERENCES `accesses` (`access_id`),
	PRIMARY KEY(`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_groups` (
	`user_id` int(10) unsigned not null,
	`group_id` int(10) unsigned not null,
	`valid_until` datetime default '0000-00-00',
	`permanent` boolean not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
	FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
	PRIMARY KEY(`group_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `group_access` (
	`access_id` int(10) unsigned not null,
	`group_id` int(10) unsigned not null,
	`valid_until` datetime default '0000-00-00',
	`permanent` boolean not null,
	FOREIGN KEY (`access_id`) REFERENCES `accesses` (`access_id`) ON DELETE CASCADE,
	FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
	PRIMARY KEY(`group_id`, `access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `memberships` (
	`user_id` int(10) unsigned not null,
	`start` date not null,
	`end` date not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY(`user_id`, `start`, `end`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `attendance` (
	`user_id` int(10) unsigned not null,
	`day` date not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`, `day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `blocked` (
	`user_id` int(10) unsigned not null,
	`admin` int(10) unsigned not null,
	`until` datetime not null,
	`reason` text not null,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	FOREIGN KEY (`admin`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `karaoke_queue` (
	`user_id` int(10) unsigned NOT NULL,
	`queued` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sessions` (
	`session_id` varchar(100) NOT NULL,
	`user_id` int(10) unsigned NOT NULL,
	`mac` varchar(17) NOT NULL,
	`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`internet` boolean NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `polls` (
	`poll_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`question` text,
	`description` text,
	`creator` int(10) unsigned NOT NULL,
	`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`vote_until` timestamp NOT NULL,
	FOREIGN KEY (`creator`) REFERENCES `users` (`user_id`),
	PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `poll_alternatives` (
	`poll_alternative_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`poll_id` int(10) unsigned NOT NULL,
	`num_votes` int(10) unsigned NOT NULL DEFAULT '0',
	`text` text,
	PRIMARY KEY (`poll_alternative_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `voters` (
	`user_id` int(10) unsigned NOT NULL,
	`poll_id` int(10) unsigned NOT NULL,
	PRIMARY KEY (`user_id`, `poll_id`),
	FOREIGN KEY (`poll_id`) REFERENCES `polls` (`poll_id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO accesses set name='Redigera användare', code_name='edit_user';
INSERT INTO accesses set name='Redigera settings', code_name='edit_setting';
INSERT INTO accesses set name='Redigera rättigheter', code_name='edit_access';
INSERT INTO accesses set name='Redigera grupper', code_name='edit_group';
INSERT INTO accesses set name='Ge rättighet till grupp', code_name='edit_group_access';
INSERT INTO accesses set name='Se användare', code_name='view_user';
INSERT INTO accesses set name='Internet access', code_name='internet';
INSERT INTO accesses set name='Uppdatera medlemskap', code_name='edit_membership';

INSERT INTO settings set name='Visa när jag är i lokalen', code_name='show_attendance';
INSERT INTO settings set name='Visa telefonnummer för andra medlemmar', code_name='show_phone';
INSERT INTO settings set name='Visa epostadress för andra medlemmar', code_name='show_email';

INSERT INTO accesses set name='Grant "Admin"', code_name='grant_1';
INSERT INTO groups set name="Admin", access_id = (SELECT access_id from accesses where code_name="grant_1");

INSERT INTO group_access set access_id = (SELECT access_id from accesses where code_name="edit_group_access"), group_id = 1, permanent = true;
INSERT INTO group_access set access_id = (SELECT access_id from accesses where code_name="edit_group"), group_id = 1, permanent = true;
