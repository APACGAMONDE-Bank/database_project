<?php
// vars for error info
require_once 'header.php';
require_once 'form_validator.php';
require_once 'states.php';
require_once 'php_tools.php';

$_SESSION ['username'] = 'pizzaBob'; // FOR TESTING

$conn = getDatabaseConnection ();

// if this page sent a post to itself
if ($_SERVER ["REQUEST_METHOD"] == "POST" && isset ( $_POST ['post_from'] )) {
	$rules = array (
			'pin' => array (
					'rule_name' => 'pin',
					'required' => true,
					'pretty_name' => 'PIN' 
			),
			'retype_pin' => array (
					'rule_name' => 'retype_pin',
					'required' => true,
					'pretty_name' => 'Re-type PIN' 
			),
			'firstname' => array (
					'rule_name' => 'string',
					'required' => true,
					'pretty_name' => 'Firstname' 
			),
			'lastname' => array (
					'rule_name' => 'string',
					'required' => true,
					'pretty_name' => 'Lastname' 
			),
			'address' => array (
					'rule_name' => 'string',
					'required' => true,
					'pretty_name' => 'Address' 
			),
			'city' => array (
					'rule_name' => 'string',
					'required' => true,
					'pretty_name' => 'City' 
			),
			'zip' => array (
					'rule_name' => 'zipcode',
					'required' => true,
					'pretty_name' => 'Zip' 
			),
			'state' => array (
					'rule_name' => 'state',
					'required' => true,
					'pretty_name' => 'State' 
			),
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
			'expiration_date' => array (
					'rule_name' => 'credit_card_expiration_date',
					'required' => true,
					'pretty_name' => 'Credit Card Expiration Date' 
			) 
	);
	
	$validator = new Form_Validator ( $rules, $_POST );
	// echo 'wasup';
	// print_r ( $_POST );
	if ($validator->validateAndSanitizeForm ()) {
		// echo 'shanana';
		try {
			$stmnt = $conn->prepare ( "UPDATE customer 
				SET  pin=?, card_type=?, card_number=?, card_exp_month=?, 
				card_exp_year=?, first_name=?, last_name=?, street=?, 
				city=?, state=?, zip=?
				WHERE username='{$_SESSION['username']}'" );
			
			$dateMonth = explode ( '/', $validator->sanitized ['expiration_date'] ); // extract date and month
			
			$stmnt->execute ( array (
					$validator->sanitized ['pin'],
					$validator->sanitized ['credit_card'],
					$validator->sanitized ['card_number'],
					intval ( $dateMonth [0] ),
					intval ( $dateMonth [1] ),
					$validator->sanitized ['firstname'],
					$validator->sanitized ['lastname'],
					$validator->sanitized ['address'],
					$validator->sanitized ['city'],
					$validator->sanitized ['state'],
					$validator->sanitized ['zip'] 
			) );
			
			// success, let's get out of here
			header ( "Location:confirm_order.php" );
			exit ();
		} catch ( PDOException $e ) {
			echo 'Could not update'; // shouldn't happen
		}
	}
}

try {
	$stmt = $conn->prepare ( "SELECT pin, card_type, card_number, card_exp_month, card_exp_year, 
			first_name, last_name, street, city, state, zip 
			FROM customer WHERE username = '{$_SESSION['username']}'" );
	$stmt->execute ();
	$result = $stmt->fetch ( PDO::FETCH_ASSOC );
	// print_r ( $result );
} catch ( PDOException $e ) {
	$e->getMessage ();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>UPDATE CUSTOMER PROFILE</title>
</head>
<body>
	<form id="update_profile"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
		method="post">
		<table align="center" style="border: 2px solid blue;">
			<tr>
				<td align="right">Username: <?php echo $_SESSION['username']; ?>
				</td>
				<td colspan="3" align="center"></td>
			</tr>
			<tr>
				<td align="right">New PIN<span style="color: red">*</span>:
				</td>
				<td><input type="password" id="pin" name="pin"
					value="<?php echo $result['pin'];?>"></td>
				<td align="right">Re-type New PIN<span style="color: red">*</span>:
				</td>
				<td><input type="password" id="retype_pin" name="retype_pin"
					value="<?php echo $result['pin'];?>"></td>
			</tr>
			<tr>
				<td align="right">First Name<span style="color: red">*</span>:
				</td>
				<td colspan="3"><input type="text" id="firstname" name="firstname"
					value="<?php echo $result['first_name'];?>"></td>
			</tr>
			<tr>
				<td align="right">Last Name<span style="color: red">*</span>:
				</td>
				<td colspan="3"><input type="text" id="lastname" name="lastname"
					value="<?php echo $result['last_name'];?>"></td>
			</tr>
			<tr>
				<td align="right">Address<span style="color: red">*</span>:
				</td>
				<td colspan="3"><input type="text" id="address" name="address"
					value="<?php echo $result['street'];?>"></td>
			</tr>
			<tr>
				<td align="right">City<span style="color: red">*</span>:
				</td>
				<td colspan="3"><input type="text" id="city" name="city"
					value="<?php echo $result['city'];?>"></td>
			</tr>
			<tr>
				<td align="right">State<span style="color: red">*</span>:
				</td>
				<td align="left"><select id="state" name="state">
						<option selected disabled>select a state</option>
				<?php States::echoSelectOptions(); //generates all of the state options ?>
				</select></td>
				<td align="right">Zip<span style="color: red">*</span>:
				</td>
				<td><input type="text" id="zip" name="zip"
					value="<?php echo $result['zip']; ?>"></td>
			</tr>
			<tr>
				<td align="right">Credit Card<span style="color: red">*</span>:
				</td>
				<td><select id="credit_card" name="credit_card">
						<option selected disabled>select a card type</option>
						<option>VISA</option>
						<option>MASTERCARD</option>
						<option>DISCOVER</option>
				</select></td>
				<td align="left" colspan="2"><input type="text" id="card_number"
					name="card_number" placeholder="Credit card number"
					value="<?php echo $result['card_number']; ?>"</td>
			</tr>
			<tr>
				<td align="right" colspan="2">Expiration Date<span
					style="color: red">*</span>:
				</td>
				<td colspan="2" align="left"><input type="text" id="expiration_date"
					name="expiration_date" placeholder="MM/YY"
					value="<?php echo $result['card_exp_month'] . '/' . $result['card_exp_year']; ?>"</td>
			</tr>
			<tr>
				<td align="right" colspan="2"><input type="submit"
					id="update_submit" name="update_submit" value="Update"></td>
				<input type="hidden" name="post_from" value="self" />
				</form>
				<form id="cancel" action="confirm_order.php" method="post">
					<td align="left" colspan="2"><input type="submit"
						id="cancel_submit" name="cancel_submit" value="Cancel"></td>
			
			</tr>
		</table>
	</form>
	<script>
		document.getElementById('state').value = "<?php echo $result['state'];?>";
		document.getElementById('credit_card').value = "<?php echo $result['card_type'];?>";
	</script>
	<div align="center">
	
	<?php
	
	if (isset ( $_POST ['post_from'] ))
		echo '<p><span style="color: red"> Unable to update: </span></p>';
	$validator->printErrors (); // show the user the problems with the form they've submitted
	?>
	</div>
</body>
</html>
