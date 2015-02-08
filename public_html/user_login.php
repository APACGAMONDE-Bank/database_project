
<!DOCTYPE HTML>
<?php

require 'input_validation.php';
//variables to report error information in
$usernameErr = $pinErr = "";

//variables to hold user values
$username = $pin = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["username"])){
		$usernameErr = "username is required";
	} else {
		$username = test_input($_POST["username"]);

		/* TODO: 
		if (username doesn't match a username in the database) {
			$usernameErr = "username not found";
		}*/
	}
	
	if (empty($_POST["pin"])){
		$pinErr = "PIN is required";
	} else {
		$pin = test_input($_POST["pin"]);	

		/* TODO:
		if (username found and pin doesn't match username){
			$pinErr = "pin doesn't match username";
		}
		*/
	}

	//if no errors
	if ($usernameErr == "" && $pinErr == "") {

		//TODO: We have a valid user, load their info from DB and create/update any necessary session vars
		header("Location:search.php");
		exit();
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
				<input type="text" name="username" id="username" value="<?php echo $username?>">
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
		<p><?php echo $usernameErr?></p>
		<p><?php echo $pinErr?></p>
	</div>
</body>

</html>
