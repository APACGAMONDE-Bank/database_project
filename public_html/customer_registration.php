
<!-- UI: Prithviraj Narahari, php and javascript code: Cade Sperlich -->
<?php
// vars for error info
require_once 'header.php';
require_once 'form_validator.php';
require_once 'states.php';
require_once 'php_tools.php';

if ($_SERVER ["REQUEST_METHOD"] == "POST") {
	
	$rules = array (
			'username' => array (
					'rule_name' => 'login_name',
					'required' => true,
					'pretty_name' => 'Username' 
			),
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
			'expiration' => array (
					'rule_name' => 'credit_card_expiration_date',
					'required' => true,
					'pretty_name' => 'Credit Card Expiration Date' 
			) 
	);
	
	$validator = new Form_Validator ( $rules, $_POST );
	if ($validator->validateAndSanitizeForm ()) {
		
		$conn = getDatabaseConnection ();
		
		$stmnt = $conn->prepare ( "INSERT INTO customer 
			(username, pin, card_type, card_number, card_exp_month, card_exp_year, first_name, last_name, street, city, state, zip)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?)" );
		
		$dateMonth = explode ( '/', $validator->sanitized ['expiration'] ); // extract date and month
		
		try {
			$stmnt->execute ( array (
					$validator->sanitized ['username'],
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
			
			// new customer created successfully
			$_SESSION ['username'] = $validator->sanitized ['username'];
			//came from checkout so we'll populate the new user's cart, and send them back to checkout
			if (isset ( $_SESSION ['came_from_checkout'] )) {
				//POPULATE USER'S DB CART FROM THEIR SESSION CART HERE!!!!!!
				
				unset ( $_SESSION ['came_from_checkout'] );
				header ( "Location:confirm_order.php" );
			} else {
				header ( "Location:search.php" );
			}
			exit ();
		} catch ( PDOException $e ) {
			// this is kind of hacky, we should be only exception we should get
			// should be an integrity constraint exception on username, so username
			// isn't unique if we've reached this code
			$validator->addError ( 'username', 'Username is already taken, please try another' );
			// echo $e->getMessage (); //print this if other errors besides non-unique username are present
		}
	}
	
	// debugging method
	// $validator->printSanitizedValues ();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>CUSTOMER REGISTRATION</title>
</head>
<body>
	<table align="center" style="border: 2px solid blue;">
		<tr>
			<form id="register" action="" method="post">
				<td align="right">Username<span style="color: red">*</span>:
				</td>
				<td align="left" colspan="3"><input type="text" id="username"
					name="username" placeholder="Enter your username"
					value="<?php echo $validator->sanitized['username'] ?>"></td>
		
		</tr>
		<tr>
			<td align="right">PIN<span style="color: red">*</span>:
			</td>
			<td align="left"><input type="password" id="pin" name="pin"></td>
			<td align="right">Re-type PIN<span style="color: red">*</span>:
			</td>
			<td align="left"><input type="password" id="retype_pin"
				name="retype_pin"></td>
		</tr>
		<tr>
			<td align="right">Firstname<span style="color: red">*</span>:
			</td>
			<td colspan="3" align="left"><input type="text" id="firstname"
				name="firstname" placeholder="Enter your firstname"
				value="<?php echo $validator->sanitized['firstname'] ?>"></td>
		</tr>
		<tr>
			<td align="right">Lastname<span style="color: red">*</span>:
			</td>
			<td colspan="3" align="left"><input type="text" id="lastname"
				name="lastname" placeholder="Enter your lastname"
				value="<?php echo $validator->sanitized['lastname'] ?>"></td>
		</tr>
		<tr>
			<td align="right">Address<span style="color: red">*</span>:
			</td>
			<td colspan="3" align="left"><input type="text" id="address"
				name="address"
				value="<?php echo $validator->sanitized['address'] ?>"></td>
		</tr>
		<tr>
			<td align="right">City<span style="color: red">*</span>:
			</td>
			<td colspan="3" align="left"><input type="text" id="city" name="city"
				value="<?php echo $validator->sanitized['city'] ?>"></td>
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
			<td align="left"><input type="text" id="zip" name="zip"
				value="<?php echo $validator->sanitized['zip'] ?>"></td>
		</tr>
		<tr>
			<td align="right">Credit Card<span style="color: red">*</span>
			</td>
			<td align="left"><select id="credit_card" name="credit_card">
					<option selected disabled>select a card type</option>
					<option>VISA</option>
					<option>MASTERCARD</option>
					<option>DISCOVER</option>
			</select></td>
			<td colspan="2" align="left"><input type="text" id="card_number"
				name="card_number" placeholder="Credit card number"
				value="<?php echo $validator->sanitized['card_number'] ?>"></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Expiration Date<span style="color: red">*</span>:
			</td>
			<td colspan="2" align="left"><input type="text" id="expiration"
				name="expiration" placeholder="MM/YY"
				value="<?php echo $validator->sanitized['expiration'] ?>"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit"
				id="register_submit" name="register_submit" value="Register"></td>
			</form>
			<form id="no_registration" action="must_register.php" method="post">
				<td colspan="2" align="center"><input type="submit"
					id="donotregister" name="donotregister" value="Don't Register"></td>
			</form>
		</tr>
	</table>
	<!-- keeps the user's select box values on incorrect form submission -->
	<script>
		var stateValue = "<?php echo $validator->sanitized['state']; ?>";
		if (stateValue !== "")
			document.getElementById('state').value = stateValue;
		var creditCardTypeValue = "<?php echo $validator->sanitized['credit_card']; ?>";
		if (creditCardTypeValue !== "")
			document.getElementById('credit_card').value = creditCardTypeValue;
	</script>
	<div align="center">
	<?php
	$validator->printErrors (); // show the user the problems with the form they've submitted
	?>
	</div>
</body>
</html>
