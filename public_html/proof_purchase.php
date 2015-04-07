<?php
// vars for error info
require_once 'php_tools.php';
require_once 'header.php';

$conn = getDatabaseConnection ();

// prepare get user info and invoice info
$getUserAndInvoiceInfoStmnt = $conn->prepare ( "SELECT first_name, last_name, street, city, state, zip, card_type, card_number, card_exp_month, card_exp_year, sale_datetime, shipping_cost, grand_total 
											 FROM customer NATURAL JOIN invoice
											WHERE customer.username=:username AND invoice_id=:invoice_id" );
$getUserAndInvoiceInfoStmnt->bindParam ( ':username', $_SESSION ['username'] );
$getUserAndInvoiceInfoStmnt->bindParam ( ':invoice_id', $_SESSION ['invoice_id'] );

// execute and store result from getUserAndInvoiceInfoStmnt
$getUserAndInvoiceInfoStmnt->execute ();
$userAndInvoiceInfo = $getUserAndInvoiceInfoStmnt->fetch ( PDO::FETCH_ASSOC );

$dateAndTime = explode ( " ", $userAndInvoiceInfo ['sale_datetime'] );
// print_r($dateAndTime);

?>
<!DOCTYPE HTML>
<head>
<title>Proof of Purchase</title>
</head>
<body>
	<h3 style="text-align: center">Proof of Purchase</h3>
	<table align="center" style="border: 2px solid blue;">
		<form id="buy" action="" method="post">
			<tr>
				<td>Shipping Address:</td>
			</tr>
			<td colspan="2">
		<?php echo "{$userAndInvoiceInfo['first_name']} {$userAndInvoiceInfo['last_name']}"?>	</td>
			<td rowspan="3" colspan="2"><b>UserID: </b><?php echo "{$_SESSION['username']}";?><br />
				<b>Date: </b><?php echo "{$dateAndTime[0]}";?><br /> <b>Time: </b><?php echo "{$dateAndTime[1]}";?><br />
				<b>Card Info: </b><?php echo "{$userAndInvoiceInfo['card_type']}";?><br /><?php echo "{$userAndInvoiceInfo['card_exp_month']}/{$userAndInvoiceInfo['card_exp_year']} - {$userAndInvoiceInfo['card_number']}"?></td>
			<tr>
				<td colspan="2">
		<?php echo "{$userAndInvoiceInfo['street']}";?>	</td>
			</tr>
			<tr>
				<td colspan="2">
		<?php echo "{$userAndInvoiceInfo['city']}";?>	</td>
			</tr>
			<tr>
				<td colspan="2">
		<?php echo "{$userAndInvoiceInfo['state']} , {$userAndInvoiceInfo['zip']}";?></td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					<div id="bookdetailsmaster"
						style="overflow: scroll; height: 180px; width: 520px; border: 1px solid black;">
						<table border='1'>
							<th>Book Description</th>
							<th>Qty</th>
							<th>Price</th>
			<?php
			
			// print_r($cart_items);
			// prepare stmt for tite and price
			// echo "{$_SESSION['invoice_id']}";
			$getInvoiceItemsInfoStmt = $conn->prepare ( "SELECT isbn, quantity, price_at_purchase, title FROM invoice_items NATURAL JOIN book WHERE invoice_id=:invoice_id" );
			$getInvoiceItemsInfoStmt->bindParam ( ':invoice_id', $_SESSION ['invoice_id'] );
			$getInvoiceItemsInfoStmt->execute ();
			$invoiceItemsInfo = $getInvoiceItemsInfoStmt->fetchAll ( PDO::FETCH_ASSOC );
			// print_r($invoiceItemsInfo);
			
			// prepare stmt for authors
			$getAuthorsInfoStmnt = $conn->prepare ( "SELECT first_name, middle_name, last_name
								FROM book NATURAL JOIN written_by NATURAL JOIN author
								WHERE isbn=:isbn" );
			$getAuthorsInfoStmnt->bindParam ( ':isbn', $isbn );
			
			foreach ( $invoiceItemsInfo as $invoiceItem ) {
				$isbn = $invoiceItem ['isbn'];
				
				echo "<tr>";
				
				echo '<td style="font-size:80%;">';
				echo "{$invoiceItem['title']}";
				
				$getAuthorsInfoStmnt->execute ();
				$authorNames = $getAuthorsInfoStmnt->fetchAll ( PDO::FETCH_ASSOC );
				echo '<div style="font-size:80%">';
				echo "<strong>By: </strong>";
				$count = 0;
				foreach ( $authorNames as $author ) {
					if (++ $count != 1) {
						echo ",<br>";
					}
					echo "{$author['first_name']} {$author['middle_name']} {$author['last_name']}";
				}
				echo "<br><strong>Price: </strong>$" . number_format($invoiceItem['price_at_purchase'], 2);
				echo '</div>';
				echo "</td>";
				
				$bookTimesQuantity = $invoiceItem ['price_at_purchase'] * $invoiceItem ['quantity'];
				
				echo "<td style='font-size:80%;text-align:center;'>{$invoiceItem['quantity']}</td>";
				echo "<td style='font-size:60%'>\$" . number_format($bookTimesQuantity, 2) . "</td>";
				
				$subtotal += $bookTimesQuantity;
				echo "</tr>";
			}
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
						Subtotal: $<?php echo number_format($subtotal, 2);?></br>
						Shipping and Handling: $<?php echo number_format($userAndInvoiceInfo['shipping_cost'], 2);?></br>_______</br>
						Grand Total: $<?php echo number_format($userAndInvoiceInfo['grand_total'], 2);?>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right"><button onclick="printPage()">Print</button></td>
		
		</form>
		<td align="right">
			<form id="update" action="search.php" method="post">
				<input type="submit" id="update_customerprofile"
					name="update_customerprofile" value="New Search">
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="welcome.php" method="post">
				<input type="submit" id="exit" name="exit" value="EXIT 3-B.com">
			</form>
		</td>
		</tr>
	</table>
	<script>
	function printPage() {
		document.getElementById("bookdetailsmaster").style.overflow = "visible";
		document.getElementById("bookdetailsmaster").style.height = "auto";
   	 	window.print();
	}
</script>
</body>
</HTML>
