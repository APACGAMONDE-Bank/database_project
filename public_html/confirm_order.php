<?php
// vars for error info
require_once 'php_tools.php';
require_once 'header.php';
require_once 'form_validator.php';

// DEFAULT SHIPPING
$shippingPerBook = 2;
$shipping = 0;

// print_r ( $_POST );

// get our connection
$conn = getDatabaseConnection ();

//var_dump($_SESSION['username']);

// for testing
// unset($_SESSION['username']);
//$_SESSION ['username'] = 'jsmith';

// if user isn't logged in, we assume they have not registered and we redirect
// them to the user registration page. Ideally we would have an option for them
// to enter their credentials if they have registered before and then possible
// merge their session cart with their db cart_items or something of that nature
if (! isset ( $_SESSION ['username'] )) {
	// we set the variable below so that the customer_registration page knows what page to go to next
	//$_SESSION ['came_from_checkout'] = true;
	header ( "Location:customer_registration.php?came_from_checkout=true" );
	exit ();
}

// The cart items may be used in a couple of places so we'll grab them here first
$stmt = $conn->prepare ( "SELECT isbn, quantity FROM cart_items WHERE username = '{$_SESSION['username']}'" );
$stmt->execute ();
$cart_items = $stmt->fetchAll ( PDO::FETCH_ASSOC );

