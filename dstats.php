<html>
<head>
<title>Statictics</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include_once('db.php');

$stmt = oci_parse($conn, "select distinct phone,INITCAP(TRIM(SUBSTR(phone,0,INSTR(phone,'/', 1)-1))) from call_log");
oci_execute($stmt);
$text = "";
while($phone=oci_fetch_array($stmt))
{
	$text = $text . "<option value='".$phone[0]."'>".$phone[1]."</phone>";
}
?>
<form>
	<table>
	<tr><td>Name</td><td><input name="name" type="text"></td></tr>
	<tr><td>Number</td><td><input name="number" type="text"></td></tr>
	<tr><td>Phone</td>
	<td><select name='type'>
				<option>All</option>
				<option>Incoming</option>
				<option>Outgoing</option>
				<option>Missed</option>
			</select>
	</td></tr>
	<tr><td>Date range</td>
	<td>
	From 
		<input name="from" type="date" value="2015-01-01">
	To
		<input name="to" type="date" value="<?php echo date("Y-m-d");?>">
	</td></tr>
	<tr><td>Type</td>
	<td><select name='phone'>
				<option>All</option>
				<?php echo $text; ?>
			</select>
	</td></tr>
	<tr><td>Calls more than</td><td><input name="callcount" value='2' type="text"></td></tr>
	<tr><td>Show Numbers</td><td><input type="checkbox" name="shownum"/>
	<tr colspan=2><td><input type="submit"></td></tr>
	<tr colspan=2><td><button onclick="openWindow()">Show Graphical Data</button></td></tr>
	</table>
	<hr>
</form>
<?php
	include 'function.php';
	show_data($conn,$_REQUEST,1);
?>
<script>
	function openWindow()
	{
		window.open('stats.php');
	}
</script>
</body>
</html>
