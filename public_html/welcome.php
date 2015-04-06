<!-- Figure 1: Welcome Screen by Alexander -->
<?php
if ($_POST['submit']){
	header('Location:'.$_POST['group1']);
}
?>

<?php 
//if a user has gotten to the welcome page via an exit button, let's log them out
if (isset($_POST['exit'])){
	unset($_SESSION['username']);
}
?>
<html>
<title>Welcome to Best Book Buy Online Bookstore!</title>
<body>
	<table align="center" style="border:1px solid blue;">
	<tr><td><h2>Best Book Buy (3-B.com)</h2></td></tr>
	<tr><td><h4>Online Bookstore</h4></td></tr>
	<tr><td><form action="" method="post">
		<input type="radio" name="group1" value="search.php"checked>Search Online<br/>
		<input type="radio" name="group1" value="customer_registration.php">New Customer<br/>
		<input type="radio" name="group1" value="user_login.php">Returning Customer<br/>
		<input type="radio" name="group1" value="admin_login.php">Administrator<br/>
		<input type="submit" name="submit" value="ENTER">
	</form></td></tr>
	</table>
</body>
</html>
