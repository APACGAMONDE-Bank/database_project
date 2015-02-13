
<!DOCTYPE HTML>
<?php
require_once 'form_validator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$rules = array(
		'adminname' => array('rule_name' => 'login_name', 'required' => true, 'pretty_name' => 'Adminname'),
		'pin' => array('rule_name' => 'pin', 'required' => true, 'pretty_name' => 'PIN')
	);

	$validator = new Form_Validator($rules, $_POST);
	if ($validator->validateAndSanitizeForm()) {
		//TODO: check DB and make sure pin matches admin login
		//TODO: create/update any necessary $_SESSION vars and DB entries
		header("Location:report.php");
		exit();
	}
}
?>

<html>
<head>
<title>Admin Login</title>
</head>

<body>
<table align="center" style="border:2px solid blue;">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="adminlogin_screen">
		<tr>
			<td align="right">
				Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="adminname" id="adminname" value="<?php echo $validator->sanitized['adminname']?>">
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
				<input type="password" name="pin" id="pin">
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
