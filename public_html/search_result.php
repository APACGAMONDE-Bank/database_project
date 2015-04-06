<?php
	require_once('php_tools.php');
	require_once('header.php');

	function addToCart($isbn)
	{
		if (isset($_SESSION['username']))
		{
			// Database Connection
			$databaseConnection = getDatabaseConnection();

			$username = $_SESSION['username'];
			$addToCartStatement = $databaseConnection->prepare("INSERT IGNORE INTO cart_items (username, isbn, quantity) VALUES ('$username', '$isbn', 1)");
			$addToCartStatement->execute();
		}
		else {
			if (! isset($_SESSION['cart_items'])) {
				$_SESSION['cart_items'] = new SessionCartItems();
			}
			
			$sessionCart = $_SESSION['cart_items'];
			$sessionCart->addToCart($isbn);
		}
		unset($_POST['isbn']);
		echo "<script> alert('ISBN: $isbn added to your cart.'); </script>";
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		addToCart($_POST['isbn']);
	}

	// Database Connection
	$databaseConnection = getDatabaseConnection();

	//get number of items in cart
	$numberOfItemsInCart = getNumberOfCartItems();
	
	// Search term setup
	$searchTerm = $_GET['searchfor'];
	$searchAttribute = $_GET['searchon'];
	$searchCategory = $_GET['category'];
	$searchTable = "(book NATURAL JOIN author NATURAL JOIN written_by NATURAL JOIN publisher)";
	$searchAuthorNameFields = "first_name LIKE '%$searchTerm%' OR middle_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%'";
	
	if ($searchAttribute === 'anywhere'){ //search term can match publisher, author, isbn, or title
		if($searchCategory === 'all'){ //category is unspecified
			$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE isbn LIKE '%$searchTerm%' OR title LIKE '%$searchTerm%' OR $searchAuthorNameFields OR name LIKE '%$searchTerm%'");
		} 
		else { //category is specified
			$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE category = '$searchCategory' AND (isbn LIKE '%$searchTerm%' OR title LIKE '%$searchTerm%' OR $searchAuthorNameFields OR name LIKE '%$searchTerm%')");
		}
	} 
	else { //seach attribute is specified
		if ($searchAttribute == "author")
		{
			if($searchCategory === 'all'){ //category is unspecified
			$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE $searchAuthorNameFields");
			} 
			else { //category is specified
				$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE category = '$searchCategory' AND ($searchAuthorNameFields)");
			}
		}
		else {
			if($searchCategory === 'all'){ //category is unspecified
				$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE $searchAttribute LIKE '%$searchTerm%'");
			} 
			else { //category is specified
				$searchStatement = $databaseConnection->prepare("SELECT * FROM $searchTable WHERE category = '$searchCategory' AND $searchAttribute LIKE '%$searchTerm%'");
			}
		}
	}
?>
<html>
<head>
	<title> Search Result - 3-B.com </title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">			
					<h6> <fieldset>Your Shopping Cart has <?php echo $numberOfItemsInCart?> items</fieldset> </h6>
			</td>
			<td>
				&nbsp
			</td>
			<td align="right">
				<form action="shopping_cart.php" method="post">
					<input type="submit" value="Manage Shopping Cart">
				</form>
			</td>
		</tr>	
		<tr>
		<td style="width: 350px" colspan="3" align="center">
			<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
			<table style="font-size:x-small;">
			<?php
				$resultCount = 0;
    			if($searchStatement->execute()) {
    				while ($row = $searchStatement->fetch()) {
    					$resultCount++;
    					print "<tr>";
    						print '<td>';
    							print '<table>';
    								print "<tr>";
    									print "<td>";
    										print '<form action="" method="POST">';
    											print '<input type="submit" class="button" value="Add To Cart"/>';
    											print '<input type="hidden" name="isbn" id="isbn" value="' . $row['isbn'] . '"/>';
    										print '</form>';
    									print "</td>";
    								print "</tr>";
    								print "<tr>";
    									print "<td>";
    										print '<form action="review.php" method="get">';
    											print '<input type="hidden" name = "isbn" value="' . $row['isbn'] . '">';
    											print '<input type="submit" value="Reviews">';
    										print '</form>';
    									print "<hr></td>";
    								print "</tr>";
    							print "</table>";
    						print "</td>";
    						print "<td>";
    							print "<strong>Title:</strong> " .$row['title'] . "<br>";
    							print "<strong>By:</strong> " . $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] . "<br>";
    							print "<strong>Publisher:</strong> " . $row['name'] . ", " . $row['pub_date'] . "<br>";
    							print "<strong>Category:</strong> " . $row['category'] . "<br>";
    							print "<strong>ISBN:</strong> " . $row['isbn'] . ", <strong>Price:</strong> $" . $row['price'] . "<br>";
    						print "<hr></td>";
    					print "</tr>";	
    				}
    			} 
    			if ($resultCount === 0)
    				print "<p>Sorry, no results found<br />Try a different search criteria</p>";
    		?>
			</table>
			
			</div>
			
			</td>
		</tr>
		<tr>
			<td align= "center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit"
						value="Proceed to Checkout"
						<?php if ($numberOfDistinctItemsInCart === 0) echo "disabled";?>>
				</form>
			</td>
			<td align="center">
				<form action="search.php" method="post">
					<input type="submit" value="New Search">
				</form>
			</td>
			<td align="center">
				<form action="welcome.php" method="post">
					<input type="submit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>