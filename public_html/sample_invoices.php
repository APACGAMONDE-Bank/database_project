<?php
require_once 'php_tools.php';

$invoices = array (
		//JANUARY sales
		array (
				'sale_datetime' => '2015-01-01 16:42:31',
				'username' => 'jsmith',
				'books' => array (
						array (
								'isbn' => '9780073523323',
								'quantity' => '1' 
						),
						array (
								'isbn' => '9780316055444',
								'quantity' => '2'
						)
				) 
		),
		array (
				'sale_datetime' => '2015-01-04 12:41:21',
				'username' => 'mjackson',
				'books' => array (
						array (
								'isbn' => '9781492291565',
								'quantity' => '2'
						),
						array (
								'isbn' => '9781476770383',
								'quantity' => '2'
						),
						array (
								'isbn' => '9780767910743',
								'quantity' => '1'
						)
				)
		),
		array (
				'sale_datetime' => '2015-01-19 06:11:53',
				'username' => 'sdouglas',
				'books' => array (
						array (
								'isbn' => '9781451627299',
								'quantity' => '10'
						),
						array (
								'isbn' => '9780763670931',
								'quantity' => '1'
						),
						array (
								'isbn' => '9780307743657',
								'quantity' => '3'
						)
				)
		),
		//FEBRUARY sales
		array (
				'sale_datetime' => '2015-02-07 02:22:33',
				'username' => 'sdouglas',
				'books' => array (
						array (
								'isbn' => '9780547745527',
								'quantity' => '1'
						),
						array (
								'isbn' => '9780984015719',
								'quantity' => '1'
						),
						array (
								'isbn' => '9781476770383',
								'quantity' => '1'
						)
				)
		),
		array (
				'sale_datetime' => '2015-02-014 03:14:21',
				'username' => 'jsmith',
				'books' => array (
						array (
								'isbn' => '9781481882903',
								'quantity' => '1'
						)
				)
		),
		array (
				'sale_datetime' => '2015-02-21 14:11:46',
				'username' => 'mjackson',
				'books' => array (
						array (
								'isbn' => '9781470008956',
								'quantity' => '1'
						),
						array (
								'isbn' => '9781492230601',
								'quantity' => '2'
						)
				)
		),
		//MARCH sales
		array (
				'sale_datetime' => '2015-03-04 15:09:26',
				'username' => 'mjackson',
				'books' => array (
						array (
								'isbn' => '9781743217191',
								'quantity' => '1'
						),
						array (
								'isbn' => '9780307474278',
								'quantity' => '1'
						)
				)
		),
		array (
				'sale_datetime' => '2015-03-17 21:04:02',
				'username' => 'sdouglas',
				'books' => array (
						array (
								'isbn' => '9780590353427',
								'quantity' => '15'
						)
				)
		),
		array (
				'sale_datetime' => '2015-03-27 09:09:13',
				'username' => 'jsmith',
				'books' => array (
						array (
								'isbn' => '9780758278456',
								'quantity' => '6'
						),
						array (
								'isbn' => '9780763670931',
								'quantity' => '1'
						)
				)
		)
);

$conn = getDatabaseConnection();

//all invoices will have a shiping cost of $4 dollars
$shipping_cost = 4;

//prepare get book price statement
$getBookPriceStmnt = $conn->prepare("SELECT price FROM book WHERE isbn=:isbn");
$getBookPriceStmnt->bindParam(':isbn', $isbn);

//prepare insert into invoice statement minus the grand total, which we'll get after inserting the books into invoice items
$insertIntoInvoiceStmnt = $conn->prepare("INSERT INTO invoice (sale_datetime, shipping_cost, username) VALUES (:sale_datetime, :shipping_cost, :username)");
$insertIntoInvoiceStmnt->bindParam(':sale_datetime', $sale_datetime);
$insertIntoInvoiceStmnt->bindParam(':shipping_cost', $shipping_cost);
$insertIntoInvoiceStmnt->bindParam(':username', $username);

//prepare insert into invoice items statement
$insertIntoInvoiceItemsStmnt = $conn->prepare("INSERT INTO invoice_items (invoice_id, isbn, quantity, price_at_purchase) VALUES (:invoice_id, :isbn, :quantity, :price_at_purchase)");
$insertIntoInvoiceItemsStmnt->bindParam(':invoice_id', $invoice_id);
$insertIntoInvoiceItemsStmnt->bindParam(':isbn', $isbn);
$insertIntoInvoiceItemsStmnt->bindParam(':quantity', $quantity);
$insertIntoInvoiceItemsStmnt->bindParam(':price_at_purchase', $price_at_purchase);

//prepare update grand total statment to update the invoices grand total once it has been calculated
$updateInvoiceGrandTotalStmnt = $conn->prepare("UPDATE invoice SET grand_total=:grand_total WHERE invoice_id=:invoice_id");
$updateInvoiceGrandTotalStmnt->bindParam(':grand_total', $grand_total);
$updateInvoiceGrandTotalStmnt->bindParam(':invoice_id', $invoice_id);

try {
	
	$conn->beginTransaction();
	foreach($invoices as $invoice){
		
		//set variables for insert into invoice statemtn
		$sale_datetime = $invoice['sale_datetime'];
		$username = $invoice['username'];
		
		//create the invoice minus the grand total
		$insertIntoInvoiceStmnt->execute();
		
		//get invoice_id for the new entry
		$invoice_id = $conn->lastInsertId();
		
		//variable for subtotal
		$subtotal = 0;
		
		//insert all books into invoices and sum a subtotal
		foreach($invoice['books'] as $book) {
			//get books price
			$isbn = $book['isbn'];
			
			$getBookPriceStmnt->execute();
			$price_at_purchase = $getBookPriceStmnt->fetchColumn();

			//insert into invoice_items
			$quantity = $book['quantity'];
			$insertIntoInvoiceItemsStmnt->execute();

			//update subtotal
			$subtotal += ($quantity * $price_at_purchase);
		}
		
		//calculate grand total
		$grand_total = $subtotal + $shipping_cost;
		
		//update invoice grand total
		$updateInvoiceGrandTotalStmnt->execute();	
	}
	$conn->commit();
} catch (PDOException $e) {
	echo $e->getMessage();
	$conn->rollBack();
}


?>