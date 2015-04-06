<?php
require_once 'php_tools.php';

$reviews = array (
		array (
				'username' => 'jsmith',
				'isbn' => '9780073523323',
				'comment' => 'OMG, changed my life!',
				'rating' => '5' 
		),
		array (
				'username' => 'jsmith',
				'isbn' => '9780307743657',
				'comment' => 'RED RUM RED RUM RED RUM',
				'rating' => '4' 
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780316055444',
				'comment' =>'You won\'t regret it!',
				'rating' =>'5'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780547745527',
				'comment' =>'I understood all of the words.',
				'rating' =>'3'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780615820095',
				'comment' =>'All we are, is hammers in the wind.',
				'rating' =>'2'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780692360019',
				'comment' =>'H-Potter for adults, what\'s not to like?',
				'rating' =>'5'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780758278456',
				'comment' =>'Me, that\'s what she left behind, I hated it!',
				'rating' =>'1'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780763670931',
				'comment' =>'Frozen: What really would\'ve happened.',
				'rating' =>'3'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780767910743',
				'comment' =>'I\'m into it.',
				'rating' =>'4'
		),
		array(
				'username' =>'jsmith',
				'isbn' =>'9780984015719',
				'comment' =>'Blah',
				'rating' =>'2'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9780988464261',
				'comment' =>'Volume 2 is already on it\'s way!',
				'rating' =>'5'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781451627299',
				'comment' =>'good book if you like to read',
				'rating' =>'4'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781451681758',
				'comment' =>'YES YES MAYBE?',
				'rating' =>'4'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781451698855',
				'comment' =>'Put me to sleep.',
				'rating' =>'1'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781470008956',
				'comment' =>'Rules, the best!',
				'rating' =>'5'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781475031904',
				'comment' =>'A breakthrough for the author, a must read.',
				'rating' =>'5'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781476754475',
				'comment' =>'A vacaiton book for sure, read only if you have extra time',
				'rating' =>'3'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781476770383',
				'comment' =>'I didn\'t hate it?',
				'rating' =>'3'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781477824757',
				'comment' =>'My new fav',
				'rating' =>'5'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9781481093781',
				'comment' =>'A real magician never tells how he stole your wallet',
				'rating' =>'4'
		),
		array(
				'username' =>'sdouglas',
				'isbn' =>'9780073523323',
				'comment' =>'The best book ever written!',
				'rating' =>'5'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9781481882903',
				'comment' =>'Please don\'t read this book.',
				'rating' =>'1'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9781492230601',
				'comment' =>'Intriguing to the last page.',
				'rating' =>'5'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9781492291565',
				'comment' =>'Read my mind! Just what I wanted!',
				'rating' =>'5'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9781680580594',
				'comment' =>'More like the Worst Files!',
				'rating' =>'1'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9781743217191',
				'comment' =>'Coffee table',
				'rating' =>'2'
		),
		array(
				'username' =>'mjackson',
				'isbn' =>'9780073523323',
				'comment' =>'Now that I\'ve read this, I can die happy.',
				'rating' =>'5'
		)
);

$conn = getDatabaseConnection();

$insertIntoReviewsStmnt = $conn->prepare("INSERT INTO reviews (username, isbn, comment, rating) VALUES (:username, :isbn, :comment, :rating)");
$insertIntoReviewsStmnt->bindParam(':username', $username);
$insertIntoReviewsStmnt->bindParam(':isbn', $isbn);
$insertIntoReviewsStmnt->bindParam(':comment', $comment);
$insertIntoReviewsStmnt->bindParam(':rating', $rating);

try {
	$conn->beginTransaction();
	
	foreach ($reviews as $review){
		
		$username = $review['username'];
		$isbn = $review['isbn'];
		$comment = $review['comment'];
		$rating = $review['rating'];
		
		$insertIntoReviewsStmnt->execute();
	}
	$conn->commit();
} catch (PDOException $e) {
	echo $e->getMessage();
	$conn->rollBack();
}


?>

