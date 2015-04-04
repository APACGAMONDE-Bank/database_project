<!DOCTYPE HTML>
<?php
require_once 'form_validator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$rules = array(
		'username' => array('rule_name' => 'login_name', 'required' => true, 'pretty_name' => 'Username'),
		'pin' => array('rule_name' => 'pin', 'required' => true, 'pretty_name' => 'PIN')
	);

	$validator = new Form_Validator($rules, $_POST);
	if ($validator->validateAndSanitizeForm()) {

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

    	$enteredUsername = $_POST['username'];
    	$enteredPin = $_POST['pin'];

    	$loginStatement = $databaseConnection->prepare("SELECT * FROM customer WHERE username = :username AND pin = :pin");

    	$loginStatement->bindParam(':username', $enteredUsername);
    	$loginStatement->bindParam(':pin', $enteredPin);

    	$loginStatement->execute();

    	if ($loginStatement->rowCount() == 1)
    	{
			header("Location:search.php");
    	}
    	else
    	{
    		$validator->addError("InvalidCredentials", "Invalid Username or PIN");
    	}
	}
}
?>

<html>
<head>
<title>User Login</title>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="login_screen">
		<tr>
			<td align="right">
				Username<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="username" id="username" value="<?php echo $validator->sanitized['username']?>">
			</td>
			<td align="right">
				<input type="submit" name="login" id="login" value="Login">
			</td>
		</tr>
		<tr>
			<td align="right">
				PIN<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="password" name="pin" id="pin" value="<?php echo $validator->sanitized['pin']?>">
			</td>
			</form>
			<form action="welcome.php" method="post" id="login_screen">
			<td align="right">
				<input type="submit" name="cancel" id="cancel" value="Cancel">
			</td>
			</form>
		</tr>
	</table>
	<div align="center">
		<?php $validator->printErrors(); ?>
	</div>
</body>

</html>
