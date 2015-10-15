<html>
	<head>
		<title>Set Dates</title>
	</head>
	<body>
		<form action="set_dates.php" method="post">
			<table style="border:1px solid #000000">
				<tr>
					<td>Start Date</td><td>:</td><td><input type="date" name="start_date" value="<?=date("Y-m-01")?>"></td>
				</tr>
				<tr>
					<td>End Date</td><td>:</td><td><input type="date" name="end_date" value="<?=date("Y-m-d")?>">
						<input type="checkbox" name="null_end_date" checked/>
					</td>
				<tr>
					<td colspan="3" align=center><input style="width:100%"	 type="submit" name="submit"></td>
				</tr>
			</table>
		</form>
	</body>
</html>