<!DOCTYPE HTML>
<?php
	// Databse login credentials
	$servername = "localhost";
	$db_username = "201501_471_02";
	$db_password = "cade&stefano";
	$database = "db201501_471_g02";

	try {
		$databaseConnection = new PDO("mysql:host=$servername;dbname=$database", $db_username, $db_password);
		
		// set the PDO error mode to exception
		$databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	$numberOfCustomersStatement = $databaseConnection->query("SELECT * FROM customer");
	$numberOfCustomers = $numberOfCustomersStatement->rowCount();

	$genreStatement = $databaseConnection->query("SELECT category, COUNT(*) AS genre_count FROM book GROUP BY category");
	$genreResults = $genreStatement->fetchAll();

	$bookGenre = [];
	$bookGenreCount = [];

	foreach($genreResults as $result)
	{
		array_push($bookGenre, $result['category']);
		array_push($bookGenreCount, $result['genre_count']);
	}

?>
<html>
<head>
<title>Reports</title>
<link rel="stylesheet" type="text/css" href="master.css">
</head>
<body>
	<h1>Administrator's Reports for 3-B</h1>
	
	<form id="cancel" action="welcome.php" method="post">
		<input type="submit" id="exit" name="exit" value="EXIT 3-B.com">
	</form>

	<h2>Registerd Customers</h2>
	<table>
		<tr>
			<th>
				Total # of Customers
			</th>
		</tr>
		<tr>
			<td>
				<?php echo $numberOfCustomers; ?>
			</td>
		</tr>
	</table>

	<h2>Inventory by Genre</h2>
	<table>
		<tr>
			<th>
				Genre
			</th>
			<th>
				# of Books
			</th>
		</tr>
		<tr>
			<td>
				<?php foreach($bookGenre as $genre)
				{
					echo "<p>" . $genre . ":\n</p>";
				}?>
			</td>
			<td>

				<?php 
				echo "<p>" . $genreCount . "\n</p>";
				foreach($bookGenreCount as $genreCount)
				{
					echo "<p>" . $genreCount . "\n</p>";
				}?>
			</td>
		</tr>
	</table>

	<h2>Monthly Sales for Placeholder: year</h2>
	<table>
		<tr>
			<th>
				Month
			</th>
			<th>
				Sales
			</th>
		</tr>
		<tr>
			<td>
				Placeholder: December
			</td>
			<td>
				Placeholder: No Sales
			</td>
		</tr>
	</table>

	<h2>Book Reviews</h2>
	<table>
		<tr>
			<th>
				Book
			</th>
			<th>
				# of Reviews
			</th>
		</tr>
		<tr>
			<td>
				Placeholder: Book Title
			</td>
			<td>
				Placeholder: No Reviews
			</td>
		</tr>
	</table>

</body>

</html>
