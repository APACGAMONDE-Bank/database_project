<?php
require_once 'php_tools.php';

$books = array (
	array (
		'isbn' => '9781470008956',
		'title' => 'The Book of Deacon (Volume 1)',
		'author' => array (
			array (
				'first_name' => 'Joseph',
				'last_name' => 'Lallo' 
			),
			array (
				'first_name' => 'Nick',
				'last_name' => 'Deligaris'
			)
		),
		'price' => '11.69',
		'category' => 'Fantasy',
		'pub_date' => '2012-03-18',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	),
	array (
		'isbn' => '9781481093781',
		'title' => 'Magic of Thieves (Legends of Dimmingwood Book 1)',
		'author' => array (
			array (
				'first_name' => 'C.',
				'last_name' => 'Greenwood' 
			) 
		),
		'price' => '9.99',
		'category' => 'Fantasy',
		'pub_date' => '2012-12-13',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	) ,
	array (
		'isbn' => '9780988464261',
		'title' => 'The Chronicles of Dragon: The Hero, the Sword and the Dragons (Volume 1)',
		'author' => array (
			array (
				'first_name' => 'Craig',
				'last_name' => 'Halloran' 
			) 
		),
		'price' => '9.99',
		'category' => 'Fantasy',
		'pub_date' => '2013-02-28',
		'pub_name' => 'Two-Ten Book Press' 
	),
	array (
		'isbn' => '9780692360019',
		'title' => 'Son of a Dark Wizard (The Dark Wizard Chronicles) (Volume 1)',
		'author' => array (
			array (
				'first_name' => 'Sean',
				'last_name' => 'Hannifin' 
			) 
		),
		'price' => '8.99',
		'category' => 'Fantasy',
		'pub_date' => '2015-01-10',
		'pub_name' => 'Morrowgrand Books' 
	),
	array (
		'isbn' => '9780615820095',
		'title' => 'Hammers in the Wind (The Northern Crusade) (Volume 1)',
		'author' => array (
			array (
				'first_name' => 'Christian',
				'last_name' => 'Freed' 
			) 
		),
		'price' => '9.89',
		'category' => 'Fantasy',
		'pub_date' => '2013-05-16',
		'pub_name' => 'Writer\'s Edge Publishing' 
	),
	array (
		'isbn' => '9780547745527',
		'title' => 'AWOL on the Appalachian Trail',
		'author' => array (
			array (
				'first_name' => 'David',
				'last_name' => 'Miller' 
			) 
		),
		'price' => '8.67',
		'category' => 'Adventure',
		'pub_date' => '2011-11-01',
		'pub_name' => 'Mariner Books' 
	),
	array (
		'isbn' => '9780767910743',
		'title' => 'Into Africa: The Epic Adventures of Stanley and Livingstone',
		'author' => array (
			array (
				'first_name' => 'Martin',
				'last_name' => 'Dugard' 
			) 
		),
		'price' => '9.57',
		'category' => 'Adventure',
		'pub_date' => '2004-04-13',
		'pub_name' => 'Broadway Books' 
	),
	array (
		'isbn' => '9780763670931',
		'title' => 'The Impossible Rescue: The True Story of an Amazing Arctic Adventure',
		'author' => array (
			array (
				'first_name' => 'Martin',
				'last_name' => 'Sandler' 
			) 
		),
		'price' => '7.56',
		'category' => 'Adventure',
		'pub_date' => '2014-07-22',
		'pub_name' => 'Candlewick' 
	),
	array (
		'isbn' => '9781475031904',
		'title' => 'Breakthrough',
		'author' => array (
			array (
				'first_name' => 'Michael',
				'last_name' => 'Grumley' 
			) 
		),
		'price' => '9.38',
		'category' => 'Adventure',
		'pub_date' => '2013-06-13',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	),
	array (
		'isbn' => '9781743217191',
		'title' => '1000 Ultimate Adventures',
		'author' => array (
			array (
				'first_name' => 'Lonely',
				'last_name' => 'Planet' 
			) 
		),
		'price' => '17.75',
		'category' => 'Adventure',
		'pub_date' => '2013-09-01',
		'pub_name' => 'Lonely Planet' 
	),
	array (
		'isbn' => '9780984015719',
		'title' => 'Forsaken',
		'author' => array (
			array (
				'first_name' => 'Andrew',
				'last_name' => 'Wey' 
			) 
		),
		'price' => '13.09',
		'category' => 'Horror',
		'pub_date' => '2012-10-04',
		'pub_name' => 'Greywood Bay' 
	),
	array (
		'isbn' => '9781476754475',
		'title' => 'Mr. Mercedes',
		'author' => array (
			array (
				'first_name' => 'Stephen',
				'last_name' => 'King' 
			) 
		),
		'price' => '13.42',
		'category' => 'Horror',
		'pub_date' => '2015-01-06',
		'pub_name' => 'Gallery Books' 
	),
	array (
		'isbn' => '9781492230601',
		'title' => 'Ancient Enemy',
		'author' => array (
			array (
				'first_name' => 'Mark',
				'last_name' => 'Lukens' 
			) 
		),
		'price' => '9.95',
		'category' => 'Horror',
		'pub_date' => '2013-09-02',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	),
	array (
		'isbn' => '9781481882903',
		'title' => 'Rushed',
		'author' => array (
			array (
				'first_name' => 'Brian',
				'last_name' => 'Harmon' 
			) 
		),
		'price' => '10.71',
		'category' => 'Horror',
		'pub_date' => '2013-02-06',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	),
	array (
		'isbn' => '9781680580594',
		'title' => 'The Ghost Files (Volume 1)',
		'author' => array (
			array (
				'first_name' => 'Apryl',
				'last_name' => 'Baker' 
			) 
		),
		'price' => '13.57',
		'category' => 'Horror',
		'pub_date' => '2015-03-15',
		'pub_name' => 'Limitless Publishing, LLC' 
	),
	array (
		'isbn' => '9780316055444',
		'title' => 'The Goldfinch',
		'author' => array (
			array (
				'first_name' => 'Donna',
				'last_name' => 'Tartt' 
			) 
		),
		'price' => '11.39',
		'category' => 'Fiction',
		'pub_date' => '2015-04-07',
		'pub_name' => 'Back Bay Books' 
	),
	array (
		'isbn' => '9781492291565',
		'title' => 'The Mind Readers',
		'author' => array (
			array (
				'first_name' => 'Lori',
				'last_name' => 'Brighton' 
			) 
		),
		'price' => '9.45',
		'category' => 'Fiction',
		'pub_date' => '2013-09-13',
		'pub_name' => 'CreateSpace Independent Publishing Platform' 
	),
	array (
		'isbn' => '9781451681758',
		'title' => 'The Light Between Oceans',
		'author' => array (
			array (
				'first_name' => 'M.L.',
				'last_name' => 'Stedman' 
			) 
		),
		'price' => '9.50',
		'category' => 'Fiction',
		'pub_date' => '2013-04-02',
		'pub_name' => 'Scribner' 
	),
	array (
		'isbn' => '9780758278456',
		'title' => 'What She Left Behind',
		'author' => array (
			array (
				'first_name' => 'Ellen',
				'last_name' => 'Wiseman' 
			) 
		),
		'price' => '9.43',
		'category' => 'Fiction',
		'pub_date' => '2013-12-31',
		'pub_name' => 'Kensington' 
	),
	array (
		'isbn' => '9781477824757',
		'title' => 'Yellow Crocus',
		'author' => array (
			array (
				'first_name' => 'Laila',
				'last_name' => 'Ibrahim' 
			) 
		),
		'price' => '10.20',
		'category' => 'Fiction',
		'pub_date' => '2014-09-19',
		'pub_name' => 'Lake Union Publishing' 
	),
	array (
		'isbn' => '9781476770383',
		'title' => 'Revival',
		'author' => array (
			array (
				'first_name' => 'Stephen',
				'last_name' => 'King' 
			) 
		),
		'price' => '17.04',
		'category' => 'Horror',
		'pub_date' => '2014-11-11',
		'pub_name' => ' Scribner' 
	),
	array (
		'isbn' => '9781451627299',
		'title' => '11/22/63',
		'author' => array (
			array (
				'first_name' => 'Stephen',
				'last_name' => 'King' 
			) 
		),
		'price' => '11.29',
		'category' => 'Horror',
		'pub_date' => '2012-07-24',
		'pub_name' => 'Gallery Books' 
	),
	array (
		'isbn' => '9781451698855',
		'title' => 'Doctor Sleep',
		'author' => array (
			array (
				'first_name' => 'Stephen',
				'last_name' => 'King' 
			) 
		),
		'price' => '13.60',
		'category' => 'Horror',
		'pub_date' => '2014-06-10',
		'pub_name' => 'Gallery Books' 
	),
	array (
		'isbn' => '9780307743657',
		'title' => 'The Shining',
		'author' => array (
			array (
				'first_name' => 'Stephen',
				'last_name' => 'King' 
			) 
		),
		'price' => '7.00',
		'category' => 'Horror',
		'pub_date' => '2013-06-26',
		'pub_name' => 'Anchor' 
	),
	array (
		'isbn' => '9780073523323',
		'title' => 'Database System Concepts: 6th Edition',
		'author' => array (
			array (
				'first_name' => 'Abraham',
				'last_name' => 'Silberschatz' 
			),
			array (
				'first_name' => 'Henry',
				'last_name' => 'Korth' 
			),
			array (
				'first_name' => 'S.',
				'last_name' => 'Sudarshan' 
			)  
		),
		'price' => '186.04',
		'category' => 'Adventure',
		'pub_date' => '2010-01-27',
		'pub_name' => 'McGraw-Hill Science/Engineering/Math' 
	)
);

