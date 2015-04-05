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

	//Number of Customers

	$numberOfCustomersStatement = $databaseConnection->query("SELECT * FROM customer");
	$numberOfCustomers = $numberOfCustomersStatement->rowCount();


	//Book Genre Counts

	$genreStatement = $databaseConnection->query("SELECT category, COUNT(*) AS genre_count FROM book GROUP BY category");
	$genreResults = $genreStatement->fetchAll();

	$bookGenre = [];
	$bookGenreCount = [];

	foreach($genreResults as $result)
	{
		array_push($bookGenre, $result['category']);
		array_push($bookGenreCount, $result['genre_count']);
	}


	//Monthly Sales

	$monthlySalesStatement = $databaseConnection->query("SELECT MONTHNAME(sale_datetime) AS month, SUM(grand_total) AS total_sales FROM invoice WHERE YEAR(sale_datetime) = YEAR(CURDATE()) GROUP BY MONTHNAME(sale_datetime) ORDER BY MONTH(sale_datetime)");
	$monthlySalesResults = $monthlySalesStatement->fetchAll();

	$months = [];
	$monthlySales = [];

	foreach($monthlySalesResults as $result)
	{
		array_push($months, $result['month']);
		array_push($monthlySales, $result['total_sales']);
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
				<?php 
					foreach($bookGenre as $genre)
					{
						echo "<p>" . $genre . ":\n</p>";
					}
				?>
			</td>
			<td>
				<?php 
					foreach($bookGenreCount as $genreCount)
					{
						echo "<p>" . $genreCount . "\n</p>";
					}
				?>
			</td>
		</tr>
	</table>

	<h2>Monthly Sales for <?php echo date("Y") ?></h2>
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
				<?php 
					foreach($months as $month)
					{
						echo "<p>" . $month . ":\n</p>";
					}
				?>
			</td>
			<td>
				<?php 
					foreach($monthlySales as $sales)
					{
						echo "<p>$" . $sales . "\n</p>";
					}
				?>
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
