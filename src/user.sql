CREATE TABLE user (
	id 			INTEGER 	NOT NULL AUTO_INCREMENT,
	first_name	VARCHAR(30) NOT NULL,
	last_name 	VARCHAR(30) NOT NULL,
	email		VARCHAR(50) NOT NULL UNIQUE,
	password	CHAR(16)	NOT NULL
	birth_month CHAR(4)		NOT NULL,
	birth_day	CHAR(2)		NOT NULL,
	birth_year	CHAR(4)		NOT NULL,
	gender 		enum('M', 'F') NOT NULL,
	PRIMARY KEY(id)
);

INSERT INTO user (first_name, last_name, email, password, birth_month, birth_day, birth_year, gender) VALUES ('Jia-Sheng', 'Ma', 'majiasheng@fb.com', 'passowrd', 'Jan', '01', '1900', 'M');