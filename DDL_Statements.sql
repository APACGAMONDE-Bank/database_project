DROP DATABASE db;

CREATE DATABASE db;

USE db;

SET foreign_key_checks=0;

CREATE TABLE customer
	(
		username VARCHAR(20) NOT NULL, 
		pin INT NOT NULL, 
		card_type VARCHAR(15), 
		card_number INT, 
		card_exp_date DATE, 
		first_name VARCHAR(20) NOT NULL, 
		middle_name VARCHAR(20), 
		last_name VARCHAR(20) NOT NULL, 
		street VARCHAR(20), 
		city VARCHAR(20), 
		state CHAR(2), 
		zip INT,
		PRIMARY KEY (username)
	);

CREATE TABLE book
	(
		isbn INT NOT NULL,
		title VARCHAR(50) NOT NULL,
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
		name VARCHAR(30) NOT NULL,
		PRIMARY KEY (pub_id)
	);

CREATE TABLE author
	(
		author_id INT NOT NULL AUTO_INCREMENT,
		first_name VARCHAR(20) NOT NULL,
		middle_name VARCHAR(20),
		last_name VARCHAR(20) NOT NULL,
		PRIMARY KEY (author_id)
	);

CREATE TABLE invoice
	(
		invoice_id INT NOT NULL AUTO_INCREMENT,
		sale_datetime DATETIME NOT NULL,
		shipping_cost DECIMAL(6,2) NOT NULL,
		grand_total DECIMAL(6,2) NOT NULL,
		username VARCHAR(20) NOT NULL,
		FOREIGN KEY (username) REFERENCES customer(username),
		PRIMARY KEY (invoice_id)
	);

CREATE TABLE written_by
	(
		isbn INT NOT NULL,
		author_id INT NOT NULL,
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		FOREIGN KEY (author_id) REFERENCES author(author_id),
		PRIMARY KEY (isbn, author_id)
	);

CREATE TABLE cart_items
	(
		username VARCHAR(20) NOT NULL,
		isbn INT NOT NULL,
		quantity INT NOT NULL,
		FOREIGN KEY (username) REFERENCES customer(username),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (username, isbn)
	);

CREATE TABLE reviews
	(
		username VARCHAR(20) NOT NULL,
		isbn INT NOT NULL,
		comment TEXT, 
		rating INT NOT NULL,
		FOREIGN KEY (username) REFERENCES customer(username),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (username, isbn)
	);

CREATE TABLE invoice_items
	(
		invoice_id INT NOT NULL,
		isbn INT NOT NULL,
		quantity INT NOT NULL,
		price_at_purchase DECIMAL(6,2) NOT NULL,
		FOREIGN KEY (invoice_id) REFERENCES invoice(invoice_id),
		FOREIGN KEY (isbn) REFERENCES book(isbn),
		PRIMARY KEY (invoice_id, isbn)
	);

CREATE TABLE web_admin
	(
		username VARCHAR(20) NOT NULL,
		password VARCHAR(32) NOT NULL,
		PRIMARY KEY (username)
	);