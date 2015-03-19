DROP DATABASE db;

CREATE DATABASE db;

USE db;

SET foreign_key_checks=0;

CREATE TABLE customer
	(
		username VARCHAR(20), 
		pin INT, 
		card_type VARCHAR(15), 
		card_number INT, 
		card_exp_date DATE, 
		first_name VARCHAR(20), 
		middle_name VARCHAR(20), 
		last_name VARCHAR(20), 
		street VARCHAR(20), 
		city VARCHAR(20), 
		state CHAR(2), 
		zip INT,
		PRIMARY KEY (username)
	);

CREATE TABLE book
	(
		isbn INT,
		title VARCHAR(50),
		price DECIMAL(6,2),
		category VARCHAR(20),
		pub_date DATE,
		pub_id INT,
		FOREIGN KEY (pub_id) REFERENCES publisher(pub_id),
		PRIMARY KEY (isbn)
	);

CREATE TABLE publisher
	(
		pub_id INT NOT NULL AUTO_INCREMENT,
		name VARCHAR(30),
		PRIMARY KEY (pub_id)
	);

CREATE TABLE author
	(
		author_id INT NOT NULL AUTO_INCREMENT,
		first_name VARCHAR(20),
		middle_name VARCHAR(20),
		last_name VARCHAR(20),
		PRIMARY KEY (author_id)
	);

CREATE TABLE invoice
	(
		invoice_id INT NOT NULL AUTO_INCREMENT,
		sale_datetime DATETIME,
		shipping_cost DECIMAL(6,2),
		grand_total DECIMAL(6,2),
		username VARCHAR(20),
		FOREIGN KEY (username) REFERENCES customer(username),
		PRIMARY KEY (invoice_id)
	);

CREATE TABLE written_by
	(
		isbn INT,
		author_id INT,
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		FOREIGN KEY (author_id) REFERENCES author(author_id),
		PRIMARY KEY (isbn, author_id)
	);

CREATE TABLE cart_items
	(
		username VARCHAR(20),
		isbn INT,
		quantity INT,
		FOREIGN KEY (username) REFERENCES customer(username),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (username, isbn)
	);

CREATE TABLE reviews
	(
		username VARCHAR(20),
		isbn INT,
		comment TEXT, 
		rating INT,
		FOREIGN KEY (username) REFERENCES customer(username),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (username, isbn)
	);

CREATE TABLE invoice_items
	(
		invoice_id INT,
		isbn INT,
		quantity INT,
		price_at_purchase DECIMAL(6,2),
		FOREIGN KEY (invoice_id) REFERENCES invoice(invoice_id),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (invoice_id, isbn)
	);

CREATE TABLE web_admin
	(
		username VARCHAR(20),
		password VARCHAR(32),
		PRIMARY KEY (username)
	);