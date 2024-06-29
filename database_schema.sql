-- DROP SCHEMA IF EXISTS `sabg_applications`;
-- CREATE SCHEMA `sabg_applications` DEFAULT CHARSET `utf8mb4` DEFAULT COLLATE `utf8mb4_general_ci`;
-- USE `sabg_applications`;
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications`(
	id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
	email VARCHAR(340) NOT NULL,
	verified BOOLEAN DEFAULT FALSE,
	-- verificationCode VARCHAR(255) NOT NULL,
    university VARCHAR(255) NOT NULL,
    fos	VARCHAR(255) NOT NULL,
    attendance VARCHAR(255) NOT NULL,
    motivation TEXT NOT NULL,
	allowImages BOOLEAN DEFAULT FALSE,
    cvFileName VARCHAR(255) NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=`utf8mb4` DEFAULT COLLATE `utf8mb4_general_ci`;

DROP TABLE IF EXISTS `admin_tokens`;
CREATE TABLE `admin_tokens`(
	id INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(340) NOT NULL,
	token VARCHAR(255) NOT NULL,
	expiration DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE InnoDB DEFAULT CHARSET=`utf8mb4` DEFAULT COLLATE `utf8mb4_general_ci`;

DROP TRIGGER IF EXISTS `add_expiration`;
CREATE TRIGGER `add_expiration` BEFORE INSERT ON `admin_tokens`
	FOR EACH ROW
	SET NEW.`expiration` = CURRENT_TIMESTAMP + INTERVAL 5 MINUTE;


DROP EVENT IF EXISTS `delete_expired_tokens`;
CREATE EVENT `delete_expired_tokens` ON SCHEDULE EVERY 1 HOUR DO
	DELETE FROM `admin_tokens` WHERE `expiration` < CURRENT_TIMESTAMP;

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`(
	email VARCHAR(340) PRIMARY KEY
)ENGINE InnoDB DEFAULT CHARSET=`utf8mb4` DEFAULT COLLATE `utf8mb4_general_ci`;
-- User creation -------------------------------

/*DROP USER 'php'@'localhost';
CREATE USER 'php'@'localhost' IDENTIFIED BY 'sabg-php-account{fiu9Vd8dRr/3nrA=}';
FLUSH PRIVILEGES;
GRANT INSERT, SELECT, DELETE, UPDATE ON `sabg_applications`.`applications` TO 'php'@'localhost';
GRANT INSERT, SELECT, DELETE, UPDATE ON `sabg_applications`.`admin_tokens` TO 'php'@'localhost';
GRANT SELECT ON `sabg_applications`.`admins` TO 'php'@'localhost';
FLUSH PRIVILEGES;*/
