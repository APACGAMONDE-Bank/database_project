<!-- This is a test comment. -->
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->
<html>
<head>
	<title> Search Result - 3-B.com </title>
	<script>
	//redirect to reviews page
	function review(isbn, title){
		window.location.href="review.php?isbn="+ isbn + "&title=" + title;
	}
	//add to cart
	function cart(isbn, searchfor, searchon, category){
		window.location.href="search_result.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
	}
	</script>
</head>
<body>


	<?php
		/*
		foreach ( $_GET as $key => $value ) 
		{

    		echo 'Key : ' . $key . ', Value : ' . $value;
    		echo '<br/>';
		}
		*/

		$servername = "localhost";
		$username = "201501_471_02";
		$password = "cade&stefano";
		$database = "db201501_471_g02";

		try {
    		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    		
    		// set the PDO error mode to exception
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	}
		catch(PDOException $e) {
    		echo "Connection failed: " . $e->getMessage();
    	}
	?>

	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				
					<h6> <fieldset>Your Shopping Cart has 0 items</fieldset> </h6>
				
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

				$searchTerm = $_GET['searchfor'];
				$searchAttribute = $_GET['searchon'];
				$searchCategory = $_GET['category'];
				
				if ($searchAttribute === 'anywhere'){ //search term can match publisher, author, isbn, or title
					if($searchCategory === 'all'){ //category is unspecified
						$stmt = $conn->prepare("SELECT * FROM book WHERE isbn LIKE '%$searchTerm%' OR title LIKE '%$searchTerm%' OR author_name LIKE '%$searchTerm%' OR publisher_name LIKE '%$searchTerm%'");
					} else { //category is specified
						$stmt = $conn->prepare("SELECT * FROM book WHERE category = '$searchCategory' AND (isbn LIKE '%$searchTerm%' OR title LIKE '%$searchTerm%' OR author_name LIKE '%$searchTerm%' OR publisher_name LIKE '%$searchTerm%')");
					}
				} else { //seach attribute is specified
					if($searchCategory === 'all'){ //category is unspecified
						$stmt = $conn->prepare("SELECT * FROM book WHERE $searchAttribute LIKE '%$searchTerm%'");
					} else { //category is specified
						$stmt = $conn->prepare("SELECT * FROM book WHERE category = '$searchCategory' AND $searchAttribute LIKE '%$searchTerm%'");
					}
				}

				$resultCount = 0;
    			if($stmt->execute()) {
    				while ($row = $stmt->fetch()) {
    					$resultCount++;
    					print "<tr>";
    						print '<td>';
    							print '<table>';
    								print "<tr>";
    									print "<td>";
    										print '<button type="button" >Add to Cart</button>';
    									print "</td>";
    								print "</tr>";
    								print "<tr>";
    									print "<td>";
    										print '<form action="review.php" method="GET">';
    											print '<input type="hidden" value="' . $row['isbn'] . '">';
    											print '<input type="submit" value="Reviews">';
    										print '</form>';
    										
    									print "</td>";
    								print "</tr>";
    							print "</table>";
    						print "</td>";
    						print "<td>";
    							print "<strong>Title:</strong> " .$row['title'] . "<br>";
    							print "<strong>By:</strong> " . $row['author_name'] . "<br>";
    							print "<strong>Publisher:</strong> " . $row['publisher_name'] . ", " . $row['date_published'] . "<br>";
    							print "<strong>Category:</strong> " . $row['category'] . "<br>";
    							print "<strong>ISBN:</strong> " . $row['isbn'] . ", <strong>Price:</strong> $" . $row[price] . "<br>";
    						print "</td>";
    					print "</tr>";
    					//print_r($row['category']);
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
				<form action="" method="get">
					<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
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
