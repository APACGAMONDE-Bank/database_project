
<!DOCTYPE HTML>
<?php
//variables to report error information in
$adminnameErr = $pinErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$filters = array (
		'adminname' => FILTER_SANITIZE_STRING,
		'pin' => FILTER_SANITIZE_STRING
	); 

	$sanitized_post = filter_input_array(INPUT_POST, $filters);

	if (empty($sanitized_post['adminname'])){
		$adminnameErr = "adminname is required";
	} /*TODO: else
		if (adminname doesn't the DB adminname) {
			$adminnameErr = "bad adminname";
		}*/

	if (empty($sanitized_post['pin'])){
		$pinErr = "PIN is required";
	} /* TODO: else 
		if (adminname found and pin doesn't match adminname){
			$pinErr = "pin doesn't match adminname";
		}
		*/

	//if no errors
	if ("{$adminnameErr}{$pinErr}" == "") {
		//TODO: We have a valid admin, load admin info from DB? and create/update any necessary session vars?
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
		<form action="" method="post" id="adminlogin_screen">
		<tr>
			<td align="right">
				Adminname<span style="color:red">*</span>:
			</td>
			<td align="left">
				<input type="text" name="adminname" id="adminname" value="<?php echo $sanitized_post['adminname']?>">
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
		<p><?php echo $adminnameErr?></p>
		<p><?php echo $pinErr?></p>
	</div>
</body>
</html>
