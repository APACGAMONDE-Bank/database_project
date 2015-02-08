
<!DOCTYPE HTML>
<head>
	<title>Proof purchase</title>
	<header align="center">Proof purchase</header> 
</head>
<body>
	<table align="center" style="border:2px solid blue;">
	<form id="buy" action="" method="post">
	<tr>
	<td>
	Shipping Address:
	</td>
	</tr>
	<td colspan="2">
		abc def	</td>
	<td rowspan="3" colspan="2">
		<b>UserID:</b>me<br />
		<b>Date:</b>2015-01-29<br />
		<b>Time:</b>21:32:37<br />
		<b>Card Info:</b>VISA<br />01/19 - 1234567812345678	</td>
	<tr>
	<td colspan="2">
		abc	</td>		
	</tr>
	<tr>
	<td colspan="2">
		def	</td>
	</tr>
	<tr>
	<td colspan="2">
		Michigan, 12345	</td>
	</tr>
	<tr>
	<td colspan="3" align="center">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:520px;border:1px solid black;">
	<table border='1'>
		<th>Book Description</th><th>Qty</th><th>Price</th>
			</table>
	</div>
	</td>
	</tr>
	<tr>
	<td align="left" colspan="2">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;background-color:LightBlue">
	<b>Shipping Note:</b> The book will be </br>delivered within 5</br>business days.
	</div>
	</td>
	<td align="right">
	<div id="bookdetails" style="overflow:scroll;height:180px;width:260px;border:1px solid black;">
		SubTotal:$0</br>Shipping_Handling:$0</br>_______</br>Total:$0	</div>
	</td>
	</tr>
	<tr>
		<td align="right">
			<input type="submit" id="buyit" name="btnbuyit" value="Print" disabled>
		</td>
		</form>
		<td align="right">
			<form id="update" action="search.php" method="post">
			<input type="submit" id="update_customerprofile" name="update_customerprofile" value="New Search">
			</form>
		</td>
		<td align="left">
			<form id="cancel" action="welcome.php" method="post">
			<input type="submit" id="exit" name="exit" value="EXIT 3-B.com">
			</form>
		</td>
	</tr>
	</table>
</body>
</HTML>
