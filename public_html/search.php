<?php require_once 'form_validator.php';?>
<html>
<head>
	<title>SEARCH - 3-B.com</title>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td>Search for: </td>
			<form action="search_result.php" method="get" id="search_screen">
				<td><input name="searchfor" type="text" id="searchfor" value="<?php echo $validator->sanitized['string']?>"></td>
				<td><input type="submit"/></td>
		</tr>
		<tr>
			<td>Search In: </td>
				<td>
					<select name="searchon" multiple>
						<option value="anywhere" selected='selected'>Keyword anywhere</option>
						<option value="title">Title</option>
						<option value="author">Author</option>
						<option value="publisher">Publisher</option>
						<option value="isbn">ISBN</option>				
					</select>
				</td>
				<td><a href="shopping_cart.php"><input type="button" name="manage" value="Manage Shopping Cart" /></a></td>
		</tr>
		<tr>
			<td>Category: </td>
				<td><select name="category">
						<option value='all' selected='selected'>All Categories</option>
						<option value='Fantasy'>Fantasy</option><option value='Adventure'>Adventure</option><option value='Fiction'>Fiction</option><option value='Horror'>Horror</option></select></td>
				</form>
	<form action="welcome.php" method="post">	
				<td><input type="submit" name="exit" value="EXIT 3-B.com<?php unset($_SESSION['username']); ?>" /></td>
			</form>
		</tr>
	</table>
</body>
</html>
