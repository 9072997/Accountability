CREATE TABLE IF NOT EXISTS `class` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`graduate` year DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `student` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`class` int unsigned DEFAULT NULL,
	`name` varchar(100) DEFAULT NULL,
	`code` varchar(100) DEFAULT NULL,
	UNIQUE (`code`),
	FOREIGN KEY (`class`) REFERENCES class(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `subject` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`class` int unsigned DEFAULT NULL,
	`name` varchar(100) DEFAULT NULL,
	FOREIGN KEY (`class`) REFERENCES class(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `section` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`subject` int unsigned DEFAULT NULL,
	`name` varchar(100) DEFAULT NULL,
	`points` int unsigned DEFAULT NULL,
	FOREIGN KEY (`subject`) REFERENCES subject(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `period` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`first` date DEFAULT NULL,
	`last` date DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `assignment` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`section` int unsigned DEFAULT NULL,
	`period` int unsigned DEFAULT NULL,
	`name` varchar(100) DEFAULT NULL,
	`note` text DEFAULT NULL,
	`points` int unsigned DEFAULT NULL,
	FOREIGN KEY (`section`) REFERENCES section(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	FOREIGN KEY (`period`) REFERENCES period(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `grade` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`assignment` int unsigned DEFAULT NULL,
	`student` int unsigned DEFAULT NULL,
	`note` text DEFAULT NULL,
	`points` int unsigned DEFAULT NULL,
	FOREIGN KEY (`assignment`) REFERENCES assignment(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	FOREIGN KEY (`student`) REFERENCES student(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `demerit` (
	`id` int unsigned NOT NULL AUTO_INCREMENT,
	`student` int unsigned DEFAULT NULL,
	`date` date DEFAULT NULL,
	`note` text DEFAULT NULL,
	`points` int DEFAULT NULL,
	FOREIGN KEY (`student`) REFERENCES student(`id`) ON UPDATE CASCADE ON DELETE SET NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;
