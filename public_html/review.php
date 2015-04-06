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

	$isbn = $_GET['isbn'];
	$reviewStatement = $databaseConnection->query("SELECT * FROM reviews WHERE isbn = '$isbn'");
	$bookDetailsStatement = $databaseConnection->query("SELECT * FROM book WHERE isbn = '$isbn'");

	$reviews = $reviewStatement->fetchAll(PDO::FETCH_ASSOC);
	$bookDetails = $bookDetailsStatement->fetch(PDO::FETCH_ASSOC);
	$bookTitle = $bookDetails['title'];
	unset($_GET['isbn']);
?>
<!DOCTYPE html>
<html>
<head>
<title>Book Reviews - 3-B.com</title>
<style>
.field_set
{
	border-style: inset;
	border-width:4px;
}
</style>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="center">
				<h5>Reviews For:</h5>
			</td>
			<td align="left">
				<h5><?php echo $bookTitle; ?></h5>
			</td>
		</tr>
			
		<tr>
			<td colspan="2">
			<div id="bookdetails" style="overflow:scroll;height:200px;width:300px;border:1px solid black;">
			<table>
			<?php 
				foreach ($reviews as $review) {
					print "<tr><p><b>User</b>: ";
					print $review['username'];
					print "</p></tr>";
					print "<tr><p><b>Comment</b>: ";
					print $review['comment'];
					print "</p></tr>";
					print "<tr><p><b>Rating</b>: ";
					print $review['rating'];
					print "/5</p></tr><hr>";
				}
			?>
			</table>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
					<button type="submit" onclick="history.go(-1);return true;">Return to Search</button>
			</td>
		</tr>
	</table>

</body>

</html>
