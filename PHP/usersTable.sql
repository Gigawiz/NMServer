CREATE TABLE `users` ( 
	`id` INT NOT NULL AUTO_INCREMENT , 
	`username` VARCHAR(255) NULL , 
	`email` VARCHAR(255) NULL , 
	`password` VARCHAR(255) NULL , 
	`salt` VARCHAR(255) NULL , 
	`hash` VARCHAR(255) NULL , 
	`online` TINYINT(1) NOT NULL DEFAULT '0', 
PRIMARY KEY (`id`));