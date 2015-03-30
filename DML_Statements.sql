SET foreign_key_checks=0;

TRUNCATE customer;
TRUNCATE book;
TRUNCATE publisher;
TRUNCATE author;
TRUNCATE invoice;
TRUNCATE written_by;
TRUNCATE cart_items;
TRUNCATE reviews;
TRUNCATE invoice_items;
TRUNCATE web_admin;

INSERT INTO customer 
		(username, pin, first_name, last_name)
	VALUES 
		('jsmith', 0000, 'John', 'Smith'),
		('sdouglas', 1234, 'Sue', 'Douglas'),
		('mjackson', 2323, 'Mark', 'Jackson');

INSERT INTO book
		(isbn, title, price, category, pub_date, pub_id)
	VALUES
		('9780590353427', 'Harry Potter and the Sorcerer''s Stone', 14.99, 'Fiction', '1997-06-26', 1),
		('9780307474278', 'The Da Vinci Code', 19.95, 'Fiction', '2003-03-18', 2),
		('9780544336261', 'The Giver', 9.99, 'Fiction', '1993-01-01', 3);

INSERT INTO publisher
		(name)
	VALUES
		('Scholastic'),
		('Doubleday'),
		('Houghton Mifflin Harcourt');

INSERT INTO author
		(first_name, last_name)
	VALUES
		('J.K.', 'Rowling'),
		('Dan', 'Brown'),
		('Lois', 'Lowry');

INSERT INTO invoice
		(sale_datetime, shipping_cost, grand_total, username)
	VALUES
		('2015-03-14 09:26:53', 3.99, 18.98, 'jsmith'),
		('2014-12-20 19:46:51', 3.99, 23.94, 'sdouglas'),
		('2013-05-16 22:00:01', 2.99, 12.98, 'mjackson');

INSERT INTO written_by
		(isbn, author_id)
	VALUES
		('9780590353427', 1),
		('9780307474278', 2),
		('9780544336261', 3);

INSERT INTO cart_items
		(username, isbn, quantity)
	VALUES
		('jsmith', '9780590353427', 1),
		('sdouglas', '9780307474278', 2),
		('mjackson', '9780544336261', 3);

INSERT INTO reviews
		(username, isbn, comment, rating)
	VALUES
		('jsmith', '9780590353427', 'Magical!', 5),
		('sdouglas', '9780307474278', 'Action packed.', 4),
		('mjackson', '9780544336261', 'Insightful.', 3);

INSERT INTO invoice_items
		(isbn, quantity, price_at_purchase)
	VALUES
		('9780590353427', 1, 14.99),
		('9780307474278', 1, 19.95),
		('9780544336261', 1, 19.99);

INSERT INTO web_admin
		(username, password)
	VALUES
		('admin', 'admin');
		
SET foreign_key_checks=1;