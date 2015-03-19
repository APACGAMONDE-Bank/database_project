DROP TABLE *;

CREATE TABLE customer
	(
		username VARCHAR(20) AS PRIMARY KEY, 
		pin INT, 
		card_type VARCHAR(15), 
		card_number INT, 
		card_exp_date INT, 
		first_name VARCHAR(20), 
		middle_name VARCHAR(20), 
		last_name VARCHAR(20), 
		street VARCHAR(20), 
		city VARCHAR(20), 
		state CHAR(2), 
		zip INT
	);

CREATE TABLE book
	(
		isbn INT AS PRIMARY KEY,
		title VARCHAR(50),
		price REAL,
		category VARCHAR(20),
		pub_date INT,
		pub_id INT FOREIGN KEY REFERENCES publisher(pub_id)
	);

CREATE TABLE publisher
	(
		pub_id INT AS PRIMARY KEY,
		name VARCHAR(30)
	);

CREATE TABLE author
	(
		author_id INT AS PRIMARY KEY,
		first_name VARCHAR(20),
		middle_name VARCHAR(20),
		last_name VARCHAR(20)
	);