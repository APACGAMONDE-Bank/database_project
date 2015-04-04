<?php
// vars for error info
require_once 'header.php';
require_once 'form_validator.php';
require_once 'php_tools.php';

$conn = getDatabaseConnection ();

// FOR TESTING
$_SESSION ['username'] = 'jsmith';
// unset ( $_SESSION ['username'] );

$_SESSION ['cart_items'] = array (
		array (
				'isbn' => '9780307474278',
				'quantity' => '4' 
		),
		array (
				'isbn' => '9780544336261',
				'quantity' => '5' 
		) 
);

if ($_SERVER ["REQUEST_METHOD"] == "POST" && (isset ( $_POST ['recalculate_payment'] ) || isset ( $_POST ['recalculate'] ))) {
	
	// if username is set we'll operate on the db cart_items so we need to prepare those statements
	if (isset ( $_SESSION ['username'] )) {
		$updateQtyStmnt = $conn->prepare ( "UPDATE cart_items SET quantity=:qty WHERE username=:username AND isbn=:isbn" );
		$updateQtyStmnt->bindParam ( ':qty', $newQuantity );
		$updateQtyStmnt->bindParam ( ':username', $username );
		$updateQtyStmnt->bindParam ( ':isbn', $isbn );
		
		$deleteItemStmnt = $conn->prepare ( "DELETE FROM cart_items WHERE username=:username AND isbn=:isbn" );
		$deleteItemStmnt->bindParam ( ':username', $username );
		$deleteItemStmnt->bindParam ( ':isbn', $isbn );
		
		$username = $_SESSION ['username'];
	}
	
	// delete and update quantities: either from the db or the session cart_items var if the user hasn't logged in/registerd
	foreach ( $_POST as $key => $val ) {
		if ($val === 'Delete') { // delete the cart_item
		                         
			// delete from db cart_items table
			if (isset ( $_SESSION ['username'] )) {
				$isbn = $key;
				$deleteItemStmnt->execute ();
			} else {
				// delete from session cart_items object
			}
		} else {
			$qtyAndIsbn = explode ( '_', $key );
			if ($qtyAndIsbn [0] === 'qty') { // update the cart item quantity
				if (isset ( $_SESSION ['username'] )) { // update db cart_items quantity
					$newQuantity = $val;
					$isbn = $qtyAndIsbn [1];
					$updateQtyStmnt->execute ();
				} else { // update session cart_items quantity
				}
			}
		}
	}
}

if (isset ( $_SESSION ['username'] )) {
	$stmt = $conn->prepare ( "SELECT isbn, quantity FROM cart_items WHERE username = '{$_SESSION['username']}'" );
	$stmt->execute ();
	$cart_items = $stmt->fetchAll ( PDO::FETCH_ASSOC );
	// print_r ( $cart_items );
} else {
	$cart_items = $_SESSION ['cart_items'];
}

// print_r ( $_SESSION ['cart_items'] );
// echo "<br>";

echo "session cart items: ";
print_r ( $_SESSION ['cart_items'] );
echo "<br> db cart items: ";
print_r ( $cart_items );

?>
<!DOCTYPE HTML>
<head>
<title>Shopping Cart</title>
<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.php?delIsbn="+ isbn;
	}
	</script>
</head>
<body>
	<table align="center" style="border: 2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit"
						value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="search.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>
			</td>
			<td align="center">
				<form id="exit" action="welcome.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
		<tr>
			<form id="recalculate" name="recalculate"
				action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
				method="post">
				<td colspan="3">
					<div id="bookdetails"
						style="overflow: scroll; height: 180px; width: 500px; border: 1px solid black;">
						<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2"
							WIDTH="100%" style="border-collapse: collapse";>
							<th width="10%">Remove</th>
							<th width="70%">Book Description</th>
							<th width="10%">Qty</th>
							<th width="10%">Price</th>
							<!-- PUT CART ITEM ROWS HERE -->
						<?php
						
						// prepare stmt for tite and price
						$titleAndPriceStmt = $conn->prepare ( "SELECT title, price FROM book WHERE isbn=:isbn" );
						$titleAndPriceStmt->bindParam ( ':isbn', $isbn );
						
						// prepare stmt for authors
						$authorsStmnt = $conn->prepare ( "SELECT first_name, middle_name, last_name
								FROM book NATURAL JOIN written_by NATURAL JOIN author
								WHERE isbn=:isbn" );
						$authorsStmnt->bindParam ( ':isbn', $isbn );
						
						foreach ( $cart_items as $row ) {
							$isbn = $row ['isbn'];
							
							$titleAndPriceStmt->execute ();
							$titleAndPrice = $titleAndPriceStmt->fetch ( PDO::FETCH_ASSOC );
							echo "<input type='hidden' name='recalculate' value='recalculate'></input>";
							echo "<tr><td><input type='submit' name='$isbn' value='Delete'></input></td>";
							
							echo '<td style="font-size:80%;">';
							echo "{$titleAndPrice['title']}";
							
							$authorsStmnt->execute ();
							$authorNames = $authorsStmnt->fetchAll ( PDO::FETCH_ASSOC );
							echo '<div style="font-size:80%">';
							echo "<strong>By: </strong>";
							$count = 0;
							foreach ( $authorNames as $author ) {
								if (++ $count != 1) {
									echo ",<br>";
								}
								echo "{$author['first_name']} {$author['middle_name']} {$author['last_name']}";
							}
							echo "<br><strong>Price: </strong>" . $titleAndPrice ['price'];
							echo '</div>';
							echo "</td>";
							
							$bookTimesQuantity = $titleAndPrice ['price'] * $row ['quantity'];
							
							echo "<td><input type='text' size='2' name='qty_$isbn' id='$isbn;_qty' value='{$row['quantity']}'></input></td>";
							echo "<td style='font-size:60%'>\$$bookTimesQuantity</td>";
							
							$subtotal += $bookTimesQuantity;
						}
						
						echo "</tr>";
						
						?>
						</table>
					</div>
				</td>
		
		</tr>
		<tr>
			<td align="center"><input type="submit" name="recalculate_payment"
				id="recalculate_payment" value="Recalculate Payment">
				</form></td>
			<td align="center">&nbsp;</td>
			<td align="center">Subtotal: <?php echo "\$$subtotal"?></td>
		</tr>
	</table>
</body>
