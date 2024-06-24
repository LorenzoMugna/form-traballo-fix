DROP SCHEMA IF EXISTS `sabg_applications`;
CREATE SCHEMA `sabg_applications` DEFAULT CHARSET `utf8mb4` DEFAULT COLLATE `uca1400_ai_ci`;
/** formato richiesta
array {
	["firstName"]=> string
	["lastName"]=> string
	["email"]=> string
	["university"]=> string
	["fos"]=> string
	["attendance"]=> string
	["motivation"]=> string
}

array{
	["cv"]=> array
	["name"]=> string
	["full_path"]=> string
	["type"]=> string
	["tmp_name"]=> string
	["error"]=> int
	["size"]=> int
}
*/

USE `sabg_applications`;
CREATE TABLE `applications`(
	id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(340) NOT NULL,
    university VARCHAR(255) NOT NULL,
    fos	VARCHAR(255) NOT NULL,
    attendance VARCHAR(255) NOT NULL,
    motivation TEXT NOT NULL,
    cvFileName VARCHAR(255) NOT NULL
) ENGINE InnoDB DEFAULT CHARSET=`utf8mb4` DEFAULT COLLATE `uca1400_ai_ci`;

-- User creation

DROP USER 'php'@'localhost';
CREATE USER 'php'@'localhost' IDENTIFIED BY 'sabg-php-account{fiu9Vd8dRr/3nrA=}';
FLUSH PRIVILEGES;
GRANT INSERT, SELECT, DELETE, UPDATE ON `sabg_applications`.`applications` TO 'php'@'localhost';
FLUSH PRIVILEGES;
