USE fb_lets_go;
CREATE TABLE users (
    id          INTEGER     NOT NULL AUTO_INCREMENT,
    first_name  VARCHAR(30) NOT NULL,
    last_name   VARCHAR(30) NOT NULL,
    email       VARCHAR(50) NOT NULL UNIQUE,
    password    CHAR(16)	NOT NULL,
    birth_month CHAR(4)		NOT NULL,
    birth_day   CHAR(2)		NOT NULL,
    birth_year  CHAR(4)		NOT NULL,
    gender      enum('M', 'F') NOT NULL,
    -- date_joined 

    PRIMARY KEY(id)
);

CREATE TABLE posts (
	id              INTEGER     NOT NULL AUTO_INCREMENT,
    author_email    VARCHAR(50) NOT NULL,
	content         TEXT        NOT NULL,
    post_time       TIMESTAMP   DEFAULT CURRENT_TIMESTAMP,
    edit_time       TIMESTAMP   DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	PRIMARY KEY (id,author_email),
	FOREIGN KEY (author_email) REFERENCES users (email)
);

CREATE TABLE comments (
    id              INTEGER     NOT NULL AUTO_INCREMENT,
    post_id         INTEGER     NOT NULL,
    author          VARCHAR(30) NOT NULL,
    comment_time    TIMESTAMP   NOT NULL,
    edited          BOOLEAN DEFAULT FALSE,

    PRIMARY KEY(id,post_id,author),
    FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- CREATE TABLE user_pics (
--     id             INTEGER     NOT NULL AUTO_INCREMENT,
--     profile        LONGBLOB,
--     cover        LONGBLOB,
--
--     PRIMARY KEY(id),
--     FOREIGN KEY (id) REFERENCES users(id)
-- );

/* directed graph */
-- CREATE TABLE friend_with (
--
--     since TIMESTAMP()
-- );


INSERT INTO users (first_name, last_name, email, password, birth_month, birth_day, birth_year, gender) VALUES ('Jia-Sheng', 'Ma', 'majiasheng@fb-lets-go.com', 'pw', 'Jan', '01', '1900', 'M');