// user is attempting a purchase
if ($_SERVER ["REQUEST_METHOD"] == "POST" && $_POST ['btnbuyit'] === 'BUY IT!') {
	// echo "try to buy!!!";
	$paymentIsValid = true;
	
	// user want's to use a different card
	if ($_POST ['cardgroup'] === 'new_card') {
		$rules = array (
				'credit_card' => array (
						'rule_name' => 'credit_card_type',
						'required' => true,
						'pretty_name' => 'Credit Card Type' 
				),
				'card_number' => array (
						'rule_name' => 'credit_card_number',
						'required' => true,
						'pretty_name' => 'Credit Card Number' 
				),
				'card_expiration' => array (
						'rule_name' => 'credit_card_expiration_date',
						'required' => true,
						'pretty_name' => 'Credit Card Expiration Date' 
				) 
		);
		
		$validator = new Form_Validator ( $rules, $_POST );
		
		// check new credit card validity
		if ($validator->validateAndSanitizeForm ()) { // new payment info is valid
			
			try {
				$updateCardStmt = $conn->prepare ( "UPDATE customer 
					SET card_type=:card_type, card_number=:card_number, card_exp_month=:card_exp_month, card_exp_year=:card_exp_year
					WHERE username=:username" );
				$updateCardStmt->bindParam ( ':card_type', $validator->sanitized ['credit_card'] );
				$updateCardStmt->bindParam ( ':card_number', $validator->sanitized ['card_number'] );
				$dateMonth = explode ( '/', $validator->sanitized ['card_expiration'] );
				$updateCardStmt->bindParam ( ':card_exp_month', $dateMonth [0] );
				$updateCardStmt->bindParam ( ':card_exp_year', $dateMonth [1] );
				$updateCardStmt->bindParam ( ':username', $_SESSION ['username'] );
				$updateCardStmt->execute ();
			} catch ( PDOException $e ) {
				$paymentIsValid = false;
				echo $e->getMessage ();
			}
		} else { // new payment info is not valid
			$paymentIsValid = false;
		}
	}
	
	if ($paymentIsValid) {
		
		// create invoice, remove items from cart_items and place them into invoice_items
		try {
			$conn->beginTransaction (); // start the transaction
			                            
			// prepare a statement to create an invoice entry
			$createInvoiceStmnt = $conn->prepare ( "INSERT INTO invoice (sale_datetime, shipping_cost, grand_total,username)
					VALUES (:sale_datetime, :shipping_cost, :grand_total, :username)" );
			$createInvoiceStmnt->bindParam ( ':sale_datetime', date ( "Y-m-d H:i:s" ) );
			$createInvoiceStmnt->bindParam ( ':shipping_cost', $_POST['shipping_cost'] );
			$createInvoiceStmnt->bindParam ( ':grand_total', $_POST ['grand_total'] );
			$createInvoiceStmnt->bindParam ( ':username', $_SESSION ['username'] );
			
			// execute create invoice statement and grab the new invoice's id
			$createInvoiceStmnt->execute ();
			$id = $conn->lastInsertId ();
			$_SESSION['invoice_id'] = $id; //so proof-of-purchase screen knows which invoice to display
			
			// prepare a statement to create an invoice_items entry
			$createInvoiceItemsStmnt = $conn->prepare ( "INSERT INTO invoice_items (invoice_id, isbn, quantity, price_at_purchase)
					VALUES (:invoice_id, :isbn, :quantity, :price_at_purchase)" );
			$createInvoiceItemsStmnt->bindParam ( ':invoice_id', $id );
			$createInvoiceItemsStmnt->bindParam ( ':isbn', $isbn );
			$createInvoiceItemsStmnt->bindParam ( ':quantity', $quantity );
			$createInvoiceItemsStmnt->bindParam ( ':price_at_purchase', $price_at_purchase );
			
			// prepare a statement to retrieve the price for a given book
			$getInvoiceItemCurrentPriceStmnt = $conn->prepare ( "SELECT price FROM book WHERE isbn=:isbn" );
			$getInvoiceItemCurrentPriceStmnt->bindParam ( ':isbn', $isbn );
			
			// for each book, get the price from the $getInvoiceItemCurrentPriceStmnt
			// and insert into invoice_items with the $createInvoiceItemsStmnt
			foreach ( $cart_items as $item ) {
				
				// get isbn of book and price of book
				$isbn = $item ['isbn'];
				$getInvoiceItemCurrentPriceStmnt->execute ();
				$price_at_purchase = $getInvoiceItemCurrentPriceStmnt->fetchColumn ();
				
				// get quantity and insert into invoice_items
				$quantity = $item ['quantity'];
				$createInvoiceItemsStmnt->execute ();
			}
			
			// prepare statment to remove all cart_items associated with this user
			$removeCartItemsStmnt = $conn->prepare ( "DELETE FROM cart_items WHERE username=:username" );
			$removeCartItemsStmnt->bindParam ( ':username', $_SESSION ['username'] );
			
			// remove the cart_items associated with this user
			$removeCartItemsStmnt->execute ();
			
			$conn->commit (); // commit the transaction
		} catch ( PDOException $e ) {
			echo $e->getMessage ();
			$conn->rollBack ();
		}
		
		// go to proof of purchase screen
		header ( "Location:proof_purchase.php" );
	}
}

// IF THE USER HASN'T CLICKED THE BUY BUTTON OR THEY ATTEMPTED TO BUY BUT INPUT BAD NEW CREDIT CARD INFO
// then we will need to populate the confirm order screen with some user info
// we grab the necessary user info below to use later
$UserInfoStmnt = $conn->prepare ( "SELECT first_name, last_name, street, city, state, zip, card_type, card_number, card_exp_month, card_exp_year FROM customer WHERE username='{$_SESSION['username']}'" );
$UserInfoStmnt->execute ();
$userInfo = $UserInfoStmnt->fetch ( PDO::FETCH_ASSOC );

?>
<!DOCTYPE HTML>
<head>
<title>Confirm Order</title>
<header align="center">Confirm Order</header>
</head>
<body>
	<table align="center" style="border: 2px solid blue;">
		<form id="buy"
			action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
			method="post">
			<tr>
				<td>Shipping Address:</td>
			</tr>
			<td colspan="2"><?php echo "{$userInfo['first_name']} {$userInfo['last_name']}"?></td>
			<td rowspan="3" colspan="2"><input type="radio" name="cardgroup"
				value="profile_card" checked>Use Credit Card on File <br /><?php echo "{$userInfo['card_type']} <br> {$userInfo['card_number']} - {$userInfo['card_exp_month']}/{$userInfo['card_exp_year']}";?><br />
				<input type="radio" name="cardgroup" value="new_card"
				<?php if (isset($_POST['cardgroup']) && $_POST['cardgroup']=="new_card") echo "checked";?>>New
				Credit Card<br /> <select id="credit_card" name="credit_card">
					<option selected disabled>Card Type</option>
					<option>VISA</option>
					<option>MASTERCARD</option>
					<option>DISCOVER</option>
			</select> <input type="text" id="card_number" name="card_number"
				placeholder="Card Number"
				value="<?php echo $validator->sanitized['card_number'] ?>"></input>
				<br />Expiration Date: <input type="text" id="card_expiration"
				name="card_expiration" placeholder="MM/YY"
				value="<?php echo $validator->sanitized['card_expiration'] ?>"> </input></td>
			<tr>
				<td colspan="2"><?php echo "{$userInfo['street']}";?></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo "{$userInfo['city']}";?></td>
			</tr>
			<tr>
				<td colspan="2"><?php echo "{$userInfo['state']}, {$userInfo['zip']}"?></td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<div id="bookdetails"
						style="overflow: scroll; height: 180px; width: 520px; border: 1px solid black;">
						<table border='1' style="border-collapse: collapse;">
							<th>Book Description</th>
							<th>Qty</th>
							<th>Price</th>
							<!-- Create book info rows -->
							<?php
							// print_r($cart_items);
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
								echo "<tr>";
								
								echo '<td style="font-size:90%;">';
								echo "{$titleAndPrice['title']}";
								
								$authorsStmnt->execute ();
								$authorNames = $authorsStmnt->fetchAll ( PDO::FETCH_ASSOC );
								echo '<div style="font-size:90%">';
								echo "<strong>By: </strong>";
								$count = 0;
								foreach ( $authorNames as $author ) {
									if (++ $count != 1) {
										echo ",<br>";
									}
									echo "{$author['first_name']} {$author['middle_name']} {$author['last_name']}";
								}
								echo "<br><strong>Price: </strong>$" . number_format($titleAndPrice['price'], 2);
								echo '</div>';
								echo "</td>";
								
								$bookTimesQuantity = $titleAndPrice ['price'] * $row ['quantity'];
								
								//update shipping
								$shipping += ($row['quantity'] * $shippingPerBook);
								
								echo "<td style='font-size:90%;text-align:center;'>{$row['quantity']}</td>";
								echo "<td style='font-size:90%'>\$" . number_format($bookTimesQuantity, 2) . "</td>";
								
								$subtotal += $bookTimesQuantity;
								echo "</tr>";
							}
							
							$grandTotal = $subtotal + $shipping;
							echo "<input type='hidden' name='grand_total' value='$grandTotal' />";
							
							?>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<div id="bookdetails"
						style="overflow: scroll; height: 100px; width: 260px; border: 1px solid black; background-color: LightBlue">
						<b>Shipping Note:</b> The book will be </br>delivered within 5</br>business
						days.
					</div>
				</td>
				<td align="right">
					<div id="bookdetails"
						style="overflow: scroll; height: 100px; width: 260px; border: 1px solid black;">
						Subtotal: $<?php echo number_format($subtotal, 2);?>
						<br>Shipping and Handling: $<?php echo number_format($shipping, 2);?>
						<br>__________<br>
						<b>Total</b>: $<?php echo number_format($grandTotal, 2);?>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right"><input type="submit" id="buyit" name="btnbuyit"
					value="Submit Order"></td>
		<input type="hidden" name="shipping_cost" value="<?php echo $shipping?>" />
		</form>
		<td align="right">
			<form id="update" action="update_customerprofile.php" method="post">
				<input type="submit" id="update_customerprofile"
					name="update_customerprofile" value="Update Customer Profile">
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="search.php" method="post">
				<input type="submit" id="cancel" name="cancel" value="Cancel">
			</form>
		</td>
		</tr>
	</table>
	<div align="center" style="color: red">
	<?php
	$validator->printErrors (); // show the user the problems with the form they've submitted
	?>
	</div>
	<script type="text/javascript">
	var creditCardTypeValue = "<?php echo $validator->sanitized['credit_card']; ?>";
	if (creditCardTypeValue !== "")
		document.getElementById('credit_card').value = creditCardTypeValue;
	</script>
</body>
</HTML>