$conn = getDatabaseConnection ();

// for finding publisher
$findPublisherStmt = $conn->prepare ( "SELECT pub_id FROM publisher WHERE name=:pub_name" );
$findPublisherStmt->bindParam ( ':pub_name', $pub_name );

// for inserting into publisher
$insertIntoPublisherStmnt = $conn->prepare ( "INSERT INTO publisher (name) VALUES (:pub_name)" );
$insertIntoPublisherStmnt->bindParam ( ':pub_name', $pub_name );

// for finding book
$findBookStmnt = $conn->prepare ( "SELECT isbn FROM book WHERE isbn=:isbn" );
$findBookStmnt->bindParam ( ':isbn', $isbn );

// for inserting into book
$insertIntoBookStmnt = $conn->prepare ( "INSERT INTO book (isbn, title, price, category, pub_date, pub_id)
	VALUES (:isbn, :title, :price, :category, :pub_date, :pub_id)" );
$insertIntoBookStmnt->bindParam ( ':isbn', $isbn );
$insertIntoBookStmnt->bindParam ( ':title', $title );
$insertIntoBookStmnt->bindParam ( ':price', $price );
$insertIntoBookStmnt->bindParam ( ':category', $category );
$insertIntoBookStmnt->bindParam ( ':pub_date', $pub_date );
$insertIntoBookStmnt->bindParam ( ':pub_id', $pub_id );

// for finding author
$findAuthorStmt = $conn->prepare ( "SELECT author_id FROM author WHERE first_name=:first_name AND last_name=:last_name" );
$findAuthorStmt->bindParam ( ':first_name', $first_name );
$findAuthorStmt->bindParam ( ':last_name', $last_name );

// for inserting into author
$insertIntoAuthorStmnt = $conn->prepare ( "INSERT INTO author (first_name, last_name) VALUES (:first_name, :last_name)" );
$insertIntoAuthorStmnt->bindParam ( ':first_name', $first_name );
$insertIntoAuthorStmnt->bindParam ( ':last_name', $last_name );

// find written by
$findWrittenByStmnt = $conn->prepare ( "SELECT isbn FROM written_by WHERE isbn=:isbn and author_id=:auth_id" );
$findWrittenByStmnt->bindParam ( ':isbn', $isbn );
$findWrittenByStmnt->bindParam ( 'auth_id', $auth_id );

// for inserting into written_by
$insertIntoWrittenByStmnt = $conn->prepare ( "INSERT INTO written_by (isbn, author_id) VALUES (:isbn, :auth_id)" );
$insertIntoWrittenByStmnt->bindParam ( ':isbn', $isbn );
$insertIntoWrittenByStmnt->bindParam ( 'auth_id', $auth_id );

try {
	$conn->beginTransaction ();
	
	foreach ( $books as $book ) {
		// set pub_name
		$pub_name = $book ['pub_name'];
		
		// try to find the pub_id for the given pub_name
		$findPublisherStmt->execute ();
		$pub_id = $findPublisherStmt->fetchColumn ();
		
		// didn't find the pub_id for the name so insert new pub
		if ($pub_id === false) {
			// inesrt into publisher and get the new pub_id
			$insertIntoPublisherStmnt->execute ();
			$pub_id = $conn->lastInsertId ();
		}
		
		// insert the book
		// first set the bound params
		$isbn = $book ['isbn'];
		$title = $book ['title'];
		$price = $book ['price'];
		$category = $book ['category'];
		$pub_date = $book ['pub_date'];
		// $pub_id already set
		
		// see if book already exists
		$findBookStmnt->execute ();
		$returnIsbn = $findBookStmnt->fetchColumn ();
		
		// if book not found
		if ($returnIsbn === false) {
			// inesrt into book
			$insertIntoBookStmnt->execute ();
		}
		
		// for each author of the book
		foreach ( $book ['author'] as $author ) {
			// set first and last name of author bound params
			var_dump ( $book );
			var_dump ( $author );
			$first_name = $author ['first_name'];
			$last_name = $author ['last_name'];
			
			echo "first_name = $first_name <br>";
			echo "last_name = $last_name <br>";
			// try to find the author's id
			$findAuthorStmt->execute ();
			$auth_id = $findAuthorStmt->fetchColumn ();
			
			// didn't find the auth_id for the first and last name so insert new author
			if ($auth_id === false) {
				// insert into author and get the new author_id
				$insertIntoAuthorStmnt->execute ();
				$auth_id = $conn->lastInsertId ();
			}
			
			// check for written_by entry
			$findWrittenByStmnt->execute ();
			$returnFromFindWrittenByStmnt = $findWrittenByStmnt->fetchColumn ();
			
			// if the written by entry doesn't exist
			if ($returnFromFindWrittenByStmnt === false) {
				// insert into written by
				$insertIntoWrittenByStmnt->execute ();
			}
		}
	}
	
	$conn->commit ();
} catch ( PDOException $e ) {
	echo $e->getMessage ();
	$conn->rollBack ();
}
?>