USE fb_lets_go;
CREATE TABLE users (
	id 			INTEGER 	NOT NULL AUTO_INCREMENT,
	first_name	VARCHAR(30) NOT NULL,
	last_name 	VARCHAR(30) NOT NULL,
	email		VARCHAR(50) NOT NULL UNIQUE,
	password	CHAR(16)	NOT NULL,
	birth_month CHAR(4)		NOT NULL,
	birth_day	CHAR(2)		NOT NULL,
	birth_year	CHAR(4)		NOT NULL,
	gender 		enum('M', 'F') NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE posts (
	post_id		INTEGER		NOT NULL AUTO_INCREMENT,
	user_id		INTEGER		NOT NULL,
	content		TEXT		NOT NULL,
	post_date	date 		NOT NULL,
	comment_id	INTEGER,

	PRIMARY KEY(post_id),
	FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
	comment_id  INTEGER 	NOT NULL AUTO_INCREMENT,
	author		VARCHAR(30) NOT NULL,
	comment_date date 		NOT NULL,


	PRIMARY KEY(comment_id),
	FOREIGN KEY (comment_id) REFERENCES posts(comment_id)
);


INSERT INTO users (first_name, last_name, email, password, birth_month, birth_day, birth_year, gender) VALUES ('Jia-Sheng', 'Ma', 'majiasheng@fb-lets-go.com', 'password', 'Jan', '01', '1900', 'M');
